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

	function insert($voter) {
		return $this->db->insert('voters', $voter);
	}

	function update($voter, $id)
	{
		return $this->db->update('voters', $voter, compact('id'));
	}
	
	function get_voters_list() {
	
		$this->db->from('voters');
		$results = $this->db->get();
		
		return $results->result_array();
		
	}
		
	function select($id) {
	
		$this->db->from('voters');
		$this->db->where('id', $id);
		$results = $this->db->get();
		
		return $results->row_array();
		
	}
	
	function select_by_username($username) {
		$this->db->from('voters');
		$this->db->where(compact('username'));
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function select_by_match($username) {
	
		$match = '%'.$username.'%';
		
		$this->db->from('voters');
		$this->db->where('name', $match);
		$results = $this->db->get();
			
		return $results->result_array();
	
	}
	
	function delete($id) {
		
		$this->db->where('id', $id);
		return $this->db->delete('voters');
		
	}

}

?>