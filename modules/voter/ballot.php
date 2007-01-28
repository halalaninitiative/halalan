<?php

/* Restricts access to specified user types */
$this->restrict(USER_VOTER);
if(isset($_SESSION['voted']) && $_SESSION['voted'] == YES) {
	$this->forward('success');
}

/* Required Files */
Hypworks::loadDao('Position');
Hypworks::loadDao('Candidate');

/* Assign/Initialize common variables */
// this is used for restricting access in confirmvote
// this is set in ballot.do and unset in ballot and confirm.do
unset($_SESSION['confirmed']);
// this is used for storing votes for confirmation
// this is set in ballot.do and unset in ballot and confirm.do
if(isset($_SESSION['votes'])) {
	$votes['votes'] = $_SESSION['votes'];
	unset($_SESSION['votes']);
}

/* Data Gathering */
$positions = Position::selectAll();
foreach($positions as $key => $position) {
	$positions[$key]['candidates'] = Candidate::selectAllByPositionID($position['positionid']);
}

/* Final Assignment of Variables */
$this->assign(compact('positions'));
if($this->hasUserInput())
	$this->setFormDefaults($this->userInput());
else if(!empty($votes))
	$this->setFormDefaults($votes);

/* Output HTML */
$this->display();

?>