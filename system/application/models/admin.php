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
	
	function select_by_username($username) {
	
		$this->db->from('admins');
		$this->db->where('username', $username);
		$results = $this->db->get();
		
		return $results->row_array();
	
	}
	
	function select_by_match($username) {
	
		$match = '%'.$username.'%';
		
		$this->db->from('admins');
		$this->db->where('username', $match);
		$results = $this->db->get();
		
		return $results->row_array();		
	
	}

}

?>