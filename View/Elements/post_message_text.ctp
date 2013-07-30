<?php
echo $this->Html->link($this->Text->truncate(h($post['message']), 100, array(
'ellipsis' => '...',
 'exact' => true,
 'html' => false
)), array('admin' => false, 'plugin' => null, 'controller' => 'posts', 'action' => 'view', $post['id']), array('class' => 'long-wait'));