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
	<table id="tbl-results" class="table">
		<tr>
			<th><?= __('Author') ?></th>
			<th><?= __('Message') ?></th>
			<th><?= __('Post Date') ?></th>
		</tr>
			<? $i = 0; ?>
			<? foreach ($group['WallPost'] as $wallPost): $i++ ?>
		<? if ($wallPost['type'] == 'status' && @$wallPost['message']) : ?>
		<tr>
			<td><?= $this->FacebookCanvas->userImage($wallPost['from_id'], array('width' => 50, 'height' => 50)) ?></td>
			<td>
				<?= (@$wallPost['message']) ? $this->element('post_message_text', array('post' => $wallPost)) : ''; //$this->element('post_message_picture', array('post' => $wallPost)) ?>
				<div class="comment_like">
					<span><?= $wallPost['comments_count']; ?> Likes - </span>
					<span><?= $wallPost['likes_count']; ?> Comments</span>
					<p><?= $this->Html->link('View Post ' . $wallPost['id'], array('admin' => false, 'plugin' => null, 'controller' => 'posts', 'action' => 'view', $wallPost['id']), array('class' => 'long-wait')) ?></p>
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
	var fetchPostsUrl = '/groups/group_posts_page/';
	var groupId = '<?= $group['Group']['id'] ?>';
	$('#fetch_next_posts').click(function(event){
		event.preventDefault();
		$('#loading-indicator').show();
		nextPage = postsPage+1;
		console.log(nextPage);
		url2fetch = fetchPostsUrl + groupId + '/' + nextPage;
		console.log(url2fetch);
		$.getJSON(url2fetch, function(data) {
			newRow = '';
			$.each(data, function(index, elem){
				newRow = newRow + buildRow(elem);
			});
			$(newRow).hide().appendTo('#tbl-results').fadeIn('slow', function(){
				$.scrollTo('#fetch_next_posts')
			});
			postsPage = nextPage;
		})
		//.done(function() { console.log( "second success" ); })
		//.fail(function() { console.log( "error" ); })
		.always(function() { $('#loading-indicator').fadeOut(); });
	});

	function buildRow(rowData){
		trimmedMsg = jQuery.trim(rowData.message).substring(0, 100).split(' ').slice(0, -1).join(' ') + '...';

		var rowHtml = '<tr><td><img src="https://graph.facebook.com/'+rowData.from_id+'/picture?" width="50" height="50" alt=""></td><td><a href="/posts/view/'+rowData.id+'" class="long-wait">'+trimmedMsg+'</a><div class="comment_like"><span>'+rowData.likes_count+' Likes - </span><span>'+rowData.comments_count+' Comments</span></div></td><td>'+rowData.created_at+'</td></tr>';
		return rowHtml;
	}
</script>
