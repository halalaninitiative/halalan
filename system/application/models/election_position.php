<?php

class Election_Position extends Model {

	function Election_Position()
	{
		parent::Model();
	}

	function select_all_by_position_id($position_id)
	{
		$this->db->from('elections_positions');
		$this->db->where(compact('position_id'));
		$query = $this->db->get();
		return $query->result_array();
	}

}

?>