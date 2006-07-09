<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Party');

/* Assign/Initialize common variables */

/* Data Gathering */
$parties = Party::selectAll();

/* Final Assignment of Variables */
$this->assign(compact('parties'));

/* Output HTML */
$this->display();

?>