<?php

/* Restricts access to specified user types */
$this->restrict(USER_VOTER);
if(isset($_SESSION['voted']) && $_SESSION['voted'] == YES) {
	$this->forward('success');
}

/* Required Files */
Hypworks::loadDao('Party');
Hypworks::loadDao('Position');
Hypworks::loadDao('Candidate');

/* Assign/Initialize common variables */
// this is used for restricting access in confirmvote
// this is set in ballot.do and unset in ballot and confirm.do
unset($_SESSION['confirmed']);
// this is used for storing votes for confirmation
// this is set in ballot.do and unset in ballot.do and confirm.do
if(isset($_SESSION['votes'])) {
	$votes['votes'] = $_SESSION['votes'];
	// unset in ballot.do instead so that refreshing the page will work
	//unset($_SESSION['votes']);
}

/* Data Gathering */
if(strtolower(ELECTION_UNIT) == "enable") {
	$positions = Position::selectAllWithUnit($_SESSION['user']['unitid']);
}
else {
	$positions = Position::selectAllWithoutUnit();
}
foreach($positions as $key => $position) {
	$candidates = Candidate::selectAllByPositionID($position['positionid']);
	foreach($candidates as $candidateid=>$candidate) {
		$party = Party::select($candidate['partyid']);
		$candidates[$candidateid]['partydesc'] = $party['description'];
	}
	$positions[$key]['candidates'] = $candidates;
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