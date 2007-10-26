<?php

class Voter extends Controller {

	function Voter()
	{
		parent::Controller();
		if (!$this->session->userdata('voter'))
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
		$main['body'] = $this->load->view('voter/vote', '', TRUE);
		$this->load->view('main', $main);
	}

}
?>