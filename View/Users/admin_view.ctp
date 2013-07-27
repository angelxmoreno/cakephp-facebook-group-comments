<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('User');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($user['User']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($user['User']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Access Token'); ?></dt>
			<dd>
				<?php echo h($user['User']['access_token']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Token Expires'); ?></dt>
			<dd>
				<?php echo h($user['User']['token_expires']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Pic Url'); ?></dt>
			<dd>
				<?php echo h($user['User']['pic_url']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($user['User']['created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modified'); ?></dt>
			<dd>
				<?php echo h($user['User']['modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('User')), array('action' => 'edit', $user['User']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('User')), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Users')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('User')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Groups')), array('controller' => 'groups', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Owned Group')), array('controller' => 'groups', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Posts')), array('controller' => 'posts', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Wall Post')), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Groups')); ?></h3>
	<?php if (!empty($user['OwnedGroup'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Members Count'); ?></th>
				<th><?php echo __('Icon'); ?></th>
				<th><?php echo __('Admin Id'); ?></th>
				<th><?php echo __('Created'); ?></th>
				<th><?php echo __('Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($user['OwnedGroup'] as $ownedGroup): ?>
			<tr>
				<td><?php echo $ownedGroup['id'];?></td>
				<td><?php echo $ownedGroup['name'];?></td>
				<td><?php echo $ownedGroup['description'];?></td>
				<td><?php echo $ownedGroup['members_count'];?></td>
				<td><?php echo $ownedGroup['icon'];?></td>
				<td><?php echo $ownedGroup['admin_id'];?></td>
				<td><?php echo $ownedGroup['created'];?></td>
				<td><?php echo $ownedGroup['modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'groups', 'action' => 'view', $ownedGroup['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'groups', 'action' => 'edit', $ownedGroup['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'groups', 'action' => 'delete', $ownedGroup['id']), null, __('Are you sure you want to delete # %s?', $ownedGroup['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Owned Group')), array('controller' => 'groups', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Posts')); ?></h3>
	<?php if (!empty($user['WallPost'])):?>
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
		<?php foreach ($user['WallPost'] as $wallPost): ?>
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
		<h3><?php echo __('Related %s', __('Groups')); ?></h3>
	<?php if (!empty($user['Group'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Members Count'); ?></th>
				<th><?php echo __('Icon'); ?></th>
				<th><?php echo __('Admin Id'); ?></th>
				<th><?php echo __('Created'); ?></th>
				<th><?php echo __('Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($user['Group'] as $group): ?>
			<tr>
				<td><?php echo $group['id'];?></td>
				<td><?php echo $group['name'];?></td>
				<td><?php echo $group['description'];?></td>
				<td><?php echo $group['members_count'];?></td>
				<td><?php echo $group['icon'];?></td>
				<td><?php echo $group['admin_id'];?></td>
				<td><?php echo $group['created'];?></td>
				<td><?php echo $group['modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'groups', 'action' => 'view', $group['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'groups', 'action' => 'edit', $group['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'groups', 'action' => 'delete', $group['id']), null, __('Are you sure you want to delete # %s?', $group['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Group')), array('controller' => 'groups', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
