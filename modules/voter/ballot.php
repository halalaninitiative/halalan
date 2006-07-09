<?php

/* Restricts access to specified user types */
$this->restrict(USER_VOTER);

/* Required Files */
Hypworks::loadDao('Position');
Hypworks::loadDao('Candidate');

/* Assign/Initialize common variables */
// this is used for restricting access in confirmvote
// this is set in ballot.do and unset in ballot and confirm.do
unset($_SESSION['confirmed']);
// this is used for storing votes for confirmation
// this is set in ballot.do and unset in ballot and confirm.do
unset($_SESSION['votes']);

/* Data Gathering */
$positions = Position::selectAll();
foreach($positions as $key => $position) {
	$positions[$key]['candidates'] = Candidate::selectAllByPositionID($position['positionid']);
}

/* Final Assignment of Variables */
$this->assign(compact('positions'));
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());

/* Output HTML */
$this->display();

?>