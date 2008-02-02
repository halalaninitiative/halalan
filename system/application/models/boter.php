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
		$chosen = $voter['chosen'];
		unset($voter['chosen']);
		$this->db->insert('voters', $voter);
		if (!empty($chosen))
		{
			$voter_id = $this->db->insert_id();
			foreach ($chosen as $position_id)
			{
				$this->db->insert('positions_voters', compact('voter_id', 'position_id'));
			}
		}
		return true;
	}

	function update($voter, $id)
	{
		if (isset($voter['chosen']))
		{
			$chosen = $voter['chosen'];
			unset($voter['chosen']);
		}
		$this->db->update('voters', $voter, compact('id'));
		if (!empty($chosen))
		{
			$voter_id = $id;
			$this->db->where(compact('voter_id'));
			$this->db->delete('positions_voters');
			foreach ($chosen as $position_id)
			{
				$this->db->insert('positions_voters', compact('voter_id', 'position_id'));
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
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_all_for_pagination($limit, $offset)
	{
		$this->db->from('voters');
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