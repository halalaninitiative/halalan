<?php

/* Required Files */
Hypworks::loadDao('Admin');

extract($_POST, EXTR_REFS|EXTR_SKIP);

$admin = Admin::authenticate($email, $password);

if($admin) {
	$_SESSION[INDEX_USERTYPE] = USER_ADMIN;
	$_SESSION['user'] = $admin;
	$this->forward('adminhome');
}
else {
	$this->addUserInput(compact('email'));
	$this->addError('login1', "Login failed!");
	$this->addError('login2', "Please try again.");
	$this->back();
}

?>