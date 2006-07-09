<?php

/* Database configuration */
$id = 0;

$id++;
define('DB_PRIMARY', $id);
$DATABASE[$id]['driver'] = 'postgres7';
$DATABASE[$id]['host'] = '192.168.1.1';
$DATABASE[$id]['name'] = 'halalan';
$DATABASE[$id]['username'] = 'postgres';
$DATABASE[$id]['password'] = 'asdfgh';
$DATABASE[$id]['persists'] = true;
// $DATABASE[$id]['unique'] = false; /* if every connection is always new ('persists' must be false if this is true) */

/* In case you want a second database for other purpose */
// $id++;
// define('DB_READONLY', $id);
// $DATABASE[$id]['driver'] = 'mysql';
// $DATABASE[$id]['host'] = '192.168.1.1';
// $DATABASE[$id]['name'] = 'hypworks-lite';
// $DATABASE[$id]['username'] = 'root';
// $DATABASE[$id]['password'] = '';
// $DATABASE[$id]['persists'] = true;
// // $DATABASE[$id]['unique'] = false; /* if every connection is always new, can not be true if the connection persists */

define('DB_DEFAULT', DB_PRIMARY); // always define DB_DEFAULT

/* ADODB Sessions */
// $ADODB_SESSION_DRIVER = "mysql";
// $ADODB_SESSION_CONNECT = $DATABASE[DB_DEFAULT]['host'];
// $ADODB_SESSION_USER = $DATABASE[DB_DEFAULT]['username'];
// $ADODB_SESSION_PWD = $DATABASE[DB_DEFAULT]['password'];
// $ADODB_SESSION_DB = $DATABASE[DB_DEFAULT]['name'];
// $ADODB_SESSION_TBL = 'sessions';
// $ADODB_SESSION_CONNMODE = $DATABASE[DB_DEFAULT]['persists'];

?>