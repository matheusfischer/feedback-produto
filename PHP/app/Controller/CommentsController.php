<?php
	 
	class CommentsController extends AppController {

		public $helpers = array( 'Html', 'Form' );
		
		public function index() {
			$this->set('comments', $this->Comment->processComments($this->Comment->getAllReadableComments(), $this->Auth->user()));
			$this->set('isLoggedIn', ($this->Auth->user() != null));
		}
		
		public function add() {
			if ($this->request->is('post')) {
				$this->request->data['Comment']['owner'] = $this->Auth->user('id');
				$this->request->data['Comment']['type'] = 1;
				if ($this->Comment->save($this->request->data)) {
					$this->Session->setFlash('Seu comentario foi adicionado', 'flash');
					return $this->redirect(array('action' => 'index'));
				}
			}
		}
		
		public function history() {
			$response = array();
			
			$id = $this->request->data['id'];
			
			if (!$this->request->is(array('post', 'ajax'))) {
				return $this->redirect(array('action' => 'index'));
			}
		
			if (!$id) {
				$response[] = 1;
			}
			
			$comment = $this->Comment->findById($id);
			if (!$comment) {
				$response[] = 1;
			}
			
			if (!$this->request->is(array('post', 'ajax')) && !isset($this->request->data['id'])) {
				$response[] = 1;
			}
			
			if(count($response) == 0) {
				$response[] = 0;
				
				$response[] = array(
								'history' => $this->Comment->processComments($this->Comment->getCommentHistoryById($this->Comment->getCommentParent($id)), $this->Auth->user()),
								'original' => $this->Comment->findById($this->Comment->getCommentParent($id))
							);
			}
			
			$this->set('response', $response);
			$this->render('ajax');
		}
		
		public function edit() {
			$id = $this->request->data['Comment']['id'];
		
			if (!$id) {
				$this->Session->setFlash('Comentario invalido', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			
			$comment = $this->Comment->findById($id);
			if (!$comment) {
				$this->Session->setFlash('Comentario invalido', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			
			if ($this->request->is(array('post', 'put'))) {
			
				unset($this->request->data['Comment']['id']);
				
				$parent = $this->Comment->getCommentParent($id);
				
				$this->request->data['Comment']['owner'] = $this->Auth->user('id');
				$this->request->data['Comment']['parent'] = (($parent != null) ? $parent : $id);
				$this->request->data['Comment']['type'] = 3;
				
				$a = array(
					'Comment' => array(
						'id' => $id,
						'type' => (($comment['Comment']['type'] == 1) ? 2 : 3)
					)
				);
				
				if ($this->Comment->save($this->request->data) && $this->Comment->save($a)) {
					return $this->redirect(array('action' => 'index'));
				}
			} else
				return $this->redirect(array('action' => 'index'));
			
			if (!$this->request->data) {
				$this->request->data = $comment;
			}
			
			$this->set('comment', $comment);
		}
		
		public function delete() {		
			$response = array();
		
			if ($this->request->is(array('post', 'ajax')) && isset($this->request->data['id'])) {
				$parent = $this->Comment->getCommentParent($this->request->data['id']);
				if ($parent != null) {
					foreach($this->Comment->getCommentHistoryIds($parent) as $currentId) {
						if (!$this->Comment->delete($currentId)) {
							$response[] = 1;
						}
					}
					
					if (!$this->Comment->delete($parent))
						$response[] = 1;
					
					if (count($response) == 0)
						$response[] = 0;
				} else {
					if ($this->Comment->delete($this->request->data['id']))
						$response[] = 0;
					else
						$response[] = 1;
					
				}
			} else {
				$this->Session->setFlash('Comentario invalido', 'flash');
				return $this->redirect(array('action' => 'index'));
			}
			
			$this->set('response', $response);
			$this->render('ajax');
		}
		
		public function isAuthorized($user) {	
			if ($this->action === 'add') {
				return true;
			}

			if (in_array($this->action, array('edit', 'delete'))) {
				$commentId = ((isset($this->request->data['id'])) ? $this->request->data['id'] : $this->request->data['Comment']['id']);
				
				if ($this->Comment->isOwnedBy($commentId, $user['id'])) {
					return true;
				}
			}

			return parent::isAuthorized($user);
		}
	}

?>