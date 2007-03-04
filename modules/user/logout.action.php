<?php

$this->restrict(USER_VOTER, USER_ADMIN);

if($_SESSION[INDEX_USERTYPE] == USER_VOTER) {
	Hypworks::loadDao('Voter');
	$logout = date("Y-m-d H:i:s");
	Voter::update(compact('logout'), $_SESSION[INDEX_USERID]);
	$home = "login";
}
else if($_SESSION[INDEX_USERTYPE] == USER_ADMIN) {
	$home = "adminlogin";
}

session_destroy();

$this->forward($home);

?>