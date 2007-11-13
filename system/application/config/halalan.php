<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['election']['status'] = "inactive"; // active or inactive
$config['election']['result'] = "hide"; // show or hide
$config['election']['name'] = "ManongLections";
$config['election']['party'] = "enable";
$config['election']['unit'] = "enable";
$config['election']['pin'] = "enable";
$config['election']['password_pin_generation'] = "web";
$config['election']['password_pin_characters'] = "alnum";
$config['election']['password_length'] = "7";
$config['election']['pin_length'] = "7";
$config['election']['captcha'] = "enable";
$config['election']['picture'] = "enable";
$config['language'] = 'filipino';

?>