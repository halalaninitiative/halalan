<?php

class Gate extends Controller {

	function Gate()
	{
		parent::Controller();
	}

	function index()
	{
		redirect('gate/voter');
	}

	function voter()
	{
		$gate = '';
		if ($login = $this->session->flashdata('login'))
		{
			$gate['messages'] = array($login);
		}
		$main['title'] = e('gate_voter_title');
		$main['body'] = $this->load->view('gate/voter', $gate, TRUE);
		$this->load->view('main', $main);
	}

	function voter_login()
	{
		$this->load->model('Boter');
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password'));
		if ($voter = $this->Boter->authenticate($username, $password))
		{
			if ($voter['voted'] == TRUE)
			{
				$this->session->set_flashdata('login', e('gate_voter_already_voted'));
				redirect('gate/voter');
			}
			else
			{
				$this->Boter->update(array('login'=>date("Y-m-d H:i:s")), $voter['id']);
				// don't save password to session
				unset($voter['password']);
				$this->session->set_userdata('voter', $voter);
				redirect('voter/vote');
			}
			
		}
		else
		{
			$this->session->set_flashdata('login', e('gate_login_failure'));
			redirect('gate/voter');
		}
	}
	
	function admin()
	{
		$gate = '';
		if ($login = $this->session->flashdata('login'))
		{
			$gate['messages'] = array($login);
		}
		$main['title'] = e('gate_admin_title');
		$main['body'] = $this->load->view('gate/admin', $gate, TRUE);
		$this->load->view('main', $main);
	}

	function admin_login()
	{
		$this->load->model('Abmin');
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password'));
		if ($admin = $this->Abmin->authenticate($username, $password))
		{
			// don't save password to session
			unset($admin['password']);
			$this->session->set_userdata('admin', $admin);
			redirect('admin/index');
		}
		else
		{
			$this->session->set_flashdata('login', e('gate_login_failure'));
			redirect('gate/admin');
		}
	}

	function logout()
	{
		setcookie('halalan_cookie', '', time() - 3600, '/'); // destroy cookie
		$this->session->sess_destroy();
		redirect('gate');
	}

}

?>