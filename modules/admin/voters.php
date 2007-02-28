<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Voter');

/* Assign/Initialize common variables */
global $DISPLAYS;

/* Data Gathering */
$rows = Voter::selectAllForPagination(true);
if(!isset($_GET['display'])) {
	$display = PAGE_LIMIT;
}
else {
	$display = $_GET['display'];
}
$last = ceil($rows/$display);
if(!isset($_GET['page'])) {
	$page = 1;
}
else {
	$page = $_GET['page'];
	if($page < 1) {
		$page = 1;
	}
	else if($page > $last) {
		$page = $last;
	}
}
$voters = Voter::selectAllForPagination(false, $display, ($page - 1) * $display);

/* Final Assignment of Variables */
$this->assign(compact('voters', 'page', 'last', 'rows'));
$temp = $_SERVER['REDIRECT_URL'];
if($page > 1) {
	$url['first'] =  $temp . "?page=1";
	$url['prev'] = $temp . "?page=" . ($page-1);
}
if($page < $last) {
	$url['next'] = $temp . "?page=" . ($page+1);
	$url['last'] = $temp . "?page=" . $last;
}
$selecteddisplay = $temp . "?display=" . $display;
foreach($DISPLAYS as $display) {
	$key = $temp . "?display=" . $display;
	$url['displays'][$key] = $display;
}
$this->assign('url', $url);
$this->assign('selecteddisplay', $selecteddisplay);

/* Output HTML */
$this->display();

?>