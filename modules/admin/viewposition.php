<?php

/* Restricts access to specified user types */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Position');

/* Assign/Initialize common variables */
$positionid = $PARAMS[0];

/* Data Gathering */
$position = Position::select($positionid);

/* Final Assignment of Variables */
$this->assign(compact('position'));

/* Output HTML */
$this->display();

?>
