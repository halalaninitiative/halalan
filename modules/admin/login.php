<?php

if(isset($_SESSION[INDEX_USERTYPE])) {
	if($_SESSION[INDEX_USERTYPE] == USER_VOTER)
		$this->forward('ballot');
	else if($_SESSION[INDEX_USERTYPE] == USER_ADMIN)
		$this->forward('adminhome');
}

/* Restricts access to specified user types */

/* Required Files */

/* Assign/Initialize common variables */

/* Data Gathering */

/* Final Assignment of Variables */
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());

/* Output HTML */
$this->display();

?>