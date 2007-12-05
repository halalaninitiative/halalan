<?php

// define BASEPATH so we can access application/config/database.php
// yes, that is the only purpose of this
// so we can put any value here
define('BASEPATH', '');

require_once('../system/application/config/database.php');

extract($db['default']);

$some_random_variable_again = true;
if (empty($dbdriver) || ($dbdriver != 'mysql' && $dbdriver != 'postgre'))
{
	$some_random_variable_again = false;
}
else
{
	$some_random_variable = true;
	if ($dbdriver == 'mysql')
	{
		$link = mysql_connect($hostname, $username, $password);
		//alert($link);
		//echo($link);
		if (!$link)
		{
			$some_random_variable = false;
		}
		else
		{
			$db_selected = mysql_select_db($database, $link);
			if (!$db_selected)
			{
				$some_random_variable = false;
			}
		}
	}
	else if ($dbdriver == 'postgre')
	{
		$some_random_variable = pg_connect("host='$hostname' port='$port' dbname='$database' user='$username' password='$password'");
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Halalan - Install</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
</head>
<body>
<div id="wrap">
	<div id="header">
		<img src="images/logo.png" alt="logo" />
	</div>
	<div class="body">
		<div class="center_body">
<?php
if (!$some_random_variable_again)
{
?>
			<fieldset>
				<legend class="position">Error</legend>
				<p>It seems like your database driver is missing or misconfigured.<br />Please correct it at system/application/config/database.php.</p>
			</fieldset>
<?php
}
else if (!$some_random_variable)
{
?>
			<fieldset>
				<legend class="position">Error</legend>
				<p>It seems like your database settings are misconfigured.<br />Please correct it at system/application/config/database.php.</p>
			</fieldset>
<?php
}
else
{
?>
			<fieldset>
				<legend class="position">Welcome to the Halalan Installer!</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td><p>Halalan is an open-source voting system designed for student elections. It aims to automate the manual processes of elections such as counting, archiving, and voting. It is designed to be easy-to-use and secure.</p><p>Please fill up the form below.  All fields are required.  Take note that <span style="color : red; ">changing the election settings after you have entered some data will break the system</span> so please review them carefully.</p></td>
					</tr>
				</table>
			</fieldset>
			<br />
			<form method="post" action="ok.php">
			<fieldset>
				<legend class="position">Administrator Settings</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td width="35%">First Name</td>
						<td width="65%"><input type="text" name="first_name" maxlength="63" /></td>
					</tr>
					<tr>
						<td width="35%">Last Name</td>
						<td width="65%"><input type="text" name="last_name" maxlength="31" /></td>
					</tr>
					<tr>
						<td width="35%">Email</td>
						<td width="65%"><input type="text" name="email" maxlength="63" /></td>
					</tr>
				</table>
			</fieldset>
			<br />
			<fieldset>
				<legend class="position">Election Settings</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td width="35%">Name</td>
						<td width="65%"><input type="text" name="name" value="Election Name" /></td>
					</tr>
					<tr>
						<td width="35%">Pin</td>
						<td width="65%"><input type="radio" name="pin" value="TRUE" checked="true" /> enable <input type="radio" name="pin" value="FALSE" /> disable</td>
					</tr>
					<tr>
						<td width="35%">Password and Pin Generation</td>
						<td width="65%"><select name="password_pin_generation"><option value="web" selected="selected">Web</option><option value="email">Email</option></select></td>
					</tr>
					<tr>
						<td width="35%">Password and Pin Characters</td>
						<td width="65%"><select name="password_pin_characters"><option value="alnum" selected="selected">Alphanumeric</option><option value="numeric">Numeric</option><option value="nozero">No Zero</option></select></td>
					</tr>
					<tr>
						<td width="35%">Password Length</td>
						<td width="65%"><select name="password_length">
						<?php for ($i = 4; $i < 11; $i++) { ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td width="35%">Pin Length</td>
						<td width="65%"><select name="pin_length">
						<?php for ($i = 4; $i < 11; $i++) { ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td width="35%">CAPTCHA</td>
						<td width="65%"><input type="radio" name="captcha" value="TRUE" checked="true" /> enable <input type="radio" name="captcha" value="FALSE" /> disable</td>
					</tr>
					<tr>
						<td width="35%">Language</td>
						<td width="65%"><select name="language"><option value="english">English</option><option value="filipino">Filipino</option></select></td>
					</tr>
				</table>
			</fieldset>
			<br />
			<fieldset>
				<legend class="position"></legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td align="center"><input type="submit" value="Install" /></td>
					</tr>
				</table>
			</fieldset>
			</form>
<?php
}
?>
			<br />
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer">
		&copy; 2006-2007 Halalan
		<br />
		University of the Philippines Linux Users' Group
	</div>
</body>
</html>