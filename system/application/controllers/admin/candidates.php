<?php

class Candidates extends Controller {

	var $admin;
	var $settings;

	function Candidates()
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
		$this->load->model('Candidate');
		$this->load->model('Position');
		$positions = $this->Position->select_all();
		foreach ($positions as $key=>$value)
		{
			$positions[$key]['candidates'] = $this->Candidate->select_all_by_position_id($value['id']);
		}
		$data['positions'] = $positions;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_candidates_title');
		$admin['body'] = $this->load->view('admin/candidates', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function add()
	{
		$admin = $this->_candidate('add');
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function do_add()
	{
		$this->_do_candidate('add');
	}

	function edit($id)
	{
		$admin = $this->_candidate('edit', $id);
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function do_edit($id = null)
	{
		$this->_do_candidate('edit', $id);
	}

	function delete($id) 
	{
		if (!$id)
			redirect('admin/candidates');
		$this->load->model('Candidate');
		if ($this->Candidate->has_votes($id))
		{
			$this->session->set_flashdata('error', array(e('admin_delete_candidate_already_has_votes')));
		}
		else
		{
			$this->Candidate->delete($id);
			$this->session->set_flashdata('success', array(e('admin_delete_candidate_success')));
		}
		redirect('admin/candidates');
	}

	function _candidate($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			if ($case == 'add')
			{
				$data['candidate'] = array('first_name'=>'', 'last_name'=>'', 'alias'=>'', 'description'=>'', 'party_id'=>'0', 'position_id'=>'0');
			}
			else if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/candidates');
				$this->load->model('Candidate');
				$data['candidate'] = $this->Candidate->select($id);
				if (!$data['candidate'])
					redirect('admin/candidates');
			}
			$messages = $this->_get_messages();
			$data['messages'] = $messages['messages'];
			$data['message_type'] = $messages['message_type'];
			$this->load->model('Party');
			$parties = $this->Party->select_all();
			$tmp = array('0'=>'Select Party');
			foreach ($parties as $party)
			{
				$tmp[$party['id']] = $party['party'];
			}
			$data['parties'] = $tmp;
			$this->load->model('Position');
			$positions = $this->Position->select_all();
			$tmp = array('0'=>'Select Position');
			foreach ($positions as $position)
			{
				$tmp[$position['id']] = $position['position'];
			}
			$data['positions'] = $tmp;
			if ($candidate = $this->session->flashdata('candidate'))
			{
				$data['candidate'] = $candidate;
			}	
			$data['action'] = $case;
			$admin['title'] = e('admin_' . $case . '_candidate_title');
			$admin['body'] = $this->load->view('admin/candidate', $data, TRUE);
			return $admin;
		}
		else
		{
			redirect('admin/candidates');
		}
	}

	function _do_candidate($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			$this->load->model('Candidate');
			if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/candidates');
				$candidate = $this->Candidate->select($id);
				if (!$candidate)
					redirect('admin/candidates');
			}
			$error = array();
			$candidate['first_name'] = $this->input->post('first_name', TRUE);
			$candidate['last_name'] = $this->input->post('last_name', TRUE);
			$candidate['alias'] = $this->input->post('alias', TRUE);
			$candidate['description'] = $this->input->post('description', TRUE);
			$candidate['party_id'] = $this->input->post('party_id', TRUE);
			$candidate['position_id'] = $this->input->post('position_id', TRUE);
			if (!$candidate['first_name'])
			{
				$error[] = e('admin_candidate_no_first_name');
			}
			if (!$candidate['last_name'])
			{
				$error[] = e('admin_candidate_no_last_name');
			}
			if (!$candidate['position_id'])
			{
				$error[] = e('admin_candidate_no_position');
			}
			if ($candidate['first_name'] && $candidate['last_name'])
			{
				if ($test = $this->Candidate->select_by_name_and_alias($candidate['first_name'], $candidate['last_name'], $candidate['alias']))
				{
					if ($case == 'add')
					{
						$name = $test['last_name'] . ', ' . $test['first_name'];
						if (!empty($test['alias']))
							$name .= ' "' . $test['alias'] . '"';
						$error[] = e('admin_candidate_exists') . ' (' . $name . ')';
					}
					else if ($case == 'edit')
					{
						if ($test['id'] != $id)
						{
							$name = $test['last_name'] . ', ' . $test['first_name'];
							if (!empty($test['alias']))
								$name .= ' "' . $test['alias'] . '"';
							$error[] = e('admin_candidate_exists') . ' (' . $name . ')';
						}
					}
				}
			}
			if ($_FILES['picture']['error'] != UPLOAD_ERR_NO_FILE)
			{
				$config['upload_path'] = HALALAN_UPLOAD_PATH . 'pictures/';
				$config['allowed_types'] = HALALAN_ALLOWED_TYPES;
				$this->upload->initialize($config);
				if ($case == 'edit')
				{
					// delete old picture first
					unlink($config['upload_path'] . $candidate['picture']);
				}
				if (!$this->upload->do_upload('picture'))
				{
					$error[] = $this->upload->display_errors();
				}
				else
				{
					$upload_data = $this->upload->data();
					$return = $this->_resize($upload_data, 96);
					if (is_array($return))
						$error = array_merge($error, $return);
					else
						$candidate['picture'] = $return;
				}
			}
			if (empty($error))
			{
				if ($case == 'add')
				{
					$this->Candidate->insert($candidate);
					$success[] = e('admin_add_candidate_success');
				}
				else if ($case == 'edit')
				{
					$this->Candidate->update($candidate, $id);
					$success[] = e('admin_edit_candidate_success');
				}
				$this->session->set_flashdata('success', $success);
			}
			else
			{
				$this->session->set_flashdata('candidate', $candidate);
				$this->session->set_flashdata('error', $error);
			}
			if ($case == 'add')
			{
				redirect('admin/candidates/add');
			}
			else if ($case == 'edit')
			{
				redirect('admin/candidates/edit/' . $id);
			}
		}
		else
		{
			redirect('admin/candidates');
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

/* End of file candidates.php */
/* Location: ./system/application/controllers/admin/candidates.php */