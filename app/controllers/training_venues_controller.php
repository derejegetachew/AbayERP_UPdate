<?php
class TrainingVenuesController extends AppController {

	var $name = 'TrainingVenues';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('trainingVenues', $this->TrainingVenue->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->TrainingVenue->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid training venue', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->TrainingVenue->recursive = 2;
		$this->set('trainingVenue', $this->TrainingVenue->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->TrainingVenue->create();
			$this->autoRender = false;
			if ($this->TrainingVenue->save($this->data)) {
				$this->Session->setFlash(__('The training venue has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The training venue could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid training venue', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->TrainingVenue->save($this->data)) {
				$this->Session->setFlash(__('The training venue has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The training venue could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('training__venue', $this->TrainingVenue->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for training venue', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->TrainingVenue->delete($i);
                }
				$this->Session->setFlash(__('Training venue deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Training venue was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->TrainingVenue->delete($id)) {
				$this->Session->setFlash(__('Training venue deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Training venue was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>