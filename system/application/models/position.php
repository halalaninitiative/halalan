<?php

class Position extends Model {

	function Position()
	{
		parent::Model();
	}

	function select($id)
	{
		$this->db->from('positions');
		$this->db->where(compact('id'));
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

	function select_all_with_units($voter_id)
	{
		$this->db->from('positions');
		$this->db->join('positions_voters', 'positions.id = positions_voters.position_id', 'left');
		$this->db->where('(positions.unit = FALSE OR positions.unit IS NULL) OR positions_voters.voter_id = ' . $voter_id);
		$this->db->orderby('ordinality ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

}

?>