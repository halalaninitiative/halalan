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

class Block_Election_Position extends Model {

	function Block_Election_Position()
	{
		parent::Model();
	}

	function select_all_by_block_id($block_id)
	{
		$this->db->from('blocks_elections_positions');
		$this->db->where(compact('block_id'));
		$query = $this->db->get();
		return $query->result_array();
	}

}

/* End of file block_election_position.php */
/* Location: ./system/application/models/block_election_position.php */
