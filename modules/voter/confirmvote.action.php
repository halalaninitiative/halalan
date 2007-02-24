<?php

/* Restricts access to specified user types or no user type at all */
$this->restrict(USER_VOTER);

/* Required Files */
Hypworks::loadDao('Vote');
Hypworks::loadDao('Voter');

/*
 * Places the POST variables in local context.
 * E.g, $_POST['username'] can be accessed
 * using $username directly. If the variable
 * $username already exists, then it will not
 * be overwritten.
 */
extract($_POST, EXTR_REFS|EXTR_SKIP);

if(strtolower(ELECTION_CAPTCHA) == "enable") {
	// check pin
	$voter = Voter::authenticatePin($_SESSION[INDEX_USERID], $pin);
	if(!$voter) {
		$this->addError('pin', 'You have entered an invalid pin');
	}
	if($_SESSION['phrase'] != $captcha) {
		$this->addError('captcha', 'Input text does not equal image text');
	}
}
else {
	$voter = Voter::select($_SESSION[INDEX_USERID]);
}

if($this->hasError()) {
	$this->addUserInput($_POST);
	$this->forward('confirmvote');
}
else {
	$voterid = $voter['voterid'];
	foreach($candidateids as $candidateid) {
		Vote::insert(compact('voterid', 'candidateid'));
	}
	$voted = YES;
	Voter::update(compact('voted'), $voterid);
	unset($_SESSION['votes']);
	unset($_SESSION['confirmed']);
	$_SESSION['voted'] = YES;
	$this->forward('success');
}

?>