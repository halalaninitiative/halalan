<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Halalan - Gate - <?= $title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/stylesheets/gate.css" />
  <script type="text/javascript" src="<?= base_url(); ?>public/javascripts/jquery.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>public/javascripts/gate.js"></script>
</head>
<body>
<div id="wrap">
	<div id="header">
		<div id="header_bg">
			<div id="header_left">
				<?= img(array('src'=>'public/images/logo_login.png', 'alt'=>'login logo')); ?>
<!--
				<h1>
					<?= anchor(site_url(), 'Halalan'); ?>
					<span>administration</span>
				</h1>
-->
			</div>
			<div id="header_right">
				<p>
				<?php if ($login == 'voter'): ?>
				<?= anchor('gate/admin', 'ADMIN LOGIN'); ?>
				<?php else: ?>
				<?= anchor('gate/voter', 'VOTER LOGIN'); ?>
				<?php endif; ?>
				</p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="content">
		<?= $body; ?>
	</div>
	<div id="footer">
		<div id="footer_bg">
			<div id="footer_left">
				<p>&copy; University of the Philippines Linux Users' Group (UnPLUG)</p>
			</div>
			<div id="footer_right">
				<p>Powered by Halalan 1.1.0</p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</body>
</html>