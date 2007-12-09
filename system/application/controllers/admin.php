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
			$this->session->set_flashdata('login', e('common_unauthorized'));
			redirect('gate/admin');
		}
		$this->settings = $this->config->item('halalan');
		$this->load->model('Option');
		$option = $this->Option->select(1);
		if ($option['status'] && $this->uri->segment(2) != 'home' && $this->uri->segment(2) != 'do_edit_option' && $this->uri->segment(2) != 'index')
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
		if($error = $this->session->flashdata('error'))
		{
			$data['messages'] = $error;
		}
		else if($success = $this->session->flashdata('success'))
		{
			$data['messages'] = $success;
		}
		$this->load->model('Option');
		$data['option'] = $this->Option->select(1);
		$data['username'] = $this->admin['username'];
		$main['title'] = e('admin_home_title');
		$main['body'] = $this->load->view('admin/home', $data, TRUE);
		$this->load->view('main', $main);
	}

	function do_edit_option($id)
	{
		if (!$id)
			redirect('admin/home');
		$this->load->model('Option');
		$option = $this->Option->select($id);
		if (!$option)
			redirect('admin/home');
		$option['status'] = $this->input->post('status');
		$option['result'] = $this->input->post('result');
		$this->load->model('Option');
		$this->Option->update($option, $id);
		$success[] = e('admin_edit_option_success');
		$this->session->set_flashdata('success', $success);
		redirect('admin/home');
	}

	function voters()
	{
		if($error = $this->session->flashdata('error'))
		{
			$data['messages'] = $error;
		}
		else if($success = $this->session->flashdata('success'))
		{
			$data['messages'] = $success;
		}
		$this->load->model('Boter');
		$data['voters'] = $this->Boter->select_all();
		$data['username'] = $this->admin['username'];
		$main['title'] = e('admin_voters_title');
		$main['body'] = $this->load->view('admin/voters', $data, TRUE);
		$this->load->view('main', $main);
	}

	function parties()
	{
		if($error = $this->session->flashdata('error'))
		{
			$data['messages'] = $error;
		}
		else if($success = $this->session->flashdata('success'))
		{
			$data['messages'] = $success;
		}
		$this->load->model('Party');
		$data['parties'] = $this->Party->select_all();
		$data['username'] = $this->admin['username'];
		$main['title'] = e('admin_parties_title');
		$main['body'] = $this->load->view('admin/parties', $data, TRUE);
		$this->load->view('main', $main);
	}

	function positions()
	{
		if($error = $this->session->flashdata('error'))
		{
			$data['messages'] = $error;
		}
		else if($success = $this->session->flashdata('success'))
		{
			$data['messages'] = $success;
		}
		$this->load->model('Position');
		$data['positions'] = $this->Position->select_all();
		$data['username'] = $this->admin['username'];
		$main['title'] = e('admin_positions_title');
		$main['body'] = $this->load->view('admin/positions', $data, TRUE);
		$this->load->view('main', $main);
	}

	function candidates()
	{
		if($error = $this->session->flashdata('error'))
		{
			$data['messages'] = $error;
		}
		else if($success = $this->session->flashdata('success'))
		{
			$data['messages'] = $success;
		}
		$this->load->model('Candidate');
		$this->load->model('Position');
		$positions = $this->Position->select_all();
		foreach ($positions as $key=>$value)
		{
			$positions[$key]['candidates'] = $this->Candidate->select_all_by_position_id($value['id']);
		}
		$data['positions'] = $positions;
		$data['username'] = $this->admin['username'];
		$main['title'] = e('admin_candidates_title');
		$main['body'] = $this->load->view('admin/candidates', $data, TRUE);
		$this->load->view('main', $main);
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
				if ($voter['voted'] == TRUE)
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
				if ($this->Party->in_used($id))
				{
					$this->session->set_flashdata('error', array(e('admin_delete_party_in_used')));
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
				if ($this->Position->in_used($id))
				{
					$this->session->set_flashdata('error', array(e('admin_delete_position_in_used')));
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

	function edit($type, $id) 
	{
		$data['username'] = $this->admin['username'];
		if($error = $this->session->flashdata('error'))
		{
			$data['messages'] = $error;
		}
		else if($success = $this->session->flashdata('success'))
		{
			$data['messages'] = $success;
		}
		switch ($type)
		{
			case 'voter':
				if (!$id)
					redirect('admin/voters');
				$this->load->model('Boter');
				$data['voter'] = $this->Boter->select($id);
				if (!$data['voter'])
					redirect('admin/voters');
				$this->load->model('Position');
				$this->load->model('Position_Voter');
				$data['general'] = $this->Position->select_all_non_units();
				$data['specific'] = $this->Position->select_all_units();
				if ($voter = $this->session->flashdata('voter'))
				{
					$data['voter'] = $voter;
					if (empty($voter['chosen']))
						$chosen = array();
					else
						$chosen = $voter['chosen'];
					unset($voter['chosen']);
				}
				else
				{
					$tmp = $this->Position_Voter->select_all_by_voter_id($id);
					$chosen = array();
					foreach ($tmp as $t)
					{
						$chosen[] = $t['position_id'];
					}
				}
				$tmp[0] = array();
				$tmp[1] = array();
				foreach ($data['specific'] as $s)
				{
					if (in_array($s['id'], $chosen))
						$tmp[0][$s['id']] = $s['position'];
					else
						$tmp[1][$s['id']] = $s['position'];
				}
				$data['possible'] = $tmp[1];
				$data['chosen'] = $tmp[0];
				$data['action'] = 'edit';
				$data['settings'] = $this->settings;
				$main['title'] = e('admin_edit_voter_title');
				$main['body'] = $this->load->view('admin/voter', $data, TRUE);
				break;
			case 'party':
				if (!$id)
					redirect('admin/parties');
				$this->load->model('Party');
				$data['party'] = $this->Party->select($id);
				if (!$data['party'])
					redirect('admin/parties');
				if ($party = $this->session->flashdata('party'))
					$data['party'] = $party;
				$data['action'] = 'edit';
				$main['title'] = e('admin_edit_party_title');
				$main['body'] = $this->load->view('admin/party', $data, TRUE);
				break;
			case 'position':
				if (!$id)
					redirect('admin/positions');
				$this->load->model('Position');
				$data['position'] = $this->Position->select($id);
				if (!$data['position'])
					redirect('admin/positions');
				if ($position = $this->session->flashdata('position'))
					$data['position'] = $position;
				$data['action'] = 'edit';
				$main['title'] = e('admin_edit_position_title');
				$main['body'] = $this->load->view('admin/position', $data, TRUE);
				break;
			case 'candidate':
				if (!$id)
					redirect('admin/candidates');
				$this->load->model('Candidate');
				$data['candidate'] = $this->Candidate->select($id);
				if (!$data['candidate'])
					redirect('admin/candidates');
				$this->load->model('Party');
				$parties = $this->Party->select_all();
				$tmp = array(''=>'Select Party');
				foreach ($parties as $party)
				{
					$tmp[$party['id']] = $party['party'];
				}
				$data['parties'] = $tmp;
				$this->load->model('Position');
				$positions = $this->Position->select_all();
				$tmp = array(''=>'Select Position');
				foreach ($positions as $position)
				{
					$tmp[$position['id']] = $position['position'];
				}
				$data['positions'] = $tmp;
				if ($candidate = $this->session->flashdata('candidate'))
					$data['candidate'] = $candidate;
				$data['action'] = 'edit';
				$main['title'] = e('admin_edit_candidate_title');
				$main['body'] = $this->load->view('admin/candidate', $data, TRUE);
				break;
			default:
				redirect('admin/home');
		}
		$this->load->view('main', $main);
	}

	function add($type)
	{
		$data['username'] = $this->admin['username'];
		if($error = $this->session->flashdata('error'))
		{
			$data['messages'] = $error;
		}
		else if($success = $this->session->flashdata('success'))
		{
			$data['messages'] = $success;
		}
		switch ($type)
		{
			case 'voter':
				$this->load->model('Position');
				$data['general'] = $this->Position->select_all_non_units();
				$data['specific'] = $this->Position->select_all_units();
				$tmp = array();
				foreach ($data['specific'] as $s)
				{
					$tmp[$s['id']] = $s['position'];
				}
				$data['possible'] = $tmp;
				if ($voter = $this->session->flashdata('voter'))
				{
					if (empty($voter['chosen']))
					{
						$data['chosen'] = array();
					}
					else
					{
						$chosen = $voter['chosen'];
						unset($voter['chosen']);
						$tmp = array();
						foreach ($data['possible'] as $key=>$value)
						{
							if (in_array($key, $chosen))
							{
								unset($data['possible'][$key]);
								$tmp[$key] = $value;
							}
						}
					}
					$data['voter'] = $voter;
					$data['chosen'] = $tmp;
				}
				else
				{
					$data['voter'] = array('username'=>'', 'first_name'=>'', 'last_name'=>'');
					$data['chosen'] = array();
				}
				$data['action'] = 'add';
				$data['settings'] = $this->settings;
				$main['title'] = e('admin_add_voter_title');
				$main['body'] = $this->load->view('admin/voter', $data, TRUE);
				break;
			case 'party':
				if ($party = $this->session->flashdata('party'))
					$data['party'] = $party;
				else
					$data['party'] = array('party'=>'', 'description'=>'');
				$data['action'] = 'add';
				$main['title'] = e('admin_add_party_title');
				$main['body'] = $this->load->view('admin/party', $data, TRUE);
				break;
			case 'position':
				if ($position = $this->session->flashdata('position'))
					$data['position'] = $position;
				else
					$data['position'] = array('position'=>'', 'description'=>'', 'maximum'=>'', 'ordinality'=>'', 'abstain'=>TRUE, 'unit'=>FALSE);
				$data['action'] = 'add';
				$main['title'] = e('admin_add_position_title');
				$main['body'] = $this->load->view('admin/position', $data, TRUE);
				break;
			case 'candidate':
				$this->load->model('Party');
				$parties = $this->Party->select_all();
				$tmp = array(''=>'Select Party');
				foreach ($parties as $party)
				{
					$tmp[$party['id']] = $party['party'];
				}
				$data['parties'] = $tmp;
				$this->load->model('Position');
				$positions = $this->Position->select_all();
				$tmp = array(''=>'Select Position');
				foreach ($positions as $position)
				{
					$tmp[$position['id']] = $position['position'];
				}
				$data['positions'] = $tmp;
				if ($candidate = $this->session->flashdata('candidate'))
					$data['candidate'] = $candidate;
				else
					$data['candidate'] = array('first_name'=>'', 'last_name'=>'', 'description'=>'', 'party_id'=>'', 'position_id'=>'');
				$data['action'] = 'add';
				$main['title'] = e('admin_add_candidate_title');
				$main['body'] = $this->load->view('admin/candidate', $data, TRUE);
				break;
			default:
				redirect('admin/home');
		}
		$this->load->view('main', $main);
	}
	
	function do_add_voter()
	{
		$this->load->model('Boter');
		$error = array();
		if (!$this->input->post('username'))
		{
			if ($this->settings['password_pin_generation'] == 'web')
				$error[] = e('admin_voter_no_username');
			else if ($this->settings['password_pin_generation'] == 'email')
				$error[] = e('admin_voter_no_email');
		}
		else
		{
			if ($test = $this->Boter->select_by_username($this->input->post('username')))
			{
				$error[] = e('admin_voter_exists') . ' (' . $test['username'] . ')';
			}
		}
		if ($this->settings['password_pin_generation'] == 'email')
		{
			if (!$this->_valid_email($this->input->post('username')))
			{
				$error[] = e('admin_voter_invalid_email');
			}
		}
		if (!$this->input->post('last_name'))
		{
			$error[] = e('admin_voter_no_last_name');
		}
		if (!$this->input->post('first_name'))
		{
			$error[] = e('admin_voter_no_first_name');
		}
		$voter['username'] = $this->input->post('username');
		$voter['last_name'] = $this->input->post('last_name');
		$voter['first_name'] = $this->input->post('first_name');
		$voter['chosen'] = $this->input->post('chosen');
		if (empty($error))
		{
			$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
			$voter['password'] = sha1($password);
			if ($this->settings['pin'])
			{
				$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
				$voter['pin'] = sha1($pin);
			}
			$voter['voted'] = FALSE;
			$this->Boter->insert($voter);
			$success = array();
			$success[] = e('admin_add_voter_success');
			if ($this->settings['password_pin_generation'] == 'web')
			{
				$success[] = 'Username: '. $voter['username'];
				$success[] = 'Password: '. $password;
				if ($this->settings['pin'])
					$success[] = 'PIN: '. $pin;
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
					$message .= "PIN: $pin\n";
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
		redirect('admin/add/voter');
	}

	function do_edit_voter($id)
	{
		if (!$id)
			redirect('admin/voters');
		$this->load->model('Boter');
		$voter = $this->Boter->select($id);
		if (!$voter)
			redirect('admin/voters');
		$error = array();
		if (!$this->input->post('username'))
		{
			if ($this->settings['password_pin_generation'] == 'web')
				$error[] = e('admin_voter_no_username');
			else if ($this->settings['password_pin_generation'] == 'email')
				$error[] = e('admin_voter_no_email');
		}
		else
		{
			if ($test = $this->Boter->select_by_username($this->input->post('username')))
			{
				if ($test['id'] != $id)
					$error[] = e('admin_voter_exists') . ' (' . $test['username'] . ')';
			}
		}
		if ($this->settings['password_pin_generation'] == 'email')
		{
			if (!$this->_valid_email($this->input->post('username')))
			{
				$error[] = e('admin_voter_invalid_email');
			}
		}
		if (!$this->input->post('last_name'))
		{
			$error[] = e('admin_voter_no_last_name');
		}
		if (!$this->input->post('first_name'))
		{
			$error[] = e('admin_voter_no_first_name');
		}
		$voter['username'] = $this->input->post('username');
		$voter['last_name'] = $this->input->post('last_name');
		$voter['first_name'] = $this->input->post('first_name');
		$voter['chosen'] = $this->input->post('chosen');
		if (empty($error))
		{
			if ($this->input->post('password'))
			{
				$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
				$voter['password'] = sha1($password);
			}
			if ($this->settings['pin'])
			{
				if ($this->input->post('pin'))
				{
					$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
					$voter['pin'] = sha1($pin);
				}
			}
			$this->Boter->update($voter, $id);
			$success = array();
			$success[] = e('admin_edit_voter_success');
			if ($this->settings['password_pin_generation'] == 'web')
			{
				$success[] = 'Username: '. $voter['username'];
				if ($this->input->post('password'))
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
				if ($this->input->post('password'))
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
				$success[] = e('admin_voter_email_success');
			}
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('voter', $voter);
			$this->session->set_flashdata('error', $error);
		}
		redirect('admin/edit/voter/' . $id);
	}

	function do_add_party()
	{
		$error = array();
		if (!$this->input->post('party'))
		{
			$error[] = e('admin_party_no_party');
		}
		$party['party'] = $this->input->post('party');
		$party['description'] = $this->input->post('description');
		if ($_FILES['logo']['error'] != UPLOAD_ERR_NO_FILE)
		{
			$config['upload_path'] = $this->config->item('upload_path') . 'logos/';
			$config['allowed_types'] = $this->config->item('allowed_types');
			$this->upload->initialize($config);
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
			$this->load->model('Party');
			$this->Party->insert($party);
			$success[] = e('admin_add_party_success');
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('party', $party);
			$this->session->set_flashdata('error', $error);
		}
		redirect('admin/add/party');
	}

	function do_edit_party($id)
	{
		if (!$id)
			redirect('admin/parties');
		$this->load->model('Party');
		$party = $this->Party->select($id);
		if (!$party)
			redirect('admin/parties');
		$error = array();
		if (!$this->input->post('party'))
		{
			$error[] = e('admin_party_no_party');
		}
		$party['party'] = $this->input->post('party');
		$party['description'] = $this->input->post('description');
		if ($_FILES['logo']['error'] != UPLOAD_ERR_NO_FILE)
		{
			$config['upload_path'] = $this->config->item('upload_path') . 'logos/';
			$config['allowed_types'] = $this->config->item('allowed_types');
			$this->upload->initialize($config);
			// delete old logo first
			unlink($config['upload_path'] . $party['logo']);
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
			$this->Party->update($party, $id);
			$success[] = e('admin_edit_party_success');
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('party', $party);
			$this->session->set_flashdata('error', $error);
		}
		redirect('admin/edit/party/' . $id);
	}

	function do_add_position()
	{
		$error = array();
		if (!$this->input->post('position'))
		{
			$error[] = e('admin_position_no_position');
		}
		if (!$this->input->post('maximum'))
		{
			$error[] = e('admin_position_no_maximum');
		}
		else
		{
			if (!ctype_digit($this->input->post('maximum')))
				$error[] = e('admin_position_maximum_not_digit');
		}
		if (!$this->input->post('ordinality'))
		{
			$error[] = e('admin_position_no_ordinality');
		}
		else
		{
			if (!ctype_digit($this->input->post('ordinality')))
				$error[] = e('admin_position_ordinality_not_digit');
		}
		$position['position'] = $this->input->post('position');
		$position['description'] = $this->input->post('description');
		$position['maximum'] = $this->input->post('maximum');
		$position['ordinality'] = $this->input->post('ordinality');
		$position['abstain'] = $this->input->post('abstain');
		$position['unit'] = $this->input->post('unit');
		if (empty($error))
		{
			$this->load->model('Position');
			$this->Position->insert($position);
			$success[] = e('admin_add_position_success');
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('position', $position);
			$this->session->set_flashdata('error', $error);
		}
		redirect('admin/add/position');
	}

	function do_edit_position($id)
	{
		if (!$id)
			redirect('admin/positions');
		$this->load->model('Position');
		$position = $this->Position->select($id);
		if (!$position)
			redirect('admin/positions');
		$error = array();
		if (!$this->input->post('position'))
		{
			$error[] = e('admin_position_no_position');
		}
		if (!$this->input->post('maximum'))
		{
			$error[] = e('admin_position_no_maximum');
		}
		else
		{
			if (!ctype_digit($this->input->post('maximum')))
				$error[] = e('admin_position_maximum_not_digit');
		}
		if (!$this->input->post('ordinality'))
		{
			$error[] = e('admin_position_no_ordinality');
		}
		else
		{
			if (!ctype_digit($this->input->post('ordinality')))
				$error[] = e('admin_position_ordinality_not_digit');
		}
		$position['position'] = $this->input->post('position');
		$position['description'] = $this->input->post('description');
		$position['maximum'] = $this->input->post('maximum');
		$position['ordinality'] = $this->input->post('ordinality');
		$position['abstain'] = $this->input->post('abstain');
		$position['unit'] = $this->input->post('unit');
		if (empty($error))
		{
			$this->Position->update($position, $id);
			$success[] = e('admin_edit_position_success');
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('position', $position);
			$this->session->set_flashdata('error', $error);
		}
		redirect('admin/edit/position/' . $id);
	}

	function do_add_candidate()
	{
		$error = array();
		if (!$this->input->post('first_name'))
		{
			$error[] = e('admin_candidate_no_first_name');
		}
		if (!$this->input->post('last_name'))
		{
			$error[] = e('admin_candidate_no_last_name');
		}
		if (!$this->input->post('position_id'))
		{
			$error[] = e('admin_candidate_no_position');
		}
		$candidate['first_name'] = $this->input->post('first_name');
		$candidate['last_name'] = $this->input->post('last_name');
		$candidate['description'] = $this->input->post('description');
		$candidate['party_id'] = $this->input->post('party_id');
		$candidate['position_id'] = $this->input->post('position_id');
		if ($_FILES['picture']['error'] != UPLOAD_ERR_NO_FILE)
		{
			$config['upload_path'] = $this->config->item('upload_path') . 'pictures/';
			$config['allowed_types'] = $this->config->item('allowed_types');
			$this->upload->initialize($config);
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
			$this->load->model('Candidate');
			$this->Candidate->insert($candidate);
			$success[] = e('admin_add_candidate_success');
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('candidate', $candidate);
			$this->session->set_flashdata('error', $error);
		}
		redirect('admin/add/candidate');
	}

	function do_edit_candidate($id)
	{
		if (!$id)
			redirect('admin/candidates');
		$this->load->model('Candidate');
		$candidate = $this->Candidate->select($id);
		if (!$candidate)
			redirect('admin/candidates');
		$error = array();
		if (!$this->input->post('first_name'))
		{
			$error[] = e('admin_candidate_no_first_name');
		}
		if (!$this->input->post('last_name'))
		{
			$error[] = e('admin_candidate_no_last_name');
		}
		if (!$this->input->post('position_id'))
		{
			$error[] = e('admin_candidate_no_position');
		}
		$candidate['first_name'] = $this->input->post('first_name');
		$candidate['last_name'] = $this->input->post('last_name');
		$candidate['description'] = $this->input->post('description');
		$candidate['party_id'] = $this->input->post('party_id');
		$candidate['position_id'] = $this->input->post('position_id');
		if ($_FILES['picture']['error'] != UPLOAD_ERR_NO_FILE)
		{
			$config['upload_path'] = $this->config->item('upload_path') . 'pictures/';
			$config['allowed_types'] = $this->config->item('allowed_types');
			$this->upload->initialize($config);
			// delete old picture first
			unlink($config['upload_path'] . $candidate['picture']);
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
			$this->Candidate->update($candidate, $id);
			$success[] = e('admin_edit_candidate_success');
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('candidate', $candidate);
			$this->session->set_flashdata('error', $error);
		}
		redirect('admin/edit/candidate/' . $id);
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

}

?>