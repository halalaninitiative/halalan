<?php

class Party extends Model {

	function Party()
	{
		parent::Model();
	}

	function select($party_id)
	{
		$this->db->from('parties');
		$this->db->where(array('id'=>$party_id));
		$query = $this->db->get();
		return $query->row_array();
	}

}

?>