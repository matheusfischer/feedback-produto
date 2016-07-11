<!-- File: /app/View/Posts/index.ctp

<p><?php // echo $this->Html->link('Add Post', array('action' => 'add')); ?></p>

 -->

<h1>Comentários</h1>

<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
    </tr>

<!-- Here's where we loop through our $posts array, printing out post info -->

	<tr>
		<td>
			<?php
				echo $original['Comment']['content'];
			?>
		</td>
	</tr>

	
    <?php foreach ($history as $comment): ?>
    <tr>
        <td>
            <?php
				echo $this->Html->link($comment['Comment']['content'], array('controller' => 'comments', 'action' => 'edit', $comment['Comment']['id']));
				
				if ($comment['Comment']['type'] == 2) {
					echo "&nbsp;*";
				}
			?>
        </td>
        <td>
            <?php echo $comment['Comment']['time']; ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>