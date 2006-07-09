<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */

/* Assign/Initialize common variables */
global $ELECTION_STATUS;

/* Data Gathering */

/* Final Assignment of Variables */
$this->assign('electionstatus', $ELECTION_STATUS);

/* Output HTML */
$this->display();

?>