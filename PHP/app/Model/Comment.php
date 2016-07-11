<?php
	
	class Comment extends AppModel {
		public $validate = array(
			'content' => array(
				'rule' => array( 'maxLength', 140 )
			)
		);
		
		public function isOwnedBy($comment, $user) {
			return $this->field('id', array('id' => $comment, 'owner' => $user)) !== false;
		}
		
		public function getCommentHistoryById($id = null) {
			$comment = $this->findById($id);
			
			$pastComments = $this->find('all', array(
					'conditions' => array(
						'Comment.parent' => $comment['Comment']['id']
					),
					'order' => array(
						'Comment.created' => 'desc'
					)
				)
			);
			
			return $pastComments;
		}
		
		public function getMostRecentCommentByParent($pid) {
			return $this->find('first', array(
					'conditions' => array(
						'Comment.parent' => $pid
					),
					'order' => array(
						'Comment.created' => 'desc'
					)
				)
			);
		}
		
		public function getCommentHistoryIds($pid) {
			$ids = array();
			
			$children = $this->find('all', array(
				'condition' => array('Comment.parent', $pid)
			));
			
			
			foreach($children as $comment) {
				if ($comment['Comment']['parent'] != null)
					$ids[] = $comment['Comment']['id'];
			}
			
			return $ids;
		}
		
		public function getCommentParent($id) {
			return $this->field('parent', array('id' => $id));
		}
		
		public function processComments($baseComments, $user = null) {
			$comments = array();
			
			foreach($baseComments as $currentComment) {			
				if ($currentComment['Comment']['type'] == 2) {
					$currentComment = $this->getMostRecentCommentByParent($currentComment['Comment']['id']);
				}
				
				$currentComment['Comment']['author'] = $this->getAuthor($currentComment['Comment']['id']);
				$currentComment['Comment']['time'] = $this->getReadableTime(strtotime( $currentComment['Comment']['created']));
				$currentComment['Comment']['owned'] = ((isset($user)) ? (($this->isOwnedBy($currentComment['Comment']['id'], $user['id'])) || ($user['role'] > 0)) : false);
					
				$comments[] = $currentComment;
			}
			
			return $comments;
		}
		
		public function getAllReadableComments() {
			return $this->find('all', array(
					'conditions' => array('Comment.type' => array( 1, 2 )),
					'order' => array('Comment.created' => 'desc')
				)
			);
		}
		
		public function getReadableTime($timestamp) {
			$times		= array( 31536000	=> 'ano',
						 2592000	=> 'mes',
						 604800		=> 'semana',
						 86400		=> 'dia',
						 3600		=> 'hora',
						 60		=> 'minuto',
						 1		=> 'segundo'	);

			$now		= time();
			$secs		= ((($now - $timestamp) > 0) ? ($now - $timestamp) : 1);
			$count		= 0;
			$time		= '';

			foreach ($times as $key => $value)
			{
				if ($secs >= $key)
				{
					$s		= '';
					$time		.= floor($secs / $key);

					if ((floor($secs / $key) != 1))
						$s = 's';

					$time		.= ' ' . $value . $s;
					$count++;
					$secs		= $secs % $key;

					if ($count > 1 || $secs == 0)
						break;
					else
						$time	.= ' e ';
				}
			}

			return $time;
		}
		
		public function beforeSave($options = array()) {
			if (isset($this->data[$this->alias]['content']))
				$this->data[$this->alias]['content'] = htmlspecialchars($this->data[$this->alias]['content']);
			
			return parent::beforeSave($options);
		}
		
		/**
		 * TODO: Otimizar função: retirar acesso direto ao MySQL (Model->query()).
		 *
		 * Sanidade dos dados neste caso é garantida, pois faz uso somente de dados
		 * internos do sistema (id).
		 */
		public function getAuthor($id = null) {
			if (!$id) {
				throw new NotFoundException(__('Comentário inválido'));
			}
			
			if (!$this->findById($id)) {
				throw new NotFoundException(__('Comentário inválido'));
			}
			
			return ($this->query('SELECT `User`.`id`, `User`.`name`, `User`.`email`, `User`.`photo_url`, `User`.`role` FROM `comments` AS `Comment` INNER JOIN `users` AS `User` ON `Comment`.`owner` = `User`.`id`  WHERE `Comment`.`id` = '.$id.' LIMIT 1'));
		}
	}
	
?>