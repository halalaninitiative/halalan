<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Voter');

/* Assign/Initialize common variables */
$voterid = $PARAMS[0];

/* Data Gathering */
$voter = Voter::select($voterid);

/* Final Assignment of Variables */
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());
else
	$this->setFormDefaults($voter);

/* Output HTML */
$this->display();

?>