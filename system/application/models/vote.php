<?php

class Vote extends Model {

	function Vote()
	{
		parent::Model();
	}

	function insert($vote)
	{
		return $this->db->insert('votes', $vote);
	}

	function count_all_by_position_id($position_id)
	{
		$this->db->select('count(votes.candidate_id) AS votes, candidates.id AS candidate_id');
		$this->db->from('votes');
		$this->db->join('candidates', 'candidates.id = votes.candidate_id', 'right');
		$this->db->where(compact('position_id'));
		$this->db->groupby('candidates.id');
		$this->db->orderby('votes', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}

}

?>