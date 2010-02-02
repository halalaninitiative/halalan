<?php

class Voter extends Controller {

	var $voter;
	var $settings;

	function Voter()
	{
		parent::Controller();
		if (in_array($this->uri->segment(2), array('votes', 'print_votes')))
		{
			if (!$this->session->userdata('voter_id'))
			{
				$error[] = e('common_unauthorized');
				$this->session->set_flashdata('error', $error);
				redirect('gate/voter');
			}
		}
		else
		{
			$this->voter = $this->session->userdata('voter');
			if (!$this->voter)
			{
				$error[] = e('common_unauthorized');
				$this->session->set_flashdata('error', $error);
				redirect('gate/voter');
			}
		}
		$this->settings = $this->config->item('halalan');
		$this->load->model('Option');
		$option = $this->Option->select(1);
		if (!$option['status'])
		{
			//$error[] = e('voter_common_not_running_one');
			//$error[] = e('voter_common_not_running_two');
			//$this->session->set_flashdata('error', $error);
			//redirect('gate/voter');
			//force logout
			redirect('gate/logout');
		}
	}

	function index()
	{
		echo 'wala lang';
	}

	function vote()
	{
		$rules = array('position_count'=>0, 'candidate_count'=>array()); // used in checking in do_vote
		$array = array();
		$chosen = $this->Election_Position_Voter->select_all_by_voter_id($this->voter['id']);
		foreach ($chosen as $c)
		{
			$array[$c['election_id']][] = $c['position_id'];
		}
		$elections = $this->Election->select_all_by_ids(array_keys($array));
		$elections = $this->_filter($elections);
		if (empty($elections))
		{
			redirect('voter/index');
		}
		foreach ($elections as $key1=>$election)
		{
			$positions = $this->Position->select_all_by_ids($array[$election['id']]);
			foreach ($positions as $key2=>$position)
			{
				$candidates = $this->Candidate->select_all_by_election_id_and_position_id($election['id'], $position['id']);
				foreach ($candidates as $key3=>$candidate)
				{
					$candidates[$key3]['party'] = $this->Party->select($candidate['party_id']);
				}
				$positions[$key2]['candidates'] = $candidates;
				if (!empty($candidates))
				{
					$rules['position_count']++;
					$rules['candidate_max'][$election['id'] . '|' . $position['id']] = $position['maximum'];
				}
			}
			$elections[$key1]['positions'] = $positions;
		}
		$this->session->set_userdata('rules', $rules);
		$data['elections'] = $elections;
		if ($votes = $this->session->userdata('votes'))
		{
			$data['votes'] = $votes;
		}
		$data['settings'] = $this->settings;
		$voter['username'] = $this->voter['username'];
		$voter['title'] = e('voter_vote_title');
		$voter['body'] = $this->load->view('voter/vote', $data, TRUE);
		$this->load->view('voter', $voter);
	}

	function do_vote()
	{
		$error = array();
		$votes = $this->input->post('votes');
		// check if there are selected candidates
		if (empty($votes))
		{
			$error[] = e('voter_vote_no_selected');
		}
		else
		{
			$rules = $this->session->userdata('rules');
			// check if all positions have selected candidates
			$count = 0;
			foreach ($votes as $election_id=>$positions)
			{
				$count += count(array_values($positions));
			}
			if ($rules['position_count'] != $count)
			{
				$error[] = e('voter_vote_not_all_selected');
			}
			else
			{
				foreach ($votes as $election_id=>$positions)
				{
					// check if the number of selected candidates does not exceed the maximum allowed for each position
					foreach ($positions as $position_id=>$candidate_ids)
					{
						if ($rules['candidate_max'][$election_id . '|' . $position_id] < count($candidate_ids))
						{
							$error[] = e('voter_vote_maximum');
						}
						else
						{
							// check if abstain is selected with other candidates
							if (in_array('abstain', $candidate_ids) && count($candidate_ids) > 1)
							{
								$error[] = e('voter_vote_abstain_and_others');
							}
						}
					}
				}
			}
		}
		// save the votes in session
		$this->session->set_userdata('votes', $votes);
		if (empty($error))
		{
			redirect('voter/verify');
		}
		else
		{
			$this->session->set_flashdata('messages', array_merge(array('negative'), $error));
			redirect('voter/vote');
		}
	}

