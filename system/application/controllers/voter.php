<?php

class Voter extends Controller {

	var $voter;
	var $settings;

	function Voter()
	{
		parent::Controller();
		if ($this->uri->segment(2) != 'votes' && $this->uri->segment(2) != 'print_votes')
		{
			$this->voter = $this->session->userdata('voter');
			if (!$this->voter)
			{
				$error[] = e('common_unauthorized');
				$this->session->set_flashdata('error', $error);
				redirect('gate/voter');
			}
		}
		else
		{
			if (!$this->session->userdata('voter_id'))
			{
				$error[] = e('common_unauthorized');
				$this->session->set_flashdata('error', $error);
				redirect('gate/voter');
			}
		}
		$this->settings = $this->config->item('halalan');
		$this->load->model('Option');
		$option = $this->Option->select(1);
		if (!$option['status'])
		{
			//$error[] = e('voter_common_not_running_one');
			//$error[] = e('voter_common_not_running_two');
			//$this->session->set_flashdata('error', $error);
			//redirect('gate/voter');
			//force logout
			redirect('gate/logout');
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
			if ($this->settings['random_order'])
			{
				$in_session = $this->session->userdata('position_' . $position['id']);
				if ($in_session)
				{
					$candidate_ids = array_flip($in_session);
					$shuffled_candidates = array();
				}
				else
				{
					$candidate_ids = array();
					shuffle($candidates);
				}
			}
			foreach ($candidates as $candidate_id=>$candidate)
			{
				$candidates[$candidate_id]['party'] = $this->Party->select($candidate['party_id']);
				if ($this->settings['random_order'])
				{
					if ($in_session)
					{
						$shuffled_candidates[$candidate_ids[$candidate['id']]] = $candidate;
					}
					else
					{
						$candidate_ids[] = $candidate['id'];
					}
				}
			}
			if ($this->settings['random_order'])
			{
				if ($in_session)
				{
					ksort($shuffled_candidates);
					$candidates = $shuffled_candidates;
				}
				else
				{
					$this->session->set_userdata('position_' . $position['id'], $candidate_ids);
				}
			}
			$positions[$key]['candidates'] = $candidates;
		}
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
		if (count($positions) == 0)
			$data['none'] = e('voter_vote_no_candidates');
		if ($votes = $this->session->userdata('votes'))
			$data['votes'] = $votes;
		$data['settings'] = $this->settings;
		$data['positions'] = $positions;
		$voter['username'] = $this->voter['username'];
		$voter['title'] = e('voter_vote_title');
		$voter['body'] = $this->load->view('voter/vote', $data, TRUE);
		$this->load->view('voter', $voter);
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
			redirect('voter/verify');
		}
		else
		{
			$this->session->set_flashdata('error', $error);
			redirect('voter/vote');
		}
	}

	function verify()
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
			if ($this->settings['random_order'])
			{
				$candidate_ids = array_flip($this->session->userdata('position_' . $position['id']));
				$shuffled_candidates = array();
			}
			$candidates = $this->Candidate->select_all_by_position_id($position['id']);
			foreach ($candidates as $candidate_id=>$candidate)
			{
				$candidates[$candidate_id]['party'] = $this->Party->select($candidate['party_id']);
				if ($this->settings['random_order'])
				{
					$shuffled_candidates[$candidate_ids[$candidate['id']]] = $candidate;
				}
			}
			if ($this->settings['random_order'])
			{
				ksort($shuffled_candidates);
				$candidates = $shuffled_candidates;
			}
			$positions[$key]['candidates'] = $candidates;
		}
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
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
		$voter['username'] = $this->voter['username'];
		$voter['title'] = e('voter_confirm_vote_title');
		$voter['body'] = $this->load->view('voter/confirm_vote', $data, TRUE);
		$this->load->view('voter', $voter);
	}

	function do_verify()
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
			$this->load->model('Abstain');
			$this->load->model('Boter');
			$this->load->model('Vote');
			$voter_id = $this->voter['id'];
			$timestamp = date("Y-m-d H:i:s");
			$votes = $this->session->userdata('votes');
			foreach ($votes as $position_id=>$candidate_ids)
			{
				$abstain = FALSE;
				foreach ($candidate_ids as $candidate_id)
				{
					if (empty($candidate_id))
					{
						$abstain = TRUE;
					}
					else
					{
						$this->Vote->insert(compact('candidate_id', 'voter_id', 'timestamp'));
					}
				}
				if ($abstain)
				{
					$this->Abstain->insert(compact('position_id', 'voter_id', 'timestamp'));
				}
			}
			$this->Boter->update(array('voted'=>TRUE), $voter_id);
			$this->session->unset_userdata('votes');
			redirect('voter/logout');
		}
		else
		{
			$this->session->set_flashdata('error', $error);
			redirect('voter/verify');
		}
	}

	function logout()
	{
		$this->load->model('Boter');
		$this->Boter->update(array('logout'=>date("Y-m-d H:i:s")), $this->voter['id']);
		setcookie('halalan_cookie', '', time() - 3600, '/'); // destroy cookie
		$this->session->sess_destroy();
		$voter['title'] = e('voter_logout_title');
		$voter['meta'] = '<meta http-equiv="refresh" content="5;URL=' . base_url() . '" />';
		$voter['body'] = $this->load->view('voter/logout', '', TRUE);
		$this->load->view('voter', $voter);
	}

	function votes()
	{
		$voter_id = $this->session->userdata('voter_id');
		$this->load->model('Abstain');
		$this->load->model('Boter');
		$this->load->model('Candidate');
		$this->load->model('Party');
		$this->load->model('Position');
		$this->load->model('Vote');
		$votes = $this->Vote->select_all_by_voter_id($voter_id);
		$candidate_ids = array();
		foreach ($votes as $vote)
		{
			$candidate_ids[] = $vote['candidate_id'];
		}
		$positions = $this->Position->select_all_with_units($voter_id);
		foreach ($positions as $key=>$position)
		{
			$count = 0;
			$candidates = $this->Candidate->select_all_by_position_id($position['id']);
			foreach ($candidates as $k=>$candidate)
			{
				if (in_array($candidate['id'], $candidate_ids))
				{
					$candidates[$k]['voted'] = TRUE;
				}
				else
				{
					$candidates[$k]['voted'] = FALSE;
					$count++;
				}
				$candidates[$k]['party'] = $this->Party->select($candidate['party_id']);
			}
			if ($count == count($candidates))
			{
				$positions[$key]['abstains'] = TRUE;
			}
			else
			{
				$positions[$key]['abstains'] = FALSE;
			}
			$positions[$key]['candidates'] = $candidates;
		}
		$voter = $this->Boter->select($voter_id);
		$data['settings'] = $this->settings;
		$data['positions'] = $positions;
		// used for marking that this action is being used
		$voter['voter_id'] = $voter_id;
		$voter['username'] = $voter['username'];
		$voter['title'] = e('voter_votes_title');
		$voter['body'] = $this->load->view('voter/votes', $data, TRUE);
		$this->load->view('voter', $voter);
	}

	function print_votes()
	{
		$voter_id = $this->session->userdata('voter_id');
		$this->load->model('Abstain');
		$this->load->model('Boter');
		$this->load->model('Candidate');
		$this->load->model('Party');
		$this->load->model('Position');
		$this->load->model('Vote');
		$votes = $this->Vote->select_all_by_voter_id($voter_id);
		$candidate_ids = array();
		foreach ($votes as $vote)
		{
			$candidate_ids[] = $vote['candidate_id'];
		}
		$positions = $this->Position->select_all_with_units($voter_id);
		foreach ($positions as $key=>$position)
		{
			$count = 0;
			$candidates = $this->Candidate->select_all_by_position_id($position['id']);
			foreach ($candidates as $k=>$candidate)
			{
				if (in_array($candidate['id'], $candidate_ids))
				{
					$candidates[$k]['voted'] = TRUE;
				}
				else
				{
					$candidates[$k]['voted'] = FALSE;
					$count++;
				}
				$candidates[$k]['party'] = $this->Party->select($candidate['party_id']);
			}
			if ($count == count($candidates))
			{
				$positions[$key]['abstains'] = TRUE;
			}
			else
			{
				$positions[$key]['abstains'] = FALSE;
			}
			$positions[$key]['candidates'] = $candidates;
		}
		$voter = $this->Boter->select($voter_id);
		$data['settings'] = $this->settings;
		$data['positions'] = $positions;
		$data['voter'] = $voter;
		$data['settings'] = $this->settings;
		$this->load->view('voter/print_votes', $data);
	}

	function _get_messages()
	{
		$messages = '';
		$message_type = '';
		if($error = $this->session->flashdata('error'))
		{
			$messages = $error;
			$message_type = 'negative';
		}
		else if($success = $this->session->flashdata('success'))
		{
			$messages = $success;
			$message_type = 'positive';
		}
		return array('messages'=>$messages, 'message_type'=>$message_type);
	}

}

?>