<?php

class Admin extends Controller {

	var $admin;
	var $settings;

	function Admin()
	{
		parent::Controller();
		$this->admin = $this->session->userdata('admin');
		if (!$this->admin)
		{
			$error[] = e('common_unauthorized');
			$this->session->set_flashdata('error', $error);
			redirect('gate/admin');
		}
		$this->settings = $this->config->item('halalan');
		$this->load->model('Option');
		$option = $this->Option->select(1);
		if ($option['status'] && $this->uri->segment(2) != 'home' && $this->uri->segment(2) != 'do_edit_option' && $this->uri->segment(2) != 'index' && $this->uri->segment(2) != 'do_regenerate')
		{
			$error[] = e('admin_common_running_one');
			$error[] = e('admin_common_running_two');
			$this->session->set_flashdata('error', $error);
			redirect('admin/home');
		}
	}

	function index()
	{
		redirect('admin/home');
	}

	function home()
	{
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
		$this->load->model('Option');
		$data['option'] = $this->Option->select(1);
		$data['settings'] = $this->settings;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_home_title');
		$admin['body'] = $this->load->view('admin/home', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function do_edit_option($id)
	{
		if (!$id)
			redirect('admin/home');
		$this->load->model('Option');
		$option = $this->Option->select($id);
		if (!$option)
			redirect('admin/home');
		$option['status'] = $this->input->post('status', TRUE);
		$option['result'] = $this->input->post('result', TRUE);
		$this->load->model('Option');
		$this->Option->update($option, $id);
		$success[] = e('admin_edit_option_success');
		$this->session->set_flashdata('success', $success);
		redirect('admin/home');
	}

	function do_regenerate()
	{
		$this->load->model('Boter');
		$error = array();
		if (!$this->input->post('username'))
		{
			if ($this->settings['password_pin_generation'] == 'web')
				$error[] = e('admin_regenerate_no_username');
			else if ($this->settings['password_pin_generation'] == 'email')
				$error[] = e('admin_regenerate_no_email');
		}
		else
		{
			if (!$voter = $this->Boter->select_by_username($this->input->post('username')))
			{
				$error[] = e('admin_regenerate_not_exists');
			}
		}
		if ($this->settings['password_pin_generation'] == 'email')
		{
			if (!$this->_valid_email($this->input->post('username')))
			{
				$error[] = e('admin_regenerate_invalid_email');
			}
		}
		if (empty($error))
		{
			$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
			$voter['password'] = sha1($password);
			if ($this->settings['pin'])
			{
				if ($this->input->post('pin'))
				{
					$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
					$voter['pin'] = sha1($pin);
				}
			}
			$this->Boter->update($voter, $voter['id']);
			$success = array();
			$success[] = e('admin_regenerate_success');
			if ($this->settings['password_pin_generation'] == 'web')
			{
				$success[] = 'Username: '. $voter['username'];
				$success[] = 'Password: '. $password;
				if ($this->settings['pin'])
				{
					if ($this->input->post('pin'))
						$success[] = 'PIN: '. $pin;
				}
			}
			else if ($this->settings['password_pin_generation'] == 'email')
			{
				$this->email->from($this->admin['email'], $this->admin['first_name'] . ' ' . $this->admin['last_name']);
				$this->email->to($voter['username']);
				$this->email->subject($this->settings['name'] . ' Login Credentials');
				$message = "Hello $voter[first_name] $voter[last_name],\n\nThe following are your login credentials:\nEmail: $voter[username]\n";
				$message .= "Password: $password\n";
				if ($this->settings['pin'])
				{
					if ($this->input->post('pin'))
						$message .= "PIN: $pin\n";
				}
				$message .= "\n";
				$message .= ($this->admin['first_name'] . ' ' . $this->admin['last_name']);
				$message .= "\n";
				$message .= $this->settings['name'] . ' Administrator';
				$this->email->message($message);
				$this->email->send();
				//echo $this->email->print_debugger();
				$success[] = e('admin_regenerate_email_success');
			}
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('error', $error);
		}
		redirect('admin/home');
	}

	function voters($offset = null)
	{
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
		$this->load->model('Boter');
		$voters = $this->Boter->select_all();
		$config['base_url'] = site_url('admin/voters');
		$config['total_rows'] = count($voters);
		$config['per_page'] = $this->config->item('per_page');
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

	function parties()
	{
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
		$this->load->model('Party');
		$data['parties'] = $this->Party->select_all();
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_parties_title');
		$admin['body'] = $this->load->view('admin/parties', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function positions()
	{
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
		$this->load->model('Position');
		$data['positions'] = $this->Position->select_all();
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_positions_title');
		$admin['body'] = $this->load->view('admin/positions', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function candidates()
	{
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
		$this->load->model('Candidate');
		$this->load->model('Position');
		$positions = $this->Position->select_all();
		foreach ($positions as $key=>$value)
		{
			$positions[$key]['candidates'] = $this->Candidate->select_all_by_position_id($value['id']);
		}
		$data['positions'] = $positions;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_candidates_title');
		$admin['body'] = $this->load->view('admin/candidates', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function delete($type, $id) 
	{
		$data['username'] = $this->admin['username'];
		switch ($type)
		{
			case 'voter':
				if (!$id)
					redirect('admin/voters');
				$this->load->model('Boter');
				$voter = $this->Boter->select($id);
				if (!$voter)
					redirect('admin/voters');
				if ($voter['voted'] == 1)
				{
					$this->session->set_flashdata('error', array(e('admin_delete_voter_already_voted')));
				}
				else
				{
					$this->Boter->delete($id);
					$this->session->set_flashdata('success', array(e('admin_delete_voter_success')));
				}
				redirect('admin/voters');
				break;
			case 'party':
				if (!$id)
					redirect('admin/parties');
				$this->load->model('Party');
				if ($this->Party->in_use($id))
				{
					$this->session->set_flashdata('error', array(e('admin_delete_party_in_use')));
				}
				else
				{
					$this->Party->delete($id);
					$this->session->set_flashdata('success', array(e('admin_delete_party_success')));
				}
				redirect('admin/parties');
				break;
			case 'position':
				if (!$id)
					redirect('admin/positions');
				$this->load->model('Position');
				if ($this->Position->in_use($id))
				{
					$this->session->set_flashdata('error', array(e('admin_delete_position_in_use')));
				}
				else
				{
					$this->Position->delete($id);
					$this->session->set_flashdata('success', array(e('admin_delete_position_success')));
				}
				redirect('admin/positions');
				break;
			case 'candidate':
				if (!$id)
					redirect('admin/candidates');
				$this->load->model('Candidate');
				if ($this->Candidate->has_votes($id))
				{
					$this->session->set_flashdata('error', array(e('admin_delete_candidate_already_has_votes')));
				}
				else
				{
					$this->Candidate->delete($id);
					$this->session->set_flashdata('success', array(e('admin_delete_candidate_success')));
				}
				redirect('admin/candidates');
				break;
			default:
				redirect('admin/home');
		}
		$this->load->view('main', $main);
	}

	function add($type)
	{
		switch ($type)
		{
			case 'candidate':
				$admin = $this->_candidate('add');
				break;
			case 'party':
				$admin = $this->_party('add');
				break;
			case 'position':
				$admin = $this->_position('add');
				break;
			case 'voter':
				$admin = $this->_voter('add');
				break;
			default:
				redirect('admin/home');
		}
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function do_add($case = null)
	{
		switch ($case)
		{
			case 'candidate':
				$this->_do_candidate('add');
				break;
			case 'party':
				$this->_do_party('add');
				break;
			case 'position':
				$this->_do_position('add');
				break;
			case 'voter':
				$this->_do_voter('add');
				break;
			default:
				redirect('admin/home');
		}
	}

	function edit($type, $id)
	{
		switch ($type)
		{
			case 'candidate':
				$admin = $this->_candidate('edit', $id);
				break;
			case 'party':
				$admin = $this->_party('edit', $id);
				break;
			case 'position':
				$admin = $this->_position('edit', $id);
				break;
			case 'voter':
				$admin = $this->_voter('edit', $id);
				break;
			default:
				redirect('admin/home');
		}
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function do_edit($case = null, $id = null)
	{
		switch ($case)
		{
			case 'candidate':
				$this->_do_candidate('edit', $id);
				break;
			case 'party':
				$this->_do_party('edit', $id);
				break;
			case 'position':
				$this->_do_position('edit', $id);
				break;
			case 'voter':
				$this->_do_voter('edit', $id);
				break;
			default:
				redirect('admin/home');
		}
	}

	function _candidate($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			if ($case == 'add')
			{
				$data['candidate'] = array('first_name'=>'', 'last_name'=>'', 'alias'=>'', 'description'=>'', 'party_id'=>'0', 'position_id'=>'0');
			}
			else if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/candidates');
				$this->load->model('Candidate');
				$data['candidate'] = $this->Candidate->select($id);
				if (!$data['candidate'])
					redirect('admin/candidates');
			}
			$messages = $this->_get_messages();
			$data['messages'] = $messages['messages'];
			$data['message_type'] = $messages['message_type'];
			$this->load->model('Party');
			$parties = $this->Party->select_all();
			$tmp = array('0'=>'Select Party');
			foreach ($parties as $party)
			{
				$tmp[$party['id']] = $party['party'];
			}
			$data['parties'] = $tmp;
			$this->load->model('Position');
			$positions = $this->Position->select_all();
			$tmp = array('0'=>'Select Position');
			foreach ($positions as $position)
			{
				$tmp[$position['id']] = $position['position'];
			}
			$data['positions'] = $tmp;
			if ($candidate = $this->session->flashdata('candidate'))
			{
				$data['candidate'] = $candidate;
			}	
			$data['action'] = $case;
			$admin['title'] = e('admin_' . $case . '_candidate_title');
			$admin['body'] = $this->load->view('admin/candidate', $data, TRUE);
			return $admin;
		}
		else
		{
			redirect('admin/candidates');
		}
	}

	function _do_candidate($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			$this->load->model('Candidate');
			if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/candidates');
				$candidate = $this->Candidate->select($id);
				if (!$candidate)
					redirect('admin/candidates');
			}
			$error = array();
			$candidate['first_name'] = $this->input->post('first_name', TRUE);
			$candidate['last_name'] = $this->input->post('last_name', TRUE);
			$candidate['alias'] = $this->input->post('alias', TRUE);
			$candidate['description'] = $this->input->post('description', TRUE);
			$candidate['party_id'] = $this->input->post('party_id', TRUE);
			$candidate['position_id'] = $this->input->post('position_id', TRUE);
			if (!$candidate['first_name'])
			{
				$error[] = e('admin_candidate_no_first_name');
			}
			if (!$candidate['last_name'])
			{
				$error[] = e('admin_candidate_no_last_name');
			}
			if (!$candidate['position_id'])
			{
				$error[] = e('admin_candidate_no_position');
			}
			if ($candidate['first_name'] && $candidate['last_name'])
			{
				if ($test = $this->Candidate->select_by_name_and_alias($candidate['first_name'], $candidate['last_name'], $candidate['alias']))
				{
					if ($case == 'add')
					{
						$name = $test['last_name'] . ', ' . $test['first_name'];
						if (!empty($test['alias']))
							$name .= ' "' . $test['alias'] . '"';
						$error[] = e('admin_candidate_exists') . ' (' . $name . ')';
					}
					else if ($case == 'edit')
					{
						if ($test['id'] != $id)
						{
							$name = $test['last_name'] . ', ' . $test['first_name'];
							if (!empty($test['alias']))
								$name .= ' "' . $test['alias'] . '"';
							$error[] = e('admin_candidate_exists') . ' (' . $name . ')';
						}
					}
				}
			}
			if ($_FILES['picture']['error'] != UPLOAD_ERR_NO_FILE)
			{
				$config['upload_path'] = $this->config->item('upload_path') . 'pictures/';
				$config['allowed_types'] = $this->config->item('allowed_types');
				$this->upload->initialize($config);
				if ($case == 'edit')
				{
					// delete old picture first
					unlink($config['upload_path'] . $candidate['picture']);
				}
				if (!$this->upload->do_upload('picture'))
				{
					$error[] = $this->upload->display_errors();
				}
				else
				{
					$upload_data = $this->upload->data();
					$return = $this->_resize($upload_data, 96);
					if (is_array($return))
						$error = array_merge($error, $return);
					else
						$candidate['picture'] = $return;
				}
			}
			if (empty($error))
			{
				if ($case == 'add')
				{
					$this->Candidate->insert($candidate);
					$success[] = e('admin_add_candidate_success');
				}
				else if ($case == 'edit')
				{
					$this->Candidate->update($candidate, $id);
					$success[] = e('admin_edit_candidate_success');
				}
				$this->session->set_flashdata('success', $success);
			}
			else
			{
				$this->session->set_flashdata('candidate', $candidate);
				$this->session->set_flashdata('error', $error);
			}
			if ($case == 'add')
			{
				redirect('admin/add/candidate');
			}
			else if ($case == 'edit')
			{
				redirect('admin/edit/candidate/' . $id);
			}
		}
		else
		{
			redirect('admin/candidates');
		}
	}

	function _party($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			if ($case == 'add')
			{
				$data['party'] = array('party'=>'', 'alias'=>'', 'description'=>'');
			}
			else if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/parties');
				$this->load->model('Party');
				$data['party'] = $this->Party->select($id);
				if (!$data['party'])
					redirect('admin/parties');
			}
			$messages = $this->_get_messages();
			$data['messages'] = $messages['messages'];
			$data['message_type'] = $messages['message_type'];
			if ($party = $this->session->flashdata('party'))
			{
				$data['party'] = $party;
			}
			$data['action'] = $case;
			$admin['title'] = e('admin_' . $case . '_party_title');
			$admin['body'] = $this->load->view('admin/party', $data, TRUE);
			return $admin;
		}
		else
		{
			redirect('admin/parties');
		}
	}

	function _do_party($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			$this->load->model('Party');
			if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/parties');
				$party = $this->Party->select($id);
				if (!$party)
					redirect('admin/parties');
			}
			$error = array();
			$party['party'] = $this->input->post('party', TRUE);
			$party['alias'] = $this->input->post('alias', TRUE);
			$party['description'] = $this->input->post('description', TRUE);
			if (!$party['party'])
			{
				$error[] = e('admin_party_no_party');
			}
			else
			{
				if ($test = $this->Party->select_by_party($party['party']))
				{
					if ($case == 'add')
					{
						$error[] = e('admin_party_exists') . ' (' . $test['party'] . ')';
					}
					else if ($case == 'edit')
					{
						if ($test['id'] != $id)
						{
							$error[] = e('admin_party_exists') . ' (' . $test['party'] . ')';
						}
					}
				}
			}
			if ($_FILES['logo']['error'] != UPLOAD_ERR_NO_FILE)
			{
				$config['upload_path'] = $this->config->item('upload_path') . 'logos/';
				$config['allowed_types'] = $this->config->item('allowed_types');
				$this->upload->initialize($config);
				if ($case == 'edit')
				{
					// delete old logo first
					unlink($config['upload_path'] . $party['logo']);
				}
				if (!$this->upload->do_upload('logo'))
				{
					$error[] = $this->upload->display_errors();
				}
				else
				{
					$upload_data = $this->upload->data();
					$return = $this->_resize($upload_data, 250);
					if (is_array($return))
						$error = array_merge($error, $return);
					else
						$party['logo'] = $return;
				}
			}
			if (empty($error))
			{
				if ($case == 'add')
				{
					$this->Party->insert($party);
					$success[] = e('admin_add_party_success');
				}
				else if ($case == 'edit')
				{
					$this->Party->update($party, $id);
					$success[] = e('admin_edit_party_success');
				}
				$this->session->set_flashdata('success', $success);
			}
			else
			{
				$this->session->set_flashdata('party', $party);
				$this->session->set_flashdata('error', $error);
			}
			if ($case == 'add')
			{
				redirect('admin/add/party');
			}
			else if ($case == 'edit')
			{
				redirect('admin/edit/party/' . $id);
			}
		}
		else
		{
			redirect('admin/parties');
		}
	}

	function _position($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			if ($case == 'add')
			{
				$data['position'] = array('position'=>'', 'description'=>'', 'maximum'=>'', 'ordinality'=>'', 'abstain'=>1, 'unit'=>0);
			}
			else if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/positions');
				$this->load->model('Position');
				$data['position'] = $this->Position->select($id);
				if (!$data['position'])
					redirect('admin/positions');
			}
			$messages = $this->_get_messages();
			$data['messages'] = $messages['messages'];
			$data['message_type'] = $messages['message_type'];
			if ($position = $this->session->flashdata('position'))
			{
				$data['position'] = $position;
			}
			$data['action'] = $case;
			$admin['title'] = e('admin_' . $case . '_position_title');
			$admin['body'] = $this->load->view('admin/position', $data, TRUE);
			return $admin;
		}
		else
		{
			redirect('admin/positions');
		}
	}

	function _do_position($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			$this->load->model('Position');
			if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/positions');
				$position = $this->Position->select($id);
				if (!$position)
					redirect('admin/positions');
			}
			$error = array();
			$position['position'] = $this->input->post('position', TRUE);
			$position['description'] = $this->input->post('description', TRUE);
			$position['maximum'] = $this->input->post('maximum', TRUE);
			$position['ordinality'] = $this->input->post('ordinality', TRUE);
			$position['abstain'] = $this->input->post('abstain', TRUE);
			$position['unit'] = $this->input->post('unit', TRUE);
			if (!$position['position'])
			{
				$error[] = e('admin_position_no_position');
			}
			else
			{
				if ($test = $this->Position->select_by_position($position['position']))
				{
					if ($case == 'add')
					{
						$error[] = e('admin_position_exists') . ' (' . $test['position'] . ')';
					}
					else if ($case == 'edit')
					{
						if ($test['id'] != $id)
						{
							$error[] = e('admin_position_exists') . ' (' . $test['position'] . ')';
						}
					}
				}
			}
			if (!$position['maximum'])
			{
				$error[] = e('admin_position_no_maximum');
			}
			else
			{
				if (!ctype_digit($position['maximum']))
					$error[] = e('admin_position_maximum_not_digit');
			}
			if (!$position['ordinality'])
			{
				$error[] = e('admin_position_no_ordinality');
			}
			else
			{
				if (!ctype_digit($position['ordinality']))
					$error[] = e('admin_position_ordinality_not_digit');
			}
			if (empty($error))
			{
				if ($case == 'add')
				{
					$this->Position->insert($position);
					$success[] = e('admin_add_position_success');
				}
				else if ($case == 'edit')
				{
					$this->Position->update($position, $id);
					$success[] = e('admin_edit_position_success');
				}
				$this->session->set_flashdata('success', $success);
			}
			else
			{
				$this->session->set_flashdata('position', $position);
				$this->session->set_flashdata('error', $error);
			}
			if ($case == 'add')
			{
				redirect('admin/add/position');
			}
			else if ($case == 'edit')
			{
				redirect('admin/edit/position/' . $id);	
			}
		}
		else
		{
			redirect('admin/positions');
		}
	}

	function _voter($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			if ($case == 'add')
			{
				$data['voter'] = array('username'=>'', 'first_name'=>'', 'last_name'=>'');
				$chosen = array();
			}
			else if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/voters');
				$this->load->model('Boter');
				$data['voter'] = $this->Boter->select($id);
				if (!$data['voter'])
					redirect('admin/voters');
				$this->load->model('Position_Voter');
				$tmp = $this->Position_Voter->select_all_by_voter_id($id);
				$chosen = array();
				foreach ($tmp as $t)
				{
					$chosen[] = $t['position_id'];
				}
			}
			$messages = $this->_get_messages();
			$data['messages'] = $messages['messages'];
			$data['message_type'] = $messages['message_type'];
			$this->load->model('Position');
			$data['general'] = $this->Position->select_all_non_units();
			$data['specific'] = $this->Position->select_all_units();
			$data['possible'] = array();
			$data['chosen'] = array();
			if ($voter = $this->session->flashdata('voter'))
			{
				if (empty($voter['chosen']))
				{
					$chosen = array();
				}
				else
				{
					$chosen = $voter['chosen'];
					unset($voter['chosen']);
				}
				$data['voter'] = $voter;
			}
			foreach ($data['specific'] as $s)
			{
				if (in_array($s['id'], $chosen))
				{
					$data['chosen'][$s['id']] = $s['position'];
				}
				else
				{
					$data['possible'][$s['id']] = $s['position'];
				}
			}
			$data['action'] = $case;
			$data['settings'] = $this->settings;
			$admin['title'] = e('admin_' . $case . '_voter_title');
			$admin['body'] = $this->load->view('admin/voter', $data, TRUE);
			return $admin;
		}
		else
		{
			redirect('admin/voters');
		}
	}

	function _do_voter($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			$this->load->model('Boter');
			if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/voters');
				$voter = $this->Boter->select($id);
				if (!$voter)
					redirect('admin/voters');
			}
			$error = array();
			$voter['username'] = $this->input->post('username', TRUE);
			$voter['last_name'] = $this->input->post('last_name', TRUE);
			$voter['first_name'] = $this->input->post('first_name', TRUE);
			$voter['chosen'] = $this->input->post('chosen', TRUE);
			if (!$voter['username'])
			{
				if ($this->settings['password_pin_generation'] == 'web')
					$error[] = e('admin_voter_no_username');
				else if ($this->settings['password_pin_generation'] == 'email')
					$error[] = e('admin_voter_no_email');
			}
			else
			{
				if ($test = $this->Boter->select_by_username($voter['username']))
				{
					if ($case == 'add')
					{
						$error[] = e('admin_voter_exists') . ' (' . $test['username'] . ')';
					}
					else if ($case == 'edit')
					{
						if ($test['id'] != $id)
							$error[] = e('admin_voter_exists') . ' (' . $test['username'] . ')';
					}
				}
				if ($this->settings['password_pin_generation'] == 'email')
				{
					if (!$this->_valid_email($voter['username']))
					{
						$error[] = e('admin_voter_invalid_email');
					}
				}
			}
			if (!$voter['last_name'])
			{
				$error[] = e('admin_voter_no_last_name');
			}
			if (!$voter['first_name'])
			{
				$error[] = e('admin_voter_no_first_name');
			}
			if (empty($error))
			{
				if ($case == 'add' || $this->input->post('password'))
				{
					$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
					$voter['password'] = sha1($password);
				}
				if ($this->settings['pin'])
				{
					if ($case == 'add' || $this->input->post('pin'))
					{
						$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
						$voter['pin'] = sha1($pin);
					}
				}
				if ($case == 'add')
				{
					$voter['voted'] = 0;
					$this->Boter->insert($voter);
				}
				else if ($case == 'edit')
				{
					$this->Boter->update($voter, $id);
				}
				$success = array();
				$success[] = e('admin_add_voter_success');
				if ($this->settings['password_pin_generation'] == 'web')
				{
					$success[] = 'Username: '. $voter['username'];
					if ($case == 'add' || $this->input->post('password'))
					{
						$success[] = 'Password: '. $password;
					}
					if ($this->settings['pin'])
					{
						if ($case == 'add' || $this->input->post('pin'))
						{
							$success[] = 'PIN: '. $pin;
						}
					}
				}
				else if ($this->settings['password_pin_generation'] == 'email')
				{
					$this->email->from($this->admin['email'], $this->admin['first_name'] . ' ' . $this->admin['last_name']);
					$this->email->to($voter['username']);
					$this->email->subject($this->settings['name'] . ' Login Credentials');
					$message = "Hello $voter[first_name] $voter[last_name],\n\nThe following are your login credentials:\nEmail: $voter[username]\n";
					if ($case == 'add' || $this->input->post('password'))
					{
						$message .= "Password: $password\n";
					}
					if ($this->settings['pin'])
					{
						if ($case == 'add' || $this->input->post('pin'))
						{
							$message .= "PIN: $pin\n";
						}
					}
					$message .= "\n";
					$message .= ($this->admin['first_name'] . ' ' . $this->admin['last_name']);
					$message .= "\n";
					$message .= $this->settings['name'] . ' Administrator';
					$this->email->message($message);
					$this->email->send();
					//echo $this->email->print_debugger();
					$success[] = e('admin_voter_email_success');
				}
				$this->session->set_flashdata('success', $success);
			}
			else
			{
				$this->session->set_flashdata('voter', $voter);
				$this->session->set_flashdata('error', $error);
			}
			if ($case == 'add')
			{
				redirect('admin/add/voter');
			}
			else if ($case == 'edit')
			{
				redirect('admin/edit/voter/' . $id);
			}
		}
		else
		{
			redirect('admin/voters');
		}
	}

	function import()
	{
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
		$this->load->model('Position');
		$data['general'] = $this->Position->select_all_non_units();
		$data['specific'] = $this->Position->select_all_units();
		$tmp = array();
		foreach ($data['specific'] as $s)
		{
			$tmp[$s['id']] = $s['position'];
		}
		$data['possible'] = $tmp;
		if ($import = $this->session->flashdata('import'))
		{
			if (empty($import['chosen']))
			{
				$data['chosen'] = array();
			}
			else
			{
				$chosen = $import['chosen'];
				unset($import['chosen']);
				$tmp = array();
				foreach ($data['possible'] as $key=>$value)
				{
					if (in_array($key, $chosen))
					{
						unset($data['possible'][$key]);
						$tmp[$key] = $value;
					}
				}
				$data['chosen'] = $tmp;
			}
		}
		else
		{
			$data['chosen'] = array();
		}
		$data['settings'] = $this->settings;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_import_title');
		$admin['body'] = $this->load->view('admin/import', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function do_import()
	{
		$error = array();
		$import['chosen'] = $this->input->post('chosen', TRUE);
		$config['upload_path'] = $this->config->item('upload_path') . 'csvs/';
		$config['allowed_types'] = 'csv';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('csv'))
		{
			$error[] = $this->upload->display_errors();
		}
		else
		{
			$upload_data = $this->upload->data();
			$data = file($upload_data['full_path']);
		}
		if (empty($error))
		{
			$this->load->model('Boter');
			$count = 0;
			unset($data[0]); // remove header
			foreach ($data as $datum)
			{
				$tmp = explode(',', $datum);
				$voter['username'] = trim(strip_quotes($tmp[0]));
				$voter['last_name'] = trim(strip_quotes($tmp[1]));
				$voter['first_name'] = trim(strip_quotes($tmp[2]));
				$voter['password'] = '';
				$voter['voted'] = 0;
				$voter['chosen'] = $this->input->post('chosen', TRUE);
				if ($voter['username'] && $voter['last_name'] && $voter['first_name'] && !$this->Boter->select_by_username($voter['username']))
				{
					if ($this->settings['password_pin_generation'] == 'web')
					{
						$this->Boter->insert($voter);
						$count++;
					}
					else if ($this->settings['password_pin_generation'] == 'email')
					{
						if ($this->_valid_email($voter['username']))
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
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('import', $import);
			$this->session->set_flashdata('error', $error);
		}
		unlink($upload_data['full_path']);
		redirect('admin/import');
	}

	function export()
	{
		$data['settings'] = $this->settings;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_export_title');
		$admin['body'] = $this->load->view('admin/export', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function do_export()
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
		if ($this->input->post('password'))
		{
			$header .= ',Password';
		}
		if ($this->settings['pin'])
		{
			if ($this->input->post('pin'))
			{
				$header .= ',PIN';
			}
		}
		if ($this->input->post('votes'))
		{
			$header .= ',Votes';
		}
		if ($this->input->post('status'))
		{
			$header .= ',Voted';
		}
		$data[] = $header;
		$this->load->model('Boter');
		$this->load->model('Vote');
		$voters = $this->Boter->select_all();
		foreach ($voters as $voter)
		{
			$row = $voter['username'] . ',' . $voter['last_name'] . ',' . $voter['first_name'];
			if ($this->input->post('password'))
			{
				$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
				$boter['password'] = sha1($password);
				$row .= ',' . $password;
				$this->Boter->update($boter, $voter['id']);
			}
			if ($this->settings['pin'])
			{
				if ($this->input->post('pin'))
				{
					$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
					$boter['pin'] = sha1($pin);
					$row .= ',' . $pin;
					$this->Boter->update($boter, $voter['id']);
				}
			}
			if ($this->input->post('votes'))
			{
				$votes = $this->Vote->select_all_by_voter_id($voter['id']);
				$tmp = array();
				foreach ($votes as $vote)
				{
					$tmp[] = $vote['first_name'] . ' ' . $vote['last_name'];
				}
				$row .= ',' . implode(' | ', $tmp);
			}
			if ($this->input->post('status'))
			{
				if ($voter['voted'])
				{
					$row .= ',yes';
				}
				else
				{
					$row .= ',no';
				}
			}
			$data[] = $row;
		}
		$data = implode("\r\n", $data);
		force_download('voters.csv', $data);
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
			return $name;
		else
			return $error;
	}

	// taken from CodeIgniter Validation Library
	function _valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

	function _get_messages()
	{
		$messages = '';
		$message_type = '';
		if($error = $this->session->flashdata('error'))
		{
			$messages = $error;
			$message_type = 'negative';
		}
		else if($success = $this->session->flashdata('success'))
		{
			$messages = $success;
			$message_type = 'positive';
		}
		return array('messages'=>$messages, 'message_type'=>$message_type);
	}

}

?>