	function verify()
	{
		$votes = $this->session->userdata('votes');
		if (empty($votes))
		{
			redirect('voter/vote');
		}
		$data['votes'] = $votes;
		$array = array();
		$chosen = $this->Election_Position_Voter->select_all_by_voter_id($this->voter['id']);
		foreach ($chosen as $c)
		{
			$array[$c['election_id']][] = $c['position_id'];
		}
		$elections = $this->Election->select_all_by_ids(array_keys($array));
		$elections = $this->_filter($elections);
		if (empty($elections))
		{
			redirect('voter/index');
		}
		foreach ($elections as $key1=>$election)
		{
			$positions = $this->Position->select_all_by_ids($array[$election['id']]);
			foreach ($positions as $key2=>$position)
			{
				$candidates = $this->Candidate->select_all_by_election_id_and_position_id($election['id'], $position['id']);
				foreach ($candidates as $key3=>$candidate)
				{
					$candidates[$key3]['party'] = $this->Party->select($candidate['party_id']);
				}
				$positions[$key2]['candidates'] = $candidates;
			}
			$elections[$key1]['positions'] = $positions;
		}
		$data['elections'] = $elections;
		if ($this->settings['captcha'])
		{
			$this->load->plugin('captcha');
			$vals = array('img_path'=>'./public/captcha/', 'img_url'=>base_url() . 'public/captcha/', 'font_path'=>'./public/fonts/Vera.ttf', 'img_width'=>150, 'img_height'=>60, 'word_length'=> $this->settings['captcha_length']);
			$captcha = create_captcha($vals);
			$data['captcha'] = $captcha;
			$this->session->set_userdata('word', $captcha['word']);
		}
		$data['settings'] = $this->settings;
		$data['positions'] = $positions;
		$voter['username'] = $this->voter['username'];
		$voter['title'] = e('voter_confirm_vote_title');
		$voter['body'] = $this->load->view('voter/confirm_vote', $data, TRUE);
		$this->load->view('voter', $voter);
	}

	function do_verify()
	{
		$error = array();
		if ($this->settings['captcha'])
		{
			$captcha = $this->input->post('captcha');
			if (empty($captcha))
			{
				$error[] = e('voter_confirm_vote_no_captcha');
			}
			else
			{
				$word = $this->session->userdata('word');
				if ($captcha != $word)
					$error[] = e('voter_confirm_vote_not_captcha');
			}
		}
		if ($this->settings['pin'])
		{
			$pin = $this->input->post('pin');
			if (empty($pin))
			{
				$error[] = e('voter_confirm_vote_no_pin');
			}
			else
			{
				if (sha1($pin) != $this->voter['pin'])
					$error[] = e('voter_confirm_vote_not_pin');
			}
		}
		if (empty($error))
		{
			$voter_id = $this->voter['id'];
			$timestamp = date("Y-m-d H:i:s");
			$votes = $this->session->userdata('votes');
			foreach ($votes as $election_id=>$positions)
			{
				foreach ($positions as $position_id=>$candidate_ids)
				{
					$abstain = FALSE;
					foreach ($candidate_ids as $candidate_id)
					{
						if ($candidate_id == 'abstain')
						{
							$abstain = TRUE;
						}
						else
						{
							$this->Vote->insert(compact('candidate_id', 'voter_id', 'timestamp'));
						}
					}
					if ($abstain)
					{
						$this->Abstain->insert(compact('election_id', 'position_id', 'voter_id', 'timestamp'));
					}
				}
				$this->Voted->insert(compact('election_id', 'voter_id', 'timestamp'));
			}
			$this->session->unset_userdata('votes');
			if ($this->settings['generate_image_trail'])
			{
				//$this->_generate_image_trail();
			}
			redirect('voter/logout');
		}
		else
		{
			$this->session->set_flashdata('messages', array_merge(array('negative'), $error));
			redirect('voter/verify');
		}
	}

	function logout()
	{
		$this->Boter->update(array('logout'=>date("Y-m-d H:i:s")), $this->voter['id']);
		setcookie('halalan_cookie', '', time() - 3600, '/'); // destroy cookie
		$this->session->sess_destroy();
		$voter['title'] = e('voter_logout_title');
		$voter['meta'] = '<meta http-equiv="refresh" content="5;URL=' . base_url() . '" />';
		$voter['body'] = $this->load->view('voter/logout', '', TRUE);
		$this->load->view('voter', $voter);
	}

