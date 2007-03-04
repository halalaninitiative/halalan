<?php

/* Restricts access to specified user types or no user type at all */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Candidate');
Hypworks::loadDao('Position');
Hypworks::loadDao('Vote');
Hypworks::loadDao('Voter');

/*
 * Places the POST variables in local context.
 * E.g, $_POST['username'] can be accessed
 * using $username directly. If the variable
 * $username already exists, then it will not
 * be overwritten.
 */
extract($_POST, EXTR_REFS|EXTR_SKIP);

if(strtolower(ELECTION_UNIT) == "enable") {
	$data = Voter::selectAllWithUnit();
	$tmp = array();
	$header = "";
	if(isset($votes)) {
		$positions = Position::selectAll();
		foreach($positions as $position) {
			$header .= ", $position[position]";
		}
	}
	$tmp[] = "Last Name, First Name, Email, Voted, Specific Unit" . $header;
	foreach($data as $datum) {
		$body = "";
		if(isset($votes)) {
			foreach($positions as $position) {
				$votes = Vote::selectAllByVoterIDAndPositionID($datum['voterid'], $position['positionid']);
				$candidates = array();
				foreach($votes as $vote) {
					$candidates[] = $vote['firstname'] . " " . $vote['lastname'];
				}
				$body .= (", " . implode(" | ", $candidates));
			}
		}
		$tmp[] = "$datum[lastname], $datum[firstname], $datum[email], $datum[voted], $datum[unit]" . $body;
	}
}
else {
	$data = Voter::selectAll();
	$tmp = array();
	$header = "";
	if(isset($votes)) {
		$positions = Position::selectAllWithoutUnit();
		foreach($positions as $position) {
			$header .= ", $position[position]";
		}
	}
	$tmp[] = "Last Name, First Name, Email, Voted" . $header;
	foreach($data as $datum) {
		$body = "";
		if(isset($votes)) {
			foreach($positions as $position) {
				$votes = Vote::selectAllByVoterIDAndPositionID($datum['voterid'], $position['positionid']);
				$candidates = array();
				foreach($votes as $vote) {
					$candidates[] = $vote['firstname'] . " " . $vote['lastname'];
				}
				$body .= (", " . implode("|", $candidates));
			}
		}
		$tmp[] = "$datum[lastname], $datum[firstname], $datum[email], $datum[voted]" . $body;
	}
}

$data = implode("\r\n", $tmp);

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=voters.txt");
echo $data;

?>