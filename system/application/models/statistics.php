<?php
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

class Statistics extends Model {

	function Statistics()
	{
		parent::Model();
	}

	function breakdown_all_voters($election_id)
	{
		$this->db->select('block, COUNT(distinct voters.id) AS count');
		$this->db->from('blocks');
		$this->db->join('blocks_elections_positions', 'blocks_elections_positions.block_id = blocks.id', 'left');
		$this->db->join('voters', 'voters.block_id = blocks_elections_positions.block_id', 'left');
		$this->db->where('election_id', $election_id);
		$this->db->group_by('block');
		$this->db->order_by('block', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function breakdown_all_voted($election_id)
	{
		$this->db->select('block, COUNT(distinct voted.voter_id) AS count');
		$this->db->from('blocks');
		$this->db->join('blocks_elections_positions', 'blocks_elections_positions.block_id = blocks.id', 'left');
		$this->db->join('voters', 'voters.block_id = blocks_elections_positions.block_id', 'left');
		$this->db->join('voted', 'voted.voter_id = voters.id', 'left');
		$this->db->where('blocks_elections_positions.election_id', $election_id);
		$this->db->group_by('block');
		$this->db->order_by('block', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function breakdown_all_by_duration($election_id, $begin, $end)
	{
		$this->db->select('block, COUNT(distinct voters.id) AS count');
		$this->db->from('blocks');
		$this->db->join('blocks_elections_positions', 'blocks_elections_positions.block_id = blocks.id', 'left');
		if ($end)
		{
			$this->db->join('voters', 'voters.block_id = blocks_elections_positions.block_id AND timediff(logout, login) >= \'' . $begin . '\' AND timediff(logout, login) < \'' . $end . '\'', 'left');
		}
		else
		{
			$this->db->join('voters', 'voters.block_id = blocks_elections_positions.block_id AND timediff(logout, login) >= \'' . $begin . '\'', 'left');
		}
		$this->db->where('election_id', $election_id);
		$this->db->group_by('block');
		$this->db->order_by('block', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function count_all_voters($election_id)
	{
		$this->db->distinct();
		$this->db->select('id');
		$this->db->from('voters');
		$this->db->join('blocks_elections_positions', 'blocks_elections_positions.block_id = voters.block_id');
		$this->db->where('election_id', $election_id);
		$query = $this->db->get();
		return count($query->result_array());
	}

	function count_all_voted($election_id)
	{
		$this->db->from('voted');
		$this->db->where('election_id', $election_id);
		return $this->db->count_all_results();
	}

	function count_all_by_duration($election_id, $begin, $end)
	{
		$this->db->distinct();
		$this->db->select('id');
		$this->db->from('voters');
		$this->db->join('blocks_elections_positions', 'blocks_elections_positions.block_id = voters.block_id');
		$this->db->where('election_id', $election_id);
		$this->db->where('timediff(logout, login) >= \'' . $begin . '\'');
		if ($end)
		{
			$this->db->where('timediff(logout, login) < \'' . $end . '\'');
		}
		$query = $this->db->get();
		return count($query->result_array());
	}

}

/* End of file statistics.php */
/* Location: ./system/application/models/statistics.php */
