<?php

// define BASEPATH so we can access application/config/database.php
// yes, that is the only purpose of this
// so we can put any value here
define('BASEPATH', '');

require_once('../system/application/config/database.php');

extract($db['default']);

$missing_driver = false;
if (empty($dbdriver) || ($dbdriver != 'mysql' && $dbdriver != 'postgre'))
{
	$missing_driver = true;
}
else
{
	$misconfigured_settings = false;
	if ($dbdriver == 'mysql')
	{
		$link = @mysql_connect($hostname, $username, $password);
		if (!$link)
		{
			$misconfigured_settings = true;
		}
		else
		{
			$db_selected = @mysql_select_db($database, $link);
			if (!$db_selected)
			{
				$misconfigured_settings = true;
			}
			else
			{
				$query = "SELECT * FROM admins";
				$result = @mysql_query($query);
				$test = FALSE;
				while ($row = @mysql_fetch_array($result))
				{
					if (!empty($row))
					{
						$test = TRUE;
						break;
					}
				}
				if ($test)
				{
					echo "Halalan is already installed.";
					exit;
				}
			}
		}
	}
	else if ($dbdriver == 'postgre')
	{
		$link = @pg_connect("host='$hostname' port='$port' dbname='$database' user='$username' password='$password'");
		if (!$link)
		{
			$misconfigured_settings = true;
		}
		else
		{
			$query = "SELECT * FROM admins";
			$result = @pg_query($query);
			$test = FALSE;
			while ($row = @pg_fetch_array($result))
			{
				if (!empty($row))
				{
					$test = TRUE;
					break;
				}
			}
			if ($test)
			{
				echo "Halalan is already installed.";
				exit;
			}
		}
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
if ($missing_driver)
{
?>
			<fieldset>
				<legend class="position">Error</legend>
				<p>It seems like your database driver is missing or misconfigured.<br />Please correct it at system/application/config/database.php.</p>
			</fieldset>
<?php
}
else if ($misconfigured_settings)
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
			<form method="post" action="ok.php">
			<fieldset>
				<legend class="position">Administrator Settings</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td class="w35">First Name</td>
						<td><input type="text" name="first_name" maxlength="63" /></td>
					</tr>
					<tr>
						<td class="w35">Last Name</td>
						<td><input type="text" name="last_name" maxlength="31" /></td>
					</tr>
					<tr>
						<td class="w35">Email</td>
						<td><input type="text" name="email" maxlength="63" /></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend class="position">Election Settings</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td class="w35">URL</td>
						<td><input type="text" name="url" value="http://localhost/" /> with trailing slash</td>
					</tr>
					<tr>
						<td class="w35">Name</td>
						<td><input type="text" name="name" value="Election Name" /></td>
					</tr>
					<tr>
						<td class="w35">PIN</td>
						<td><label><input type="checkbox" name="pin" value="TRUE" /> use in ballot validation?</label></td>
					</tr>
					<tr>
						<td class="w35">Password and PIN Generation</td>
						<td><select name="password_pin_generation"><option value="web" selected="selected">Web</option><option value="email">Email</option></select></td>
					</tr>
					<tr>
						<td class="w35">Password and PIN Characters</td>
						<td><select name="password_pin_characters"><option value="alnum" selected="selected">Alphanumeric</option><option value="numeric">Numeric</option><option value="nozero">No Zero</option></select></td>
					</tr>
					<tr>
						<td class="w35">Password Length</td>
						<td><select name="password_length">
						<?php for ($i = 4; $i < 11; $i++) { ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td class="w35">PIN Length</td>
						<td><select name="pin_length">
						<?php for ($i = 4; $i < 11; $i++) { ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td class="w35">CAPTCHA</td>
						<td><label><input type="checkbox" name="captcha" value="TRUE" /> use in ballot validation?</label></td>
					</tr>
					<tr>
						<td class="w35">CAPTCHA Length</td>
						<td><select name="captcha_length">
						<?php for ($i = 4; $i < 11; $i++) { ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td class="w35">Language</td>
						<td><select name="language"><option value="english">English</option><option value="filipino">Filipino</option></select></td>
					</tr>
					<tr>
						<td class="w35">Candidate Details</td>
						<td><label><input type="checkbox" name="details" value="TRUE" /> show in ballot?</label></td>
					</tr>
					<tr>
						<td class="w35">Candidate Order</td>
						<td><label><input type="checkbox" name="random" value="TRUE" /> randomize order in ballot?</label></td>
					</tr>
					<tr>
						<td class="w35">Virtual Paper Trail</td>
						<td><label><input type="checkbox" name="image_trail" value="TRUE" /> generate virtual paper trail (image file)?</label></td>
					</tr>
					<tr>
						<td class="w35">Virtual Paper Trail Path</td>
						<td><input type="text" name="image_trail_path" size="40" value="/var/www/html/w/" /></td>
					</tr>
				</table>
			</fieldset>
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
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer">
		<br />
		&copy; University of the Philippines Linux Users' Group (UnPLUG)
	</div>
</div>
</body>
</html>
