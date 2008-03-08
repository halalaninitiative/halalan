<?php

class Party extends Model {

	function Party()
	{
		parent::Model();
	}

	function insert($party)
	{
		return $this->db->insert('parties', $party);
	}

	function update($party, $id)
	{
		return $this->db->update('parties', $party, compact('id'));
	}

	function delete($id)
	{
		$this->db->where(compact('id'));
		return $this->db->delete('parties');
	}

	function select($id)
	{
		$this->db->from('parties');
		$this->db->where(compact('id'));
		$query = $this->db->get();
		return $query->row_array();
	}

	function select_all()
	{
		$this->db->from('parties');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_by_party($party)
	{
		$this->db->from('parties');
		$this->db->where(compact('party'));
		$query = $this->db->get();
		return $query->row_array();
	}

	function in_use($party_id)
	{
		$this->db->from('candidates');
		$this->db->where(compact('party_id'));
		return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
	}

}

?>
