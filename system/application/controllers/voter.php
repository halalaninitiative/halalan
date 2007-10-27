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
		$vote['positions'] = $positions;
		$vote['username'] = $this->voter['username'];
		$main['body'] = $this->load->view('voter/vote', $vote, TRUE);
		$this->load->view('main', $main);
	}

}
?>