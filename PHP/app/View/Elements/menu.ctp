<div class="masthead">
	<ul class="nav nav-pills pull-right">
		<li><?php echo $this->Html->link('Início', array('controller' => 'comments', 'action' => 'index')); ?></li>
		<li>
		<?php
			if (isset($login) && !$login) {
				echo $this->Html->link('Login', '#', array(
						'data-toggle' => 'popover',
						'data-placement' => 'bottom',
						'data-html' => 'true',
						'data-content' => '
							<div class="well pop">
							'.
								$this->Form->create('User', array(
									'url' => array(
										'controller' => 'users',
										'action' => 'login'
									),
									'inputDefaults' => array(
										'label' => false,
										'div' => false
									)
								))
								
								.
								
								$this->Form->input('email', array(
									'placeholder' => 'E-mail'
									)
								)
								
								.
								
								$this->Form->input('password', array(
									'placeholder' => 'Senha'
									)
								)
								
								.
								
								$this->Form->end(array(
									'label' => 'Login',
									'class' => 'btn btn-default'
									)
								)
							
							.'
							</div>
						'
					)
				);
			}
		 ?>
		 </li>
		
		
		
		
		
		
		
		<li><?php if (isset($login) && $login) echo $this->Html->link('Editar Perfil', array('controller' => 'users', 'action' => 'edit')); ?></li>
		<li><?php if (isset($login) && $login) echo $this->Html->link('Sair', array('controller' => 'users', 'action' => 'logout')); ?></li>
		
		
		<li><?php if (isset($login) && !$login) echo $this->Html->link('Registrar', array('controller' => 'users', 'action' => 'register')); ?></li>
	</ul>
	<h3 class="muted">ArrayEnterprises</h3>
</div>

<hr />