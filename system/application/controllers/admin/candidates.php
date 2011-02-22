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

class Candidates extends Controller {

	var $admin;
	var $settings;

	function Candidates()
	{
		parent::Controller();
		$this->admin = $this->session->userdata('admin');
		if (!$this->admin)
		{
			$this->session->set_flashdata('messages', array('negative', e('common_unauthorized')));
			redirect('gate/admin');
		}
		$this->settings = $this->config->item('halalan');
	}
	
	function index($election_id = 0, $position_id = 0)
	{
		$this->load->helper('cookie');
		$elections = $this->Election->select_all_with_positions();
		// If only one election exists, show it by default.
		if (count($elections) == 1)
		{
			$election_id = $elections[0]['id'];
		}
		else if (get_cookie('selected_election'))
		{
			$election_id = get_cookie('selected_election');
		}
		$tmp = array();
		foreach ($elections as $election)
		{
			$tmp[$election['id']] = $election['election'];
		}
		$elections = $tmp;
		$pos = $this->Position->select_all_by_election_id($election_id);
		$tmp = array();
		foreach ($pos as $p)
		{
			$tmp[$p['id']] = $p['position'];
		}
		$pos = $tmp;
		$positions = $this->Position->select_all_by_election_id($election_id);
		foreach ($positions as $key=>$value)
		{
			$positions[$key]['candidates'] = $this->Candidate->select_all_by_election_id_and_position_id($election_id, $value['id']);
			if ($position_id > 0 && $value['id'] == $position_id)
			{
				$tmp = $positions[$key];
				// clear data since only one position will be displayed
				$positions = array();
				$positions[] = $tmp; 
				break;
			}
		}
		$data['election_id'] = $election_id;
		$data['position_id'] = $position_id;
		$data['elections'] = $elections;
		$data['pos'] = $pos;
		$data['positions'] = $positions;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_candidates_title');
		$admin['body'] = $this->load->view('admin/candidates', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function add()
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			$election_id = $this->input->post('election_id');
			echo json_encode($this->Position->select_all_by_election_id($election_id));
		}
		else
		{
			$this->_candidate('add');
		}
	}

