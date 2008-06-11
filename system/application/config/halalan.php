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
$config['halalan']['random_order'] = TRUE;
$config['halalan']['generate_image_trail'] = FALSE;
$config['halalan']['image_trail_path'] = "/var/www/html/w/";

$config['base_url'] = "http://localhost/~waldemar/halalan/";
$config['language'] = "english";
$config['encryption_key'] = "FIJDtfzhUllTcd41zC4a6VwtMaQlPEOl";

?>