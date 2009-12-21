<?php

class Positions extends Controller {

	var $admin;
	var $settings;

	function Positions()
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
		$this->load->model('Option');
		$option = $this->Option->select(1);
		if ($option['status'])
		{
			$error[] = e('admin_common_running_one');
			$error[] = e('admin_common_running_two');
			$this->session->set_flashdata('error', $error);
			redirect('admin/home');
		}
	}
	
	function index()
	{
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
		$this->load->model('Position');
		$data['positions'] = $this->Position->select_all();
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_positions_title');
		$admin['body'] = $this->load->view('admin/positions', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function add()
	{
		$admin = $this->_position('add');
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function do_add()
	{
		$this->_do_position('add');
	}

	function edit($id)
	{
		$admin = $this->_position('edit', $id);
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function do_edit($id = null)
	{
		$this->_do_position('edit', $id);
	}

	function delete($id) 
	{
		if (!$id)
			redirect('admin/positions');
		$this->load->model('Position');
		if ($this->Position->in_use($id))
		{
			$this->session->set_flashdata('error', array(e('admin_delete_position_in_use')));
		}
		else
		{
			$this->Position->delete($id);
			$this->session->set_flashdata('success', array(e('admin_delete_position_success')));
		}
		redirect('admin/positions');
	}

	function _position($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			if ($case == 'add')
			{
				$data['position'] = array('position'=>'', 'description'=>'', 'maximum'=>'', 'ordinality'=>'', 'abstain'=>1, 'unit'=>0);
			}
			else if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/positions');
				$this->load->model('Position');
				$data['position'] = $this->Position->select($id);
				if (!$data['position'])
					redirect('admin/positions');
			}
			$messages = $this->_get_messages();
			$data['messages'] = $messages['messages'];
			$data['message_type'] = $messages['message_type'];
			if ($position = $this->session->flashdata('position'))
			{
				$data['position'] = $position;
			}
			$data['action'] = $case;
			$admin['title'] = e('admin_' . $case . '_position_title');
			$admin['body'] = $this->load->view('admin/position', $data, TRUE);
			return $admin;
		}
		else
		{
			redirect('admin/positions');
		}
	}

	function _do_position($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			$this->load->model('Position');
			if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/positions');
				$position = $this->Position->select($id);
				if (!$position)
					redirect('admin/positions');
			}
			$error = array();
			$position['position'] = $this->input->post('position', TRUE);
			$position['description'] = $this->input->post('description', TRUE);
			$position['maximum'] = $this->input->post('maximum', TRUE);
			$position['ordinality'] = $this->input->post('ordinality', TRUE);
			$position['abstain'] = $this->input->post('abstain', TRUE);
			$position['unit'] = $this->input->post('unit', TRUE);
			if (!$position['position'])
			{
				$error[] = e('admin_position_no_position');
			}
			else
			{
				if ($test = $this->Position->select_by_position($position['position']))
				{
					if ($case == 'add')
					{
						$error[] = e('admin_position_exists') . ' (' . $test['position'] . ')';
					}
					else if ($case == 'edit')
					{
						if ($test['id'] != $id)
						{
							$error[] = e('admin_position_exists') . ' (' . $test['position'] . ')';
						}
					}
				}
			}
			if (!$position['maximum'])
			{
				$error[] = e('admin_position_no_maximum');
			}
			else
			{
				if (!ctype_digit($position['maximum']))
					$error[] = e('admin_position_maximum_not_digit');
			}
			if (!$position['ordinality'])
			{
				$error[] = e('admin_position_no_ordinality');
			}
			else
			{
				if (!ctype_digit($position['ordinality']))
					$error[] = e('admin_position_ordinality_not_digit');
			}
			if (empty($error))
			{
				if ($case == 'add')
				{
					$this->Position->insert($position);
					$success[] = e('admin_add_position_success');
				}
				else if ($case == 'edit')
				{
					$this->Position->update($position, $id);
					$success[] = e('admin_edit_position_success');
				}
				$this->session->set_flashdata('success', $success);
			}
			else
			{
				$this->session->set_flashdata('position', $position);
				$this->session->set_flashdata('error', $error);
			}
			if ($case == 'add')
			{
				redirect('admin/positions/add');
			}
			else if ($case == 'edit')
			{
				redirect('admin/positions/edit/' . $id);	
			}
		}
		else
		{
			redirect('admin/positions');
		}
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

/* End of file positions.php */
/* Location: ./system/application/controllers/admin/positions.php */