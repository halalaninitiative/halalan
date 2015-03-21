<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Elections extends MY_Controller {

	private $event_id;

	public function __construct()
	{
		parent::__construct();
		$this->event_id = $this->session->userdata('manage_event_id');
	}

	public function index()
	{
		$where = array('event_id' => $this->event_id);
		$elections = $this->Election->select_all_where($where);
		foreach ($elections as $key => $election)
		{
			$abmin = 'None';
			$admin = $this->Abmin->select_where(array('id' => $election['admin_id']));
			if ($admin)
			{
				$abmin = $admin['username'];
			}
			$elections[$key]['admin'] = $abmin;
		}
		$data['elections'] = $elections;
		$admin['title'] = 'Manage Elections';
		$admin['body'] = $this->load->view('admin/elections', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

	public function add()
	{
		$election = array('election' => '', 'admin_id' => NULL);
		$this->_election($election, 'add');
	}

	public function edit($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'event_id' => $this->event_id);
		$election = $this->Election->select_where($where);
		if ( ! $election)
		{
			show_404();
		}
		$this->_election($election, 'edit', $id);
	}

	public function delete($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'event_id' => $this->event_id);
		$election = $this->Election->select_where($where);
		if ( ! $election)
		{
			show_404();
		}
		$this->Election->delete($id);
		$this->session->set_flashdata('messages', array('success', 'The election has been successfully deleted.'));
		redirect('admin/elections');
	}

	public function manage($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'event_id' => $this->event_id);
		$election = $this->Election->select_where($where);
		if ( ! $election)
		{
			show_404();
		}
		$this->session->set_userdata('manage_election_id', $election['id']);
		$this->session->set_userdata('manage_election_election', $election['election']);
		$this->session->set_flashdata('messages', array('success', 'The election has been successfully chosen.'));
		redirect('admin/elections');
	}

	private function _election($election, $action, $id = NULL)
	{
		$this->form_validation->set_rules('election', 'Election', 'required');
		// TODO: check that admin_id is created by the admin user
		// TODO: also check that the admin_id is not yet assigned to an election
		$this->form_validation->set_rules('admin_id', 'Admin');
		if ($this->form_validation->run())
		{
			$election['event_id'] = $this->event_id;
			$election['election'] = $this->input->post('election', TRUE);
			if ($this->input->post('admin_id'))
			{
				$election['admin_id'] = $this->input->post('admin_id');
			}
			else
			{
				$election['admin_id'] = NULL;
			}
			if ($action == 'add')
			{
				$this->Election->insert($election);
				$this->session->set_flashdata('messages', array('success', 'The election has been successfully added.'));
				redirect('admin/elections/add');
			}
			else if ($action == 'edit')
			{
				$this->Election->update($election, $id);
				$this->session->set_flashdata('messages', array('success', 'The election has been successfully edited.'));
				redirect('admin/elections/edit/' . $id);
			}
		}
		if ($action == 'edit')
		{
			$data['admin'] = $this->Abmin->select_where(array('id' => $election['admin_id']));
		}
		$where = array('admin_id' => $this->admin['id'], 'type' => 'election');
		$data['admins'] = $this->Abmin->select_all_where($where);
		$data['admin_ids'] = $this->Election->get_admin_ids($this->event_id);
		$data['election'] = $election;
		$data['action'] = $action;
		$admin['title'] = ucfirst($action) . ' Election';
		$admin['body'] = $this->load->view('admin/election', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

}

/* End of file elections.php */
/* Location: ./application/controllers/admin/elections.php */
