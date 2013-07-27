<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Group');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($group['Group']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($group['Group']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($group['Group']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Members Count'); ?></dt>
			<dd>
				<?php echo h($group['Group']['members_count']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Icon'); ?></dt>
			<dd>
				<?php echo h($group['Group']['icon']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Admin Id'); ?></dt>
			<dd>
				<?php echo h($group['Group']['admin_id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($group['Group']['created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modified'); ?></dt>
			<dd>
				<?php echo h($group['Group']['modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Group')), array('action' => 'edit', $group['Group']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Group')), array('action' => 'delete', $group['Group']['id']), null, __('Are you sure you want to delete # %s?', $group['Group']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Groups')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Group')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Users')), array('controller' => 'users', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Admin')), array('controller' => 'users', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Posts')), array('controller' => 'posts', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Wall Post')), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Posts')); ?></h3>
	<?php if (!empty($group['WallPost'])):?>
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
		<?php foreach ($group['WallPost'] as $wallPost): ?>
			<tr>
				<td><?php echo $wallPost['id'];?></td>
				<td><?php echo $wallPost['group_id'];?></td>
				<td><?php echo $wallPost['from_id'];?></td>
				<td><?php echo $wallPost['to_id'];?></td>
				<td><?php echo $wallPost['message'];?></td>
				<td><?php echo $wallPost['likes_count'];?></td>
				<td><?php echo $wallPost['comments_count'];?></td>
				<td><?php echo $wallPost['parent_id'];?></td>
				<td><?php echo $wallPost['modified'];?></td>
				<td><?php echo $wallPost['created'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'posts', 'action' => 'view', $wallPost['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'posts', 'action' => 'edit', $wallPost['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'posts', 'action' => 'delete', $wallPost['id']), null, __('Are you sure you want to delete # %s?', $wallPost['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Wall Post')), array('controller' => 'posts', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Users')); ?></h3>
	<?php if (!empty($group['GroupMember'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Access Token'); ?></th>
				<th><?php echo __('Token Expires'); ?></th>
				<th><?php echo __('Pic Url'); ?></th>
				<th><?php echo __('Created'); ?></th>
				<th><?php echo __('Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($group['GroupMember'] as $groupMember): ?>
			<tr>
				<td><?php echo $groupMember['id'];?></td>
				<td><?php echo $groupMember['name'];?></td>
				<td><?php echo $groupMember['access_token'];?></td>
				<td><?php echo $groupMember['token_expires'];?></td>
				<td><?php echo $groupMember['pic_url'];?></td>
				<td><?php echo $groupMember['created'];?></td>
				<td><?php echo $groupMember['modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $groupMember['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $groupMember['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $groupMember['id']), null, __('Are you sure you want to delete # %s?', $groupMember['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Group Member')), array('controller' => 'users', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
