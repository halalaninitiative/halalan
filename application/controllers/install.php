<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// TODO: check system requirements like PHP GD, etc.
		$this->load->database();
		if ($this->db->table_exists('admins')) // Maybe we should check all the tables?
		{
			$error = '<p>It looks like Halalan is already installed.';
			$error .= ' Please remove application/controllers/install.php to continue.</p>';
			show_error($error);
		}

		$this->load->library('form_validation');
		$this->load->helper(array('file', 'form', 'halalan', 'password', 'string', 'url'));

		$installed = FALSE;
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password_pin_generation', 'Password/PIN Generation', 'required');
		$this->form_validation->set_rules('password_pin_characters', 'Password/PIN Characters', 'required');
		$this->form_validation->set_rules('password_length', 'Password Length', 'required');
		$this->form_validation->set_rules('pin', 'PIN');
		$pin = $this->input->post('pin');
		if ($pin)
		{
			$this->form_validation->set_rules('pin_length', 'PIN Length', 'required');
		}
		$this->form_validation->set_rules('captcha', 'CAPTCHA');
		$captcha = $this->input->post('captcha');
		if ($captcha)
		{
			$this->form_validation->set_rules('captcha_length', 'CAPTCHA Length', 'required');
		}
		$this->form_validation->set_rules('image_trail', 'Virtual Paper Trail');
		$image_trail = $this->input->post('image_trail');
		if ($image_trail)
		{
			$this->form_validation->set_rules('image_trail_path', 'Virtual Paper Trail Path', 'required');
		}
		$this->form_validation->set_rules('details', 'Candidate Details');
		if ($this->form_validation->run())
		{
			$sqls = explode(';', read_file('./halalan.sql'));
			foreach ($sqls as $sql)
			{
				$sql = trim($sql);
				if ( ! empty($sql))
				{
					$this->db->query($sql);
				}
			}

			$admin['username'] = $this->input->post('username', TRUE);
			$password = $this->input->post('password');
			$admin['password'] = password_hash($password, PASSWORD_DEFAULT);
			$admin['first_name'] = $this->input->post('first_name', TRUE);
			$admin['last_name'] = $this->input->post('last_name', TRUE);
			$admin['email'] = $this->input->post('email', TRUE);
			$this->db->insert('admins', $admin);

			$data['password_pin_generation'] = $this->input->post('password_pin_generation');
			$data['password_pin_characters'] = $this->input->post('password_pin_characters');
			$data['password_length'] = $this->input->post('password_length');
			$data['pin'] = $pin ? 'TRUE' : 'FALSE';
			$data['pin_length'] = $this->input->post('pin_length');
			$data['captcha'] = $captcha ? 'TRUE' : 'FALSE';
			$data['captcha_length'] = $this->input->post('captcha_length');
			$data['image_trail'] = $image_trail ? 'TRUE' : 'FALSE';
			$data['image_trail_path'] = $this->input->post('image_trail_path');
			$data['details'] = $this->input->post('details') ? 'TRUE' : 'FALSE';
			$data['encryption_key'] = random_string('alnum', 32);

			$installed = TRUE;
		}
		$data['installed'] = $installed;
		$this->load->view('install', $data);
	}

}

/* End of file install.php */
/* Location: ./application/controllers/install.php */