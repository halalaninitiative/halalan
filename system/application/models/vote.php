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

class Vote extends Model {

	function Vote()
	{
		parent::Model();
	}

	function insert($vote)
	{
		return $this->db->insert('votes', $vote);
	}

	function count_all_by_election_id_and_position_id($election_id, $position_id)
	{
		$this->db->select('count(votes.candidate_id) AS votes, candidates.id AS candidate_id');
		$this->db->from('votes');
		$this->db->join('candidates', 'candidates.id = votes.candidate_id', 'right');
		$this->db->where(compact('election_id', 'position_id'));
		$this->db->group_by('candidates.id');
		$this->db->order_by('votes', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_all_by_voter_id($voter_id)
	{
		$this->db->from('votes');
		$this->db->join('candidates', 'candidates.id = votes.candidate_id');
		$this->db->where(compact('voter_id'));
		$this->db->order_by('last_name', 'asc');
		$this->db->order_by('first_name', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

}

?>
