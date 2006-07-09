<?php

class Hypworks {

	/**
	 * Generates a random id for various purposes.
	 *
	 */
	function generateId () {
		$rand1 = mt_rand();
		$rand2 = mt_rand();
		$hash = md5($rand1);
		$id = 'hyp' . substr($hash, 3, 4) . substr($rand2, 3, 3);
		return $id;
	}

	function loadAddin ($name) {
		$names = func_get_args();
		unset($name);
		foreach ($names as $name) {
			require_once APP_ADDINS . "/$name.php";
		}
	}

	function loadDao ($name) {
		$names = func_get_args();
		unset($name);
		foreach ($names as $name) {
			require_once APP_DAO . "/$name.class.php";
		}
	}

}


?>