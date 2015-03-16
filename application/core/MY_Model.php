<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $table;

	public function __construct()
	{
		parent::__construct();
	}

	function insert($data)
	{
		return $this->db->insert($this->table, $data);
	}

	function update($data, $id)
	{
		return $this->db->update($this->table, $data, compact('id'));
	}

	function delete($id)
	{
		$this->db->where(compact('id'));
		return $this->db->delete($this->table);
	}

	public function select_where($where)
	{
		$this->db->from($this->table);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function select_all_where($where)
	{
		$this->db->from($this->table);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}

}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */
