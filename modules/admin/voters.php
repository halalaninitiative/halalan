<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Voter');

/* Assign/Initialize common variables */

/* Data Gathering */
$voters = Voter::selectAll();

/* Final Assignment of Variables */
$this->assign(compact('voters'));

/* Output HTML */
$this->display();

?>