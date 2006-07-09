<?php

/* Restricts access to specified user types */

/* Required Files */
Hypworks::loadDao('Position');

/* Assign/Initialize common variables */

/* Data Gathering */
$positions = Position::selectAll();

/* Final Assignment of Variables */
$this->assign(compact('positions'));

/* Output HTML */
$this->display();

?>