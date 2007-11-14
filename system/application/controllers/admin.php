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
		$this->settings = $this->config->item('election');
	}

	function index() 
	{
		redirect('admin/manage');
	}
	
	function manage() 
	{
	
		$data['username'] = $this->admin['username'];
	
		$main['title'] = e('admin_title');
		$main['body'] = $this->load->view('admin/manage', $data, TRUE);
		
		$this->load->view('main', $main);
	
	}
	
	function voters() 
	{
		$this->load->model('Abmin');
		$this->load->model('Boter');
		
		$data['username'] = $this->admin['username'];
		$data['voters'] = $this->Boter->get_voters_list();		
		$data['unit'] = $this->settings['unit'];
		
// 		$voters_list = $this->Boter->get_voters_list();
// 		foreach($voters_list as $voter_id => $voter) {
// 			$voters_list[$voter_id];
// 		}
		
		$main['title'] = e('admin_voters_title');
		$main['body'] = $this->load->view('admin/voters', $data, TRUE);
		
		$this->load->view('main', $main);
		
		
	}
	
	
}

?>