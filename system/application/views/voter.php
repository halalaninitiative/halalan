<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Halalan - Ballot - <?php echo $title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Last-Modified" content="<?php echo gmdate('D, d M Y H:i:s'); ?> GMT" />
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0" />
  <meta http-equiv="Pragma" content="no-cache" />
  <?php if (isset($meta) && !empty($meta)): ?>
  <?php echo $meta; ?>
  <?php endif; ?>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/stylesheets/voter.css" />
  <script type="text/javascript" src="<?php echo base_url(); ?>public/javascripts/jquery.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>public/javascripts/jquery.color.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>public/javascripts/common.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>public/javascripts/voter.js"></script>
</head>
<body>
<div id="wrap">
	<div id="header">
		<div id="header_bg">
			<div id="header_left">
				<?php echo img(array('src'=>'public/images/logo_small.png', 'alt'=>'voter logo')); ?>
				<span>ballot</span>
<!--
				<h1>
					<?php echo anchor(site_url(), 'Halalan'); ?>
					<span>ballot</span>
				</h1>
-->
			</div>
			<div id="header_right">
				<?php if (isset($meta) && !empty($meta)): ?>
				<p>YOU ARE NOW LOGGED OUT</p>
				<?php else: ?>
				<p>LOGGED IN AS <?php echo strtoupper($username); ?> | <?php echo anchor('gate/logout', 'LOGOUT'); ?></p>
				<?php endif; ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="menu">
		<ul>
			<?php if (isset($voter_id) && !empty($voter_id)): ?>
			<li>VOTES</li>
			<?php else: ?>
			<li>VOTE</li>
			<li>VERIFY</li>
			<li>LOG OUT</li>
			<?php endif; ?>
		</ul>
	</div>
	<div id="content">
		<?php echo $body; ?>
	</div>
	<div id="footer">
		<div id="footer_bg">
			<div id="footer_left">
				<p>&copy; University of the Philippines Linux Users' Group (UnPLUG)</p>
			</div>
			<div id="footer_right">
				<p>Powered by Halalan <?php echo HALALAN_VERSION; ?></p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</body>
</html>
