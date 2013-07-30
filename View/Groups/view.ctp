<div class="row-fluid">
	<div class="span9">
		<h2><?= $this->Html->image($group['Group']['icon_big']) ?><?= h($group['Group']['name']) ?></h2>
		<span><?= $this->Html->link('Visit the ' . $group['Group']['name'] . ' group on Facebook', 'http://facebook.com/' . $group['Group']['id']) ?></span>
		<dl>
			<dt><?= __('Admin') ?></dt>
			<dd>
				<?= $this->FacebookCanvas->userImage($group['Group']['admin_id']) ?>
				&nbsp;
			</dd>
			<dt><?= __('Description') ?></dt>
			<dd>
				<?= h($group['Group']['description']) ?>
				&nbsp;
			</dd>

		</dl>
	</div>
</div>

<div class="row-fluid">
	<h3>Posts</h3>
	<?php if (!empty($group['WallPost'])): ?>
	<table class="table">
		<tr>
			<th><?= __('Author') ?></th>
			<th><?= __('Message') ?></th>
			<th><?= __('Post Date') ?></th>
		</tr>
			<? $i = 0; ?>
			<? foreach ($group['WallPost'] as $wallPost): $i++ ?>
		<? if ($wallPost['type'] == 'status') : ?>
		<tr>
			<td><?= $this->FacebookCanvas->userImage($wallPost['from_id'], array('width' => 50, 'height' => 50)) ?></td>
			<td>
				<?= (@$wallPost['message']) ? $this->element('post_message_text', array('post' => $wallPost)) : $this->element('post_message_picture', array('post' => $wallPost)) ?>
				<div class="comment_like">
					<span><?= $wallPost['comments_count']; ?> Likes</span>
					<span><?= $wallPost['likes_count']; ?> Comments</span>
				</div>
			</td>
			<td><?= $this->Time->timeAgoInWords($wallPost['created_at'])?></td>
		</tr>
		<? endif; ?>
			<?php endforeach ?>
	</table>
		<?= $this->Html->link('Older Posts', '#', array('id' => 'fetch_next_posts', 'class' => 'btn btn-large btn-primary')) ?>
<?php endif ?>

</div>

<script>
	var postsPage = 1;
	$('#fetch_next_posts').click(function(event){
		event.preventDefault();
		
	});
</script>
