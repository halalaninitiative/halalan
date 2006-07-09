<?php

require_once APP_CORE . "/HypDao.class.php";

class Candidate extends HypDao {

	function insert($entity) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 0;
		return $db->autoExecute('candidates', $entity, 'INSERT');
	}

	function update($entity, $candidateid) {
		$db = parent::connect();
		$GLOBALS['ADODB_FORCE_TYPE'] = 1;
		return $db->autoExecute('candidates', $entity, 'UPDATE', "candidateid=$candidateid");
	}

	function delete($candidateid) {
		$db = parent::connect();
		return $db->execute("DELETE FROM candidates WHERE candidateid = ?", array($candidateid));
	}

	function select($candidateid) {
		$db = parent::connect();
		return $db->getRow("SELECT candidates.*, parties.party, positions.position, positions.maximum, positions.ordinality FROM candidates JOIN parties USING(partyid) JOIN positions USING(positionid) WHERE candidates.candidateid = ? ORDER BY lastname, firstname", array($candidateid));
	}

	function selectAll() {
		$db = parent::connect();
		return $db->getAll("SELECT * FROM candidates ORDER BY lastname ASC, firstname ASC");
	}

	function selectAllByPositionID($positionid) {
		$db = parent::connect();
		return $db->getAll("SELECT candidates.*, parties.party, positions.maximum, positions.ordinality FROM candidates JOIN parties USING(partyid) JOIN positions USING(positionid) WHERE candidates.positionid = ? ORDER BY lastname, firstname", array($positionid));
	}
}

?>