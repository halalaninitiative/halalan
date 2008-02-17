<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Halalan - Ballot - <?= $title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <?php if (isset($meta) && !empty($meta)): ?>
  <?= $meta; ?>
  <?php endif; ?>
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/stylesheets/voter.css" />
  <script type="text/javascript" src="<?= base_url(); ?>public/javascripts/jquery.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>public/javascripts/jquery.cookie.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>public/javascripts/voter.js"></script>
</head>
<body>
<div id="wrap">
	<div id="header">
		<div id="header_bg">
			<div id="header_left">
				<?= img(array('src'=>'public/images/logo_voter.png', 'alt'=>'voter logo')); ?>
<!--
				<h1>
					<?= anchor(site_url(), 'Halalan'); ?>
					<span>ballot</span>
				</h1>
-->
			</div>
			<div id="header_right">
				<?php if (isset($meta) && !empty($meta)): ?>
				<p>YOU ARE NOW LOGGED OUT</p>
				<?php else: ?>
				<p>LOGGED IN AS <?= strtoupper($username); ?> | <?= anchor('gate/logout', 'LOGOUT'); ?></p>
				<?php endif; ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="menu">
		<ul>
			<?php if (isset($voter_id) && !empty($voter_id)): ?>
			<li><?= anchor('voter/votes', 'VOTES', array('onclick'=>'return false;')); ?></li>
			<?php else: ?>
			<li><?= anchor('voter/vote', 'VOTE', array('onclick'=>'return false;')); ?></li>
			<li><?= anchor('voter/confirm_vote', 'CONFIRM VOTE', array('onclick'=>'return false;')); ?></li>
			<li><?= anchor('voter/logout', 'LOG OUT', array('onclick'=>'return false;')); ?></li>
			<?php endif; ?>
		</ul>
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