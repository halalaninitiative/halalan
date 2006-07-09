<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Position');

/* Assign/Initialize common variables */
$positionid = $PARAMS[0];

/* Data Gathering */
$position = Position::select($positionid);

/* Final Assignment of Variables */
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());
else
	$this->setFormDefaults($position);

/* Output HTML */
$this->display();

?>