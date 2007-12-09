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
		$data = '';
		if ($error = $this->session->flashdata('error'))
		{
			$data['messages'] = $error;
		}
		$this->load->model('Option');
		$data['option'] = $this->Option->select(1);
		$main['title'] = e('gate_voter_title');
		$main['body'] = $this->load->view('gate/voter', $data, TRUE);
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
				$error[] = e('gate_voter_already_voted');
				$this->session->set_flashdata('error', $error);
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
			$error[] = e('gate_common_login_failure');
			$this->session->set_flashdata('error', $error);
			redirect('gate/voter');
		}
	}
	
	function admin()
	{
		$data = '';
		if ($error = $this->session->flashdata('error'))
		{
			$data['messages'] = $error;
		}
		$main['title'] = e('gate_admin_title');
		$main['body'] = $this->load->view('gate/admin', $data, TRUE);
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
			$error[] = e('gate_common_login_failure');
			$this->session->set_flashdata('error', $error);
			redirect('gate/admin');
		}
	}

	function logout()
	{
		setcookie('halalan_cookie', '', time() - 3600, '/'); // destroy cookie
		$this->session->sess_destroy();
		redirect('gate');
	}

	function result()
	{
		$this->load->model('Option');
		$option = $this->Option->select(1);
		if ($option['result'])
		{
			$this->load->model('Candidate');
			$this->load->model('Party');
			$this->load->model('Position');
			$this->load->model('Vote');
			$positions = $this->Position->select_all();
			foreach ($positions as $key=>$position)
			{
				$candidates = array();
				$votes = $this->Vote->count_all_by_position_id($position['id']);
				foreach ($votes as $vote)
				{
					$candidate_id = $vote['candidate_id'];
					$candidate = $this->Candidate->select($candidate_id);
					$candidates[$candidate_id] = $candidate;
					$candidates[$candidate_id]['votes'] = $vote['votes'];
					$candidates[$candidate_id]['party'] = $this->Party->select($candidate['party_id']);
				}
				$positions[$key]['candidates'] = $candidates;
			}
			$data['positions'] = $positions;
			$main['title'] = e('gate_result_title');
			$main['body'] = $this->load->view('gate/result', $data, TRUE);
			$this->load->view('main', $main);
		}
		else
		{
			$this->session->set_flashdata('error', array(e('gate_result_unavailable')));
			redirect('gate/voter');
		}
	}

}

?>