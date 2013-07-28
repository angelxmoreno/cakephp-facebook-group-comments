<div class="hero-unit">
	<h1>Facebook Group Comments</h1>
	<p>a better way to view your Facebook Group comments</p>
	<? if (AuthComponent::user('id')) : ?>
	<p><?php echo $this->Html->link('Browse Groups &raquo;', array('admin' => false, 'plugin' => null, 'controller' => 'groups', 'action' => 'index'), array('class' => 'btn btn-primary btn-large', 'escape' => false)) ?></p>
		<p><?php echo $this->Html->link('Log Out &raquo;', array('admin' => false, 'plugin' => null, 'controller' => 'users', 'action' => 'logout'), array('class' => 'btn btn-danger btn-large', 'escape' => false)) ?></p>
	<? else : ?>
	<p><?php echo $this->Html->link('Log In with Facebook &raquo;', array('admin' => false, 'plugin' => null, 'controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-primary btn-large', 'escape' => false)) ?></p>
	<? endif; ?>
</div>

<!-- Example row of columns
<div class="row">
    <div class="span3">
        <h2>Twitter</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
    <div class="span3">
        <h2>Facebook</h2>
        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
        <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
    <div class="span3">
        <h2>Foursquare</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
    <div class="span3">
	    <h2>YouTube</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
</div>
-->