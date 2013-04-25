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

class Positions extends CI_Controller {

	private $admin;
	private $settings;

	public function __construct()
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
	
	public function index()
	{
		$election_id = get_cookie('selected_election');
		$data['election_id'] = $election_id;
		$data['elections'] = $this->Election->select_all();
		$data['positions'] = $this->Position->select_all_by_election_id($election_id);
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_positions_title');
		$admin['body'] = $this->load->view('admin/positions', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	public function add()
	{
		$this->_position('add');
	}

	public function edit($id)
	{
		$this->_position('edit', $id);
	}

	public function delete($id) 
	{
		if ( ! $id)
		{
			redirect('admin/positions');
		}
		$position = $this->Position->select($id);
		if ( ! $position)
		{
			redirect('admin/positions');
		}
		if ($this->Position->in_running_election($id))
		{
			$this->session->set_flashdata('messages', array('negative', e('admin_position_in_running_election')));
		}
		else if ($this->Position->in_use($id))
		{
			$this->session->set_flashdata('messages', array('negative', e('admin_delete_position_in_use')));
		}
		else
		{
			$this->Position->delete($id);
			$this->session->set_flashdata('messages', array('positive', e('admin_delete_position_success')));
		}
		redirect('admin/positions');
	}

	public function _position($case, $id = null)
	{
		if ($case == 'add')
		{
			$data['position'] = array('election_id' => get_cookie('selected_election'), 'position' => '', 'description' => '', 'maximum' => '', 'ordinality' => '', 'abstain' => '1');
			$this->session->unset_userdata('position'); // so callback rules know that the action is add
		}
		else if ($case == 'edit')
		{
			if ( ! $id)
			{
				redirect('admin/positions');
			}
			$data['position'] = $this->Position->select($id);
			if ( ! $data['position'])
			{
				redirect('admin/positions');
			}
			if ($this->Position->in_running_election($id))
			{
				$this->session->set_flashdata('messages', array('negative', e('admin_position_in_running_election')));
				redirect('admin/positions');
			}
			$this->session->set_userdata('position', $data['position']); // used in callback rules
		}
		if ($this->input->post('election_id'))
		{
			// set cookie again since the election might have changed
			set_cookie('selected_election', $this->input->post('election_id'), 0);
		}
		$this->form_validation->set_rules('election_id', e('admin_position_election'), 'required|callback__rule_running_election');
		$this->form_validation->set_rules('position', e('admin_position_position'), 'required|callback__rule_position_exists|callback__rule_dependencies');
		$this->form_validation->set_rules('description', e('admin_position_description'));
		$this->form_validation->set_rules('maximum', e('admin_position_maximum'), 'required|is_natural_no_zero');
		$this->form_validation->set_rules('ordinality', e('admin_position_ordinality'), 'required|is_natural_no_zero');
		$this->form_validation->set_rules('abstain', e('admin_position_abstain'));
		if ($this->form_validation->run())
		{
			$position['election_id'] = $this->input->post('election_id', TRUE);
			$position['position'] = $this->input->post('position', TRUE);
			$position['description'] = $this->input->post('description', TRUE);
			$position['maximum'] = $this->input->post('maximum', TRUE);
			$position['ordinality'] = $this->input->post('ordinality', TRUE);
			$position['abstain'] = $this->input->post('abstain', TRUE);
			if ($case == 'add')
			{
				$this->Position->insert($position);
				$this->session->set_flashdata('messages', array('positive', e('admin_add_position_success')));
				redirect('admin/positions/add');
			}
			else if ($case == 'edit')
			{
				$this->Position->update($position, $id);
				$this->session->set_flashdata('messages', array('positive', e('admin_edit_position_success')));
				redirect('admin/positions/edit/' . $id);
			}
		}
		$data['elections'] = $this->Election->select_all();
		$data['action'] = $case;
		$admin['title'] = e('admin_' . $case . '_position_title');
		$admin['body'] = $this->load->view('admin/position', $data, TRUE);
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	public function _rule_position_exists()
	{
		$election_id = $this->input->post('election_id');
		$position = trim($this->input->post('position', TRUE));
		if ($test = $this->Position->select_by_election_id_and_position($election_id, $position))
		{
			$error = FALSE;
			if ($position = $this->session->userdata('position')) // edit
			{
				if ($test['id'] != $position['id'])
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
				$message = e('admin_position_exists') . ' (' . $test['position'] . ')';
				$this->form_validation->set_message('_rule_position_exists', $message);
				return FALSE;
			}
		}
		return TRUE;
	}

	// placed in position so it comes up on top
	public function _rule_dependencies()
	{
		if ($position = $this->session->userdata('position')) // edit
		{
			// don't check if chosen is empty
			if ($this->input->post('chosen') == FALSE)
			{
				return TRUE;
			}
			if ($this->Position->in_use($position['id']))
			{
				if ($position['election_id'] != $this->input->post('election_id'))
				{
					$this->form_validation->set_message('_rule_dependencies', e('admin_position_dependencies'));
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	public function _rule_running_election()
	{
		if ($this->Election->is_running($this->input->post('election_id')))
		{
			$this->form_validation->set_message('_rule_running_election', e('admin_position_running_election'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

}

/* End of file positions.php */
/* Location: ./system/application/controllers/admin/positions.php */
