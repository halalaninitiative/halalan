<?php

class Boter extends Model {

	function Boter()
	{
		parent::Model();
	}

	function authenticate($username, $password)
	{
		$this->db->from('voters');
		$this->db->where(compact('username', 'password'));
		$query = $this->db->get();
		return $query->row_array();
	}

	function insert($voter)
	{
		$extra = $voter['extra'];
		unset($voter['extra']);
		$this->db->insert('voters', $voter);
		if (!empty($extra))
		{
			$voter_id = $this->db->insert_id();
			foreach ($extra as $e)
			{
				$election_id = $e['election_id'];
				$position_id = $e['position_id'];
				$this->db->insert('elections_positions_voters', compact('election_id', 'position_id', 'voter_id'));
			}
		}
		return true;
	}

	function update($voter, $id)
	{
		$extra = $voter['extra'];
		unset($voter['extra']);
		$this->db->where('voter_id', $id);
		$this->db->delete('elections_positions_voters');
		$this->db->update('voters', $voter, compact('id'));
		if (!empty($extra))
		{
			$voter_id = $id;
			foreach ($extra as $e)
			{
				$election_id = $e['election_id'];
				$position_id = $e['position_id'];
				$this->db->insert('elections_positions_voters', compact('election_id', 'position_id', 'voter_id'));
			}
		}
		return true;
	}

	function delete($id)
	{
		$this->db->where(array('voter_id'=>$id));
		$this->db->delete('positions_voters');
		$this->db->where(compact('id'));
		return $this->db->delete('voters');
	}

	function select($id)
	{
		$this->db->from('voters');
		$this->db->where(compact('id'));
		$query = $this->db->get();
		return $query->row_array();
	}

	function select_all()
	{
		$this->db->from('voters');
		$this->db->order_by('last_name', 'asc');
		$this->db->order_by('first_name', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_all_for_pagination($limit, $offset)
	{
		$this->db->from('voters');
		$this->db->order_by('last_name', 'asc');
		$this->db->order_by('first_name', 'asc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_by_username($username)
	{
		$this->db->from('voters');
		$this->db->where(compact('username'));
		$query = $this->db->get();
		return $query->row_array();
	}

	function select_by_match($username)
	{
		$match = '%'.$username.'%';
		$this->db->from('voters');
		$this->db->where('name', $match);
		$results = $this->db->get();
		return $results->result_array();
	}

}

?>