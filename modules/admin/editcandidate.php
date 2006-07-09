<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Candidate');
Hypworks::loadDao('Party');
Hypworks::loadDao('Position');

/* Assign/Initialize common variables */
$candidateid = $PARAMS[0];

/* Data Gathering */
$parties = array(''=>'Select a party') + Party::selectAllForSelect();
$positions = array(''=>'Select a position') + Position::selectAllForSelect();
$candidate = Candidate::select($candidateid);

/* Final Assignment of Variables */
$this->assign(compact('parties', 'positions'));
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());
else
	$this->setFormDefaults($candidate);

/* Output HTML */
$this->display();

?>