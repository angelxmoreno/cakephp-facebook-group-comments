<div class="row-fluid">
	<div class="span9">
		<p>
			<?= $this->Html->link($post['Poster']['name'], 'https://www.facebook.com/' . $post['Poster']['id']) ?>
			from
			<?= $this->Html->link($post['Group']['name'], array('controller' => 'groups', 'action' => 'view', $post['Group']['id'])) ?>
			asks:
		</p>
		<blockquote>
			<p><?=h($post['Post']['message'])?></p>
		</blockquote>
		<? /*
		<dl>
			<dt><?=__('Type') ?></dt>
			<dd>
				<?=h($post['Post']['type']) ?>
				&nbsp;
			</dd>
			<dt><?=__('Full Picture') ?></dt>
			<dd>
				<?=h($post['Post']['full_picture']) ?>
				&nbsp;
			</dd>
			<dt><?=__('Picture') ?></dt>
			<dd>
				<?=h($post['Post']['picture']) ?>
				&nbsp;
			</dd>
			<dt><?=__('Link') ?></dt>
			<dd>
				<?=h($post['Post']['link']) ?>
				&nbsp;
			</dd>
			<dt><?=__('Likes Count') ?></dt>
			<dd>
				<?=h($post['Post']['likes_count']) ?>
				&nbsp;
			</dd>
			<dt><?=__('Comments Count') ?></dt>
			<dd>
				<?=h($post['Post']['comments_count']) ?>
				&nbsp;
			</dd>
		 *
		 */ ?>
			<dt><?=__('Created At') ?></dt>
			<dd>
				<?=h($post['Post']['created_at']) ?>
				&nbsp;
			</dd>
			<dt><?=__('Updated At') ?></dt>
			<dd>
				<?=h($post['Post']['modified']) ?>
				&nbsp;
			</dd>
		</dl>
	</div>
</div>

<div class="row-fluid">
		<h3><?=__('Related %s', __('Posts')) ?></h3>
	<?php if (!empty($post['ChildPost'])):?>
		<table class="table">
			<tr>
				<th></th>
				<th><?=__('Comment') ?></th>
				<th><?=__('Created At') ?></th>
			</tr>
		<?php foreach ($post['ChildPost'] as $childPost):  ?>
			<tr>
				<td nowrap><?= $this->FacebookCanvas->userImage($childPost['from_id'], array('width' => 50, 'height' => 50)) ?></td>
				<td>
					<h4><?= (@$childPost['message'])?></h4>
					<div class="comment_like">
						<span><?= $childPost['comments_count']; ?> Likes - </span>
						<span><?= $childPost['likes_count']; ?> Comments</span>
					</div>
				</td>
				<td nowrap><?= $this->Time->timeAgoInWords($childPost['created_at']) ?></td>
			</tr>
		<?php endforeach ?>
		</table>
	<?php endif ?>
</div>
