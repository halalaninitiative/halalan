<?php

class Gate extends Controller {

	function Gate()
	{
		parent::Controller();
	}
	
	function index()
	{
		$gate = '';
		if ($login = $this->session->flashdata('login'))
		{
			$gate['messages'] = array($login);
		}
		$main['title'] = e('gate_title');
		$main['body'] = $this->load->view('gate/index', $gate, TRUE);
		$this->load->view('main', $main);			
	}

	function login()
	{
		$this->load->model('Boter');
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password'));

		if ($voter = $this->Boter->authenticate($username, $password))

		{			
			if ($voter['voted'] == TRUE)
			{
				$this->session->set_flashdata('login', e('already_voted'));
				redirect('gate');
			}
			else
			{
				$this->Boter->update(array('login'=>date("Y-m-d H:i:s")), $voter['id']);
				$this->session->set_userdata('voter', $voter);
				redirect('voter');
			}
			
		}
		else
		{
			$this->session->set_flashdata('login', e('login_failure'));
			redirect('gate');
		}
	}

	function logout()
	{
		setcookie('halalan_cookie', '', time() - 3600, '/'); // destroy cookie
		$this->session->sess_destroy();
		redirect('gate');
	}
	
	function admin()
	{
		$gate = '';
		if ($login = $this->session->flashdata('login'))
		{
			$gate['message'] = $login;
		}
		$main['title'] = e('gate_title');
		$main['body'] = $this->load->view('gate/admin', $gate, TRUE);
		$this->load->view('main', $main);
		//echo(sha1('password'));
	}

	function admin_login()
	{
		$this->load->model('Abmin');
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password'));
		
		if ($admin = $this->Abmin->authenticate($username, $password))
		{		
			// don't save password and pin to session
			unset($admin['password']);			
			$this->session->set_userdata('admin', $admin);
			redirect('admin');		
		}
		else
		{
			$this->session->set_flashdata('login', e('login_failure'));
			redirect('gate/admin');
		}
	}

}
?>