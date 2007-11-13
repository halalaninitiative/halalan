<?php

class Boter extends Model {

	function Boter()
	{
		parent::Model();
	}

	function authenticate($username, $password)
	{
		$this->db->from('voters');
		$this->db->where(array('username'=>$username, 'password'=>$password));
		$query = $this->db->get();
		return $query->row_array();
	}

	function update($voter, $voter_id)
	{
		return $this->db->update('voters', $voter, array('id'=>$voter_id));
	}
	
	function getVotersList() {
	
		$this->db->from('voters');
		$results = $this->db->get();
		
		return $results->row_array();
		
	}
		
	function select($id) {
	
		$this->db->from('voters');
		$this->db->where('id', $id);
		$results = $this->db->get();
		
		return $results->row_array();
		
	}
	
	function selectByUsername($username) {
		
		$this->db->from('voters');
		$this->db->where('name', $username);
		$results = $this->db->get();
		
		return $results->row_array();
		
	}
	
	function selectByMatch($username) {
	
		$match = '%'.$username.'%';
		
		$this->db->from('voters');
		$this->db->where('name', $match);
		$results = $this->db->get();
			
		return $results->row_array();
	
	}
	
	function add($entity) {
	
		$this->db->set('username', $entity['username']);
		$this->db->set('password', sha1($entity['password']);
		$this->db->set('pin', $entity['pin']);
		$this->db->set('first_name', $entity['first_name']);		
		$this->db->set('last_name', $entity['last_name']);
		$this->db->set('voted', 0);
		$this->db->insert('voters');
	
	}
	
	function update($id, $entity) {
	
		$this->db->where('id', $id);
		$this->db->update('voters', $entity);		
		
	}
	
	function delete($id) {
		
		$this->db->where('id', $id);
		$this->db->delete('voters');
		
	}

}

?>