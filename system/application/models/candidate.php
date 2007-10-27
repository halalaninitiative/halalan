<?php

class Candidate extends Model {

	function Candidate()
	{
		parent::Model();
	}

	function select_all_by_position_id($position_id)
	{
		$this->db->from('candidates');
		$this->db->where(array('position_id'=>$position_id));
		$query = $this->db->get();
		return $query->result_array();
	}

}

?>