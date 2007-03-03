<?php

/* Restricts access to specified user types */

/* Required Files */
Hypworks::loadDao('Candidate');
Hypworks::loadDao('Party');
Hypworks::loadDao('Position');
Hypworks::loadDao('Vote');

/* Assign/Initialize common variables */

/* Data Gathering */
if(strtolower(ELECTION_UNIT) == "enable") {
	$positions = Position::selectAll();
}
else {
	$positions = Position::selectAllWithoutUnit();
}
foreach($positions as $key => $position) {
	$votes = Vote::countAllByPositionID($position['positionid']);
	$candidates = array();
	foreach($votes as $vote) {
		$candidateid = $vote['candidateid'];
		$candidate = Candidate::select($candidateid);
		$candidates[$candidateid] = $candidate;
		$candidates[$candidateid]['votes'] = $vote['votes'];
		$party = Party::select($candidate['partyid']);
		$candidates[$candidateid]['partydesc'] = $party['description'];
	}
	$positions[$key]['candidates'] = $candidates;
}

/* Final Assignment of Variables */
$this->assign(compact('positions'));

/* Output HTML */
$this->display();

?>