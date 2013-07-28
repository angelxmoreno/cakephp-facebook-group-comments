<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('User Login'); ?></h2>
		<p>
			In order to use our application, we need you to authorize our application to access your group information. Click on the button below to log in with
			Facebook.
		</p>
		<?= $this->Html->link('Login With Facebook', $auth_url, array('class' => 'btn btn-large btn-primary')) ?>
	</div>
</div>
