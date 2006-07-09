<?php

require_once APP_CORE . "/HypDao.class.php";

class Party extends HypDao {

	function insert($entity) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 0;
		return $db->autoExecute('parties', $entity, 'INSERT');
	}

	function update($entity, $partyid) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 1;
		return $db->autoExecute('parties', $entity, 'UPDATE', "partyid=$partyid");
	}

	function delete($partyid) {
		$db = parent::connect();
		return $db->execute("DELETE FROM parties WHERE partyid = ?", array($partyid));
	}

	function select($partyid) {
		$db = parent::connect();
		return $db->getRow("SELECT * FROM parties WHERE partyid = ?", array($partyid));
	}

	function selectAll() {
		$db = parent::connect();
		return $db->getAll("SELECT * FROM parties ORDER BY party ASC");
	}

	function selectAllForSelect() {
		$db = parent::connect();
		$rs = $db->execute("SELECT * FROM parties ORDER BY party ASC");
		$list = array();
		while($row = $rs->fields) {
			$list[$row['partyid']] = $row['party'];
			$rs->moveNext();
		}
		return $list;
	}

}

?>