	function votes()
	{
		$voter_id = $this->session->userdata('voter_id');
		$this->load->model('Abstain');
		$this->load->model('Boter');
		$this->load->model('Candidate');
		$this->load->model('Party');
		$this->load->model('Position');
		$this->load->model('Vote');
		$votes = $this->Vote->select_all_by_voter_id($voter_id);
		$candidate_ids = array();
		foreach ($votes as $vote)
		{
			$candidate_ids[] = $vote['candidate_id'];
		}
		$positions = $this->Position->select_all_with_units($voter_id);
		foreach ($positions as $key=>$position)
		{
			$count = 0;
			$candidates = $this->Candidate->select_all_by_position_id($position['id']);
			foreach ($candidates as $k=>$candidate)
			{
				if (in_array($candidate['id'], $candidate_ids))
				{
					$candidates[$k]['voted'] = TRUE;
				}
				else
				{
					$candidates[$k]['voted'] = FALSE;
					$count++;
				}
				$candidates[$k]['party'] = $this->Party->select($candidate['party_id']);
			}
			if ($count == count($candidates))
			{
				$positions[$key]['abstains'] = TRUE;
			}
			else
			{
				$positions[$key]['abstains'] = FALSE;
			}
			$positions[$key]['candidates'] = $candidates;
		}
		$boter = $this->Boter->select($voter_id);
		$data['settings'] = $this->settings;
		$data['positions'] = $positions;
		// used for marking that this action is being used
		$voter['voter_id'] = $voter_id;
		$voter['username'] = $boter['username'];
		$voter['title'] = e('voter_votes_title');
		$voter['body'] = $this->load->view('voter/votes', $data, TRUE);
		$this->load->view('voter', $voter);
	}

	function print_votes()
	{
		$voter_id = $this->session->userdata('voter_id');
		$this->load->model('Abstain');
		$this->load->model('Boter');
		$this->load->model('Candidate');
		$this->load->model('Party');
		$this->load->model('Position');
		$this->load->model('Vote');
		$votes = $this->Vote->select_all_by_voter_id($voter_id);
		$candidate_ids = array();
		foreach ($votes as $vote)
		{
			$candidate_ids[] = $vote['candidate_id'];
		}
		$positions = $this->Position->select_all_with_units($voter_id);
		foreach ($positions as $key=>$position)
		{
			$count = 0;
			$candidates = $this->Candidate->select_all_by_position_id($position['id']);
			foreach ($candidates as $k=>$candidate)
			{
				if (in_array($candidate['id'], $candidate_ids))
				{
					$candidates[$k]['voted'] = TRUE;
				}
				else
				{
					$candidates[$k]['voted'] = FALSE;
					$count++;
				}
				$candidates[$k]['party'] = $this->Party->select($candidate['party_id']);
			}
			if ($count == count($candidates))
			{
				$positions[$key]['abstains'] = TRUE;
			}
			else
			{
				$positions[$key]['abstains'] = FALSE;
			}
			$positions[$key]['candidates'] = $candidates;
		}
		$voter = $this->Boter->select($voter_id);
		$data['settings'] = $this->settings;
		$data['positions'] = $positions;
		$data['voter'] = $voter;
		$data['settings'] = $this->settings;
		$this->load->view('voter/print_votes', $data);
	}

