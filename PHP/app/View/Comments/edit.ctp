<h1>Edit Comment</h1>
<?php

echo $this->Form->create('Comment');
echo $this->Form->input('content', array('value' => $comment['Comment']['content']));
echo $this->Form->end('Save Comment');
?>