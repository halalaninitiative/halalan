<?php

class Gate extends Controller {

	function Gate()
	{
		parent::Controller();
	}
	
	function index()
	{
		$data = '';
		if ($login = $this->session->flashdata('login'))
		{
			$data['message'] = $login;
		}
		$this->load->view('gate', $data);
	}

	function login()
	{
		$this->load->model('Voter');
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password'));
		if ($voter = $this->Voter->authenticate($username, $password))
		{
			if ($voter['voted'] == TRUE)
			{
				$this->session->set_flashdata('login', e('already_voted'));
				redirect('gate');
			}
			else
			{
				echo "login";
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
		$this->session->sess_destroy();
		redirect('gate');
	}

}
?>