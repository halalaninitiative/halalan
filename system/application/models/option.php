<?php

class Option extends Model {

	function Option()
	{
		parent::Model();
	}

	function update($option, $id)
	{
		return $this->db->update('options', $option, compact('id'));
	}

	function select($id)
	{
		$this->db->from('options');
		$this->db->where(compact('id'));
		$query = $this->db->get();
		return $query->row_array();
	}

}

?>