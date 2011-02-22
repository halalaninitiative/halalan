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

class Statistics extends Model {

	function Statistics()
	{
		parent::Model();
	}

	function count_all_voters($election_id)
	{
		$this->db->distinct();
		$this->db->select('id');
		$this->db->from('voters');
		$this->db->join('elections_positions_voters', 'elections_positions_voters.voter_id = voters.id');
		$this->db->where('election_id', $election_id);
		$query = $this->db->get();
		return count($query->result_array());
	}

	function count_all_voted($election_id)
	{
		$this->db->from('voters');
		$this->db->join('voted', 'voted.voter_id = voters.id');
		$this->db->where('election_id', $election_id);
		return $this->db->count_all_results();
	}

	function count_all_by_duration($election_id, $begin, $end)
	{
		$this->db->distinct();
		$this->db->select('id');
		$this->db->from('voters');
		$this->db->join('elections_positions_voters', 'elections_positions_voters.voter_id = voters.id');
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

?>
