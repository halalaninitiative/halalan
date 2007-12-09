<?php

class Candidate extends Model {

	function Candidate()
	{
		parent::Model();
	}

	function insert($candidate)
	{
		return $this->db->insert('candidates', $candidate);
	}

	function update($candidate, $id)
	{
		return $this->db->update('candidates', $candidate, compact('id'));
	}

	function delete($id)
	{
		$this->db->where(compact('id'));
		return $this->db->delete('candidates');
	}

	function select($id)
	{
		$this->db->where(compact('id'));
		$this->db->from('candidates');
		$query = $this->db->get();
		return $query->row_array();
	}

	function select_all_by_position_id($position_id)
	{
		$this->db->from('candidates');
		$this->db->where(compact('position_id'));
		$query = $this->db->get();
		return $query->result_array();
	}

	function has_votes($candidate_id)
	{
		$this->db->from('votes');
		$this->db->where(compact('candidate_id'));
		$query = $this->db->get();
		if (count($query->result_array()) > 0)
			return TRUE;
		else
			return FALSE;
	}

}

?>