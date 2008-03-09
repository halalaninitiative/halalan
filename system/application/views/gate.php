<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Halalan - Gate - <?= $title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/stylesheets/gate.css" />
  <script type="text/javascript" src="<?= base_url(); ?>public/javascripts/jquery.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>public/javascripts/jquery.color.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>public/javascripts/common.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>public/javascripts/gate.js"></script>
</head>
<body>
<div id="wrap">
	<div id="header">
		<div id="header_bg">
			<div id="header_left">
				<?= img(array('src'=>'public/images/logo_small.png', 'alt'=>'login logo')); ?>
				<?php if ($login != 'result' && $login != 'statistics'): ?>
				<span>login</span>
				<?php endif; ?>
<!--
				<h1>
					<?= anchor(site_url(), 'Halalan'); ?>
					<span>administration</span>
				</h1>
-->
			</div>
			<div id="header_right">
				<p>GO TO
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
	<?php if ($login == 'result' || $login == 'statistics'): ?>
	<div id="menu">
		<ul>
			<li><?= anchor('gate/results', 'RESULTS', array('title'=>'Results')); ?></li>
			<li><?= anchor('gate/statistics', 'STATISTICS', array('title'=>'Statistics')); ?></li>
		</ul>
	</div>
	<?php endif; ?>
	<div id="content">
		<?= $body; ?>
	</div>
	<div id="footer">
		<div id="footer_bg">
			<div id="footer_left">
				<p>&copy; University of the Philippines Linux Users' Group (UnPLUG)</p>
			</div>
			<div id="footer_right">
				<?php
					$CI =& get_instance();
				?>
				<p>Powered by Halalan <?= $CI->config->item('halalan_version'); ?></p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</body>
</html>
