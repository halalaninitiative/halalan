<?php

require_once APP_CORE . "/HypDao.class.php";

class Vote extends HypDao {

	function insert($entity) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 0;
		return $db->autoExecute('votes', $entity, 'INSERT');
	}

	function selectAll() {
		$db = parent::connect();
		return $db->getAll("SELECT * FROM votes");
	}

}

?>