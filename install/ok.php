<?php
/**
 * Copyright (C) 2006-2011  University of the Philippines Linux Users' Group
 *
 * This file is part of Halalan.
 *
 * Halalan is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Halalan is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Halalan.  If not, see <http://www.gnu.org/licenses/>.
 */

$error = FALSE;
// error checking
if (empty($_POST['first_name']))
	$error = TRUE;
if (empty($_POST['last_name']))
	$error = TRUE;
if (empty($_POST['email']))
	$error = TRUE;
if (empty($_POST['url']))
	$error = TRUE;
if (empty($_POST['image_trail_path']))
	$error = TRUE;
if (isset($_POST['captcha']) || isset($_POST['image_trail']))
{
	if (!extension_loaded('gd') || !function_exists('gd_info'))
	{
		echo "The PHP installation doesn't seem to have a GD extension.  Please install the GD library and install Halalan again.";
		exit;
	}
}
if ($error)
{
	echo "The installer encountered some errors.  Please use your browser back button to go back and correct them.";
	exit;
}

// DB creation
define('BASEPATH', '');

require_once('../system/application/config/database.php');
require_once('../system/application/config/config.php');
extract($db['default']);
$link = mysql_connect($hostname, $username, $password);
mysql_select_db($database, $link);
$queries = explode(";", file_get_contents("mysql.sql"));
foreach ($queries as $query)
{
	if (!empty($query))
		mysql_query($query);
}

$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$password = '';
for ($i=0; $i < $_POST['password_length']; $i++)
{
	$password .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
}

$query = "INSERT INTO admins (email, username, password, first_name, last_name) VALUES('$_POST[email]', 'admin', '" . sha1($password) . "', '$_POST[first_name]', '$_POST[last_name]')";

mysql_query($query);

$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$encryption_key = '';
for ($i=0; $i < 32; $i++)
{
	$encryption_key .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
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
			<fieldset>
				<legend class="position">Welcome to the Halalan Installer!</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td><p>Halalan is an open-source voting system designed for student elections. It aims to automate the manual processes of elections such as counting, archiving, and voting. It is designed to be easy-to-use and secure.</p><p>Halalan is now installed!  Copy the election settings below and save to system/application/config as halalan.php.</p></td>
					</tr>
				</table>
			</fieldset>
			<br />
			<fieldset>
				<legend class="position">Administrator Settings</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td class="w35">Username</td>
						<td>admin</td>
					</tr>
					<tr>
						<td class="w35">Password</td>
						<td><?php echo $password; ?></td>
					</tr>
					<tr>
						<td colspan="2">The administrator login is found at <a href="<?php echo $_POST['url']; ?><?php echo $config['index_page']; ?><?php echo (!empty($config['index_page'])) ? '/' : ''; ?>gate/admin"><?php echo $_POST['url']; ?><?php echo $config['index_page']; ?><?php echo (!empty($config['index_page'])) ? '/' : ''; ?>gate/admin</a></td>
					</tr>
				</table>
			</fieldset>
			<br />
			<fieldset>
				<legend class="position">Election Settings</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td align="center">
<textarea cols="70" rows="25" readonly="readonly">
<?php echo "<?php"; ?> if (!defined('BASEPATH')) exit('No direct script access allowed');

// don't change if you already entered some data
$config['halalan']['pin'] = <?php echo isset($_POST['pin']) ? $_POST['pin'] : 'FALSE'; ?>;
$config['halalan']['password_pin_generation'] = "<?php echo $_POST['password_pin_generation']; ?>";
$config['halalan']['password_pin_characters'] = "<?php echo $_POST['password_pin_characters']; ?>";
$config['halalan']['password_length'] = <?php echo $_POST['password_length']; ?>;
$config['halalan']['pin_length'] = <?php echo $_POST['pin_length']; ?>;
$config['halalan']['captcha'] = <?php echo isset($_POST['captcha']) ? $_POST['captcha'] : 'FALSE'; ?>;
$config['halalan']['captcha_length'] = <?php echo $_POST['captcha_length']; ?>;
$config['halalan']['show_candidate_details'] = <?php echo isset($_POST['details']) ? $_POST['details'] : 'FALSE'; ?>;
$config['halalan']['generate_image_trail'] = <?php echo isset($_POST['image_trail']) ? $_POST['image_trail'] : 'FALSE'; ?>;
$config['halalan']['image_trail_path'] = "<?php echo $_POST['image_trail_path']; ?>";

$config['base_url'] = "<?php echo $_POST['url']; ?>";
$config['encryption_key'] = "<?php echo $encryption_key; ?>";

<?php echo "?>"; ?>
</textarea>
						</td>
					</tr>
				</table>
			</fieldset>
			<br />
			<fieldset>
				<legend class="position"></legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td align="center">Copy the settings above and save to system/application/config as halalan.php</td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer">
		&copy; University of the Philippines Linux Users' Group (UnPLUG)
	</div>
</div>
</body>
</html>
