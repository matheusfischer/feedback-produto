<?php

	echo $this->Form->create('Comment');
	echo $this->Form->input('content');
	echo $this->Form->end(__('Submit'));
	
?>