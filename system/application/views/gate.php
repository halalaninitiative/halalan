<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Halalan - Login</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/stylesheets/main.css" />
</head>
<body>
<div id="wrap">
	<div id="header">
		<img src="<?= base_url(); ?>public/images/logo.png" alt="logo" />
	</div>
	<?php if (isset($message) && !empty($message)): ?>
	<div>
		<?= $message; ?>
	</div>
	<?php endif; ?>
	<?= form_open('gate/login'); ?>
	<div class="body">
		<div class="center_body" style="text-align : center;">
			<fieldset style="width : 350px; margin : 0 auto;">
				<legend class="position">Login to Halalan</legend>
				<table cellspacing="2" cellpadding="2" align="center">
					<tr>
						<td>Username</td>
						<td><?= form_input(array('name'=>'username', 'maxlength'=>'63')); ?></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><?= form_password(array('name'=>'password')); ?></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><?= form_submit(array('value'=>'Login')); ?></td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class="clear"></div>
	</div>
	</form>
	<div id="footer">
		&copy; 2006-2007 Halalan
		<br />
		University of the Philippines Linux Users' Group
	</div>
</form>
</body>
</html>