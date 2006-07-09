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
$partyid = $PARAMS[0];

if(!@Party::delete($partyid))
	$this->addError('deleteparty', 'Cannot delete party.  It is still in used');
else
	$this->addMessage('deleteparty', 'The party has been successfully deleted');
$this->forward('parties');

?>