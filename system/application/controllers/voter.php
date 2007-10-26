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
		$vote['username'] = $this->voter['username'];
		$main['body'] = $this->load->view('voter/vote', $vote, TRUE);
		$this->load->view('main', $main);
	}

}
?>