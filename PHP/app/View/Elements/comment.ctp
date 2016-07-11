<div id="_comment<?php echo $comment['id']; ?>">
	<div class="row-fluid comment-row">
		<div class="span1">
			<?php if ($author['photo_url']): ?>
				<img class="avatar" src="img/<?php echo $author['photo_url']; ?>"/>
			<?php else: ?>
				<img class="avatar" src="<?php echo Router::url('/', true); ?>img/default.gif" />
			<?php endif; ?>
		</div>
		<div class="span8">
			<p class="content">
				<strong data-toggle="tooltip" data-placement="top" title="<?php echo $author['email'] ?>"><?php echo $author['name'] ?></strong>
				<?php echo $comment['content']; ?> 
			</p>
		</div>
		<div class="span3">
			<span class="datetime" data-toggle="tooltip" data-placement="right" title="<?php echo $comment['created']; ?>">há <?php echo $comment['time']; ?></span><br />
			<span class="actions">				
				<?php
					$hasHistory = false;
				
					if (in_array($comment['type'], array(2, 3))) {
						$hasHistory = true;
						echo $this->Html->link('Editado', '#', array('class' => 'history', 'cid' => $comment['id']));
					}
					
					if ($comment['owned']) {
						if ($hasHistory) {
							echo ' | ';
						}
						echo $this->Html->link('Editar', '#', array('class' => 'edit', 'cid' => $comment['id'], 'content' => $comment['content']));
						echo ' | '. $this->Html->link('Apagar', '#', array('class' => 'del', 'cid' => $comment['id']));
					}
				?>
			</span>
		</div>
	</div>
</div>