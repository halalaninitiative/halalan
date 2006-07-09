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

if(!@Position::delete($positionid))
	$this->addError('deleteposition', 'Cannot delete position.  It is still in used');
else
	$this->addMessage('deleteposition', 'The position has been successfully deleted');
$this->forward('positions');

?>