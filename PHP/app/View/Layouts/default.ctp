<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Produto</title>
	<?php
		echo $this->Html->css('bootstrap.min.css');
		echo $this->Html->css('bootstrap-responsive.min.css');
		echo $this->Html->css('comments.css');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		
		echo $this->Html->script('jquery-2.1.1.min');
		echo $this->Html->script('bootstrap.min');
		echo $this->fetch('script');
	?>
</head>
<body>

	<?php echo $this->Session->flash(); ?>
	
	<div class="loading-container">
		<p class="nomargpad">Carregando...</p>
	</div>

	<div class="container">
		<?php echo $this->fetch('content'); ?>
	</div>
	
	<?php
		echo $this->element('historyModal');
		echo $this->element('editModal');
		
		echo $this->element('js');
	?>
</body>
</html>
