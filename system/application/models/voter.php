<?php

class Voter extends Model {

	function Voter()
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