<?php

class Position extends Model {

	function Position()
	{
		parent::Model();
	}

	function select_all()
	{
		$this->db->from('positions');
		$this->db->orderby('ordinality ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

}

?>