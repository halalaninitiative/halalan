<?php

class Position extends Model {

	function Position()
	{
		parent::Model();
	}

	function select($position_id)
	{
		$this->db->from('positions');
		$this->db->where(array('id'=>$position_id));
		$query = $this->db->get();
		return $query->row_array();
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