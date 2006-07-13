<?php

/* Restricts access to specified user types */
$this->restrict(USER_VOTER);
if(isset($_SESSION['voted'])) {
	if($_SESSION['voted'] == YES)
		$this->forward('success');
}

if(!isset($_SESSION['confirmed'])) {
	if($_SESSION['confirmed'] == true)
		$this->forward('ballot');
}

/* Required Files */
Hypworks::loadDao('Candidate');
Hypworks::loadDao('Position');
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
unset($_SESSION['phrase']); // unset first
$_SESSION['phrase'] = $c->getPhrase();
$png = $c->getCAPTCHAAsPNG();
if (PEAR::isError($png)) {
    echo 'Error generating CAPTCHA!';
    exit;
}
// Save the CAPTCHA image file
file_put_contents(APP_ROOT . '/includes/images/captcha/' . md5(session_id()) . '.png', $png);

$votes = $_SESSION['votes'];
$positions = Position::selectAll();
foreach($positions as $key=>$position) {
	foreach($votes[$positions[$key]['positionid']] as $candidateid) {
		$positions[$key]['candidates'][] = Candidate::select($candidateid);
	}
}

/* Final Assignment of Variables */
$this->assign(compact('positions'));
$this->assign('captcha', 'images/captcha/' . md5(session_id()) . '.png');
if($this->hasUserInput()) {
	$userinput = $this->userInput();
	unset($userinput['candidateids']);
	$this->setFormDefaults($userinput);
}

/* Output HTML */
$this->display();

?>