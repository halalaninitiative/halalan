<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Voter');

/* Assign/Initialize common variables */

/* Data Gathering */
if(strtolower(ELECTION_UNIT) == "enable") {
	$data = Voter::selectAllByUnitID();
	$tmp = array();
	$tmp[] = "Last Name, First Name, Email, Voted, Specific Unit";
	foreach($data as $datum) {
		$tmp[] = "$datum[lastname], $datum[firstname], $datum[email], $datum[voted], $datum[unit]";
	}
}
else {
	$data = Voter::selectAll();
	$tmp = array();
	$tmp[] = "Last Name, First Name, Email, Voted";
	foreach($data as $datum) {
		$tmp[] = "$datum[lastname], $datum[firstname], $datum[email], $datum[voted]";
	}
}

$data = implode("\r\n", $tmp);

/* Final Assignment of Variables */

/* Output HTML */
header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=voters.txt");
echo $data;

?>