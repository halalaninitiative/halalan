<?php

class Voted extends Model {

	function Voted()
	{
		parent::Model();
	}

	function insert($voted)
	{
		return $this->db->insert('voted', $voted);
	}

	function select_all_by_voter_id($voter_id)
	{
		$this->db->from('voted');
		$this->db->where(compact('voter_id'));
		$query = $this->db->get();
		return $query->result_array();
	}

}

?>
