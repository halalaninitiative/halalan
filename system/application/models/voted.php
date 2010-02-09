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

	function update($voted, $election_id, $voter_id)
	{
		return $this->db->update('voted', $voted, compact('election_id', 'voter_id'));
	}

	function select($election_id, $voter_id)
	{
		$this->db->from('voted');
		$this->db->where(compact('election_id', 'voter_id'));
		$query = $this->db->get();
		return $query->row_array();
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
