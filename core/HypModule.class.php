<?php


define('HYP_MOD_VIEW', 1);
define('HYP_MOD_ACTION', 2);

/**
 * This class encapsulates the execution, processing of modules.
 *
 */
class HypModule {

	/** The name of the module */
	var $name;
	/** The params that comes with the module defined in the Module Definition File */
	var $params = array();

	function HypModule ($name) {
		global $MODULES; // defined in boroonggoo.php
		$this->name = $name;
		$this->params = $MODULES[$name];
	}

	/**
	 * Starts the execution of the script defined in the Modules
	 * definition file of the module.
	 *
	 */
	function execute () {
		global $PARAMS; // defined in common.php

		include(APP_HOOKS . "/pre-execute.php");

		if (!empty($this->params['path']))
			require $this->params['path'];
		else
			$this->display(); // this is for View Modules only

		include(APP_HOOKS . "/post-execute.php");
	}

	/**
	 * Forwards to another module / web page.
	 *
	 * NOTE: There must be no headers sent yet for this to work.
	 *
	 * @param string $uri the URI on which this module will be forwarded
	 * @param boolean $isAbsolute if true, will be forwarded to an external URI
	 *
	 */
	function forward ($uri, $isAbsolute = null) {
		if (func_num_args() < 2)
			$isAbsolute = isAbsUri($uri);
		if (!$isAbsolute)
			$uri = APP_URI . "/" . HypModule::uri($uri);
		header("Location: $uri");
		exit();
	}

	/**
	 * Goes back to the previous page. Useful in action modules.
	 *
	 */
	function back () {
		$uri = @$_SERVER['HTTP_REFERER']; // suppress the error because this value does not exist on URIs without referrers
		header("Location: $uri");
		exit();
	}

	/**
	 * Restricts access to a specified user type (or types) or if the user is logged in.
	 *
	 * @param integer $userType the allowed user type to access the module (variable number)
	 *
	 * @returns boolean if true the current user in the session is allowed to access the module
	 *
	 */
	function restrict ($userType = null) {
		if (isset($userType)) {
			if (isset($_SESSION[INDEX_USERTYPE])) {
				$types = func_get_args();
				if (in_array($_SESSION[INDEX_USERTYPE], $types))
					return true;
			}
		} else {
			if (isset($_SESSION[INDEX_USERID])) {
				return true;
			}
		}

		if (isset($_SESSION[INDEX_USERID])) { // if the user is logged in but restricted
			HypModule::forbidden();
		} else {
			HypModule::unauthorized();
		}

		HypModule::forward($moduleName);
	}

	/**
	 * Adds a message to the session.
	 *
	 * @param string the message itself, or the ID that represents the message, if an optional second parameter is supplied
	 * @param string the message
	 *
	 */
	function addMessage ($param1, $param2 = null) {
		if (func_num_args() < 2) {
			return $_SESSION[INDEX_MESSAGE][] = $param1;
		} else {
			return $_SESSION[INDEX_MESSAGE][$param1] = $param2;
		}
	}

	/**
	 * Returns the message represented by the Message ID
	 *
	 * @param string $messageid the ID that represents the message
	 *
	 * @returns the message that comes with the message ID
	 *
	 */
	function message ($messageid) {
		return @$_SESSION[INDEX_MESSAGE][$messageid];
	}

	/**
	 * Returns an associative array of all messages that exist.
	 *
	 */
	function messages () {
		if (!empty($_SESSION[INDEX_MESSAGE]))
			return $_SESSION[INDEX_MESSAGE];
		else
			return array();
	}

	/**
	 * Returns true if there is a message in the session.
	 *
	 */
	function hasMessage ($messageid = null) {
		if (func_num_args() >= 1) {
			return !empty($_SESSION[INDEX_MESSAGE][$messageid]);
		} else {
			return !empty($_SESSION[INDEX_MESSAGE]);
		}
	}


	/**
	 * Clears all messages in the session.
	 *
	 */
	function clearMessages () {
		unset($_SESSION[INDEX_MESSAGE]);
	}

	/**
	 * Adds an error to the session.
	 *
	 * @param string the error itself, or the ID that represents the error, if an optional second parameter is supplied
	 * @param string the error
	 *
	 */
	function addError ($param1, $param2 = null) {
		if (func_num_args() < 2) {
			return $_SESSION[INDEX_ERROR][] = $param1;
		} else {
			return $_SESSION[INDEX_ERROR][$param1] = $param2;
		}
	}

	/**
	 * Returns the error represented by the Error ID
	 *
	 * @param string $errorid the ID that represents the error
	 *
	 * @returns the error that comes with the error ID
	 *
	 */
	function error ($errorid) {
		return @$_SESSION[INDEX_ERROR][$errorid];
	}

	/**
	 * Returns an associative array of all errors that exist.
	 *
	 */
	function errors () {
		if (!empty($_SESSION[INDEX_ERROR]))
			return $_SESSION[INDEX_ERROR];
		else
			return array();
	}

