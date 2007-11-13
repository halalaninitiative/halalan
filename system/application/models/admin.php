<?php

class Admin extends Model {
	
	function Admin() 
	{
		parent::Model();
	}
	
	function authenticate($username, $password)
	{
		$this->db->from('admins');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$results = $this->db->get();
		
		return $results->row_array();
	}
		
	function select($id) {
	
		$this->db->from('admins');
		$this->db->where('id', $id);
		$results = $this->db->get();
		
		return $results->row_array();
		
	}
	
	function selectByUsername($username) {
	
		$this->db->from('admins');
		$this->db->where('username', $username);
		$results = $this->db->get();
		
		return $results->row_array();
	
	}
	
	function selectByMatch($username) {
	
		$match = '%'.$username.'%';
		
		$this->db->from('admins');
		$this->db->where('username', $match);
		$results = $this->db->get();
		
		return $results->row_array();		
	
	}

}

?>