	function _generate_image_trail()
	{
		$this->load->model('Boter');
		$this->load->model('Candidate');
		$this->load->model('Position');
		$this->load->model('Vote');
		$voter = $this->Boter->select($this->voter['id']);
		$count = 0;
		$positions = $this->Position->select_all_with_units($this->voter['id']);
		foreach ($positions as $position)
		{
			// maximum + name
			$count += $position['maximum'] + 1;
		}
		$y_size = 95 + ($count * 20) + 35;
		$image = imagecreate(500, $y_size);
		$bg = imagecolorallocate($image, 255, 255, 255);
		$text = imagecolorallocate($image, 0, 0, 0);
		imagestring($image, 5, 5, 5, $this->settings['name'], $text);
		imagestring($image, 5, 5, 15, '', $text);
		imagestring($image, 5, 5, 25, '', $text);
		imagestring($image, 5, 5, 35, 'Username: ' . $this->voter['username'], $text);
		imagestring($image, 5, 5, 45, '', $text);
		imagestring($image, 5, 5, 55, 'Hash: ' . $voter['password'], $text);
		imagestring($image, 5, 5, 65, '', $text);
		$votes = $this->Vote->select_all_by_voter_id($this->voter['id']);
		$candidate_ids = array();
		foreach ($votes as $vote)
		{
			$candidate_ids[] = $vote['candidate_id'];
		}
		$y = 75;
		foreach ($positions as $position)
		{
			imagestring($image, 5, 5, $y += 10, $position['position'], $text);
			imagestring($image, 5, 5, $y += 10, '', $text);
			$count = 0;
			$candidates = $this->Candidate->select_all_by_position_id($position['id']);
			foreach ($candidates as $candidate)
			{
				if (in_array($candidate['id'], $candidate_ids))
				{
					$name = $candidate['first_name'];
					if (!empty($candidate['alias']))
						$name .= ' "' . $candidate['alias'] . '"';
					$name .= ' ' . $candidate['last_name'];
					imagestring($image, 5, 5, $y += 10, ' - ' . $name, $text);
					imagestring($image, 5, 5, $y += 10, '', $text);
				}
				else
				{
					$count++;
				}
			}
			if (empty($candidates))
			{
				imagestring($image, 5, 5, $y += 10, '', $text);
				imagestring($image, 5, 5, $y += 10, '', $text);
			}
			else if ($count == count($candidates))
			{
				imagestring($image, 5, 5, $y += 10, ' - ABSTAIN', $text);
				imagestring($image, 5, 5, $y += 10, '', $text);
			}
		}
		imagestring($image, 2, 5, $y_size - 15, 'Generated on ' . date('Y-m-d H:i:s'), $text);
		$image_trail_path = $this->settings['image_trail_path'];
		imagepng($image, $image_trail_path . $this->voter['id'] . '.png', 0, PNG_NO_FILTER);
		imagedestroy($image);
		$config['source_image'] = $image_trail_path . $this->voter['id'] . '.png';
		$config['wm_overlay_path'] = './public/images/logo_small.png';
		$config['wm_type'] = 'overlay';
		$config['wm_vrt_alignment'] = 'top';
		$config['wm_hor_alignment'] = 'left';
		$config['wm_opacity'] = 25;
		$this->image_lib->initialize($config);
		$this->image_lib->watermark();
		$config['wm_vrt_alignment'] = 'top';
		$config['wm_hor_alignment'] = 'right';
		$this->image_lib->initialize($config);
		$this->image_lib->watermark();
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'left';
		$this->image_lib->initialize($config);
		$this->image_lib->watermark();
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'right';
		$this->image_lib->initialize($config);
		$this->image_lib->watermark();
		return TRUE;
	}

	// get only running elections
	function _filter($elections)
	{
		$parents = array();
		$children = array();
		$running = array();
		foreach ($elections as $election)
		{
			if ($election['parent_id'] == 0)
			{
				$parents[] = $election;
			}
			else
			{
				$children[] = $election;
			}
		}
		foreach ($parents as $parent)
		{
			if ($parent['status'])
			{
				$running[$parent['id']]['parent'] = $parent;
			}
		}
		foreach ($children as $child)
		{
			if ($child['status'])
			{
				$running[$child['parent_id']][] = $child;
			}
			else
			{
				// don't show the parent election if the child election is not running
				unset($running[$child['parent_id']]);
			}
		}
		// flatten the array and remove elections that have been voted in by the voter
		// the format of $running is like that so we can put the children elections after their parents
		$voted = $this->Voted->select_all_by_voter_id($this->voter['id']);
		$election_ids = array();
		foreach ($voted as $v)
		{
			$election_ids[] = $v['election_id'];
		}
		$tmp = array();
		foreach ($running as $r)
		{
			if (isset($r['parent']))
			{
				if (!in_array($r['parent']['id'], $election_ids))
				{
					$tmp[] = $r['parent'];
				}
				unset($r['parent']);
			}
			foreach ($r as $value)
			{
				if (!in_array($value['id'], $election_ids))
				{
					$tmp[] = $value;
				}
			}
		}
		return $tmp;
	}

}

?>