	function edit($id)
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			$election_id = $this->input->post('election_id');
			echo json_encode($this->Position->select_all_by_election_id($election_id));
		}
		else
		{
			$this->_candidate('edit', $id);
		}
	}

	function delete($id) 
	{
		if (!$id)
			redirect('admin/candidates');
		if ($this->Candidate->in_running_election($id))
		{
			$this->session->set_flashdata('messages', array('negative', e('admin_candidate_in_running_election')));
		}
		else if ($this->Candidate->in_use($id))
		{
			$this->session->set_flashdata('messages', array('negative', e('admin_delete_candidate_already_has_votes')));
		}
		else
		{
			$this->Candidate->delete($id);
			$this->session->set_flashdata('messages', array('positive', e('admin_delete_candidate_success')));
		}
		redirect('admin/candidates');
	}

	function _candidate($case, $id = null)
	{
		$election_id = 0;
		if ($case == 'add')
		{
			$data['candidate'] = array('first_name'=>'', 'last_name'=>'', 'alias'=>'', 'description'=>'', 'party_id'=>'', 'election_id'=>'', 'position_id'=>'');
			$this->session->unset_userdata('candidate'); // so callback rules know that the action is add
		}
		else if ($case == 'edit')
		{
			if (!$id)
				redirect('admin/candidates');
			$data['candidate'] = $this->Candidate->select($id);
			if (!$data['candidate'])
				redirect('admin/candidates');
			if ($this->Candidate->in_running_election($id))
			{
				$this->session->set_flashdata('messages', array('negative', e('admin_candidate_in_running_election')));
				redirect('admin/candidates');
			}
			if (empty($_POST))
			{
				$election_id = $data['candidate']['election_id'];
			}
			$this->session->set_userdata('candidate', $data['candidate']); // used in callback rules
		}
		$this->form_validation->set_rules('first_name', e('admin_candidate_first_name'), 'required|callback__rule_dependencies');
		$this->form_validation->set_rules('last_name', e('admin_candidate_last_name'), 'required|callback__rule_candidate_exists');
		$this->form_validation->set_rules('alias', e('admin_candidate_alias'));
		$this->form_validation->set_rules('description', e('admin_candidate_description'));
		$this->form_validation->set_rules('party_id', e('admin_candidate_party'));
		$this->form_validation->set_rules('election_id', e('admin_candidate_election'), 'required|callback__rule_running_election');
		$this->form_validation->set_rules('position_id', e('admin_candidate_position'), 'required');
		$this->form_validation->set_rules('picture', e('admin_candidate_picture'), 'callback__rule_picture');
		if ($this->form_validation->run())
		{
			$candidate['first_name'] = $this->input->post('first_name', TRUE);
			$candidate['last_name'] = $this->input->post('last_name', TRUE);
			$candidate['alias'] = $this->input->post('alias', TRUE);
			$candidate['description'] = $this->input->post('description', TRUE);
			$candidate['party_id'] = $this->input->post('party_id', TRUE);
			$candidate['election_id'] = $this->input->post('election_id', TRUE);
			$candidate['position_id'] = $this->input->post('position_id', TRUE);
			if ($picture = $this->session->userdata('candidate_picture'))
			{
				$candidate['picture'] = $picture;
				$this->session->unset_userdata('candidate_picture');
			}
			if ($case == 'add')
			{
				$this->Candidate->insert($candidate);
				$this->session->set_flashdata('messages', array('positive', e('admin_add_candidate_success')));
				redirect('admin/candidates/add');
			}
			else if ($case == 'edit')
			{
				$this->Candidate->update($candidate, $id);
				$this->session->set_flashdata('messages', array('positive', e('admin_edit_candidate_success')));
				redirect('admin/candidates/edit/' . $id);
			}
		}
		if ($this->input->post('election_id'))
		{
			$election_id = $this->input->post('election_id');
		}
		$data['elections'] = $this->Election->select_all_with_positions();
		$data['positions'] = array();
		if ($election_id > 0)
		{
			$data['positions'] = $this->Position->select_all_by_election_id($election_id);
		}
		$data['parties'] = $this->Party->select_all();
		$data['action'] = $case;
		$admin['title'] = e('admin_' . $case . '_candidate_title');
		$admin['body'] = $this->load->view('admin/candidate', $data, TRUE);
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function _rule_candidate_exists()
	{
		$first_name = trim($this->input->post('first_name', TRUE));
		$last_name = trim($this->input->post('last_name', TRUE));
		$alias = trim($this->input->post('alias', TRUE));
		if ($test = $this->Candidate->select_by_name_and_alias($first_name, $last_name, $alias))
		{
			$error = FALSE;
			if ($candidate = $this->session->userdata('candidate')) // edit
			{
				if ($test['id'] != $candidate['id'])
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
				$name = $test['last_name'] . ', ' . $test['first_name'];
				if (!empty($test['alias']))
				{
					$name .= ' "' . $test['alias'] . '"';
				}
				$message = e('admin_candidate_exists') . ' (' . $name . ')';
				$this->form_validation->set_message('_rule_candidate_exists', $message);
				return FALSE;
			}
		}
		return TRUE;
	}

	function _rule_picture()
	{
		if ($_FILES['picture']['error'] != UPLOAD_ERR_NO_FILE)
		{
			$config['upload_path'] = HALALAN_UPLOAD_PATH . 'pictures/';
			$config['allowed_types'] = HALALAN_ALLOWED_TYPES;
			$this->upload->initialize($config);
			if ($candidate = $this->session->userdata('candidate')) // edit
			{
				// delete old logo first
				unlink($config['upload_path'] . $candidate['picture']);
			}
			if (!$this->upload->do_upload('picture'))
			{
				$message = $this->upload->display_errors('', '');
				$this->form_validation->set_message('_rule_picture', $message);
				return FALSE;
			}
			else
			{
				$upload_data = $this->upload->data();
				$return = $this->_resize($upload_data, 96);
				if (is_array($return))
				{
					$this->form_validation->set_message('_rule_picture', $return[0]);
					return FALSE;
				}
				else
				{
					// flashdata doesn't work I don't know why
					$this->session->set_userdata('candidate_picture', $return);
					return TRUE;
				}
			}
		}
		else
		{
			return TRUE;
		}
	}

	function _resize($upload_data, $n)
	{
		$width = $upload_data['image_width'];
		$height = $upload_data['image_height'];
		if ($width > $n || $height > $n)
		{
			$config['source_image'] = $upload_data['full_path'];
			$config['quality'] = '100%';
			$config['width'] = $n;
			$config['height'] = (($n*$height)/$width);
			$this->image_lib->initialize($config);
			if (!$this->image_lib->resize())
			{
				$error[] = $this->image_lib->display_errors();
			}
			else
			{
				$name = $upload_data['file_name'];
			}
		}
		else
		{
			$name = $upload_data['file_name'];
		}
		if (empty($error))
		{
			return $name;
		}
		else
		{
			return $error;
		}
	}

	// placed in first name so it comes up on top
	function _rule_dependencies()
	{
		if ($candidate = $this->session->userdata('candidate')) // edit
		{
			// don't check if election_id or position_id is empty
			if ($this->input->post('election_id') == FALSE || $this->input->post('position_id') == FALSE)
			{
				return TRUE;
			}
			if ($this->Candidate->in_use($candidate['id']))
			{
				if ($candidate['election_id'] != $this->input->post('election_id') || $candidate['position_id'] != $this->input->post('position_id'))
				{
					$this->form_validation->set_message('_rule_dependencies', e('admin_candidate_dependencies'));
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	function _rule_running_election()
	{
		if ($this->Election->is_running(array($this->input->post('election_id'))))
		{
			$this->form_validation->set_message('_rule_running_election', e('admin_candidate_running_election'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

}

/* End of file candidates.php */
/* Location: ./system/application/controllers/admin/candidates.php */
