<?php

class Parties extends Controller {

	var $admin;
	var $settings;

	function Parties()
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
		$this->load->model('Party');
		$data['parties'] = $this->Party->select_all();
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_parties_title');
		$admin['body'] = $this->load->view('admin/parties', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function add()
	{
		$admin = $this->_party('add');
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function do_add()
	{
		$this->_do_party('add');
	}

	function edit($id)
	{
		$admin = $this->_party('edit', $id);
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function do_edit($id = null)
	{
		$this->_do_party('edit', $id);
	}

	function delete($id) 
	{
		if (!$id)
			redirect('admin/parties');
		$this->load->model('Party');
		if ($this->Party->in_use($id))
		{
			$this->session->set_flashdata('error', array(e('admin_delete_party_in_use')));
		}
		else
		{
			$this->Party->delete($id);
			$this->session->set_flashdata('success', array(e('admin_delete_party_success')));
		}
		redirect('admin/parties');
	}

	function _party($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			if ($case == 'add')
			{
				$data['party'] = array('party'=>'', 'alias'=>'', 'description'=>'');
			}
			else if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/parties');
				$this->load->model('Party');
				$data['party'] = $this->Party->select($id);
				if (!$data['party'])
					redirect('admin/parties');
			}
			$messages = $this->_get_messages();
			$data['messages'] = $messages['messages'];
			$data['message_type'] = $messages['message_type'];
			if ($party = $this->session->flashdata('party'))
			{
				$data['party'] = $party;
			}
			$data['action'] = $case;
			$admin['title'] = e('admin_' . $case . '_party_title');
			$admin['body'] = $this->load->view('admin/party', $data, TRUE);
			return $admin;
		}
		else
		{
			redirect('admin/parties');
		}
	}

	function _do_party($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			$this->load->model('Party');
			if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/parties');
				$party = $this->Party->select($id);
				if (!$party)
					redirect('admin/parties');
			}
			$error = array();
			$party['party'] = $this->input->post('party', TRUE);
			$party['alias'] = $this->input->post('alias', TRUE);
			$party['description'] = $this->input->post('description', TRUE);
			if (!$party['party'])
			{
				$error[] = e('admin_party_no_party');
			}
			else
			{
				if ($test = $this->Party->select_by_party($party['party']))
				{
					if ($case == 'add')
					{
						$error[] = e('admin_party_exists') . ' (' . $test['party'] . ')';
					}
					else if ($case == 'edit')
					{
						if ($test['id'] != $id)
						{
							$error[] = e('admin_party_exists') . ' (' . $test['party'] . ')';
						}
					}
				}
			}
			if ($_FILES['logo']['error'] != UPLOAD_ERR_NO_FILE)
			{
				$config['upload_path'] = HALALAN_UPLOAD_PATH . 'logos/';
				$config['allowed_types'] = HALALAN_ALLOWED_TYPES;
				$this->upload->initialize($config);
				if ($case == 'edit')
				{
					// delete old logo first
					unlink($config['upload_path'] . $party['logo']);
				}
				if (!$this->upload->do_upload('logo'))
				{
					$error[] = $this->upload->display_errors();
				}
				else
				{
					$upload_data = $this->upload->data();
					$return = $this->_resize($upload_data, 250);
					if (is_array($return))
						$error = array_merge($error, $return);
					else
						$party['logo'] = $return;
				}
			}
			if (empty($error))
			{
				if ($case == 'add')
				{
					$this->Party->insert($party);
					$success[] = e('admin_add_party_success');
				}
				else if ($case == 'edit')
				{
					$this->Party->update($party, $id);
					$success[] = e('admin_edit_party_success');
				}
				$this->session->set_flashdata('success', $success);
			}
			else
			{
				$this->session->set_flashdata('party', $party);
				$this->session->set_flashdata('error', $error);
			}
			if ($case == 'add')
			{
				redirect('admin/parties/add');
			}
			else if ($case == 'edit')
			{
				redirect('admin/parties/edit/' . $id);
			}
		}
		else
		{
			redirect('admin/parties');
		}
	}

	function _resize($upload_data, $n)
	{
		$width = $upload_data['image_width'];
		$height = $upload_data['image_height'];
		if ($width > $n || $height > $n)
		{
			$config['source_image'] = $upload_data['full_path'];
			$config['quality'] = '100%';
			$config['width'] = $n;
			$config['height'] = (($n*$height)/$width);
			$this->image_lib->initialize($config);
			if (!$this->image_lib->resize())
			{
				$error[] = $this->image_lib->display_errors();
			}
			else
			{
				$name = $upload_data['file_name'];
			}
		}
		else
		{
			$name = $upload_data['file_name'];
		}
		if (empty($error))
			return $name;
		else
			return $error;
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

/* End of file parties.php */
/* Location: ./system/application/controllers/admin/parties.php */