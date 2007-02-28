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
	$position = Position::select($voter['unitid']);
	$this->assign(compact('position'));
}

/* Final Assignment of Variables */
$this->assign(compact('voter'));

/* Output HTML */
$this->display();

?>
