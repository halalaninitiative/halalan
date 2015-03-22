<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidates extends MY_Controller {

	private $election_id;

	public function __construct()
	{
		parent::__construct();
		$this->election_id = $this->session->userdata('manage_election_id');
	}
	
	public function index()
	{
		$where = array('election_id' => $this->election_id);
		$candidates = $this->Candidate->select_all_where($where);
		foreach ($candidates as $key => $candidate)
		{
			$position = $this->Position->select_where(array('id' => $candidate['position_id']));
			$candidates[$key]['position'] = $position['position'];
			if ($candidate['party_id'])
			{
				$party = $this->Party->select_where(array('id' => $candidate['party_id']));
				$candidates[$key]['party'] = $party['party'];
			}
			else
			{
				$candidates[$key]['party'] = '';
			}
		}
		$data['candidates'] = $candidates;
		$admin['title'] = 'Manage Candidates';
		$admin['body'] = $this->load->view('admin/candidates', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

	public function add()
	{
		$candidate = array('position_id' => NULL, 'last_name' => '', 'first_name' => '', 'alias' => '', 'party_id' => NULL, 'description' => '');
		$this->_candidate($candidate, 'add');
	}

	public function edit($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'election_id' => $this->election_id);
		$candidate = $this->Candidate->select_where($where);
		if ( ! $candidate)
		{
			show_404();
		}
		$this->_candidate($candidate, 'edit', $id);
	}

	public function delete($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'election_id' => $this->election_id);
		$candidate = $this->Candidate->select_where($where);
		if ( ! $candidate)
		{
			show_404();
		}
		$this->Candidate->delete($id);
		$this->session->set_flashdata('messages', array('success', 'The candidate has been successfully deleted.'));
		redirect('admin/candidates');
	}

	private function _candidate($candidate, $action, $id = NULL)
	{
		$this->form_validation->set_rules('position_id', 'Position', 'required');
		$this->form_validation->set_rules('last_name', 'Last name', 'required');
		$this->form_validation->set_rules('first_name', 'First name', 'required');
		$this->form_validation->set_rules('alias', 'Alias');
		$this->form_validation->set_rules('party_id', 'Party');
		$this->form_validation->set_rules('description', 'Description');
		$this->form_validation->set_rules('picture', 'Picture');
		if ($this->form_validation->run())
		{
			$candidate['election_id'] = $this->election_id;
			$candidate['position_id'] = $this->input->post('position_id');
			$candidate['last_name'] = $this->input->post('last_name', TRUE);
			$candidate['first_name'] = $this->input->post('first_name', TRUE);
			$candidate['alias'] = $this->input->post('alias', TRUE);
			if ($this->input->post('party_id'))
			{
				$candidate['party_id'] = $this->input->post('party_id');
			}
			else
			{
				$candidate['party_id'] = NULL;
			}
			$candidate['description'] = $this->input->post('description', TRUE);
			$candidate['picture'] = ''; // TODO: Add upload
			if ($action == 'add')
			{
				$this->Candidate->insert($candidate);
				$this->session->set_flashdata('messages', array('success', 'The candidate has been successfully added.'));
				redirect('admin/candidates/add');
			}
			else if ($action == 'edit')
			{
				$this->Candidate->update($candidate, $id);
				$this->session->set_flashdata('messages', array('success', 'The candidate has been successfully edited.'));
				redirect('admin/candidates/edit/' . $id);
			}
		}
		$where = array('election_id' => $this->election_id);
		$data['positions'] = $this->Position->select_all_where($where);
		$election = $this->Election->select_where(array('id' => $this->election_id));
		$where = array('event_id' => $election['event_id']);
		$data['parties'] = $this->Party->select_all_where($where);
		$data['candidate'] = $candidate;
		$data['action'] = $action;
		$admin['title'] = ucfirst($action) . ' Candidate';
		$admin['body'] = $this->load->view('admin/candidate', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

}

/* End of file candidates.php */
/* Location: ./application/controllers/admin/candidates.php */
