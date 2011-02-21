<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Halalan - Gate - <?php echo $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/stylesheets/gate.css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>public/javascripts/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/javascripts/jquery.color.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/javascripts/sha1.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/javascripts/common.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/javascripts/gate.js"></script>
</head>
<body>
<div id="wrap">
	<div id="header">
		<div id="header_bg">
			<div id="header_left">
				<?php echo img(array('src'=>'public/images/logo_small.png', 'alt'=>'login logo')); ?>
				<?php if ($login != 'results' && $login != 'statistics'): ?>
				<span>login</span>
				<?php endif; ?>
<!--
				<h1>
					<?php echo anchor(site_url(), 'Halalan'); ?>
					<span>administration</span>
				</h1>
-->
			</div>
		<?php if ($login == 'admin'): ?>
			<div id="header_right">
				<p>GO TO
				<?php echo anchor('gate/voter', 'VOTER LOGIN'); ?>
				</p>
			</div>
		<?php endif; ?>
			<div class="clear"></div>
		</div>
	</div>
	<?php if ($login == 'results' || $login == 'statistics'): ?>
	<div id="menu">
		<ul>
			<li><?php echo anchor('gate/results', 'RESULTS', array('title'=>'Results')); ?></li>
			<li><?php echo anchor('gate/statistics', 'STATISTICS', array('title'=>'Statistics')); ?></li>
		</ul>
	</div>
	<?php endif; ?>
	<div id="content">
		<?php echo $body; ?>
	</div>
	<div id="footer">
		<div id="footer_bg">
			<div id="footer_left">
				<p><a href="http://uplug.org">&copy; University of the Philippines Linux Users' Group (UnPLUG)</a></p>
			</div>
			<div id="footer_right">
				<p><a href="http://halalan.uplug.org">Powered by Halalan <?php echo HALALAN_VERSION; ?></a></p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</body>
</html>
