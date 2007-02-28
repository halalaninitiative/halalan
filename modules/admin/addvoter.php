<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Position');

/* Assign/Initialize common variables */

/* Data Gathering */
if(strtolower(ELECTION_UNIT) == "enable") {
	$units = array(''=>'') + Position::selectAllUnitsForSelect();
	$this->assign(compact('units'));
}

/* Final Assignment of Variables */
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());

/* Output HTML */
$this->display();

?>