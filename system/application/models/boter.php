<?php
/**
 * Copyright (C) 2006-2011  University of the Philippines Linux Users' Group
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

class Boter extends Model {

	function Boter()
	{
		parent::Model();
	}

	function authenticate($username, $password)
	{
		$this->db->from('voters');
		$this->db->where(compact('username', 'password'));
		$query = $this->db->get();
		return $query->row_array();
	}

	function insert($voter)
	{
		if (isset($voter['extra']))
		{
			$extra = $voter['extra'];
			unset($voter['extra']);
		}
		$this->db->insert('voters', $voter);
		if (!empty($extra))
		{
			$voter_id = $this->db->insert_id();
			foreach ($extra as $e)
			{
				$election_id = $e['election_id'];
				$position_id = $e['position_id'];
				$this->db->insert('elections_positions_voters', compact('election_id', 'position_id', 'voter_id'));
			}
		}
		return true;
	}

	function update($voter, $id)
	{
		if (isset($voter['extra']))
		{
			$extra = $voter['extra'];
			unset($voter['extra']);
			$this->db->where('voter_id', $id);
			$this->db->delete('elections_positions_voters');
		}
		$this->db->update('voters', $voter, compact('id'));
		if (!empty($extra))
		{
			$voter_id = $id;
			foreach ($extra as $e)
			{
				$election_id = $e['election_id'];
				$position_id = $e['position_id'];
				$this->db->insert('elections_positions_voters', compact('election_id', 'position_id', 'voter_id'));
			}
		}
		return true;
	}

	function delete($id)
	{
		$this->db->where(array('voter_id'=>$id));
		$this->db->delete('elections_positions_voters');
		$this->db->where(compact('id'));
		return $this->db->delete('voters');
	}

	function select($id)
	{
		$this->db->from('voters');
		$this->db->where(compact('id'));
		$query = $this->db->get();
		return $query->row_array();
	}

	function select_all()
	{
		$this->db->from('voters');
		$this->db->order_by('last_name', 'asc');
		$this->db->order_by('first_name', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_all_for_pagination($limit, $offset)
	{
		$this->db->from('voters');
		$this->db->order_by('last_name', 'asc');
		$this->db->order_by('first_name', 'asc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_by_username($username)
	{
		$this->db->from('voters');
		$this->db->where(compact('username'));
		$query = $this->db->get();
		return $query->row_array();
	}

	function select_by_match($username)
	{
		$match = '%'.$username.'%';
		$this->db->from('voters');
		$this->db->where('name', $match);
		$results = $this->db->get();
		return $results->result_array();
	}

	function in_use($voter_id)
	{
		$this->db->from('voted');
		$this->db->where(compact('voter_id'));
		return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
	}

	function in_running_election($voter_id)
	{
		$this->db->from('elections_positions_voters');
		$this->db->where(compact('voter_id'));
		$this->db->where('election_id IN (SELECT id FROM elections WHERE status = 1)');
		return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
	}

}

?>
