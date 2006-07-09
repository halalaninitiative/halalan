<?php

/* Restricts access to specified user types */

/* Required Files */
require_once('Image/Text.php');
require_once('Text/CAPTCHA.php');

/* Assign/Initialize common variables */
// Set CAPTCHA options (font must exist!)
$options = array(
    'font_size' => FONT_SIZE,
    'font_path' => FONT_PATH,
    'font_file' => FONT_FILE
);

/* Data Gathering */
$c = Text_CAPTCHA::factory('Image');
$retval = $c->init(CAPTCHA_WIDTH, CAPTCHA_HEIGHT, null, $options);
if (PEAR::isError($retval)) {
    echo 'Error generating CAPTCHA!';
    exit;
}
// The CAPTCHA phrase is saved in the session.
$_SESSION['phrase'] = $c->getPhrase();
$png = $c->getCAPTCHAAsPNG();
if (PEAR::isError($png)) {
    echo 'Error generating CAPTCHA!';
    exit;
}
// Save the CAPTCHA image file
file_put_contents(APP_ROOT . '/includes/images/captcha/' . md5(session_id()) . '.png', $png);

/* Final Assignment of Variables */
$this->assign('captcha', 'images/captcha/' . md5(session_id()) . '.png');
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());

/* Output HTML */
$this->display();

?>
