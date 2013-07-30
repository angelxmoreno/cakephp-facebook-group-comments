<div class="row-fluid">
	<div class="span9">
		<h2>Groups</h2>
		<p>Below are a list of groups you belong to</p>
		<div class="btn-group btn-group-vertical">
<? if ($groups) foreach ($groups as $group) : ?>
			<?= $this->Html->link($this->Html->image($group['icon_small']) . '&nbsp; ' . $group['name'], array('action' => 'view', $group['id']), array('class' => 'btn btn-large long-wait', 'escape' => false)) ?>
<? endforeach; ?>
		</div>
	</div>
</div>