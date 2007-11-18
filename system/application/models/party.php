<?php

class Party extends Model {

	function Party()
	{
		parent::Model();
	}

	function select($id)
	{
		$this->db->from('parties');
		$this->db->where(compact('id'));
		$query = $this->db->get();
		return $query->row_array();
	}

}

?>