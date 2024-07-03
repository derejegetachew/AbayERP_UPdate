<?php
class BranchCategoriesController extends AppController {

	var $name = 'BranchCategories';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('branchCategories', $this->BranchCategory->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BranchCategory->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid branch category', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BranchCategory->recursive = 2;
		$this->set('branchCategory', $this->BranchCategory->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->BranchCategory->create();
			$this->autoRender = false;
			if ($this->BranchCategory->save($this->data)) {
				$this->Session->setFlash(__('The branch category has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The branch category could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch category', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->BranchCategory->save($this->data)) {
				$this->Session->setFlash(__('The branch category has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The branch category could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('branch__category', $this->BranchCategory->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for branch category', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BranchCategory->delete($i);
                }
				$this->Session->setFlash(__('Branch category deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Branch category was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BranchCategory->delete($id)) {
				$this->Session->setFlash(__('Branch category deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Branch category was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>