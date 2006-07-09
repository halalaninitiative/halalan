<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */

/* Assign/Initialize common variables */

/* Data Gathering */

/* Final Assignment of Variables */
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());

/* Output HTML */
$this->display();

?>