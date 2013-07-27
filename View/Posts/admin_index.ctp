<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Posts'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('group_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('from_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('to_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('message');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('likes_count');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('comments_count');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('parent_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modified');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('created');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($posts as $post): ?>
			<tr>
				<td><?php echo h($post['Post']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($post['Group']['name'], array('controller' => 'groups', 'action' => 'view', $post['Group']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($post['Poster']['name'], array('controller' => 'users', 'action' => 'view', $post['Poster']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($post['Recipient']['name'], array('controller' => 'users', 'action' => 'view', $post['Recipient']['id'])); ?>
				</td>
				<td><?php echo h($post['Post']['message']); ?>&nbsp;</td>
				<td><?php echo h($post['Post']['likes_count']); ?>&nbsp;</td>
				<td><?php echo h($post['Post']['comments_count']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($post['ParentPost']['id'], array('controller' => 'posts', 'action' => 'view', $post['ParentPost']['id'])); ?>
				</td>
				<td><?php echo h($post['Post']['modified']); ?>&nbsp;</td>
				<td><?php echo h($post['Post']['created']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $post['Post']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $post['Post']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Post')), array('action' => 'add')); ?></li>
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