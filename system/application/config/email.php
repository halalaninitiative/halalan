<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['protocol'] = 'smtp'; // mail, sendmail, or smtp
// only needed if sendmail was chosen
$config['mailpath'] = '/usr/sbin/sendmail';
// only needed if smtp was chosen
$config['smtp_host'] = '';
$config['smtp_user'] = '';
$config['smtp_pass'] = '';
$config['smtp_port'] = 25;

?>