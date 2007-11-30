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
			$this->session->set_flashdata('login', e('unauthorized'));
			redirect('gate/admin');
		}
		$this->settings = $this->config->item('halalan');
	}

	function index()
	{
		redirect('admin/manage');
	}

	function manage()
	{
		$data['username'] = $this->admin['username'];
		$main['title'] = e('admin_manage_title');
		$main['body'] = $this->load->view('admin/manage', $data, TRUE);
		$this->load->view('main', $main);
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
				$this->Party->delete($id);
				$this->session->set_flashdata('success', array(e('admin_delete_party_success')));
				redirect('admin/parties');
				break;
			case 'position':
				if (!$id)
					redirect('admin/position');
				$this->load->model('Position');
				$this->Position->delete($id);
				$this->session->set_flashdata('success', array(e('admin_delete_position_success')));
				redirect('admin/positions');
				break;
			default:
				redirect('admin/manage');
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
				$tmp = $this->Position_Voter->select_all_by_voter_id($id);
				$chosen = array();
				foreach ($tmp as $t)
				{
					$chosen[] = $t['position_id'];
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
				$data['positions'] = $tmp[1];
				$data['chosen'] = $tmp[0];
				$main['title'] = e('admin_edit_voter_title');
				$main['body'] = $this->load->view('admin/edit_voter', $data, TRUE);
				break;
			case 'party':
				if (!$id)
					redirect('admin/parties');
				$this->load->model('Party');
				$data['party'] = $this->Party->select($id);
				if (!$data['party'])
					redirect('admin/parties');
				$main['title'] = e('admin_edit_party_title');
				$main['body'] = $this->load->view('admin/edit_party', $data, TRUE);
				break;
			case 'position':
				if (!$id)
					redirect('admin/positions');
				$this->load->model('Position');
				$data['position'] = $this->Position->select($id);
				if (!$data['position'])
					redirect('admin/positions');
				$main['title'] = e('admin_edit_position_title');
				$main['body'] = $this->load->view('admin/edit_position', $data, TRUE);
				break;
			default:
				redirect('admin/manage');
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
				$data['positions'] = $tmp;
				$main['title'] = e('admin_add_voter_title');
				$main['body'] = $this->load->view('admin/add_voter', $data, TRUE);
				break;
			case 'party':
				$main['title'] = e('admin_add_party_title');
				$main['body'] = $this->load->view('admin/add_party', $data, TRUE);
				break;
			case 'position':
				$main['title'] = e('admin_add_position_title');
				$main['body'] = $this->load->view('admin/add_position', $data, TRUE);
				break;
			default:
				redirect('admin/manage');
		}
		$this->load->view('main', $main);
	}
	
	function do_add_voter()
	{
		$this->load->model('Boter');
		$error = array();
		if (!$this->input->post('username'))
		{
			$error[] = e('admin_voter_no_username');
		}
		else
		{
			if ($test = $this->Boter->select_by_username($this->input->post('username')))
			{
				$error[] = e('admin_voter_exists') . ' (' . $test['username'] . ')';
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
		if (empty($error))
		{
			$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
			$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
			$voter['username'] = $this->input->post('username');
			$voter['password'] = sha1($password);
			$voter['pin'] = sha1($pin);
			$voter['last_name'] = $this->input->post('last_name');
			$voter['first_name'] = $this->input->post('first_name');
			$voter['voted'] = FALSE;
			$voter['chosen'] = $this->input->post('chosen');
			$this->Boter->insert($voter);
			$success = array();
			$success[] = e('admin_add_voter_success');
			if ($this->settings['password_pin_generation'] == 'web')
			{
				$success[] = 'Username: '. $voter['username'];
				$success[] = 'Password: '. $password;
				$success[] = 'PIN: '. $pin;
			}
			$this->session->set_flashdata('success', $success);
		}
		else
		{
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
			$error[] = e('admin_voter_no_username');
		}
		else
		{
			if ($test = $this->Boter->select_by_username($this->input->post('username')))
			{
				if ($test['id'] != $id)
					$error[] = e('admin_voter_exists') . ' (' . $test['username'] . ')';
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
		if (empty($error))
		{
			if ($this->input->post('password'))
			{
				$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
				$voter['password'] = sha1($password);
			}
			if ($this->input->post('pin'))
			{
				$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
				$voter['pin'] = sha1($pin);
			}
			$voter['username'] = $this->input->post('username');
			$voter['last_name'] = $this->input->post('last_name');
			$voter['first_name'] = $this->input->post('first_name');
			$voter['chosen'] = $this->input->post('chosen');
			$this->Boter->update($voter, $id);
			$success = array();
			$success[] = e('admin_edit_voter_success');
			if ($this->settings['password_pin_generation'] == 'web')
			{
				$success[] = 'Username: '. $voter['username'];
				if ($this->input->post('password'))
					$success[] = 'Password: '. $password;
				if ($this->input->post('pin'))
					$success[] = 'PIN: '. $pin;
			}
			$this->session->set_flashdata('success', $success);
		}
		else
		{
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
		if (empty($error))
		{
			$party['party'] = $this->input->post('party');
			$party['description'] = $this->input->post('description');
			$party['logo'] = $this->input->post('logo');
			$this->load->model('Party');
			$this->Party->insert($party);
			$success[] = e('admin_add_party_success');
			$this->session->set_flashdata('success', $success);
		}
		else
		{
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
		if (empty($error))
		{
			$party['party'] = $this->input->post('party');
			$party['description'] = $this->input->post('description');
			unset($party['logo']);
			if ($this->input->post('logo'))
				$party['logo'] = $this->input->post('logo');
			$this->Party->update($party, $id);
			$success[] = e('admin_edit_party_success');
			$this->session->set_flashdata('success', $success);
		}
		else
		{
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
		if (empty($error))
		{
			$position['position'] = $this->input->post('position');
			$position['description'] = $this->input->post('description');
			$position['maximum'] = $this->input->post('maximum');
			$position['ordinality'] = $this->input->post('ordinality');
			$position['abstain'] = $this->input->post('abstain');
			$position['unit'] = $this->input->post('unit');
			$this->load->model('Position');
			$this->Position->insert($position);
			$success[] = e('admin_add_position_success');
			$this->session->set_flashdata('success', $success);
		}
		else
		{
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
		if (empty($error))
		{
			$position['position'] = $this->input->post('position');
			$position['description'] = $this->input->post('description');
			$position['maximum'] = $this->input->post('maximum');
			$position['ordinality'] = $this->input->post('ordinality');
			$position['abstain'] = $this->input->post('abstain');
			$position['unit'] = $this->input->post('unit');
			$this->Position->update($position, $id);
			$success[] = e('admin_edit_position_success');
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('error', $error);
		}
		redirect('admin/edit/position/' . $id);
	}

}

?>