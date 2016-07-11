<?php

	echo $this->element('menu', array(
		'login' => $isLoggedIn
	));
	
?>
<div class="well">
<?php

	echo $this->Form->create('User', array('type' => 'file'));
	echo $this->Form->input('email', array(
		'label' => 'E-mail'
		)
	);
	echo $this->Form->input('name', array(
		'label' => 'Nome'
		)
	);
    echo $this->Form->input('password', array(
		'label' => 'Senha'
		)
	);
	echo $this->Form->file('photo_url', array(
		'label' => 'Avatar',
		'class' => ''
		)
	);  
	echo $this->Form->end(array(
		'label' => 'Salvar Alteracões',
		'class' => 'btn btn-default'
		)
	);
	
?>
</div>