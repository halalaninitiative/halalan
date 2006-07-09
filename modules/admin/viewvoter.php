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
$this->assign(compact('voter'));

/* Output HTML */
$this->display();

?>
