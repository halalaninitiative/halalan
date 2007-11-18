<?php

class Abmin extends Model {
	
	function Abmin()
	{
		parent::Model();
	}

	function authenticate($username, $password)
	{
		$this->db->from('admins');
		$this->db->where(compact('username', 'password'));
		$query = $this->db->get();
		return $query->row_array();
	}

	function select($id)
	{
		$this->db->from('admins');
		$this->db->where(compact('id'));
		$query = $this->db->get();
		return $query->row_array();
	}

}

?>