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

class Blocks extends CI_Controller {

	var $admin;
	var $settings;

	function __construct()
	{
		parent::__construct();
		$this->admin = $this->session->userdata('admin');
		if ( ! $this->admin)
		{
			$this->session->set_flashdata('messages', array('negative', e('common_unauthorized')));
			redirect('gate/admin');
		}
		$this->settings = $this->config->item('halalan');
	}
	
	function index()
	{
		$election_id = get_cookie('selected_election');
		$data['election_id'] = $election_id;
		$data['elections'] = $this->Election->select_all();
		$data['blocks'] = $this->Block->select_all_by_election_id($election_id);
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_blocks_title');
		$admin['body'] = $this->load->view('admin/blocks', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function add()
	{
		$this->_block('add');
	}

	function edit($id)
	{
		$this->_block('edit', $id);
	}

	function delete($id) 
	{
		if ( ! $id)
		{
			redirect('admin/blocks');
		}
		$block = $this->Block->select($id);
		if ( ! $block)
		{
			redirect('admin/blocks');
		}
		if ($this->Block->in_running_election($id))
		{
			$this->session->set_flashdata('messages', array('negative', e('admin_block_in_running_election')));
		}
		else if ($this->Block->in_use($id))
		{
			$this->session->set_flashdata('messages', array('negative', e('admin_delete_block_in_use')));
		}
		else
		{
			$this->Block->delete($id);
			$this->session->set_flashdata('messages', array('positive', e('admin_delete_block_success')));
		}
		redirect('admin/blocks');
	}

	function _block($case, $id = null)
	{
		$selected = array();
		if ($case == 'add')
		{
			$data['block'] = array('block' => '');
			$this->session->unset_userdata('block'); // so callback rules know that the action is add
		}
		else if ($case == 'edit')
		{
			if ( ! $id)
			{
				redirect('admin/blocks');
			}
			$data['block'] = $this->Block->select($id);
			if ( ! $data['block'])
			{
				redirect('admin/blocks');
			}
			if ($this->Block->in_running_election($id))
			{
				$this->session->set_flashdata('messages', array('negative', e('admin_block_in_running_election')));
				redirect('admin/blocks');
			}
			if (empty($_POST))
			{
				$tmp = $this->Block_Election_Position->select_all_by_block_id($id);
				foreach ($tmp as $t)
				{
					$selected[] = $t['election_id'] . '|' . $t['position_id'];
				}
			}
			$this->session->set_userdata('block', $data['block']); // so callback rules know that the action is edit
		}
		$this->form_validation->set_rules('block', e('admin_block_block'), 'required|callback__rule_block_exists|callback__rule_dependencies');
		$this->form_validation->set_rules('elections_positions[]', e('admin_block_elections_positions'), 'required|callback__rule_running_election');
		if ($this->form_validation->run())
		{
			$block['block'] = $this->input->post('block', TRUE);
			$elections_positions = $this->input->post('elections_positions', TRUE);
			$extra = array();
			foreach ($elections_positions as $election_position)
			{
				list($election_id, $position_id) = explode('|', $election_position);
				$extra[] = array('election_id' => $election_id, 'position_id' => $position_id);
			}
			$block['extra'] = $extra;
			if ($case == 'add')
			{
				$this->Block->insert($block);
				$this->session->set_flashdata('messages', array('positive', e('admin_add_block_success')));
				redirect('admin/blocks/add');
			}
			else if ($case == 'edit')
			{
				$this->Block->update($block, $id);
				$this->session->set_flashdata('messages', array('positive', e('admin_edit_block_success')));
				redirect('admin/blocks/edit/' . $id);
			}
		}
		if ($this->input->post('elections_positions'))
		{
			$selected = $this->input->post('elections_positions');
		}
		$elections = $this->Election->select_all();
		$elections_positions = array();
		foreach ($elections as $election)
		{
			$tmp = array();
			$positions = $this->Position->select_all_by_election_id($election['id']);
			foreach ($positions as $position)
			{
				$tmp[$election['id'] . '|' . $position['id']] = $position['position'];
			}
			// exclude elections with no positions since it is not supported by form_dropdown / form_multiselect
			if ( ! empty($tmp))
			{
				$elections_positions[$election['election']] = $tmp;
			}
		}
		$data['elections_positions'] = $elections_positions;
		$data['selected'] = $selected;
		$data['action'] = $case;
		$admin['title'] = e('admin_' . $case . '_block_title');
		$admin['body'] = $this->load->view('admin/block', $data, TRUE);
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	// a block cannot be added to a running election
	function _rule_running_election()
	{
		$elections_positions = $this->input->post('elections_positions');
		$election_ids = array();
		foreach ($elections_positions as $election_position)
		{
			list($election_id, $position_id) = explode('|', $election_position);
			$election_ids[] = $election_id;
		}
		if ($this->Election->is_running($election_ids))
		{
			$this->form_validation->set_message('_rule_running_election', e('admin_block_running_election'));
			return FALSE;
		}
		return TRUE;
	}

	// blocks must have different names
	function _rule_block_exists()
	{
		$block = trim($this->input->post('block', TRUE));
		$test = $this->Block->select_by_block($block);
		if ( ! empty($test))
		{
			$error = FALSE;
			if ($block = $this->session->userdata('block')) // check when in edit mode
			{
				if ($test['id'] != $block['id'])
				{
					$error = TRUE;
				}
			}
			else
			{
				$error = TRUE;
			}
			if ($error)
			{
				$message = e('admin_block_exists') . ' (' . $test['block'] . ')';
				$this->form_validation->set_message('_rule_block_exists', $message);
				return FALSE;
			}
		}
		return TRUE;
	}

	// a block cannot change election when it already has voters under it
	function _rule_dependencies()
	{
		if ($block = $this->session->userdata('block')) // check when in edit mode
		{
			// don't check if no elections or positions are selected since we already have a rule for them
			if ( ! $this->input->post('elections_positions'))
			{
				return TRUE;
			}
			// don't check if elections and positions do not change
			$tmp = $this->Block_Election_Position->select_all_by_block_id($block['id']);
			foreach ($tmp as $t)
			{
				$selected[] = $t['election_id'] . '|' . $t['position_id'];
			}
			$array_diff = array_diff($selected, $this->input->post('elections_positions'));
			if (empty($array_diff))
			{
				return TRUE;
			}
			if ($this->Block->in_use($block['id']))
			{
				$this->form_validation->set_message('_rule_dependencies', e('admin_block_dependencies'));
				return FALSE;
			}
		}
		return TRUE;
	}

}

/* End of file blocks.php */
/* Location: ./system/application/controllers/admin/blocks.php */
