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
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			$election_ids = json_decode($this->input->post('election_ids', TRUE));
			$this->_fill_positions($election_ids, TRUE);
		}
		else
		{
			$this->_voter('add');
		}
	}

	function edit($id)
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			$election_ids = json_decode($this->input->post('election_ids', TRUE));
			$this->_fill_positions($election_ids, TRUE);
		}
		else
		{
			$this->_voter('edit', $id);
		}
	}

	function delete($id) 
	{
		if (!$id)
			redirect('admin/voters');
		$voter = $this->Boter->select($id);
		if (!$voter)
			redirect('admin/voters');
		if ($voter['voted'] == 1)
		{
			$this->session->set_flashdata('messages', array('negative', e('admin_delete_voter_already_voted')));
		}
		else
		{
			$this->Boter->delete($id);
			$this->session->set_flashdata('messages', array('positive', e('admin_delete_voter_success')));
		}
		redirect('admin/voters');
	}

	function _voter($case, $id = null)
	{
		$chosen_elections = array();
		$chosen_positions = array();
		if ($case == 'add')
		{
			$data['voter'] = array('username'=>'', 'first_name'=>'', 'last_name'=>'');
		}
		else if ($case == 'edit')
		{
			if (!$id)
				redirect('admin/voters');
			$data['voter'] = $this->Boter->select($id);
			if (!$data['voter'])
				redirect('admin/voters');
			if (empty($_POST))
			{
				$tmp = $this->Election_Position_Voter->select_all_by_voter_id($id);
				foreach ($tmp as $t)
				{
					$chosen_elections[] = $t['election_id'];
					$chosen_positions[] = $t['election_id'] . '|' . $t['position_id'];
				}
			}
			$this->session->set_userdata('voter', $data['voter']); // used in callback rules
		}
		if ($this->settings['password_pin_generation'] == 'email')
		{
			$this->form_validation->set_rules('username', e('admin_voter_email'), 'required|valid_email|callback__rule_voter_exists');
		}
		else
		{
			$this->form_validation->set_rules('username', e('admin_voter_username'), 'required|callback__rule_voter_exists');
		}
		$this->form_validation->set_rules('first_name', e('admin_voter_first_name'), 'required');
		$this->form_validation->set_rules('last_name', e('admin_voter_last_name'), 'required');
		$this->form_validation->set_rules('chosen_elections', e('admin_voter_chosen_elections'), 'required');
		if ($this->form_validation->run())
		{
			$voter['username'] = $this->input->post('username', TRUE);
			$voter['last_name'] = $this->input->post('last_name', TRUE);
			$voter['first_name'] = $this->input->post('first_name', TRUE);
			// chosen elections are also in the ids of the positions
			//$voter['chosen_elections'] = $this->input->post('chosen_elections', TRUE);
			$general_positions = $this->input->post('general_positions', TRUE);
			$chosen_positions = $this->input->post('chosen_positions', TRUE);
			if (!$chosen_positions)
			{
				// if no chosen positions, its value is FALSE so convert to array
				$chosen_positions = array();
			}
			$extra = array();
			foreach (array_merge($general_positions, $chosen_positions) as $p)
			{
				list($election_id, $position_id) = explode('|', $p);
				$extra[] = array('election_id'=>$election_id, 'position_id'=>$position_id);
			}
			$voter['extra'] = $extra;
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
			$messages[] = 'positive';
			if ($case == 'add')
			{
				$voter['voted'] = 0;
				$this->Boter->insert($voter);
				$messages[] = e('admin_add_voter_success');
			}
			else if ($case == 'edit')
			{
				$this->Boter->update($voter, $id);
				$messages[] = e('admin_edit_voter_success');
			}
			if ($this->settings['password_pin_generation'] == 'web')
			{
				$messages[] = 'Username: '. $voter['username'];
				if ($case == 'add' || $this->input->post('password'))
				{
					$messages[] = 'Password: '. $password;
				}
				if ($this->settings['pin'])
				{
					if ($case == 'add' || $this->input->post('pin'))
					{
						$messages[] = 'PIN: '. $pin;
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
				$messages[] = e('admin_voter_email_success');
			}
			if ($case == 'add')
			{
				$this->session->set_flashdata('messages', $messages);
				redirect('admin/voters/add');
			}
			else if ($case == 'edit')
			{
				$this->session->set_flashdata('messages', $messages);
				redirect('admin/voters/edit/' . $id);
			}
		}
		if ($this->input->post('chosen_elections'))
		{
			$chosen_elections = $this->input->post('chosen_elections');
		}
		if ($this->input->post('chosen_positions'))
		{
			$chosen_positions = $this->input->post('chosen_positions');
		}
		$data['elections'] = $this->Election->select_all_with_positions();
		$data['possible_elections'] = array();
		$data['chosen_elections'] = array();
		foreach ($data['elections'] as $e)
		{
			if (in_array($e['id'], $chosen_elections))
			{
				$data['chosen_elections'][$e['id']] = '(' . $e['id'] . ') ' . $e['election'];
			}
			else
			{
				$data['possible_elections'][$e['id']] = '(' . $e['id'] . ') ' . $e['election'];
			}
		}
		$fill = $this->_fill_positions($chosen_elections, FALSE);
		$data['general_positions'] = array();
		foreach ($fill[0] as $f)
		{
			$data['general_positions'][$f['value']] = $f['text'];
		}
		$data['possible_positions'] = array();
		foreach ($fill[1] as $f)
		{
			$data['possible_positions'][$f['value']] = $f['text'];
		}
		$data['chosen_positions'] = array();
		foreach ($data['possible_positions'] as $key=>$value)
		{
			if (in_array($key, $chosen_positions))
			{
				$data['chosen_positions'][$key] = $value;
				unset($data['possible_positions'][$key]);
			}
		}
		$data['action'] = $case;
		$data['settings'] = $this->settings;
		$admin['title'] = e('admin_' . $case . '_voter_title');
		$admin['body'] = $this->load->view('admin/voter', $data, TRUE);
		$admin['username'] = $this->admin['username'];
		$this->load->view('admin', $admin);
	}

	function _fill_positions($election_ids, $json)
	{
		$general = array();
		$specific = array();
		foreach ($election_ids as $election_id)
		{
			$positions = $this->Position->select_all_by_election_id($election_id);
			foreach ($positions as $position)
			{
				$value = $election_id . '|' . $position['id'];
				$text = $position['position'] . ' (' . $election_id . ')';
				if ($position['unit'])
				{
					$specific[] = array('value'=>$value, 'text'=>$text);
				}
				else
				{
					$general[] = array('value'=>$value, 'text'=>$text);
				}
			}
		}
		$return = array($general, $specific);
		if ($json)
		{
			echo json_encode($return);
		}
		else
		{
			return $return;
		}
	}

	function import()
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			$election_ids = json_decode($this->input->post('election_ids', TRUE));
			$this->_fill_positions($election_ids, TRUE);
		}
		else
		{
			$chosen_elections = array();
			$chosen_positions = array();
			if ($this->input->post('chosen_elections'))
			{
				$chosen_elections = $this->input->post('chosen_elections');
			}
			if ($this->input->post('chosen_positions'))
			{
				$chosen_positions = $this->input->post('chosen_positions');
			}
			$this->form_validation->set_rules('chosen_elections', e('admin_import_chosen_elections'), 'required');
			$this->form_validation->set_rules('csv', e('admin_import_csv'), 'callback__rule_csv');
			if ($this->form_validation->run())
			{
				$voter['password'] = '';
				$voter['voted'] = 0;
				// chosen elections are also in the ids of the positions
				//$voter['chosen_elections'] = $this->input->post('chosen_elections', TRUE);
				$general_positions = $this->input->post('general_positions', TRUE);
				$chosen_positions = $this->input->post('chosen_positions', TRUE);
				if (!$chosen_positions)
				{
					// if no chosen positions, its value is FALSE so convert to array
					$chosen_positions = array();
				}
				$extra = array();
				foreach (array_merge($general_positions, $chosen_positions) as $p)
				{
					list($election_id, $position_id) = explode('|', $p);
					$extra[] = array('election_id'=>$election_id, 'position_id'=>$position_id);
				}
				$voter['extra'] = $extra;
				$data = $this->session->userdata('voter_csv');
				$count = 0;
				unset($data[0]); // remove header
				foreach ($data as $datum)
				{
					$tmp = explode(',', $datum);
					$voter['username'] = trim(strip_quotes($tmp[0]));
					$voter['last_name'] = trim(strip_quotes($tmp[1]));
					$voter['first_name'] = trim(strip_quotes($tmp[2]));
					if ($voter['username'] && $voter['last_name'] && $voter['first_name'] && !$this->Boter->select_by_username($voter['username']))
					{
						if ($this->settings['password_pin_generation'] == 'web')
						{
							$this->Boter->insert($voter);
							$count++;
						}
						else if ($this->settings['password_pin_generation'] == 'email')
						{
							if ($this->form_validation->valid_email($voter['username']))
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
				$this->session->set_flashdata('messages', array_merge(array('positive'), $success));
				redirect('admin/voters/import');
			}
			$data['elections'] = $this->Election->select_all_with_positions();
			$data['possible_elections'] = array();
			$data['chosen_elections'] = array();
			foreach ($data['elections'] as $e)
			{
				if (in_array($e['id'], $chosen_elections))
				{
					$data['chosen_elections'][$e['id']] = '(' . $e['id'] . ') ' . $e['election'];
				}
				else
				{
					$data['possible_elections'][$e['id']] = '(' . $e['id'] . ') ' . $e['election'];
				}
			}
			$fill = $this->_fill_positions($chosen_elections, FALSE);
			$data['general_positions'] = array();
			for ($i = 0; $i < count($fill[1]); $i++)
			{
				$data['general_positions'][$fill[0][$i]] = $fill[1][$i];
			}
			$data['possible_positions'] = array();
			for ($i = 0; $i < count($fill[3]); $i++)
			{
				$data['possible_positions'][$fill[2][$i]] = $fill[3][$i];
			}
			$data['chosen_positions'] = array();
			foreach ($data['possible_positions'] as $key=>$value)
			{
				if (in_array($key, $chosen_positions))
				{
					$data['chosen_positions'][$key] = $value;
					unset($data['possible_positions'][$key]);
				}
			}
			$data['settings'] = $this->settings;
			$admin['username'] = $this->admin['username'];
			$admin['title'] = e('admin_import_title');
			$admin['body'] = $this->load->view('admin/import', $data, TRUE);
			$this->load->view('admin', $admin);
		}
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

	function _rule_voter_exists()
	{
		$username = trim($this->input->post('username', TRUE));
		if ($test = $this->Boter->select_by_username($username))
		{
			$error = FALSE;
			if ($voter = $this->session->userdata('voter')) // edit
			{
				if ($test['id'] != $voter['id'])
				{
					$error = TRUE;
				}
			}
			else
			{
				$error = TRUE;
			}
			if ($error)
			{
				$message = e('admin_voter_exists') . ' (' . $test['username'] . ')';
				$this->form_validation->set_message('_rule_voter_exists', $message);
				return FALSE;
			}
		}
		return TRUE;
	}

	function _rule_csv()
	{
		$config['upload_path'] = HALALAN_UPLOAD_PATH . 'csvs/';
		$config['allowed_types'] = 'csv';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('csv'))
		{
			$message = $this->upload->display_errors('', '');
			$this->form_validation->set_message('_rule_csv', $message);
			return FALSE;
		}
		else
		{
			$upload_data = $this->upload->data();
			$data = file($upload_data['full_path']);
			unlink($upload_data['full_path']);
			// flashdata doesn't work I don't know why
			$this->session->set_userdata('voter_csv', $data);
			return TRUE;
		}
	}

}

/* End of file voters.php */
/* Location: ./system/application/controllers/admin/voters.php */