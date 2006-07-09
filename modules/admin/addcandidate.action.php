<?php

/* Restricts access to specified user types or no user type at all */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Candidate');

/*
 * Places the POST variables in local context.
 * E.g, $_POST['username'] can be accessed
 * using $username directly. If the variable
 * $username already exists, then it will not
 * be overwritten.
 */
extract($_POST, EXTR_REFS|EXTR_SKIP);

if(empty($firstname))
	$this->addError('firstname', 'First name is required');
if(empty($lastname))
	$this->addError('lastname', 'Last name is required');
if($partyid == "")
	$this->addError('party', 'Party is required');
if($positionid == "")
	$this->addError('position', 'Position is required');

if($this->hasError()) {
	$this->addUserInput($_POST);
	$this->forward('addcandidate');
}
else {
	if($_FILES['picture']['error'] == 0) {
		$picture = $_FILES['picture']['name'];
		move_uploaded_file($_FILES['picture']['tmp_name'], UPLOAD_PATH . '/' . $picture);
	}
	Candidate::insert(compact('firstname', 'lastname', 'partyid', 'positionid', 'description', 'picture'));
	$this->addMessage('addcandidate', 'A new candidate has been successfully added');
	$this->forward('candidates');
}

?>