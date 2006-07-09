<?php

require_once APP_CORE . "/HypDao.class.php";

class Admin extends HypDao {

	function insert($entity) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 0;
		return $db->autoExecute('admins', $entity, 'INSERT');
	}

	function update($entity, $adminid) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 1;
		return $db->autoExecute('admins', $entity, 'UPDATE', "adminid=$adminid");
	}

	function delete($adminid) {
		$db = parent::connect();
		return $db->execute("DELETE FROM admins WHERE adminid = ?", array($adminid));
	}

	function select($adminid) {
		$db = parent::connect();
		return $db->getRow("SELECT * FROM admins WHERE adminid = ?", array($adminid));
	}

	function selectByEmail($email) {
		$db = parent::connect();
		return $db->getRow("SELECT * FROM admins WHERE email = ?", array($email));
	}

	function selectAll() {
		$db = parent::connect();
		return $db->getAll("SELECT * FROM admins");
	}

	function authenticate($email, $password) {
		$db = parent::connect();
		return $db->getRow("SELECT * FROM admins WHERE email = ? AND password = ? LIMIT 1", array($email, sha1($password)));
	}

}

?>