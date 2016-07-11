<?php

	App::uses('AppController', 'Controller');

	class UsersController extends AppController {	
		public function beforeFilter() {
			$this->Auth->allow('register', 'login', 'logout');
			parent::beforeFilter();
		}

		public function login() {
			if($this->Session->check('Auth.User')){
				$this->redirect(array('controller' => 'comments', 'action' => 'index'));  
			} 
			
			if ($this->request->is('post')) {
				if ($this->Auth->login()) {
					$this->redirect($this->Auth->redirectUrl());
				} else {
					$this->Session->setFlash('E-mail ou senha incorretos!', 'flash');
					return $this->redirect(array('controller' => 'comments', 'action' => 'index'));
				}
			} else {
				return $this->redirect(array('controller' => 'comments', 'action' => 'index'));
			}
		}

		public function logout() {
			return $this->redirect($this->Auth->logout());
		}

		public function register() {
			if($this->Session->check('Auth.User')){
				$this->redirect(array('controller' => 'comments', 'action' => 'index'));  
			}
		
			if ($this->request->is('post')) {
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					return $this->redirect(array('controller' => 'comments', 'action' => 'index'));
				}
			}
		}

		public function edit() {
			$id = $this->Auth->user('id');
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {
			
				if ($this->request->data['User']['email'] == $this->Auth->user('email'))
					unset($this->request->data['User']['email']);
					
				if ($this->request->data['User']['password'] == "")
					unset($this->request->data['User']['password']);
					
				if ($this->request->data['User']['name'] == $this->Auth->user('name'))
					unset($this->request->data['User']['name']);
					
				if ($this->request->data['User']['photo_url']['name'] == "")
					unset($this->request->data['User']['photo_url']);
					
				$session = array();
					
				
					
				// debug($this->request->data);
				// debug($this->Auth->user());
				// die();
			
				if ($this->User->save($this->request->data)) {
				
					foreach($this->Auth->user() as $key => $value) {
						$session[$key] = $value;
						
						if (isset($this->request->data['User'][$key]))
							$session[$key] = $this->request->data['User'][$key];
					}
					
					if (isset($this->request->data['User']['photo_url'])) {
						$session['photo_url'] = $this->User->getPhotoUrl($this->Auth->user('id'));
					}
				
					$this->Session->write('Auth.User', $session);
				
					return $this->redirect(array('controller' => 'comments', 'action' => 'index'));
				}
			} else {
				$this->request->data = $this->User->read(null, $id);
				unset($this->request->data['User']['password']);
			}
			
			$this->set('isLoggedIn', ($this->Auth->user() != null));
		}
		
		public function isAuthorized($user) {
			if (in_array($this->action, array('edit', 'logout'))) {
				return true;
			}
			
			return parent::isAuthorized($user);
		}

	}

?>