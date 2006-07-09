<?php

$this->restrict(USER_VOTER, USER_ADMIN);

if($_SESSION[INDEX_USERTYPE] == USER_VOTER)
	$home = "login";
else if($_SESSION[INDEX_USERTYPE] == USER_ADMIN)
	$home = "adminlogin";

session_destroy();

$this->forward($home);

?>