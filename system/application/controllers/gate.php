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
		setcookie('halalan_alerts', '', time() - 3600, '/'); // used in abstain alerts
		$this->session->sess_destroy();
		redirect('gate/' . $gate);
	}

	function results()
	{
		$selected = $this->input->post('elections', TRUE);
		$all_elections = $this->Election->select_all_with_results();
		$elections = $this->Election->select_all_by_ids($selected);
		foreach ($elections as $key1=>$election)
		{
			$positions = $this->Position->select_all_by_election_id($election['id']);
			foreach ($positions as $key2=>$position)
			{
				$candidates = array();
				$votes = $this->Vote->count_all_by_election_id_and_position_id($election['id'], $position['id']);
				foreach ($votes as $vote)
				{
					$candidate = $this->Candidate->select($vote['candidate_id']);
					$candidate['votes'] = $vote['votes'];
					$candidate['party'] = $this->Party->select($candidate['party_id']);
					$candidates[] = $candidate;
				}
				$positions[$key2]['candidates'] = $candidates;
				$positions[$key2]['abstains'] = $this->Abstain->count_all_by_election_id_and_position_id($election['id'], $position['id']);
			}
			$elections[$key1]['positions'] = $positions;
		}
		// $this->input->post returns FALSE so make it an array to avoid in_array errors
		if ($selected == FALSE)
		{
			$selected = array();
		}
		$data['selected'] = $selected;
		$data['all_elections'] = $all_elections;
		$data['elections'] = $elections;
		$data['settings'] = $this->config->item('halalan');
		$gate['login'] = 'results';
		$gate['title'] = e('gate_results_title');
		$gate['body'] = $this->load->view('gate/results', $data, TRUE);
		$this->load->view('gate', $gate);
	}

	function statistics()
	{
		$this->load->model('Statistics');
		$selected = $this->input->post('elections', TRUE);
		$all_elections = $this->Election->select_all_with_results();
		$elections = $this->Election->select_all_by_ids($selected);
		foreach ($elections as $key=>$election)
		{
			$elections[$key]['voter_count'] = $this->Statistics->count_all_voters($election['id']);
			$elections[$key]['voted_count'] = $this->Statistics->count_all_voted($election['id']);

			$elections[$key]['lt_one'] = $this->Statistics->count_all_by_duration($election['id'], '00:00:00', '00:01:00');
			$elections[$key]['lt_two_gte_one'] = $this->Statistics->count_all_by_duration($election['id'], '00:01:00', '00:02:00');
			$elections[$key]['lt_three_gte_two'] = $this->Statistics->count_all_by_duration($election['id'], '00:02:00', '00:03:00');
			$elections[$key]['gt_three'] = $this->Statistics->count_all_by_duration($election['id'], '00:03:00', FALSE);
		}
		// $this->input->post returns FALSE so make it an array to avoid in_array errors
		if ($selected == FALSE)
		{
			$selected = array();
		}
		$data['selected'] = $selected;
		$data['all_elections'] = $all_elections;
		$data['elections'] = $elections;
		$gate['login'] = 'statistics';
		$gate['title'] = e('gate_statistics_title');
		$gate['body'] = $this->load->view('gate/statistics', $data, TRUE);
		$this->load->view('gate', $gate);
	}

}

?>
