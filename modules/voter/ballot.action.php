<?php

/* Restricts access to specified user types or no user type at all */
$this->restrict(USER_VOTER);

/* Required Files */
Hypworks::loadDao('Position');

/*
 * Places the POST variables in local context.
 * E.g, $_POST['username'] can be accessed
 * using $username directly. If the variable
 * $username already exists, then it will not
 * be overwritten.
 */
extract($_POST, EXTR_REFS|EXTR_SKIP);

// check if there are selected candidates
if(!isset($votes)) {
	$this->addError('vote', 'No candidates selected');
}
else {
	// check if all positions have selected candidates
	if(strtolower(ELECTION_UNIT) == "enable") {
		$positions = Position::selectAllWithUnit($_SESSION['user']['unitid']);
	}
	else {
		$positions = Position::selectAllWithoutUnit();
	}
	if(count($positions) != count($votes)) {
		$this->addError('inc', 'You must select candidates for all positions.  Otherwise, select "abstain"');
	}
	else {
		foreach($votes as $positionid=>$candidateids) {
			// check if the number of selected candidates does not exceed the maximum allowed for each position
			$position = Position::select($positionid);
			if($position['maximum'] < count($candidateids)) {
				$this->addError('max', 'You have selected more candidates that what is required');
			}
		}
	}
}

if($this->hasError()) {
	$this->addUserInput($_POST);
	$this->forward('ballot');
}
else {
	unset($_SESSION['votes']);
	$_SESSION['votes'] = $votes;
	$_SESSION['confirmed'] = true;
	$this->forward('confirmvote');
}

?>