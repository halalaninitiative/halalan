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

class Party extends Model {

	function Party()
	{
		parent::Model();
	}

	function insert($party)
	{
		$chosen = $party['chosen'];
		unset($party['chosen']);
		$this->db->insert('parties', $party);
		if ( ! empty($chosen))
		{
			$party_id = $this->db->insert_id();
			foreach ($chosen as $election_id)
			{
				$this->db->insert('elections_parties', compact('election_id', 'party_id'));
			}
		}
		return TRUE;
	}

	function update($party, $id)
	{
		$chosen = $party['chosen'];
		unset($party['chosen']);
		$this->db->update('parties', $party, compact('id'));
		if ( ! empty($chosen))
		{
			$this->db->where('party_id', $id);
			$this->db->delete('elections_parties');
			$party_id = $id;
			foreach ($chosen as $election_id)
			{
				$this->db->insert('elections_parties', compact('election_id', 'party_id'));
			}
		}
		return TRUE;
	}

	function delete($id)
	{
		$this->db->where('party_id', $id);
		$this->db->delete('elections_parties');
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

	function select_all_by_election_id($election_id)
	{
		$this->db->from('parties');
		$this->db->join('elections_parties', 'parties.id = elections_parties.party_id');
		$this->db->where('election_id', $election_id);
		$this->db->order_by('party', 'ASC');
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

	function in_running_election($party_id)
	{
		$this->db->from('candidates');
		$this->db->where(compact('party_id'));
		$this->db->where('election_id IN (SELECT id FROM elections WHERE status = 1)');
		return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
	}

}

/* End of file party.php */
/* Location: ./system/application/models/party.php */
