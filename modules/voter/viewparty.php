<?php

/* Restricts access to specified user types */
$this->restrict(USER_VOTER);
if(isset($_SESSION['voted'])) {
	if($_SESSION['voted'] == YES)
		$this->forward('success');
}

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
