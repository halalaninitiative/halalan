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

}

?>