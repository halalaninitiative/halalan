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
$candidateid = $PARAMS[0];

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
	$this->forward("editcandidate/$candidateid");
}
else {
	if(strtolower(ELECTION_PICTURE) == "enable") {
		if($_FILES['picture']['error'] == 0) {
			$picture = $_FILES['picture']['name'];
			move_uploaded_file($_FILES['picture']['tmp_name'], UPLOAD_PATH . '/' . $picture);
			Candidate::update(compact('firstname', 'lastname', 'partyid', 'positionid', 'description', 'picture'), $candidateid);
		}
		else {
			Candidate::update(compact('firstname', 'lastname', 'partyid', 'positionid', 'description'), $candidateid);
		}
	}
	else {
		Candidate::update(compact('firstname', 'lastname', 'partyid', 'positionid', 'description'), $candidateid);
	}
	$this->addMessage('editcandidate', 'The candidate has been successfully edited');
	$this->forward('candidates');
}

?>