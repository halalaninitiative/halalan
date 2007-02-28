<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Position');
Hypworks::loadDao('Voter');

/* Assign/Initialize common variables */
$voterid = $PARAMS[0];

/* Data Gathering */
$voter = Voter::select($voterid);
if(strtolower(ELECTION_UNIT) == "enable") {
	$units = array(''=>'') + Position::selectAllUnitsForSelect();
	$this->assign(compact('units'));
}

/* Final Assignment of Variables */
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());
else
	$this->setFormDefaults($voter);

/* Output HTML */
$this->display();

?>