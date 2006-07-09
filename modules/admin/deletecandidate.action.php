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

Candidate::delete($candidateid);
$this->addMessage('deletecandidate', 'The candidate has been successfully deleted');
$this->forward('candidates');

?>