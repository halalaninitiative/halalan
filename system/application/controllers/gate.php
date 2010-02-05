<?php

class Gate extends Controller {

	function Gate()
	{
		parent::Controller();
		if ($this->uri->segment(2) != 'results' && $this->uri->segment(2) != 'statistics' && $this->uri->segment(2) != 'logout')
		{
			if ($this->session->userdata('admin'))
			{
				redirect('admin/home');
			}
			else if ($this->session->userdata('voter'))
			{
				redirect('voter/vote');
			}
		}
		
	}

	function index()
	{
		redirect('gate/voter');
	}

	function voter()
	{
		$data['settings'] = $this->config->item('halalan');
		$gate['login'] = 'voter';
		$gate['title'] = e('gate_voter_title');
		$gate['body'] = $this->load->view('gate/voter', $data, TRUE);
		$this->load->view('gate', $gate);
	}

	function voter_login()
	{
		if (!$this->input->post('username') || !$this->input->post('password'))
		{
			$messages = array('negative', e('gate_common_login_failure'));
			$this->session->set_flashdata('messages', $messages);
			redirect('gate/voter');
		}
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if (strlen($password) != 40)
		{
			$password = sha1($password);
		}
		if ($voter = $this->Boter->authenticate($username, $password))
		{
			if (strtotime($voter['login']) > strtotime($voter['logout']))
			{
				$messages = array('negative', e('gate_voter_currently_logged_in'));
				$this->session->set_flashdata('messages', $messages);
				redirect('gate/voter');
			}
			else
			{
				$this->Boter->update(array('login'=>date("Y-m-d H:i:s"), 'ip_address'=>ip2long($this->input->ip_address())), $voter['id']);
				// don't save password to session
				unset($voter['password']);
				$this->session->set_userdata('voter', $voter);
				redirect('voter/vote');
			}
		}
		else
		{
			$messages = array('negative', e('gate_common_login_failure'));
			$this->session->set_flashdata('messages', $messages);
			redirect('gate/voter');
		}
	}
	
	function admin()
	{
		$gate['login'] = 'admin';
		$gate['title'] = e('gate_admin_title');
		$gate['body'] = $this->load->view('gate/admin', '', TRUE);
		$this->load->view('gate', $gate);
	}

	function admin_login()
	{
		if (!$this->input->post('username') || !$this->input->post('password'))
		{
			$messages = array('negative', e('gate_common_login_failure'));
			$this->session->set_flashdata('messages', $messages);
			redirect('gate/admin');
		}
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if (strlen($password) != 40)
		{
			$password = sha1($password);
		}
		if ($admin = $this->Abmin->authenticate($username, $password))
		{
			// don't save password to session
			unset($admin['password']);
			$this->session->set_userdata('admin', $admin);
			redirect('admin/home');
		}
		else
		{
			$messages = array('negative', e('gate_common_login_failure'));
			$this->session->set_flashdata('messages', $messages);
			redirect('gate/admin');
		}
	}

	function logout()
	{
		if ($this->session->userdata('admin'))
		{
			$gate = 'admin';
		}
		else if($voter = $this->session->userdata('voter'))
		{
			// voter has not yet voted
			$this->Boter->update(array('logout'=>date("Y-m-d H:i:s")), $voter['id']);
			$gate = 'voter';
		}
		else
		{
			// voter has already voted
			$gate = 'voter';
		}
		setcookie('halalan_cookie', '', time() - 3600, '/'); // destroy cookie
		$this->session->sess_destroy();
		redirect('gate/' . $gate);
	}

	function results()
	{
		$this->load->model('Option');
		$option = $this->Option->select(1);
		$settings = $this->config->item('halalan');
		if (($option['result'] && !$option['status']) || ($settings['realtime_results'] && $this->session->userdata('admin')))
		{
			$selected = array_keys($this->input->post('positions', TRUE));
			if (!empty($selected))
			{
				$this->load->model('Abstain');
				$this->load->model('Candidate');
				$this->load->model('Party');
				$this->load->model('Vote');
			}
			else
			{
				$selected = FALSE;
			}
			$this->load->model('Position');
			$all_positions = $this->Position->select_all();
			$positions = $this->Position->select_multiple($selected);
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
				$positions[$key]['abstains'] = $this->Abstain->count_all_by_position_id($position['id']);
			}
			$data['settings'] = $this->config->item('halalan');
			$data['all_positions'] = $all_positions;
			$data['selected'] = $selected;
			$data['positions'] = $positions;
			$gate['login'] = 'results';
			$gate['title'] = e('gate_results_title');
			$gate['body'] = $this->load->view('gate/results', $data, TRUE);
			$this->load->view('gate', $gate);
		}
		else
		{
			$this->session->set_flashdata('error', array(e('gate_result_unavailable')));
			redirect('gate/voter');
		}
	}

	function statistics()
	{
		$this->load->model('Option');
		$option = $this->Option->select(1);
		$settings = $this->config->item('halalan');
		if (($option['result'] && !$option['status']) || ($settings['realtime_results'] && $this->session->userdata('admin')))
		{
			$this->load->model('Statistics');
			$data['voter_count'] = $this->Statistics->count_all_voters();
			$data['voted_count'] = $this->Statistics->count_voted();
			$data['settings'] = $this->config->item('halalan');
			$gate['login'] = 'statistics';
			$gate['title'] = e('gate_statistics_title');
			$gate['body'] = $this->load->view('gate/statistics', $data, TRUE);
			$this->load->view('gate', $gate);
		}
		else
		{
			$this->session->set_flashdata('error', array(e('gate_result_unavailable')));
			redirect('gate/voter');
		}
	}

}

?>
