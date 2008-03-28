<?php

class Random_Order extends Model {

	function Random_Order()
	{
		parent::Model();
	}

	function insert($random_order)
	{
		return $this->db->insert('random_orders', $random_order);
	}

	function select_by_voter_id($voter_id)
	{
		$this->db->from('random_orders');
		$this->db->where(compact('voter_id'));
		$query = $this->db->get();
		return $query->row_array();
	}

}

?>