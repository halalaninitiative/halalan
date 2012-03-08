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

class Vote extends Model {

	function Vote()
	{
		parent::Model();
	}

	function insert($vote)
	{
		return $this->db->insert('votes', $vote);
	}

	function breakdown($election_id, $candidate_id)
	{
		$this->db->select('block, COUNT(distinct votes.voter_id) AS count');
		$this->db->from('blocks');
		$this->db->join('blocks_elections_positions', 'blocks_elections_positions.block_id = blocks.id AND blocks_elections_positions.election_id = ' . $election_id);
		$this->db->join('voters', 'voters.block_id = blocks_elections_positions.block_id', 'left');
		$this->db->join('votes', 'votes.voter_id = voters.id AND votes.candidate_id = ' . $candidate_id, 'left');
		$this->db->group_by('block');
		$this->db->order_by('block', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function count_all_by_election_id_and_position_id($election_id, $position_id)
	{
		$this->db->select('count(votes.candidate_id) AS votes, candidates.id AS candidate_id');
		$this->db->from('votes');
		$this->db->join('candidates', 'candidates.id = votes.candidate_id', 'right');
		$this->db->where(compact('election_id', 'position_id'));
		$this->db->group_by('candidates.id');
		$this->db->order_by('votes', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function select_all_by_voter_id($voter_id)
	{
		$this->db->from('votes');
		$this->db->join('candidates', 'candidates.id = votes.candidate_id');
		$this->db->where(compact('voter_id'));
		$this->db->order_by('last_name', 'ASC');
		$this->db->order_by('first_name', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

}

/* End of file vote.php */
/* Location: ./system/application/models/vote.php */
