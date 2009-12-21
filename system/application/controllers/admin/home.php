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
			$error[] = e('common_unauthorized');
			$this->session->set_flashdata('error', $error);
			redirect('gate/admin');
		}
		$this->settings = $this->config->item('halalan');
	}
	
	function index()
	{
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
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
		$this->load->model('Option');
		$this->Option->update($option, $id);
		$success[] = e('admin_edit_option_success');
		$this->session->set_flashdata('success', $success);
		redirect('admin/home');
	}

	function do_regenerate()
	{
		$this->load->model('Boter');
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
			if (!$this->_valid_email($this->input->post('username')))
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
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('error', $error);
		}
		redirect('admin/home');
	}

	// taken from CodeIgniter Validation Library
	function _valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
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

/* End of file home.php */
/* Location: ./system/application/controllers/admin/home.php */