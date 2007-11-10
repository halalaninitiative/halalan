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

}

?>