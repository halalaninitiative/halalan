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
		$this->load->model('Boter');
		
		$data['username'] = $this->admin['username'];		
		$data['voters'] = $this->Boter->get_voters_list();		
		$data['unit'] = $this->settings['unit'];
		
		$main['title'] = e('admin_voters_title');
		$main['body'] = $this->load->view('admin/voters', $data, TRUE);
		
		$this->load->view('main', $main);
		
		
	}
	
	function edit($type, $id) 
	{
	
		$data['username'] = $this->admin['username'];
		switch($type) 
		{
		
			case 'voter': 
			{
			
				$this->load->model('Boter');
			
				$data['voter'] = $this->Boter->select($id);
				
				$main['title'] = e('admin_edit_voters_title');
				$main['body'] = $this->load->view('admin/edit_voters', $data, TRUE);
				break;
			}			
		
		}
		
		$this->load->view('main', $main);
	
	}
	
	function add($type)
	{
	
		$data['username'] = $this->admin['username'];
		if($error = $this->session->flashdata('error'))
		{
			$data['messages'] = $error;
		}
		else if($success = $this->session->flashdata('success'))
		{
			$data['messages'] = $success;
		}
		switch($type) 
		{
		
			case 'voter': 
			{
			
				$main['title'] = e('add_voter');
				$main['body'] = $this->load->view('admin/add_voter', $data, TRUE);
				break;
							
			}
		
		}
		$this->load->view('main', $main);
	
	}
	
	function confirm_add_voter() 
	{
		$this->load->model('Boter');
		
		$error = array();
		if( $this->input->post('username') == '' || $this->input->post('username') == null ) 
		{
			$error[] = e('add_voter_no_username');
		}
		else
		{			
			if( $test = $this->Boter->select_by_username($this->input->post('username')) ) 
			{
				$error[] = e('add_voter_exists') . ' (' . $test['username'] . ')';
			}
		}
		
		if( $this->input->post('last_name') == '' || $this->input->post('last_name') == null )
		{
			$error[] = e('add_voter_no_lastname');
		}
		if( $this->input->post('first_name') == '' || $this->input->post('first_name') == null )
		{
			$error[] = e('add_voter_no_firstname');
		}
		
		if(empty($error))
		{
			$ret = $this->generate_pin_password();
			$entity = array(
				'username' => $this->input->post('username'),
				'last_name' => $this->input->post('last_name'),
				'first_name' => $this->input->post('first_name'),
				'pin' => $ret['pin'],
				'password' => $ret['password'],
				'voted' => FALSE
				
			);			
			$this->Boter->add($entity);
			$success = array();
			$success[] = e('add_voter_success');
			if($this->settings['password_pin_generation'] == 'web')
			{				
				$success[] = 'Username: '. $entity['username'];
				$success[] = 'Password: '. $entity['password'];
				$success[] = 'PIN: '. $entity['pin'];
				
			}
			$this->session->set_flashdata('success', $success);
			
		}
		else
		{			
			$this->session->set_flashdata('error', $error);
			
		}
		redirect('admin/add/voter');
		
	}
	
	function generate_pin_password()
	{		
		$pool = '';
		if($this->settings['password_pin_characters'] == 'alnum') 
		{
			$pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		}
		else if($this->settings['password_pin_characters'] == 'numeric')
		{
			$pool = '0123456789';
		}
		else if($this->settings['password_pin_characters'] == 'nozero')
		{
			$pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
		}
		
		srand(time());
		
		$length = $this->settings['pin_length'];
		$ret['pin'] = '';		
		for($i = 0; $i < $length; $i += 1)
		{
			$index = (rand() % strlen($pool));
			$ret['pin'] = $ret['pin'] . $pool[$index];
		}
		
		$length = $this->settings['password_length'];
		$ret['password'] = '';		
		for($i = 0; $i < $length; $i += 1)
		{
			$index = (rand() % strlen($pool));
			$ret['password'] = $ret['password'] . $pool[$index];
		}
		
		return $ret;
	}
	
	
}

?>