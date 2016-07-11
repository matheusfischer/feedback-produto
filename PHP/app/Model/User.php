<?php

	App::uses('AppModel', 'Model');
	App::uses('AuthComponent', 'Controller/Component');
	
	class User extends AppModel {
		public $validate = array(
			'email' => array(
				'required' => array(
					'rule' => array('notEmpty'),
					'message' => 'O e-mail é um campo obrigatório.'
				),
				'valid' => array(
					'rule' => array('email', true),    
					'message' => 'Insira um e-mail válido.'   
				),
				'unique' => array(
					'rule'    => array('isMailUnique'),
					'message' => 'Esse e-mail já está em uso.',
				)
			),
			'name' => array(
				'required' => array(
					'rule' => array('notEmpty'),
					'message' => 'O nome é um campo obrigatório.'
				),
				'alphaNumeric' => array(
					'rule' => array('custom', '/^[a-z0-9 ]*$/i'),
					'message' => 'O nome deve ser preenchido apenas com caracteres alphanuméricos (A-z, 0-9) e espaços.'
				)
			),
			'password' => array(
				'required' => array(
					'rule' => array('notEmpty'),
					'message' => 'A senha é um campo obrigatorio.'
				)
			)
		);
		
		public function getPhotoUrl($id) {
			return $this->field('photo_url', array('id' => $id));
		}
		
		public function isMailUnique($data) {
			$email = $this->find(
				'first',
				array(
					'fields' => array(
						'User.id'
					),
					'conditions' => array(
						'User.email' => $data['email']
					)
				)
			);
			
			return empty($email);
		}
		
		public function beforeSave($options = array()) {
			if (isset($this->data[$this->alias]['password'])) {
				$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
			}
	
			if(!empty($this->data[$this->alias]['photo_url']['name'])) {  
				$this->data[$this->alias]['photo_url'] = $this->upload($this->data[$this->alias]['photo_url']);  
			} else {  
				unset($this->data[$this->alias]['photo_url']);  
			}  
	
			return parent::beforeSave($options);
		}
		
		/**
		 * Funções dedicadas ao upload de imagens de avatar.
		 */
		 
		private function upload($data = array(), $dir = 'img') {
			$dir = WWW_ROOT . $dir . DIRECTORY_SEPARATOR;
			
			if (($data['error'] != 0) && ($data['size'] == 0)) {
				throw new NotImplementedException(__('Erro de upload.'));
			}
			
			$this->validateDirectory($dir);
			$data = $this->formatFile($data, $dir);
			$this->processFile($data, $dir);
			
			return $data['name'];
		}
		
		private function validateDirectory($dir) {
			App::uses('Folder', 'Utility');
			
			$folder = new Folder();
			if (!is_dir($dir))
				$folder->create($dir);
		}
		
		private function formatFile($data, $dir) {
			$info = pathinfo($dir . $data['name']);
			$data['name'] = md5($data['name'].time()).'.'.$info['extension'];
			
			return $data;
		}
		
		private function processFile($data, $dir) {
			App::uses('File', 'Utility'); 
			
			$file = new File($data['tmp_name']);
			$file->copy($dir.$data['name']);
			$file->close();
		}
	}

?>