<?php

class Election_Position_Voter extends Model {

	function Election_Position_Voter()
	{
		parent::Model();
	}

	function select_all_by_voter_id($voter_id)
	{
		$this->db->from('elections_positions_voters');
		$this->db->where(compact('voter_id'));
		$query = $this->db->get();
		return $query->result_array();
	}

}

?>