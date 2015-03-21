<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {

	public function index()
	{
		// TODO: check system requirements like PHP GD, etc.
		$this->load->database();
		if (strlen($this->config->item('encryption_key')) != 32)
		{
			$error = '<p>It looks like $config[\'encryption_key\'] is not set.';
			$error .= ' Please set it in application/config/config.php.</p>';
			$error .= '<p>See user_guide/libraries/encryption.html for more details.</p>';
			show_error($error);
		}
		if ($this->db->table_exists('admins')) // Maybe we should check all the tables?
		{
			$error = '<p>It looks like Halalan is already installed.';
			$error .= ' Please remove application/controllers/install.php to continue.</p>';
			show_error($error);
		}

		$this->load->library('form_validation');
		$this->load->helper(array('file', 'form', 'halalan', 'password', 'url'));

		$installed = FALSE;
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
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
			$admin['admin_id'] = 1;
			$admin['type'] = 'super';
			$this->db->insert('admins', $admin);

			$installed = TRUE;
		}
		$data['installed'] = $installed;
		$this->load->view('install', $data);
	}

}

/* End of file install.php */
/* Location: ./application/controllers/install.php */
