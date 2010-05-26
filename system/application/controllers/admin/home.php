<?php

class Home extends Controller {

	var $admin;
	var $settings;

	function Home()
	{
		parent::Controller();
		$this->admin = $this->session->userdata('admin');
		if (!$this->admin)
		{
			$this->session->set_flashdata('messages', array('negative', e('common_unauthorized')));
			redirect('gate/admin');
		}
		$this->settings = $this->config->item('halalan');
	}
	
	function index()
	{
		$this->load->model('Option');
		$data['option'] = $this->Option->select(1);
		$data['settings'] = $this->settings;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_home_title');
		$admin['body'] = $this->load->view('admin/home', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function do_edit_option($id)
	{
		if (!$id)
			redirect('admin/home');
		$this->load->model('Option');
		$option = $this->Option->select($id);
		if (!$option)
			redirect('admin/home');
		$option['status'] = $this->input->post('status', TRUE);
		$option['result'] = $this->input->post('result', TRUE);
		$this->Option->update($option, $id);
		$this->session->set_flashdata('messages', array('positive', e('admin_edit_option_success')));
		redirect('admin/home');
	}

	function do_regenerate()
	{
		$error = array();
		if (!$this->input->post('username'))
		{
			if ($this->settings['password_pin_generation'] == 'web')
				$error[] = e('admin_regenerate_no_username');
			else if ($this->settings['password_pin_generation'] == 'email')
				$error[] = e('admin_regenerate_no_email');
		}
		else
		{
			if (!$voter = $this->Boter->select_by_username($this->input->post('username')))
			{
				$error[] = e('admin_regenerate_not_exists');
			}
		}
		if ($this->settings['password_pin_generation'] == 'email')
		{
			if (!$this->form_validation->valid_email($this->input->post('username')))
			{
				$error[] = e('admin_regenerate_invalid_email');
			}
		}
		if (empty($error))
		{
			$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
			$voter['password'] = sha1($password);
			if ($this->settings['pin'])
			{
				if ($this->input->post('pin'))
				{
					$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
					$voter['pin'] = sha1($pin);
				}
			}
			if ($this->input->post('login'))
			{
				$voter['login'] = NULL;
			}
			$this->Boter->update($voter, $voter['id']);
			$success = array();
			$success[] = e('admin_regenerate_success');
			if ($this->settings['password_pin_generation'] == 'web')
			{
				$success[] = 'Username: '. $voter['username'];
				$success[] = 'Password: '. $password;
				if ($this->settings['pin'])
				{
					if ($this->input->post('pin'))
						$success[] = 'PIN: '. $pin;
				}
			}
			else if ($this->settings['password_pin_generation'] == 'email')
			{
				$this->email->from($this->admin['email'], $this->admin['first_name'] . ' ' . $this->admin['last_name']);
				$this->email->to($voter['username']);
				$this->email->subject($this->settings['name'] . ' Login Credentials');
				$message = "Hello $voter[first_name] $voter[last_name],\n\nThe following are your login credentials:\nEmail: $voter[username]\n";
				$message .= "Password: $password\n";
				if ($this->settings['pin'])
				{
					if ($this->input->post('pin'))
						$message .= "PIN: $pin\n";
				}
				$message .= "\n";
				$message .= ($this->admin['first_name'] . ' ' . $this->admin['last_name']);
				$message .= "\n";
				$message .= $this->settings['name'] . ' Administrator';
				$this->email->message($message);
				$this->email->send();
				//echo $this->email->print_debugger();
				$success[] = e('admin_regenerate_email_success');
			}
			$this->session->set_flashdata('messages', array_merge(array('positive'), $success));
		}
		else
		{
			$this->session->set_flashdata('messages', array_merge(array('negative'), $error));
		}
		redirect('admin/home');
	}

}

/* End of file home.php */
/* Location: ./system/application/controllers/admin/home.php */
