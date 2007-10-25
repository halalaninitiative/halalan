<?php

class Voter extends Controller {

	function Voter()
	{
		parent::Controller();
	}
	
	function index()
	{
		$main['body'] = $this->load->view('voter/vote', '', TRUE);
		$this->load->view('main', $main);
	}

}
?>