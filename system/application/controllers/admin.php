<?php

class Admin extends Controller {

	function Admin()
	{
		parent::Controller();
		
		$this->admin = $this->session->userdata('admin');
		if (!$this->admin)
		{
			$this->session->set_flashdata('login', e('unauthorized'));
			redirect('gate/admin');
		}
	}

	function index() {
		
	}
	
	function manage() {
	
		$main['title'] = e('admin_title');
		$main['body'] = $this->load->view('admin/manage', );
		
		$this->load->view('main', $main);
	
	}
	
	
}

?>