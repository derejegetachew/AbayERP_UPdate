<?php
class PerrdiemmsController extends AppController {

	var $name = 'Perrdiemms';
	
	function index() {
		$employees = $this->Perrdiemm->Employee->find('all');
		$this->set(compact('employees'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$employee_id = (isset($_REQUEST['employee_id'])) ? $_REQUEST['employee_id'] : -1;
		if($id)
			$employee_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($employee_id != -1) {
            $conditions['Perrdiemm.employee_id'] = $employee_id;
        }
		
		$this->set('perrdiemms', $this->Perrdiemm->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Perrdiemm->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid perrdiemm', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Perrdiemm->recursive = 2;
		$this->set('perrdiemm', $this->Perrdiemm->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Perrdiemm->create();
			$this->autoRender = false;
			if ($this->Perrdiemm->save($this->data)) {
				$this->Session->setFlash(__('The perdium has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The perrdiemm could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$employees = $this->Perrdiemm->Employee->find('list');
		$payrolls = $this->Perrdiemm->Payroll->find('list');
		$this->set(compact('employees', 'payrolls'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid perrdiemm', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Perrdiemm->save($this->data)) {
				$this->Session->setFlash(__('The perrdiemm has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The perrdiemm could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('perrdiemm', $this->Perrdiemm->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$employees = $this->Perrdiemm->Employee->find('list');
		$payrolls = $this->Perrdiemm->Payroll->find('list');
		$this->set(compact('employees', 'payrolls'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for perrdiemm', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Perrdiemm->delete($i);
                }
				$this->Session->setFlash(__('Perrdiemm deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Perrdiemm was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Perrdiemm->delete($id)) {
				$this->Session->setFlash(__('Perrdiemm deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Perrdiemm was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>