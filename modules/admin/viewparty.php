<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Party');

/* Assign/Initialize common variables */
$partyid = $PARAMS[0];

/* Data Gathering */
$party = Party::select($partyid);

/* Final Assignment of Variables */
$this->assign(compact('party'));

/* Output HTML */
$this->display();

?>
