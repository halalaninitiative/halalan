<?php

/* Restricts access to specified user types or no user type at all */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Party');

/*
 * Places the POST variables in local context.
 * E.g, $_POST['username'] can be accessed
 * using $username directly. If the variable
 * $username already exists, then it will not
 * be overwritten.
 */
extract($_POST, EXTR_REFS|EXTR_SKIP);

if(empty($party))
	$this->addError('party', 'Party is required');

if($this->hasError()) {
	$this->addUserInput($_POST);
	$this->forward('addparty');
}
else {
	if($_FILES['logo']['error'] == 0) {
		$logo = $_FILES['logo']['name'];
		move_uploaded_file($_FILES['logo']['tmp_name'], UPLOAD_PATH . '/' . $logo);
	}
	Party::insert(compact('party', 'description', 'logo'));
	$this->addMessage('addparty', 'A new party has been successfully added');
	$this->forward('parties');
}

?>