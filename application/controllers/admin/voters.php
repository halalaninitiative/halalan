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

class Voters extends CI_Controller {

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
	
	function index($offset = null)
	{
		$voters = $this->Boter->select_all();
		$config['base_url'] = site_url('admin/voters/index');
		$config['total_rows'] = count($voters);
		$config['per_page'] = HALALAN_PER_PAGE;
		$config['uri_segment'] = 4;
		$config['num_links'] = 5;
		$config['first_link'] = img('public/images/go-first.png');
		$config['last_link'] = img('public/images/go-last.png');
		$config['prev_link'] = img('public/images/go-previous.png');
		$config['next_link'] = img('public/images/go-next.png');
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		if ($offset == null)
		{
			$offset = 0;
		}
		$limit = $config['per_page'];
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['total_rows'] = $config['total_rows'];
		$data['voters'] = $this->Boter->select_all_for_pagination($limit, $offset);
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_voters_title');
		$admin['body'] = $this->load->view('admin/voters', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function add()
	{
		$this->_voter('add');
	}

	function edit($id)
	{
		$this->_voter('edit', $id);
	}

	function delete($id) 
	{
		if ( ! $id)
		{
			redirect('admin/voters');
		}
		$voter = $this->Boter->select($id);
		if ( ! $voter)
		{
			redirect('admin/voters');
		}
		if ($this->Boter->in_running_election($id))
		{
			$this->session->set_flashdata('messages', array('negative', e('admin_voter_in_running_election')));
		}
		else if ($this->Boter->in_use($id))
		{
			$this->session->set_flashdata('messages', array('negative', e('admin_delete_voter_already_voted')));
		}
		else
		{
			$this->Boter->delete($id);
			$this->session->set_flashdata('messages', array('positive', e('admin_delete_voter_success')));
		}
		redirect('admin/voters');
	}

	function _voter($case, $id = null)
	{
		if ($case == 'add')
		{
			$data['voter'] = array('username' => '', 'first_name' => '', 'last_name' => '', 'block_id' => '');
			$this->session->unset_userdata('voter'); // so callback rules know that the action is add
		}
		else if ($case == 'edit')
		{
			if ( ! $id)
			{
				redirect('admin/voters');
			}
			$data['voter'] = $this->Boter->select($id);
			if ( ! $data['voter'])
			{
				redirect('admin/voters');
			}
			$this->session->set_userdata('voter', $data['voter']); // used in callback rules
		}
		if ($this->settings['password_pin_generation'] == 'email')
		{
			$this->form_validation->set_rules('username', e('admin_voter_email'), 'required|valid_email|callback__rule_voter_exists|callback__rule_dependencies');
		}
		else
		{
			$this->form_validation->set_rules('username', e('admin_voter_username'), 'required|callback__rule_voter_exists|callback__rule_dependencies');
		}
		$this->form_validation->set_rules('first_name', e('admin_voter_first_name'), 'required');
		$this->form_validation->set_rules('last_name', e('admin_voter_last_name'), 'required');
		$this->form_validation->set_rules('block_id', e('admin_voter_block'), 'required|callback__rule_running_election');
		if ($this->form_validation->run())
		{
			$voter['username'] = $this->input->post('username', TRUE);
			$voter['last_name'] = $this->input->post('last_name', TRUE);
			$voter['first_name'] = $this->input->post('first_name', TRUE);
			$voter['block_id'] = $this->input->post('block_id', TRUE);
			if ($case == 'add')
			{
				$this->Boter->insert($voter);
				$this->session->set_flashdata('messages', array('positive', e('admin_add_voter_success')));
				redirect('admin/voters/add');
			}
			else if ($case == 'edit')
			{
				$this->Boter->update($voter, $id);
				$this->session->set_flashdata('messages', array('positive', e('admin_edit_voter_success')));
				redirect('admin/voters/edit/' . $id);
			}
		}
		$data['blocks'] = $this->Block->select_all();
		$data['action'] = $case;
		$data['settings'] = $this->settings;
		$admin['title'] = e('admin_' . $case . '_voter_title');
		$admin['body'] = $this->load->view('admin/voter', $data, TRUE);
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function import()
	{
		$this->form_validation->set_rules('block_id', e('admin_import_block'), 'required|callback__rule_running_election');
		$this->form_validation->set_rules('csv', e('admin_import_csv'), 'callback__rule_csv');
		if ($this->form_validation->run())
		{
			$voter['password'] = '';
			$voter['block_id'] = $this->input->post('block_id', TRUE);
			$upload_data = $this->session->userdata('csv_upload_data');
			$csv = array();
			if ($handle = fopen($upload_data['full_path'], 'r'))
			{
				while ($data = fgetcsv($handle, 1000))
				{
					$csv[] = $data;
				}
				fclose($handle);
			}
			unset($csv[0]); // remove header
			$count = 0;
			foreach ($csv as $value)
			{
				$voter['username'] = $value[0];
				$voter['last_name'] = $value[1];
				$voter['first_name'] = $value[2];
				if ($voter['username'] && $voter['last_name'] && $voter['first_name'] && ! $this->Boter->select_by_username($voter['username']))
				{
					if ($this->settings['password_pin_generation'] == 'web')
					{
						$this->Boter->insert($voter);
						$count++;
					}
					else if ($this->settings['password_pin_generation'] == 'email')
					{
						if ($this->form_validation->valid_email($voter['username']))
						{
							$this->Boter->insert($voter);
							$count++;
						}
					}
				}
			}
			if ($count == 1)
			{
				$success[] = $count . e('admin_import_success_singular');
			}
			else
			{
				$success[] = $count . e('admin_import_success_plural');
			}
			$reminder = e('admin_import_reminder');
			if ($this->settings['pin'])
			{
				$reminder = trim($reminder, '.'); // remove period
				$reminder .= e('admin_import_reminder_too');
			}
			$success[] = $reminder;
			unlink($upload_data['full_path']);
			$this->session->unset_userdata('csv_upload_data');
			$this->session->set_flashdata('messages', array_merge(array('positive'), $success));
			redirect('admin/voters/import');
		}
		if ($upload_data = $this->session->userdata('csv_upload_data'))
		{
			// delete csv file when upload is successful but other fields have problems
			unlink($upload_data['full_path']);
			$this->session->unset_userdata('csv_upload_data');
		}
		$data['blocks'] = $this->Block->select_all();
		$data['settings'] = $this->settings;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_import_title');
		$admin['body'] = $this->load->view('admin/import', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function export()
	{
		$this->form_validation->set_rules('block_id', e('admin_export_block'), 'required');
		if ($this->form_validation->run())
		{
			$header = '';
			if ($this->settings['password_pin_generation'] == 'web')
			{
				$header = 'Username';
			}
			else if ($this->settings['password_pin_generation'] == 'email')
			{
				$header = 'Email';
			}
			$header .= ',Last Name,First Name';
			if ($this->input->post('status'))
			{
				$header .= ',Voted';
			}
			$data[] = $header;
			$voters = $this->Boter->select_all_by_block_id($this->input->post('block_id', TRUE));
			foreach ($voters as $voter)
			{
				$row = $voter['username'] . ',' . $voter['last_name'] . ',' . $voter['first_name'];
				if ($this->input->post('status'))
				{
					$voted = $this->Voted->select_all_by_voter_id($voter['id']);
					$tmp = array();
					foreach ($voted as $v)
					{
						$election = $this->Election->select($v['election_id']);
						$tmp[] = $election['election'];
					}
					$row .= ',' . implode(' | ', $tmp);
				}
				$data[] = $row;
			}
			$data = implode("\r\n", $data);
			force_download('voters.csv', $data);
		}
		$data['blocks'] = $this->Block->select_all();
		$data['settings'] = $this->settings;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_export_title');
		$admin['body'] = $this->load->view('admin/export', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function _rule_voter_exists()
	{
		$username = trim($this->input->post('username', TRUE));
		if ($test = $this->Boter->select_by_username($username))
		{
			$error = FALSE;
			if ($voter = $this->session->userdata('voter')) // edit
			{
				if ($test['id'] != $voter['id'])
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
				$message = e('admin_voter_exists') . ' (' . $test['username'] . ')';
				$this->form_validation->set_message('_rule_voter_exists', $message);
				return FALSE;
			}
		}
		return TRUE;
	}

	// placed in username so it comes up on top
	function _rule_dependencies()
	{
		if ($voter = $this->session->userdata('voter')) // edit
		{
			// don't check if block_id is empty
			if ($this->input->post('block_id') == FALSE)
			{
				return TRUE;
			}
			if ($this->Boter->in_use($voter['id']))
			{
				if ($voter['block_id'] != $this->input->post('block_id'))
				{
					$this->form_validation->set_message('_rule_dependencies', e('admin_voter_dependencies'));
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	function _rule_running_election()
	{
		$block_id = $this->input->post('block_id');
		$blocks = $this->Block_Election_Position->select_all_by_block_id($block_id);
		$election_ids = array();
		foreach ($blocks as $block)
		{
			$election_ids[] = $block['election_id'];
		}
		$election_ids = array_unique($election_ids);
		if ($this->Election->is_running($election_ids))
		{
			$this->form_validation->set_message('_rule_running_election', e('admin_voter_running_election'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function _rule_csv()
	{
		$config['upload_path'] = HALALAN_UPLOAD_PATH . 'csvs/';
		$config['allowed_types'] = 'csv';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('csv'))
		{
			$message = $this->upload->display_errors('', '');
			$this->form_validation->set_message('_rule_csv', $message);
			return FALSE;
		}
		else
		{
			$upload_data = $this->upload->data();
			$this->session->set_userdata('csv_upload_data', $upload_data);
			return TRUE;
		}
	}

}

/* End of file voters.php */
/* Location: ./system/application/controllers/admin/voters.php */
