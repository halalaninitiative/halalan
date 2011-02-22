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

class Abstain extends Model {

	function Abstain()
	{
		parent::Model();
	}

	function insert($abstain)
	{
		return $this->db->insert('abstains', $abstain);
	}

	function count_all_by_election_id_and_position_id($election_id, $position_id)
	{
		$this->db->from('abstains');
		$this->db->where(compact('election_id', 'position_id'));
		return $this->db->count_all_results();
	}

}

?>
