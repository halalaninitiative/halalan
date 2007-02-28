<?php

require_once APP_CORE . "/HypDao.class.php";

class Position extends HypDao {

	function insert($entity) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 0;
		return $db->autoExecute('positions', $entity, 'INSERT');
	}

	function update($entity, $positionid) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 1;
		return $db->autoExecute('positions', $entity, 'UPDATE', "positionid=$positionid");
	}

	function delete($positionid) {
		$db = parent::connect();
		return $db->execute("DELETE FROM positions WHERE positionid = ?", array($positionid));
	}

	function select($positionid) {
		$db = parent::connect();
		return $db->getRow("SELECT * FROM positions WHERE positionid = ?", array($positionid));
	}

	function selectAll() {
		$db = parent::connect();
		return $db->getAll("SELECT * FROM positions ORDER BY ordinality ASC");
	}

	function selectAllWithoutUnit() {
		$db = parent::connect();
		return $db->getAll("SELECT * FROM positions WHERE unit = 0 OR unit IS NULL ORDER BY ordinality ASC");
	}

	function selectAllWithUnit($unitid) {
		$db = parent::connect();
		return $db->getAll("SELECT * FROM positions WHERE (unit = 0 OR unit IS NULL) OR positionid = ? ORDER BY ordinality ASC", array($unitid));
	}

	function selectAllForSelect() {
		$db = parent::connect();
		$rs = $db->execute("SELECT * FROM positions ORDER BY position ASC");
		$list = array();
		while($row = $rs->fields) {
			$list[$row['positionid']] = $row['position'];
			$rs->moveNext();
		}
		return $list;
	}

	function selectAllUnitsForSelect() {
		$db = parent::connect();
		$rs = $db->execute("SELECT * FROM positions WHERE unit = 1 ORDER BY position ASC");
		$list = array();
		while($row = $rs->fields) {
			$list[$row['positionid']] = $row['position'];
			$rs->moveNext();
		}
		return $list;
	}

}

?>