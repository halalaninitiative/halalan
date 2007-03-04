<?php

require_once APP_CORE . "/HypDao.class.php";

class Voter extends HypDao {

	function insert($entity) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 0;
		return $db->autoExecute('voters', $entity, 'INSERT');
	}

	function update($entity, $voterid) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 1;
		return $db->autoExecute('voters', $entity, 'UPDATE', "voterid=$voterid");
	}

	function delete($voterid) {
		$db = parent::connect();
		return $db->execute("DELETE FROM voters WHERE voterid = ?", array($voterid));
	}

	function select($voterid) {
		$db = parent::connect();
		return $db->getRow("SELECT * FROM voters WHERE voterid = ?", array($voterid));
	}

	function selectByEmail($email) {
		$db = parent::connect();
		return $db->getRow("SELECT * FROM voters WHERE email = ?", array($email));
	}

	function selectAll() {
		$db = parent::connect();
		return $db->getAll("SELECT * FROM voters ORDER BY lastname ASC, firstname ASC");
	}

	function selectAllWithUnit() {
		$db = parent::connect();
		return $db->getAll("SELECT *, position AS unit FROM voters LEFT JOIN positions ON (unitid = positionid) ORDER BY position, lastname ASC, firstname ASC");
	}

	function selectAllForPagination($count, $limit="ALL", $offset="0") {
		$db = parent::connect();
		if($count) {
			$rs = $db->execute("SELECT * FROM voters ORDER BY lastname ASC, firstname ASC LIMIT $limit OFFSET $offset");
			return $rs->RecordCount();
		}
		else {
			return $db->getAll("SELECT * FROM voters ORDER BY lastname ASC, firstname ASC LIMIT $limit OFFSET $offset");
			
		}
	}

	function authenticate($email, $password) {
		$db = parent::connect();
		return $db->getRow("SELECT * FROM voters WHERE email = ? AND password = ? LIMIT 1", array($email, sha1($password)));
	}

	function authenticatePin($voterid, $pin) {
		$db = parent::connect();
		return $db->getRow("SELECT * FROM voters WHERE voterid = ? AND pin = ? LIMIT 1", array($voterid, sha1($pin)));
	}

	function doEmailExists($email) {
		$db = parent::connect();
		return $db->getRow("SELECT * FROM voters WHERE email = ?", array($email));
	}

}

?>