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
		$this->db->where('username', $username);
		$results = $this->db->get();
		
		return $results->row_array();
		
	}
	
	function select_by_match($username) {
	
		$match = '%'.$username.'%';
		
		$this->db->from('voters');
		$this->db->where('name', $match);
		$results = $this->db->get();
			
		return $results->result_array();
	
	}
	
	function add($entity) {
	
		$this->db->set('username', $entity['username']);
 		$this->db->set('password', sha1($entity['password']));
		$this->db->set('pin', $entity['pin']);
		$this->db->set('first_name', $entity['first_name']);		
		$this->db->set('last_name', $entity['last_name']);
		$this->db->set('voted', 0);
		return $this->db->insert('voters');
	
	}
	
	function delete($id) {
		
		$this->db->where('id', $id);
		return $this->db->delete('voters');
		
	}

}

?>