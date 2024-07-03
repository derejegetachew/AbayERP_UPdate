<?php
class TabsController extends AppController {

	var $name = 'Tabs';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('tabs', $this->Tab->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Tab->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		$this->Tab->recursive = 2;
		$this->set('tab', $this->Tab->read(null, $id));
	}

	function display($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid tab', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Tab->recursive = -1;
		$this->set('tab', $this->Tab->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Tab->create();
			$this->autoRender = false;
			if ($this->Tab->save($this->data)) {
				$this->Session->setFlash(__('The tab has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The tab could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid tab', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Tab->save($this->data)) {
				$this->Session->setFlash(__('The tab has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The tab could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('tab', $this->Tab->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for tab', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Tab->delete($i);
                }
				$this->Session->setFlash(__('Tab deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Tab was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Tab->delete($id)) {
				$this->Session->setFlash(__('Tab deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Tab was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>