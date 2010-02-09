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

	function select_all_by_election_id_and_position_id($election_id, $position_id)
	{
		$this->db->from('candidates');
		$this->db->where(compact('election_id', 'position_id'));
		$this->db->order_by('party_id', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_all_by_position_id($position_id)
	{
		$this->db->from('candidates');
		$this->db->where(compact('position_id'));
		$this->db->order_by('party_id', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_by_name_and_alias($first_name, $last_name, $alias)
	{
		$this->db->from('candidates');
		if (empty($alias))
		{
			$this->db->where(compact('first_name', 'last_name'));
		}
		else
		{
			$this->db->where(compact('first_name', 'last_name', 'alias'));
		}
		$query = $this->db->get();
		return $query->row_array();
	}

	function has_votes($candidate_id)
	{
		$this->db->from('votes');
		$this->db->where(compact('candidate_id'));
		return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
	}

    function update_candidates_election_id()
    {
        $this->db->from('candidates');
        $this->db->select('id, position_id');
        $query = $this->db->get();
        $candidates = $query->result_array();
        foreach ($candidates as $candidate)
        {
            $this->db->flush_cache();
            $this->db->from('elections_positions');
            $this->db->where('position_id',$candidate['position_id']);
            $this->db->select('election_id');
            $result = $this->db->get();
            $election_id = $result->row_array();
            $this->db->where('id',$candidate['id']);
            $this->db->update('candidates',$election_id);
        }
    }

	function select_all_by_election_id($election_id)
	{
		$this->db->from('candidates');
		$this->db->where(compact('election_id'));
		$this->db->order_by('party_id', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

    function select_party_ids_by_election_id($election_id)
	{
		$this->db->from('candidates');
		$this->db->select('party_id');
		$this->db->distinct();
		$this->db->where(compact('election_id'));
		$this->db->order_by('party_id', 'asc');
		$query = $this->db->get();
        $result = $query->result_array();

		foreach ($result as $party_id)
		{
		    $this->db->flush_cache();
    		$this->db->from('parties');
		    $this->db->where('id',$party_id['party_id']);
		    $temp = $this->db->get();
		    $return[] = $temp->row_array();
		}

        return $return;

	}

}

?>
