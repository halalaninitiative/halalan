<?php

/* Required Files */
Hypworks::loadDao('Voter');

extract($_POST, EXTR_REFS|EXTR_SKIP);

$voter = Voter::authenticate($email, $password);

if($voter) {
	if($voter['voted'] == YES) {
		$this->addError('voted', 'You have already voted');
		$this->back();
	}
	else {
		$_SESSION[INDEX_USERTYPE] = USER_VOTER;
		$_SESSION[INDEX_USERID] = $voter['voterid'];
		$_SESSION['user'] = $voter;
		$login = date("Y-m-d H:i:s");
		Voter::update(compact('login'), $_SESSION[INDEX_USERID]);
		$this->forward('ballot');
	}
}
else {
	$this->addUserInput(compact('email'));
	$this->addError('login', "Login failed!  Please try again.");
	$this->back();
}

?>