<?php

/* Restricts access to specified user types or no user type at all */

/* Required Files */
Hypworks::loadDao('Voter');
Hypworks::loadAddin('rfc822');
require_once APP_LIB . '/phpmailer/class.phpmailer.php';
require_once 'common/PinPasswordGenerator.class.php';

/*
 * Places the POST variables in local context.
 * E.g, $_POST['username'] can be accessed
 * using $username directly. If the variable
 * $username already exists, then it will not
 * be overwritten.
 */
extract($_POST, EXTR_REFS|EXTR_SKIP);

if(!isset($email)) {
	$this->addError('email', 'Enter your email address');
}
else {
	if(!isValidEmail($email)) {
		$this->addError('email', 'You have entered an invalid email address');
	}
	else if(!$voter = Voter::selectByEmail($email)) {
		$this->addError('nonexistent', 'There is no voter with that email address');
	}
	else if($voter['voted'] == 1) {
		$this->addError('voted', 'You have already voted');
	}
}
if($_SESSION['phrase'] != $captcha) {
	$this->addError('captcha', 'Input text does not equal image text');
}

if($this->hasError()) {
	$this->addUserInput($_POST);
	$this->forward('forgotpassword');
}
else {
	$code = PinPasswordGenerator::generatePassword();
	$voter['password'] = sha1($code);
	Voter::update($voter, $voter['voterid']);

	// Create PHPMailer object
	$mail = new PHPMailer();
	$mail->From     = MAIL_FROM;
	$mail->FromName = MAIL_FROM_NAME;
	$mail->Host     = MAIL_HOST;
	$mail->Port     = MAIL_PORT;
	$mail->Mailer   = MAIL_MAILER;
	$mail->SMTPAuth  = MAIL_SMTPAUTH;
	$mail->Username  = MAIL_USERNAME;
	$mail->Password  = MAIL_PASSWORD;
	$mail->Subject = "Halalan New Password";

	// Create Mail Body
	$body  = "Mabuhay!<br /><br />";
	$body .= "Ang bagong password mo ay " . $code;
	$body .= "<br /><br />";
	$body .= "Halalan";

	// Plain text body (for mail clients that cannot read HTML)
	$text_body  = "Mabuhay!\n\n";
	$text_body .= "Ang bagong password mo ay " . $code;
	$text_body .= "\n\n";
	$text_body .= "Halalan";

	$mail->Body    = $body;
	$mail->AltBody = $text_body;
	$mail->AddAddress($voter['email']);

	if(!$mail->Send()) {
		echo $mail->ErrorInfo;
		echo '<br />There has been a mail sending error.<br/>';
		echo '<a href="forgotpassword">[Back to Password Reset Tool]</a></p>';
		exit();
	}
		
	// Clear all addresses and attachments for next loop
	$mail->ClearAddresses();
	$mail->ClearAttachments();
	$this->addMessage('success', 'Your new password has been successfully sent to your email!');
	$this->forward('login');
}

?>