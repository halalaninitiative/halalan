<?php

class Voter extends Controller {

	var $voter;
	var $settings;

	function Voter()
	{
		parent::Controller();
		$this->voter = $this->session->userdata('voter');
		if (!$this->voter)
		{
			$error[] = e('common_unauthorized');
			$this->session->set_flashdata('error', $error);
			redirect('gate/voter');
		}
		$this->settings = $this->config->item('halalan');
		$this->load->model('Option');
		$option = $this->Option->select(1);
		if (!$option['status'])
		{
			$error[] = e('voter_common_not_running_one');
			$error[] = e('voter_common_not_running_two');
			$this->session->set_flashdata('error', $error);
			redirect('gate/voter');
		}
	}

	function index()
	{
		redirect('voter/vote');
	}

	function vote()
	{
		$this->load->model('Candidate');
		$this->load->model('Party');
		$this->load->model('Position');
		$positions = $this->Position->select_all_with_units($this->voter['id']);
		foreach ($positions as $key=>$position)
		{
			$candidates = $this->Candidate->select_all_by_position_id($position['id']);
			foreach ($candidates as $candidate_id=>$candidate)
			{
				$candidates[$candidate_id]['party'] = $this->Party->select($candidate['party_id']);
			}
			$positions[$key]['candidates'] = $candidates;
		}
		if ($error = $this->session->flashdata('error'))
			$data['messages'] = $error;
		if (count($positions) == 0)
			$data['none'] = e('voter_vote_no_candidates');
		if ($votes = $this->session->userdata('votes'))
			$data['votes'] = $votes;
		$data['positions'] = $positions;
		$data['username'] = $this->voter['username'];
		$main['title'] = e('voter_vote_title');
		$main['body'] = $this->load->view('voter/vote', $data, TRUE);
		$this->load->view('main', $main);
	}

	function do_vote()
	{
		$error = array();
		$votes = $this->input->post('votes');
		// check if there are selected candidates
		if (empty($votes))
		{
			$error[] = e('voter_vote_no_selected');
		}
		else
		{
			// check if all positions have selected candidates
			$this->load->model('Position');
			$positions = $this->Position->select_all_with_units($this->voter['id']);
			$in_used = 0;
			foreach ($positions as $position)
			{
				if ($this->Position->in_used($position['id']))
					$in_used++;
			}
			if ($in_used != count($votes))
			{
				$error[] = e('voter_vote_not_all_selected');
			}
			else
			{
				foreach ($votes as $position_id => $candidate_ids)
				{
					// check if the number of selected candidates does not exceed the maximum allowed for each position
					$position = $this->Position->select($position_id);
					if ($position['maximum'] < count($candidate_ids))
					{
						$error[] = e('voter_vote_maximum');
					}
					else
					{
						// check if abstain is selected with other candidates
						if (in_array('', $candidate_ids) && count($candidate_ids) > 1)
						{
							$error[] = e('voter_vote_abstain_and_others');
						}
					}
				}
			}
		}
		// save the votes in session
		$this->session->set_userdata('votes', $votes);
		if (empty($error))
		{
			redirect('voter/confirm_vote');
		}
		else
		{
			$this->session->set_flashdata('error', $error);
			redirect('voter/vote');
		}
	}

	function confirm_vote()
	{
		$votes = $this->session->userdata('votes');
		if (empty($votes))
			redirect('voter/vote');
		$data['votes'] = $votes;
		$this->load->model('Candidate');
		$this->load->model('Party');
		$this->load->model('Position');
		$positions = $this->Position->select_all_with_units($this->voter['id']);
		foreach ($positions as $key=>$position)
		{
			$candidates = $this->Candidate->select_all_by_position_id($position['id']);
			foreach ($candidates as $candidate_id=>$candidate)
			{
				$candidates[$candidate_id]['party'] = $this->Party->select($candidate['party_id']);
			}
			$positions[$key]['candidates'] = $candidates;
		}
		if ($error = $this->session->flashdata('error'))
			$data['messages'] = $error;
		if ($this->settings['captcha'])
		{
			$this->load->plugin('captcha');
			$vals = array('img_path'=>'./public/captcha/', 'img_url'=>base_url() . 'public/captcha/', 'font_path'=>'./public/fonts/Vera.ttf', 'img_width'=>150, 'img_height'=>60);
			$captcha = create_captcha($vals);
			$data['captcha'] = $captcha;
			$this->session->set_userdata('word', $captcha['word']);
		}
		$data['settings'] = $this->settings;
		$data['positions'] = $positions;
		$data['username'] = $this->voter['username'];
		$main['title'] = e('voter_confirm_vote_title');
		$main['body'] = $this->load->view('voter/confirm_vote', $data, TRUE);
		$this->load->view('main', $main);
	}

	function do_confirm_vote()
	{
		$error = array();
		if ($this->settings['captcha'])
		{
			$captcha = $this->input->post('captcha');
			if (empty($captcha))
			{
				$error[] = e('voter_confirm_vote_no_captcha');
			}
			else
			{
				$word = $this->session->userdata('word');
				if ($captcha != $word)
					$error[] = e('voter_confirm_vote_not_captcha');
			}
		}
		if ($this->settings['pin'])
		{
			$pin = $this->input->post('pin');
			if (empty($pin))
			{
				$error[] = e('voter_confirm_vote_no_pin');
			}
			else
			{
				if (sha1($pin) != $this->voter['pin'])
					$error[] = e('voter_confirm_vote_not_pin');
			}
		}
		if (empty($error))
		{
			$this->load->model('Boter');
			$this->load->model('Vote');
			$voter_id = $this->voter['id'];
			$timestamp = date("Y-m-d H:i:s");
			$votes = $this->session->userdata('votes');
			foreach ($votes as $candidate_ids)
			{
				foreach ($candidate_ids as $candidate_id)
				{
					if (!empty($candidate_id))
						$this->Vote->insert(compact('candidate_id', 'voter_id', 'timestamp'));
				}
			}
			$this->Boter->update(array('voted'=>TRUE), $voter_id);
			$this->session->unset_userdata('votes');
			redirect('voter/logout');
		}
		else
		{
			$this->session->set_flashdata('error', $error);
			redirect('voter/confirm_vote');
		}
	}

	function logout()
	{
		$this->load->model('Boter');
		$this->Boter->update(array('logout'=>date("Y-m-d H:i:s")), $this->voter['id']);
		setcookie('halalan_cookie', '', time() - 3600, '/'); // destroy cookie
		$this->session->sess_destroy();
		$main['title'] = e('voter_logout_title');
		$main['meta'] = '<meta http-equiv="refresh" content="5;URL=' . base_url() . '" />';
		$main['body'] = $this->load->view('voter/logout', '', TRUE);
		$this->load->view('main', $main);
	}

}

?>