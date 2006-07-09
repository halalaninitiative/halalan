<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Party');
Hypworks::loadDao('Position');

/* Assign/Initialize common variables */

/* Data Gathering */
$parties = array(''=>'Select a party') + Party::selectAllForSelect();
$positions = array(''=>'Select a position') + Position::selectAllForSelect();

/* Final Assignment of Variables */
$this->assign(compact('parties', 'positions'));
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());

/* Output HTML */
$this->display();

?>