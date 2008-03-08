<?php

class Position extends Model {

	function Position()
	{
		parent::Model();
	}

	function insert($position)
	{
		return $this->db->insert('positions', $position);
	}

	function update($position, $id)
	{
		return $this->db->update('positions', $position, compact('id'));
	}

	function delete($id)
	{
		$this->db->where(array('position_id'=>$id));
		$this->db->delete('positions_voters');
		$this->db->where(compact('id'));
		return $this->db->delete('positions');
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
		$this->db->order_by('ordinality ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_all_with_units($voter_id)
	{
		$this->db->from('positions');
		$this->db->join('positions_voters', 'positions.id = positions_voters.position_id', 'left');
		$this->db->where('(positions.unit = FALSE OR positions.unit IS NULL) OR positions_voters.voter_id = ' . $voter_id);
		$this->db->order_by('ordinality ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_all_non_units()
	{
		$this->db->from('positions');
		$this->db->where('unit = FALSE OR unit IS NULL');
		$this->db->order_by('ordinality ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_all_units()
	{
		$this->db->from('positions');
		$this->db->where('unit = TRUE');
		$this->db->order_by('ordinality ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_by_position($position)
	{
		$this->db->from('positions');
		$this->db->where(compact('position'));
		$query = $this->db->get();
		return $query->row_array();
	}

	function in_use($position_id)
	{
		$this->db->from('candidates');
		$this->db->where(compact('position_id'));
		return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
	}

}

?>
