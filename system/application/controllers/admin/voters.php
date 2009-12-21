<?php

class Voters extends Controller {

	var $admin;
	var $settings;

	function Voters()
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
	
	function index($offset = null)
	{
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
		$this->load->model('Boter');
		$voters = $this->Boter->select_all();
		$config['base_url'] = site_url('admin/voters');
		$config['total_rows'] = count($voters);
		$config['per_page'] = HALALAN_PER_PAGE;
		$config['num_links'] = 5;
		$config['first_link'] = img('public/images/go-first.png');
		$config['last_link'] = img('public/images/go-last.png');
		$config['prev_link'] = img('public/images/go-previous.png');
		$config['next_link'] = img('public/images/go-next.png');
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		if ($offset == null)
		{
			$offset = 0;
		}
		$limit = $config['per_page'];
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['total_rows'] = $config['total_rows'];
		$data['voters'] = $this->Boter->select_all_for_pagination($limit, $offset);
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_voters_title');
		$admin['body'] = $this->load->view('admin/voters', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function add()
	{
		$admin = $this->_voter('add');
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function do_add()
	{
		$this->_do_voter('add');
	}

	function edit($id)
	{
		$admin = $this->_voter('edit', $id);
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function do_edit($id = null)
	{
		$this->_do_voter('edit', $id);
	}

	function delete($id) 
	{
		if (!$id)
			redirect('admin/voters');
		$this->load->model('Boter');
		$voter = $this->Boter->select($id);
		if (!$voter)
			redirect('admin/voters');
		if ($voter['voted'] == 1)
		{
			$this->session->set_flashdata('error', array(e('admin_delete_voter_already_voted')));
		}
		else
		{
			$this->Boter->delete($id);
			$this->session->set_flashdata('success', array(e('admin_delete_voter_success')));
		}
		redirect('admin/voters');
	}

	function _voter($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			if ($case == 'add')
			{
				$data['voter'] = array('username'=>'', 'first_name'=>'', 'last_name'=>'');
				$chosen = array();
			}
			else if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/voters');
				$this->load->model('Boter');
				$data['voter'] = $this->Boter->select($id);
				if (!$data['voter'])
					redirect('admin/voters');
				$this->load->model('Position_Voter');
				$tmp = $this->Position_Voter->select_all_by_voter_id($id);
				$chosen = array();
				foreach ($tmp as $t)
				{
					$chosen[] = $t['position_id'];
				}
			}
			$messages = $this->_get_messages();
			$data['messages'] = $messages['messages'];
			$data['message_type'] = $messages['message_type'];
			$this->load->model('Position');
			$data['general'] = $this->Position->select_all_non_units();
			$data['specific'] = $this->Position->select_all_units();
			$data['possible'] = array();
			$data['chosen'] = array();
			if ($voter = $this->session->flashdata('voter'))
			{
				if (empty($voter['chosen']))
				{
					$chosen = array();
				}
				else
				{
					$chosen = $voter['chosen'];
					unset($voter['chosen']);
				}
				$data['voter'] = $voter;
			}
			foreach ($data['specific'] as $s)
			{
				if (in_array($s['id'], $chosen))
				{
					$data['chosen'][$s['id']] = $s['position'];
				}
				else
				{
					$data['possible'][$s['id']] = $s['position'];
				}
			}
			$data['action'] = $case;
			$data['settings'] = $this->settings;
			$admin['title'] = e('admin_' . $case . '_voter_title');
			$admin['body'] = $this->load->view('admin/voter', $data, TRUE);
			return $admin;
		}
		else
		{
			redirect('admin/voters');
		}
	}

	function _do_voter($case = null, $id = null)
	{
		if ($case == 'add' || $case == 'edit')
		{
			$this->load->model('Boter');
			if ($case == 'edit')
			{
				if (!$id)
					redirect('admin/voters');
				$voter = $this->Boter->select($id);
				if (!$voter)
					redirect('admin/voters');
			}
			$error = array();
			$voter['username'] = $this->input->post('username', TRUE);
			$voter['last_name'] = $this->input->post('last_name', TRUE);
			$voter['first_name'] = $this->input->post('first_name', TRUE);
			$voter['chosen'] = $this->input->post('chosen', TRUE);
			if (!$voter['username'])
			{
				if ($this->settings['password_pin_generation'] == 'web')
					$error[] = e('admin_voter_no_username');
				else if ($this->settings['password_pin_generation'] == 'email')
					$error[] = e('admin_voter_no_email');
			}
			else
			{
				if ($test = $this->Boter->select_by_username($voter['username']))
				{
					if ($case == 'add')
					{
						$error[] = e('admin_voter_exists') . ' (' . $test['username'] . ')';
					}
					else if ($case == 'edit')
					{
						if ($test['id'] != $id)
							$error[] = e('admin_voter_exists') . ' (' . $test['username'] . ')';
					}
				}
				if ($this->settings['password_pin_generation'] == 'email')
				{
					if (!$this->_valid_email($voter['username']))
					{
						$error[] = e('admin_voter_invalid_email');
					}
				}
			}
			if (!$voter['last_name'])
			{
				$error[] = e('admin_voter_no_last_name');
			}
			if (!$voter['first_name'])
			{
				$error[] = e('admin_voter_no_first_name');
			}
			if (empty($error))
			{
				if ($case == 'add' || $this->input->post('password'))
				{
					$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
					$voter['password'] = sha1($password);
				}
				if ($this->settings['pin'])
				{
					if ($case == 'add' || $this->input->post('pin'))
					{
						$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
						$voter['pin'] = sha1($pin);
					}
				}
				if ($case == 'add')
				{
					$voter['voted'] = 0;
					$this->Boter->insert($voter);
				}
				else if ($case == 'edit')
				{
					$this->Boter->update($voter, $id);
				}
				$success = array();
				$success[] = e('admin_' . $case . '_voter_success');
				if ($this->settings['password_pin_generation'] == 'web')
				{
					$success[] = 'Username: '. $voter['username'];
					if ($case == 'add' || $this->input->post('password'))
					{
						$success[] = 'Password: '. $password;
					}
					if ($this->settings['pin'])
					{
						if ($case == 'add' || $this->input->post('pin'))
						{
							$success[] = 'PIN: '. $pin;
						}
					}
				}
				else if ($this->settings['password_pin_generation'] == 'email')
				{
					$this->email->from($this->admin['email'], $this->admin['first_name'] . ' ' . $this->admin['last_name']);
					$this->email->to($voter['username']);
					$this->email->subject($this->settings['name'] . ' Login Credentials');
					$message = "Hello $voter[first_name] $voter[last_name],\n\nThe following are your login credentials:\nEmail: $voter[username]\n";
					if ($case == 'add' || $this->input->post('password'))
					{
						$message .= "Password: $password\n";
					}
					if ($this->settings['pin'])
					{
						if ($case == 'add' || $this->input->post('pin'))
						{
							$message .= "PIN: $pin\n";
						}
					}
					$message .= "\n";
					$message .= ($this->admin['first_name'] . ' ' . $this->admin['last_name']);
					$message .= "\n";
					$message .= $this->settings['name'] . ' Administrator';
					$this->email->message($message);
					$this->email->send();
					//echo $this->email->print_debugger();
					$success[] = e('admin_voter_email_success');
				}
				$this->session->set_flashdata('success', $success);
			}
			else
			{
				$this->session->set_flashdata('voter', $voter);
				$this->session->set_flashdata('error', $error);
			}
			if ($case == 'add')
			{
				redirect('admin/voters/add');
			}
			else if ($case == 'edit')
			{
				redirect('admin/voters/edit/' . $id);
			}
		}
		else
		{
			redirect('admin/voters');
		}
	}

	function import()
	{
		$messages = $this->_get_messages();
		$data['messages'] = $messages['messages'];
		$data['message_type'] = $messages['message_type'];
		$this->load->model('Position');
		$data['general'] = $this->Position->select_all_non_units();
		$data['specific'] = $this->Position->select_all_units();
		$tmp = array();
		foreach ($data['specific'] as $s)
		{
			$tmp[$s['id']] = $s['position'];
		}
		$data['possible'] = $tmp;
		if ($import = $this->session->flashdata('import'))
		{
			if (empty($import['chosen']))
			{
				$data['chosen'] = array();
			}
			else
			{
				$chosen = $import['chosen'];
				unset($import['chosen']);
				$tmp = array();
				foreach ($data['possible'] as $key=>$value)
				{
					if (in_array($key, $chosen))
					{
						unset($data['possible'][$key]);
						$tmp[$key] = $value;
					}
				}
				$data['chosen'] = $tmp;
			}
		}
		else
		{
			$data['chosen'] = array();
		}
		$data['settings'] = $this->settings;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_import_title');
		$admin['body'] = $this->load->view('admin/import', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function do_import()
	{
		$error = array();
		$import['chosen'] = $this->input->post('chosen', TRUE);
		$config['upload_path'] = HALALAN_UPLOAD_PATH . 'csvs/';
		$config['allowed_types'] = 'csv';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('csv'))
		{
			$error[] = $this->upload->display_errors();
		}
		else
		{
			$upload_data = $this->upload->data();
			$data = file($upload_data['full_path']);
		}
		if (empty($error))
		{
			$this->load->model('Boter');
			$count = 0;
			unset($data[0]); // remove header
			foreach ($data as $datum)
			{
				$tmp = explode(',', $datum);
				$voter['username'] = trim(strip_quotes($tmp[0]));
				$voter['last_name'] = trim(strip_quotes($tmp[1]));
				$voter['first_name'] = trim(strip_quotes($tmp[2]));
				$voter['password'] = '';
				$voter['voted'] = 0;
				$voter['chosen'] = $this->input->post('chosen', TRUE);
				if ($voter['username'] && $voter['last_name'] && $voter['first_name'] && !$this->Boter->select_by_username($voter['username']))
				{
					if ($this->settings['password_pin_generation'] == 'web')
					{
						$this->Boter->insert($voter);
						$count++;
					}
					else if ($this->settings['password_pin_generation'] == 'email')
					{
						if ($this->_valid_email($voter['username']))
						{
							$this->Boter->insert($voter);
							$count++;
						}
					}
				}
			}
			if ($count == 1)
			{
				$success[] = $count . e('admin_import_success_singular');
			}
			else
			{
				$success[] = $count . e('admin_import_success_plural');
			}
			$reminder = e('admin_import_reminder');
			if ($this->settings['pin'])
			{
				$reminder = trim($reminder, '.'); // remove period
				$reminder .= e('admin_import_reminder_too');
			}
			$success[] = $reminder;
			$this->session->set_flashdata('success', $success);
		}
		else
		{
			$this->session->set_flashdata('import', $import);
			$this->session->set_flashdata('error', $error);
		}
		unlink($upload_data['full_path']);
		redirect('admin/voters/import');
	}

	function export()
	{
		$data['settings'] = $this->settings;
		$admin['username'] = $this->admin['username'];
		$admin['title'] = e('admin_export_title');
		$admin['body'] = $this->load->view('admin/export', $data, TRUE);
		$this->load->view('admin', $admin);
	}

	function do_export()
	{
		$header = '';
		if ($this->settings['password_pin_generation'] == 'web')
		{
			$header = 'Username';
		}
		else if ($this->settings['password_pin_generation'] == 'email')
		{
			$header = 'Email';
		}
		$header .= ',Last Name,First Name';
		if ($this->input->post('password'))
		{
			$header .= ',Password';
		}
		if ($this->settings['pin'])
		{
			if ($this->input->post('pin'))
			{
				$header .= ',PIN';
			}
		}
		if ($this->input->post('votes'))
		{
			$header .= ',Votes';
		}
		if ($this->input->post('status'))
		{
			$header .= ',Voted';
		}
		$data[] = $header;
		$this->load->model('Boter');
		$this->load->model('Vote');
		$voters = $this->Boter->select_all();
		foreach ($voters as $voter)
		{
			$row = $voter['username'] . ',' . $voter['last_name'] . ',' . $voter['first_name'];
			if ($this->input->post('password'))
			{
				$password = random_string($this->settings['password_pin_characters'], $this->settings['password_length']);
				$boter['password'] = sha1($password);
				$row .= ',' . $password;
				$this->Boter->update($boter, $voter['id']);
			}
			if ($this->settings['pin'])
			{
				if ($this->input->post('pin'))
				{
					$pin = random_string($this->settings['password_pin_characters'], $this->settings['pin_length']);
					$boter['pin'] = sha1($pin);
					$row .= ',' . $pin;
					$this->Boter->update($boter, $voter['id']);
				}
			}
			if ($this->input->post('votes'))
			{
				$votes = $this->Vote->select_all_by_voter_id($voter['id']);
				$tmp = array();
				foreach ($votes as $vote)
				{
					$tmp[] = $vote['first_name'] . ' ' . $vote['last_name'];
				}
				$row .= ',' . implode(' | ', $tmp);
			}
			if ($this->input->post('status'))
			{
				if ($voter['voted'])
				{
					$row .= ',yes';
				}
				else
				{
					$row .= ',no';
				}
			}
			$data[] = $row;
		}
		$data = implode("\r\n", $data);
		force_download('voters.csv', $data);
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

/* End of file voters.php */
/* Location: ./system/application/controllers/admin/voters.php */