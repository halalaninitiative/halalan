<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins extends MY_Controller {

	public function index()
	{
		$where = array('admin_id' => $this->admin['id']);
		$data['admins'] = $this->Abmin->select_all_where($where);
		$admin['title'] = 'Manage Admins';
		$admin['body'] = $this->load->view('admin/admins', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

	public function add()
	{
		$admin = array('username' => '', 'last_name' => '', 'first_name' => '', 'email' => '', 'type' => 'election');
		$this->_admin($admin, 'add');
	}

	public function edit($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'admin_id' => $this->admin['id']);
		$admin = $this->Abmin->select_where($where);
		if ( ! $admin)
		{
			show_404();
		}
		$this->_admin($admin, 'edit', $id);
	}

	public function delete($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'admin_id' => $this->admin['id']);
		$admin = $this->Abmin->select_where($where);
		if ( ! $admin)
		{
			show_404();
		}
		$this->Abmin->delete($id);
		$this->session->set_flashdata('messages', array('success', 'The admin has been successfully deleted.'));
		redirect('admin/admins');
	}

	public function _admin($abmin, $action, $id = NULL)
	{
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique_x[' . $action . '.admins.username.' . $id . ']');
		$this->form_validation->set_rules('last_name', 'Last name', 'required');
		$this->form_validation->set_rules('first_name', 'First name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('type', 'Type');
		if ($this->form_validation->run())
		{
			$abmin['admin_id'] = $this->admin['id'];
			$abmin['username'] = $this->input->post('username', TRUE);
			$abmin['last_name'] = $this->input->post('last_name', TRUE);
			$abmin['first_name'] = $this->input->post('first_name', TRUE);
			$abmin['email'] = $this->input->post('email', TRUE);
			if ($this->admin['type'] == 'super')
			{
				$abmin['type'] = $this->input->post('type');
			}
			else
			{
				$abmin['type'] = 'election';
			}
			if ($action == 'add' OR $this->input->post('regenerate'))
			{
				$password = random_string('alnum', 8);
				$abmin['password'] = password_hash($password, PASSWORD_DEFAULT);
			}
			if ($action == 'add')
			{
				$this->Abmin->insert($abmin);
				$messages[] = 'success';
				$messages[] = 'The admin has been successfully added.';
				$messages[] = 'Password: ' . $password;
				$this->session->set_flashdata('messages', $messages);
				redirect('admin/admins/add');
			}
			else if ($action == 'edit')
			{
				$this->Abmin->update($abmin, $id);
				$messages[] = 'success';
				$messages[] = 'The admin has been successfully edited.';
				if ($this->input->post('regenerate'))
				{
					$messages[] = 'New password: ' . $password;
				}
				$this->session->set_flashdata('messages', $messages);
				redirect('admin/admins/edit/' . $id);
			}
		}
		$data['admin'] = $abmin;
		$data['action'] = $action;
		$admin['title'] = ucfirst($action) . ' Admin';
		$admin['body'] = $this->load->view('admin/admin', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

}

/* End of file admins.php */
/* Location: ./application/controllers/admin/admins.php */
