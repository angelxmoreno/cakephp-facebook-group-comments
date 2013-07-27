<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Post');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($post['Post']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Group'); ?></dt>
			<dd>
				<?php echo $this->Html->link($post['Group']['name'], array('controller' => 'groups', 'action' => 'view', $post['Group']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Poster'); ?></dt>
			<dd>
				<?php echo $this->Html->link($post['Poster']['name'], array('controller' => 'users', 'action' => 'view', $post['Poster']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Recipient'); ?></dt>
			<dd>
				<?php echo $this->Html->link($post['Recipient']['name'], array('controller' => 'users', 'action' => 'view', $post['Recipient']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Message'); ?></dt>
			<dd>
				<?php echo h($post['Post']['message']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Likes Count'); ?></dt>
			<dd>
				<?php echo h($post['Post']['likes_count']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Comments Count'); ?></dt>
			<dd>
				<?php echo h($post['Post']['comments_count']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Parent Post'); ?></dt>
			<dd>
				<?php echo $this->Html->link($post['ParentPost']['id'], array('controller' => 'posts', 'action' => 'view', $post['ParentPost']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modified'); ?></dt>
			<dd>
				<?php echo h($post['Post']['modified']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($post['Post']['created']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Post')), array('action' => 'edit', $post['Post']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Post')), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Posts')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Post')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Groups')), array('controller' => 'groups', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Group')), array('controller' => 'groups', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Users')), array('controller' => 'users', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Poster')), array('controller' => 'users', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Posts')), array('controller' => 'posts', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Parent Post')), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Posts')); ?></h3>
	<?php if (!empty($post['ChildPost'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Group Id'); ?></th>
				<th><?php echo __('From Id'); ?></th>
				<th><?php echo __('To Id'); ?></th>
				<th><?php echo __('Message'); ?></th>
				<th><?php echo __('Likes Count'); ?></th>
				<th><?php echo __('Comments Count'); ?></th>
				<th><?php echo __('Parent Id'); ?></th>
				<th><?php echo __('Modified'); ?></th>
				<th><?php echo __('Created'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($post['ChildPost'] as $childPost): ?>
			<tr>
				<td><?php echo $childPost['id'];?></td>
				<td><?php echo $childPost['group_id'];?></td>
				<td><?php echo $childPost['from_id'];?></td>
				<td><?php echo $childPost['to_id'];?></td>
				<td><?php echo $childPost['message'];?></td>
				<td><?php echo $childPost['likes_count'];?></td>
				<td><?php echo $childPost['comments_count'];?></td>
				<td><?php echo $childPost['parent_id'];?></td>
				<td><?php echo $childPost['modified'];?></td>
				<td><?php echo $childPost['created'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'posts', 'action' => 'view', $childPost['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'posts', 'action' => 'edit', $childPost['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'posts', 'action' => 'delete', $childPost['id']), null, __('Are you sure you want to delete # %s?', $childPost['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Child Post')), array('controller' => 'posts', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
