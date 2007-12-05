<?php

// error checking
if (empty($_POST['first_name']))
	$error = TRUE;
if (empty($_POST['last_name']))
	$error = TRUE;
if (empty($_POST['email']))
	$error = TRUE;
if (empty($_POST['name']))
	$error = TRUE;
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
						<td><p>Halalan is an open-source voting system designed for student elections. It aims to automate the manual processes of elections such as counting, archiving, and voting. It is designed to be easy-to-use and secure.</p><p>Halalan is now installed!  Copy the election settings below and save to system/application/config as halalan.php.</p></td>
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
					<tr>
						<td colspan="2">The administrator login is found at <a href="<?php echo dirname($config['base_url']); ?>/<?php echo $config['index_page']; ?><?php echo (!empty($config['index_page'])) ? '/' : ''; ?>gate/admin"><?php echo dirname($config['base_url']); ?>/<?php echo $config['index_page']; ?><?php echo (!empty($config['index_page'])) ? '/' : ''; ?>gate/admin</a></td>
					</tr>
				</table>
			</fieldset>
			<br />
			<fieldset>
				<legend class="position">Election Settings</legend>
				<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td align="center">
<textarea cols="75" rows="25" readonly="true">
<?php echo "<?php"; ?> if (!defined('BASEPATH')) exit('No direct script access allowed');

// don't change if you already entered some data
$config['halalan']['name'] = "<?php echo $_POST['name']; ?>";
$config['halalan']['pin'] = <?php echo $_POST['pin']; ?>;
$config['halalan']['password_pin_generation'] = "<?php echo $_POST['password_pin_generation']; ?>";
$config['halalan']['password_pin_characters'] = "<?php echo $_POST['password_pin_characters']; ?>";
$config['halalan']['password_length'] = <?php echo $_POST['password_length']; ?>;
$config['halalan']['pin_length'] = <?php echo $_POST['pin_length']; ?>;
$config['halalan']['captcha'] = <?php echo $_POST['captcha']; ?>;

$config['language'] = "<?php echo $_POST['language']; ?>";

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