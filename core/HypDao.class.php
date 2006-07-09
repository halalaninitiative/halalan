<?php

if (ADODB_ERROR_REPORTING) {
	require_once 'adodb/adodb-errorhandler.inc.php'; /** TODO: consider error logging */
}
require_once "adodb/adodb.inc.php";

/**
 * This is the class that DAOs of the web application will extend.
 *
 */
class HypDao {

	/**
	 * Connects to a database of specified type (or implicit type, which is the default).
	 *
	 */
	function &connect ($type = DB_DEFAULT) {
		global $CONNECTIONS; // holds all the ADODB connections
		global $CONNECTION; // holds the most recent connection
		global $DATABASE;
		$db =& $DATABASE[$type];
		if (isset($CONNECTIONS[$type])) {
			$CONNECTION =& $CONNECTIONS[$type];
			return $CONNECTION;
		} else {
			$CONNECTIONS[$type] =& ADONewConnection($db['driver']);
		}
		$conn =& $CONNECTIONS[$type];
		$CONNECTION =& $CONNECTIONS[$type];

		$forceNew = (count($CONNECTIONS) > 1); // if there is already more than one connection

		if ($db['persists'] && !$forceNew)
			$conn->pConnect($db['host'], $db['username'], $db['password'], $db['name']);
		else if (@$db['unique'] || $forceNew)
			$conn->nConnect($db['host'], $db['username'], $db['password'], $db['name']);
		else
			$conn->connect($db['host'], $db['username'], $db['password'], $db['name']);

		$GLOBALS['ADODB_FORCE_TYPE'] = ADODB_FORCE_TYPE;
		$conn->setFetchMode(ADODB_FETCH_MODE);
		$conn->debug = ADODB_DEBUG;
		return $conn;
	}


	/**
	 * Sets the $ADODB_FORCE_TYPE global variable and returns the former value.
	 * Especially useful if you want to temporarily set the force type of a query.
	 *
	 */
	function setForceType ($forceType)  {
		global $ADODB_FORCE_TYPE;
		$former = $ADODB_FORCE_TYPE;
		$ADODB_FORCE_TYPE = $forceType;
		return $former;
	}

}

?>