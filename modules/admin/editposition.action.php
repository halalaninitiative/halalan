<?php

/* Restricts access to specified user types or no user type at all */
$this->restrict(USER_ADMIN);

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
$positionid = $PARAMS[0];

if(empty($position))
	$this->addError('position', 'Position is required');
if(empty($maximum)) {
	$this->addError('maximum', 'Maximum is required');
}
else {
	if(!ctype_digit($maximum))
		$this->addError('maximum', 'Maximum is not a digit');
}
if(empty($ordinality)) {
	$this->addError('ordinality', 'Ordinality is required');
}
else {
	if(!ctype_digit($ordinality))
		$this->addError('ordinality', 'Ordinality is not a digit');
}
if(!isset($abstain))
	$this->addError('abstain', 'Abstain is required');
if(strtolower(ELECTION_UNIT) == "enable") {
	if(!isset($unit))
		$this->addError('unit', 'Unit is required');
}

if($this->hasError()) {
	$this->addUserInput($_POST);
	$this->forward("editposition/$positionid");
}
else {
	if(strtolower(ELECTION_UNIT) == "enable") {
		Position::update(compact('position', 'maximum', 'ordinality', 'description', 'abstain', 'unit'), $positionid);
	}
	else {
		Position::update(compact('position', 'maximum', 'ordinality', 'description', 'abstain'), $positionid);
	}
	$this->addMessage('editposition', 'The position has been successfully edited');
	$this->forward('positions');
}

?>