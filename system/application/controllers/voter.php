<?php

class Voter extends Controller {

	var $voter;

	function Voter()
	{
		parent::Controller();
		$this->voter = $this->session->userdata('voter');
		if (!$this->voter)
		{
			$this->session->set_flashdata('login', e('unauthorized'));
			redirect('gate');
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
		$positions = $this->Position->select_all();
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
			$data['message'] = $error;
		if ($votes = $this->session->userdata('votes'))
			$data['votes'] = $votes;
		$data['positions'] = $positions;
		$data['username'] = $this->voter['username'];
		$main['title'] = e('vote_title');
		$main['body'] = $this->load->view('voter/vote', $data, TRUE);
		$this->load->view('main', $main);
	}

	function do_vote()
	{
		$error = '';
		$votes = $this->input->post('votes');
		// check if there are selected candidates
		if (empty($votes))
		{
			$error = e('vote_no_selected');
		}
		else
		{
			// check if all positions have selected candidates
			$this->load->model('Position');
			// TODO: add here if units are enabled
			$positions = $this->Position->select_all();
			if (count($positions) != count($votes))
			{
				$error = e('vote_not_all_selected');
			}
			else
			{
				foreach ($votes as $position_id => $candidate_ids)
				{
					// check if the number of selected candidates does not exceed the maximum allowed for each position
					$position = $this->Position->select($position_id);
					if ($position['maximum'] < count($candidate_ids))
					{
						$error = e('vote_maximum');
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
		$this->load->model('Candidate');
		$this->load->model('Party');
		$this->load->model('Position');
		$positions = $this->Position->select_all();
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
			$data['message'] = $error;
		$votes = $this->session->userdata('votes');
		$data['votes'] = $votes;
		$this->load->plugin('captcha');
		$vals = array('img_path'=>'./public/captcha/', 'img_url'=>base_url() . 'public/captcha/', 'font_path'=>'./public/fonts/Vera.ttf', 'img_width'=>150, 'img_height'=>60);
		$captcha = create_captcha($vals);
		$data['captcha'] = $captcha;
		$data['positions'] = $positions;
		$data['username'] = $this->voter['username'];
		$main['title'] = e('confirm_vote_title');
		$main['body'] = $this->load->view('voter/confirm_vote', $data, TRUE);
		$this->load->view('main', $main);
	}

	function do_confirm_vote()
	{
	}

}
?>