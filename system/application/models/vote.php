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

	function count_all_by_election_id_and_position_id($election_id, $position_id)
	{
		$this->db->select('count(votes.candidate_id) AS votes, candidates.id AS candidate_id');
		$this->db->from('votes');
		$this->db->join('candidates', 'candidates.id = votes.candidate_id', 'right');
		$this->db->where(compact('election_id', 'position_id'));
		$this->db->group_by('candidates.id');
		$this->db->order_by('votes', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_all_by_voter_id($voter_id)
	{
		$this->db->from('votes');
		$this->db->join('candidates', 'candidates.id = votes.candidate_id');
		$this->db->where(compact('voter_id'));
		$this->db->order_by('last_name', 'asc');
		$this->db->order_by('first_name', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

}

?>