<?php

// error checking first
// let us assume that everything is ok
// so that we can move on

// DB creation
define('BASEPATH', '');

require_once('../system/application/config/database.php');
extract($db['default']);
if ($dbdriver == 'mysql')
{
	$link = mysql_connect($hostname, $username, $password);
	mysql_select_db($database, $link);
	$queries = explode(";", file_get_contents("db/mysql.sql"));
	foreach ($queries as $query)
	{
		if (!empty($query))
			mysql_query($query);
	}
}
else if ($dbdriver == 'postgre')
{
	pg_connect("host='$hostname' port='$port' dbname='$database' user='$username' password='$password'");
	$query = file_get_contents("db/postgresql.sql");
}

$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$password = '';
for ($i=0; $i < 6; $i++)
{
	$password .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
}

$query = "INSERT INTO admins (email, username, password, first_name, last_name) VALUES('$_POST[email]', 'admin', '" . sha1($password) . "', '$_POST[first_name]', '$_POST[last_name]')";

if ($dbdriver == 'mysql')
{
	mysql_query($query);
}
else if ($dbdriver == 'postgre')
{

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
						<td align="center">some nifty description here</td>
					</tr>
				</table>
			</fieldset>
			<br />
			<fieldset>
				<legend class="position">Administrator Settings</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td width="35%">Username</td>
						<td width="65%">admin</td>
					</tr>
					<tr>
						<td width="35%">Password</td>
						<td width="65%"><?php echo $password; ?></td>
					</tr>
				</table>
			</fieldset>
			<br />
			<fieldset>
				<legend class="position">Election Configuration</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td align="center">
<textarea cols="75" rows="25" readonly="true">
<?php echo "<?php"; ?> if (!defined('BASEPATH')) exit('No direct script access allowed');

// run time configuration
$config['halalan']['status'] = "inactive"; // active or inactive
$config['halalan']['result'] = "hide"; // show or hide

// build time configuration
$config['halalan']['name'] = "<?php echo $_POST['name']; ?>";
$config['halalan']['pin'] = <?php echo $_POST['pin']; ?>;
$config['halalan']['password_pin_generation'] = "<?php echo $_POST['password_pin_generation']; ?>";
$config['halalan']['password_pin_characters'] = "<?php echo $_POST['password_pin_characters']; ?>";
$config['halalan']['password_length'] = <?php echo $_POST['password_length']; ?>;
$config['halalan']['pin_length'] = <?php echo $_POST['pin_length']; ?>;
$config['halalan']['captcha'] = <?php echo $_POST['captcha']; ?>;

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
						<td align="center">Copy the configuration above and save to system/application/config as halalan.php</td>
					</tr>
				</table>
			</fieldset>
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