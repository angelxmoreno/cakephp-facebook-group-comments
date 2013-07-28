<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>
			<?= Configure::read('TwitterBootstrap.AppName') ?>
			<?= $title_for_layout ?>
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<?= $this->Html->css('bootstrap.min') ?>
		<?= $this->Html->css('bootstrap-responsive.min') ?>
		<style>
			/* Sticky footer styles	-------------------------------------------------- */

			html,
			body {
				height: 100%;
				/* The html and body elements cannot have any padding or margin. */
			}

			/* Wrapper for page content to push down footer */
			#wrap {
				min-height: 100%;
				height: auto !important;
				height: 100%;
				/* Negative indent footer by it's height */
				margin: 0 auto -60px;
			}

			/* Set the fixed height of the footer here */
			#push,
			footer {
				height: 60px;
			}
			footer {
				background-color: #f5f5f5;
			}

			/* Lastly, apply responsive CSS fixes as necessary */
			@media (max-width: 767px) {
				#footer {
					margin-left: -20px;
					margin-right: -20px;
					padding-left: 20px;
					padding-right: 20px;
				}
			}

			/* Custom page CSS
			-------------------------------------------------- */
			/* Not required for template or sticky footer method. */

			#wrap > .container {
				padding-top: 60px;
			}
			.container .credit {
				margin: 20px 0;
			}

			code {
				font-size: 80%;
			}
			footer div.container p {
				text-align: center;
			}
			/* -------------------------------------------------- */
			body {
				padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
			}
		</style>


		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le fav and touch icons -->

		<link rel="shortcut icon" href="/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">

		<?php
		echo $this->fetch('meta');
		echo $this->fetch('css');
		?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<?= $this->Html->script('bootstrap.min') ?>
		<?= $this->fetch('script') ?>
	</head>

	<body>

		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="/"><?= Configure::read('TwitterBootstrap.AppName') ?></a>
					<div class="nav-collapse">
						<ul class="nav">
							<? foreach ($navLinks as $name => $link) : ?>
								<? if (!isset($link['auth']) || ((bool) $link['auth'] == (bool) AuthComponent::user())) : ?>
									<li<?= ($this->here == $this->Html->url($link['url'])) ? ' class="active"' : '' ?>>
										<?= $this->Html->Link(__($name), $link['url']) ?>
									</li>
								<? endif; ?>
							<? endforeach; ?>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div class="container">
			<?= ($this->here !== '/') ? $this->Html->getCrumbList(array('class' => 'breadcrumb', 'lastClass' => 'active', 'separator' => '<span class="divider">/</span>'), array('Home', '/')) : '' ?>
			<?=
			$this->Session->flash('flash', array(
			    'element' => 'alert',
			))
			?>
			<?=
			$this->Session->flash('auth', array(
			    'element' => 'alert',
			    'params' => array('plugin' => 'TwitterBootstrap'),
			))
			?>
			<?= $this->fetch('content') ?>
			<div id="push"></div>
		</div> <!-- /container -->

		<footer>
			<div class="container">
				<p class="muted credit"><?= Configure::read('TwitterBootstrap.AppName') ?> &copy; <?= date('Y') ?></p>
			</div>
		</footer>
		<!-- Le javascript
	    ================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->

	</body>
</html>
