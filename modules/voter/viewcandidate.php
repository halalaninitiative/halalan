<?php

/* Restricts access to specified user types */
$this->restrict(USER_VOTER);
if(isset($_SESSION['voted'])) {
	if($_SESSION['voted'] == YES)
		$this->forward('success');
}

/* Required Files */
Hypworks::loadDao('Candidate');

/* Assign/Initialize common variables */
$candidateid = $PARAMS[0];

/* Data Gathering */
$candidate = Candidate::select($candidateid);

/* Final Assignment of Variables */
$this->assign(compact('candidate'));

/* Output HTML */
$this->display();

?>