	/**
	 * Returns true if there is an error in the session.
	 *
	 */
	function hasError ($errorid = null) {
		if (func_num_args() >= 1) {
			return !empty($_SESSION[INDEX_ERROR][$errorid]);
		} else {
			return !empty($_SESSION[INDEX_ERROR]);
		}
	}

	/**
	 * Clears all errors in the session.
	 *
	 */
	function clearErrors () {
		unset($_SESSION[INDEX_ERROR]);
	}


	/**
	 * Restricts the number of parameters.
	 *
	 * Parameters not needed (i.e. they are beyond the number of valid parameters) by this module is discarded.
	 * This is a security measure especially useful to avoid attacks on Smarty's caching capability.
	 *
	 * @param int $num the number of parameters required for a specific module.
	 *
	 * @returns the number of discarded parameters
	 *
	 */
	function restrictParams ($num) {
		global $PARAMS;
		$c = count($PARAMS);
		for ($i = $num; $i < $c; $i++) {
			unset($PARAMS[$i]);
		}
		return $c - $num;
	}


	/**
	 * Binds the ordered parameters into named parameters (associative array).
	 * Furthermore, the paramaters that are not bound are unset.
	 *
	 * @param string ... the name of the parameters, respectively
	 *
	 * @returns the associative array that is bound to the global $PARAMS variable
	 *
	 */
	function &bindParams () {
		global $PARAMS;
		$args = func_get_args();
		HypModule::restrictParams(count($args));
		$params = array();
		$i = 0;
		foreach ($args as $arg) {
			@$params[$arg] =& $PARAMS[$i++];
		}
		return $params;
	}

	/**
	* Translates a module name to its URI counterpart.
	*
	*/
	function uri ($modulename) {
		if (empty($modulename)) {
			$modulename = MODULE_FULLNAME;
		}
		if ($modulename{0} == '#' || $modulename{0} == '?') {
			$modulename = MODULE_FULLNAME . $modulename;
		}
		$parts = explode('?', $modulename, 2); // separate the query string
		$uri = str_replace(array('{$MOD}', '{$GET}'), $parts, APP_MOD_URI);
		return rtrim($uri, '?&');
	}

	function log ($message, $type = E_USER_WARNING) {
		if (!file_exists(APP_LOGS)) {
			mkdirhier(APP_LOGS);
		}
		$filename = APP_LOGS . '/' . date('Y-m-d') . '.log';
		if (!file_exists($filename)) {
			touch($filename);
		}
		$time = date('H:i:s');
		$prefix = "[$time]";
		if (isset($this)) {
			$prefix = "[{$this->name}]$prefix";
		}
		$result = error_log("$prefix $message\n", 3, $filename);
		trigger_error($message, $type);
		return $result;
	}


	function addUserInput ($param1, $param2 = null) {
		$params = array();
		if (func_num_args() >= 2) {
			$params[$param1] = $param2;
		} else if (is_array($param1)) {
			$params = $param1;
		} else {
			trigger_error("HypModule::addUserInput() : 1st parameter must be an array or two parameters must represent a key-value pair.", E_USER_WARNING);
			return false;
		}
		if (empty($params)) {
			return false;
		}
		$_SESSION[INDEX_USER_INPUT] = $params + (isset($_SESSION[INDEX_USER_INPUT]) ? $_SESSION[INDEX_USER_INPUT] : array());
		return true;
	}

	function userInput ($paramname = null) {
		if (isset($paramname)) {
			return @$_SESSION[INDEX_USER_INPUT][$paramname];
		} else {
			if (isset($_SESSION[INDEX_USER_INPUT])) {
				return $_SESSION[INDEX_USER_INPUT];
			} else {
				return array();
			}
		}
	}


	function clearUserInput () {
		unset($_SESSION[INDEX_USER_INPUT]);
	}

	function hasUserInput () {
		return !empty($_SESSION[INDEX_USER_INPUT]);
	}

	function home () {
		HypModule::forward(APP_MOD_DEFAULT);
	}


	function unauthorized ($log = null) {
		header("HTTP/1.0 401 Unauthorized", true, 401);
		if (func_num_args() > 0) {
			if (isset($this)) {
				$this->log($log);
			} else {
				HypModule::log($log);
			}
		}
		require_once APP_CORE . "/HypView.class.php";
		$module = new HypView(strtolower(APP_MOD_UNAUTHORIZED));
		$module->execute();
		exit();
	}

	function forbidden ($log = null) {
		header("HTTP/1.0 403 Forbidden", true, 403);
		if (func_num_args() > 0) {
			if (isset($this)) {
				$this->log($log);
			} else {
				HypModule::log($log);
			}
		}
		require_once APP_CORE . "/HypView.class.php";
		$module = new HypView(strtolower(APP_MOD_FORBIDDEN));
		$module->execute();
		exit();
	}

	function missing ($log = null) {
		header("HTTP/1.0 404 Not Found", true, 404);
		if (func_num_args() > 0) {
			if (isset($this)) {
				$this->log($log);
			} else {
				HypModule::log($log);
			}
		}
		require_once APP_CORE . "/HypView.class.php";
		$module = new HypView(strtolower(APP_MOD_MISSING));
		$module->execute();
		exit();
	}

}

?>