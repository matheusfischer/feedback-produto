<div class="modal fade" id="edit-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edição do Comentário</h4>
			</div>
			<div class="modal-body">
				<?php

					echo $this->Form->create('Comment', array(
						'action' => 'edit',
						'inputDefaults' => array(
							'label' => false,
							'div' => false
						)
					));
					
					echo $this->Form->hidden('id', array(
						'id' => 'edit-comment-id'
						)
					);
					
					echo $this->Form->textarea('content', array(
						'id' => 'edit-comment-content',
						'rows' => '20',
						'cols' => '20',
						'class' => 'in-modal'
					));
					
					echo $this->Form->end(array(
						'label' => 'Salvar Alterações',
						'class' => 'btn btn-default'
						)
					);
				?>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>