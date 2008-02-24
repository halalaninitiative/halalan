<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['language'] = 'english';

$config['halalan']['name'] = "University Student Council Election";
$config['halalan']['pin'] = FALSE;
$config['halalan']['password_pin_generation'] = "web";
$config['halalan']['password_pin_characters'] = "alnum";
$config['halalan']['password_length'] = 6;
$config['halalan']['pin_length'] = 6;
$config['halalan']['captcha'] = FALSE;
$config['halalan']['show_candidate_details'] = TRUE;
$config['halalan']['random_order'] = TRUE;
$config['halalan']['generate_image_trail'] = TRUE;
$config['halalan']['image_trail_path'] = '/home/httpd/html/w/';

$config['halalan']['v'] = FALSE;

?>