<?php

class Vote extends Model {

	function Vote()
	{
		parent::Model();
	}

	function insert($vote)
	{
		return $this->db->insert('votes', $vote);
	}

}

?>