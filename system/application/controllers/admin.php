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
		$this->load->model('Boter');
		$data['voters'] = $this->Boter->get_voters_list();
		$data['username'] = $this->admin['username'];
		$main['title'] = e('admin_voters_title');
		$main['body'] = $this->load->view('admin/voters', $data, TRUE);
		$this->load->view('main', $main);
	}

	function edit($type, $id) 
	{
		$data['username'] = $this->admin['username'];
		switch ($type)
		{
			case 'voter':
				$this->load->model('Boter');
				$data['voter'] = $this->Boter->select($id);
				if (!$data['voter'])
					redirect('admin/voters');
				$main['title'] = e('admin_edit_voter_title');
				$main['body'] = $this->load->view('admin/edit_voter', $data, TRUE);
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
				$main['title'] = e('admin_add_voter');
				$main['body'] = $this->load->view('admin/add_voter', $data, TRUE);
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
		if(!$this->input->post('username'))
		{
			$error[] = e('admin_add_voter_no_username');
		}
		else
		{
			if ($test = $this->Boter->select_by_username($this->input->post('username')))
			{
				$error[] = e('admin_add_voter_exists') . ' (' . $test['username'] . ')';
			}
		}
		if(!$this->input->post('last_name'))
		{
			$error[] = e('admin_add_voter_no_last_name');
		}
		if(!$this->input->post('first_name'))
		{
			$error[] = e('admin_add_voter_no_first_name');
		}
		if(empty($error))
		{
			$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
			$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
			$voter['username'] = $this->input->post('username');
			$voter['password'] = sha1($password);
			$voter['pin'] = sha1($pin);
			$voter['last_name'] = $this->input->post('last_name');
			$voter['first_name'] = $this->input->post('first_name');
			$voter['voted'] = FALSE;
			$this->Boter->insert($voter);
			$success = array();
			$success[] = e('add_voter_success');
			if($this->settings['password_pin_generation'] == 'web')
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

}

?>