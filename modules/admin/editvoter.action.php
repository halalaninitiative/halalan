<?php

/* Restricts access to specified user types or no user type at all */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Voter');
Hypworks::loadAddin('rfc822');
require_once APP_LIB . '/phpmailer/class.phpmailer.php';

/*
 * Places the POST variables in local context.
 * E.g, $_POST['username'] can be accessed
 * using $username directly. If the variable
 * $username already exists, then it will not
 * be overwritten.
 */
extract($_POST, EXTR_REFS|EXTR_SKIP);
$voterid = $PARAMS[0];

if(empty($firstname))
	$this->addError('firstname', 'First name is required');
if(empty($lastname))
	$this->addError('lastname', 'Last name is required');
if(empty($email)) {
	$this->addError('email', 'Email is required');
}
else {
	if(!isValidEmail($email)) {
		$this->addError('email', 'Email is invalid');
	}	
}

if($this->hasError()) {
	$this->addUserInput($_POST);
	$this->forward('addvoter');
}
else {
	if(isset($password) && $password == 1) {
		// regenerate password
		$chars = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$password = '' ;
		while ($i < 8) {
			$num = rand() % 58;
			$tmp = substr($chars, $num, 1);
			$password = $password . $tmp;
			$i++;
		}
	}
	if(isset($pin) && $pin == 1) {
		// generate pin
		$chars = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$pin = '';
		while ($i < 8) {
			$num = rand() % 58;
			$tmp = substr($chars, $num, 1);
			$pin = $pin . $tmp;
			$i++;
		}
	}

	if(!empty($password) || !empty($pin)) {	
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
		if(!empty($password)) {
			$mail->Subject = "Halalan Auto-Generated Password";
		
			// Create Mail Body
			$body  = "Mabuhay!<br /><br />";
			$body .= "Ang bagong password mo ay " . $password;
			$body .= "<br /><br />";
			$body .= "Halalan";
		
			// Plain text body (for mail clients that cannot read HTML)
			$text_body  = "Mabuhay!\n\n";
			$text_body .= "Ang bagong password mo ay " . $password;
			$text_body .= "\n\n";
			$text_body .= "Halalan";
		
			$mail->Body    = $body;
			$mail->AltBody = $text_body;
			$mail->AddAddress($email);
		
			if(!$mail->Send()) {
				echo $mail->ErrorInfo;
				echo '<br />There has been a mail sending error.<br/>';
				echo "<a href=\"editvoter/$voterid\">[Back to Edit Voter]</a></p>";
				exit();
			}
			
			// Clear all addresses and attachments for next loop
			$mail->ClearAddresses();
			$mail->ClearAttachments();
			$password = sha1($password);
			Voter::update(compact('firstname', 'lastname', 'email', 'password'), $voterid);
		}
		if(!empty($pin)) {
			$mail->Subject = "Halalan Auto-Generated Pin";
		
			// Create Mail Body
			$body  = "Mabuhay!<br /><br />";
			$body .= "Ang bagong pin mo ay " . $pin;
			$body .= "<br /><br />";
			$body .= "Halalan";
		
			// Plain text body (for mail clients that cannot read HTML)
			$text_body  = "Mabuhay!\n\n";
			$text_body .= "Ang bagong pin mo ay " . $pin;
			$text_body .= "\n\n";
			$text_body .= "Halalan";
		
			$mail->Body    = $body;
			$mail->AltBody = $text_body;
			$mail->AddAddress($email);
		
			if(!$mail->Send()) {
				echo $mail->ErrorInfo;
				echo '<br />There has been a mail sending error.<br/>';
				echo "<a href=\"editvoter/$voterid\">[Back to Edit Voter]</a></p>";
				exit();
			}
			
			// Clear all addresses and attachments for next loop
			$mail->ClearAddresses();
			$mail->ClearAttachments();
			$pin = sha1($pin);
			Voter::update(compact('firstname', 'lastname', 'email', 'pin'), $voterid);
		}
	}
	else {
		Voter::update(compact('firstname', 'lastname', 'email'), $voterid);
	}
	$this->addMessage('editvoter', 'The voter has been successfully edited');
	$this->forward('voters');
}

?>