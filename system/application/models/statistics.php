<?php

class Statistics extends Model {

	function Statistics()
	{
		parent::Model();
	}

	function count_all_voters($election_id)
	{
		$this->db->distinct();
		$this->db->select('id');
		$this->db->from('voters');
		$this->db->join('elections_positions_voters', 'elections_positions_voters.voter_id = voters.id');
		$this->db->where('election_id', $election_id);
		$query = $this->db->get();
		return count($query->result_array());
	}

	function count_all_voted($election_id)
	{
		$this->db->from('voters');
		$this->db->join('voted', 'voted.voter_id = voters.id');
		$this->db->where('election_id', $election_id);
		return $this->db->count_all_results();
	}

	function count_all_by_duration($election_id, $begin, $end)
	{
		$this->db->distinct();
		$this->db->select('id');
		$this->db->from('voters');
		$this->db->join('elections_positions_voters', 'elections_positions_voters.voter_id = voters.id');
		$this->db->where('election_id', $election_id);
		$this->db->where('timediff(logout, login) >= \'' . $begin . '\'');
		if ($end)
		{
			$this->db->where('timediff(logout, login) < \'' . $end . '\'');
		}
		$query = $this->db->get();
		return count($query->result_array());
	}

}

?>
