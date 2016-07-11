<?php
	echo $this->element('menu', array(
		'login' => $isLoggedIn
	));
?>

<div class="product">
	<h1>Produto</h1>
</div>

<hr />

<div class="subcontainer container-fluid">
    <?php	
		foreach ($comments as $comment) {
			echo $this->element('comment', array(
				'comment'	=> $comment['Comment'],
				'author'	=> $comment['Comment']['author'][0]['User']
			));
		}
	?>
</div>

<hr />

<?php

	if ($isLoggedIn) {
	
?>
<h4>Inserir Comentário</h4>
<?php

		echo $this->Form->create('Comment', array(
			'action' => 'add',
			'inputDefaults' => array(
				'label' => false,
				'div' => false
			)
		));
		
		echo $this->Form->textarea('content', array(
			'rows' => '20',
			'cols' => '20',
		));
		
		echo $this->Form->end(array(
			'label' => 'Adicionar Comentário',
			'class' => 'btn btn-default'
			)
		);
		
	}
?>