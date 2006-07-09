<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Candidate');
Hypworks::loadDao('Position');

/* Assign/Initialize common variables */

/* Data Gathering */
$positions = Position::selectAll();
foreach($positions as $key => $position) {
	$positions[$key]['candidates'] = Candidate::selectAllByPositionID($position['positionid']);
}

/* Final Assignment of Variables */
$this->assign(compact('positions'));

/* Output HTML */
$this->display();

?>