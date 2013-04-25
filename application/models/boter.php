<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Copyright (C) 2006-2012 University of the Philippines Linux Users' Group
 *
 * This file is part of Halalan.
 *
 * Halalan is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Halalan is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Halalan.  If not, see <http://www.gnu.org/licenses/>.
 */

class Boter extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function authenticate($username, $password)
	{
		$this->db->from('voters');
		$this->db->where(compact('username', 'password'));
		$query = $this->db->get();
		return $query->row_array();
	}

	public function insert($voter)
	{
		return $this->db->insert('voters', $voter);
	}

	public function update($voter, $id)
	{
		return $this->db->update('voters', $voter, compact('id'));
	}

	public function delete($id)
	{
		$this->db->where(compact('id'));
		return $this->db->delete('voters');
	}

	public function select($id)
	{
		$this->db->from('voters');
		$this->db->where(compact('id'));
		$query = $this->db->get();
		return $query->row_array();
	}

	public function select_all()
	{
		$this->db->from('voters');
		$this->db->order_by('last_name', 'ASC');
		$this->db->order_by('first_name', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function select_all_by_block_id($block_id)
	{
		$this->db->where('block_id', $block_id);
		$this->db->from('voters');
		$this->db->order_by('last_name', 'ASC');
		$this->db->order_by('first_name', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function select_by_username($username)
	{
		$this->db->from('voters');
		$this->db->where(compact('username'));
		$query = $this->db->get();
		return $query->row_array();
	}

	public function in_use($voter_id)
	{
		$this->db->from('voted');
		$this->db->where(compact('voter_id'));
		return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
	}

	public function in_running_election($id)
	{
		$this->db->from('voters');
		$this->db->join('blocks_elections_positions', 'voters.block_id = blocks_elections_positions.block_id');
		$this->db->where(compact('id'));
		$this->db->where('election_id IN (SELECT id FROM elections WHERE status = 1)');
		return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
	}

}

/* End of file boter.php */
/* Location: ./application/models/boter.php */