<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// don't change if you already entered some data
$config['halalan']['name'] = "Election Name";
$config['halalan']['pin'] = TRUE;
$config['halalan']['password_pin_generation'] = "web";
$config['halalan']['password_pin_characters'] = "alnum";
$config['halalan']['password_length'] = 4;
$config['halalan']['pin_length'] = 4;
$config['halalan']['captcha'] = TRUE;
$config['halalan']['captcha_length'] = 4;
$config['halalan']['show_candidate_details'] = TRUE;
$config['halalan']['random_order'] = FALSE;
$config['halalan']['generate_image_trail'] = TRUE;
$config['halalan']['image_trail_path'] = "/home/waldemar/Desktop/trails";
$config['halalan']['realtime_results'] = TRUE;

$config['base_url'] = "http://localhost/~waldemar/kappa/";
$config['language'] = "english";
$config['encryption_key'] = "M89XeDIZ5KVTZiEm2q8SPWDS1t3H0iER";

?>