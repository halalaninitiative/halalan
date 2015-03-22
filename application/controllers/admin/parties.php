<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parties extends MY_Controller {

	private $event_id;

	public function __construct()
	{
		parent::__construct();
		$this->event_id = $this->session->userdata('manage_event_id');
	}

	public function index()
	{
		$where = array('event_id' => $this->event_id);
		$data['parties'] = $this->Party->select_all_where($where);
		$admin['title'] = 'Manage Parties';
		$admin['body'] = $this->load->view('admin/parties', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

	public function add()
	{
		$party = array('party' => '', 'alias' => '', 'description' => '');
		$this->_party($party, 'add');
	}

	public function edit($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'event_id' => $this->event_id);
		$party = $this->Party->select_where($where);
		if ( ! $party)
		{
			show_404();
		}
		$this->_party($party, 'edit', $id);
	}

	public function delete($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'event_id' => $this->event_id);
		$party = $this->Party->select_where($where);
		if ( ! $party)
		{
			show_404();
		}
		$this->Party->delete($id);
		$this->session->set_flashdata('messages', array('success', 'The party has been successfully deleted.'));
		redirect('admin/parties');
	}

	private function _party($party, $action, $id = NULL)
	{
		$this->form_validation->set_rules('party', 'Party', 'required');
		$this->form_validation->set_rules('alias', 'Alias');
		$this->form_validation->set_rules('description', 'Description');
		$this->form_validation->set_rules('logo', 'Logo');
		if ($this->form_validation->run())
		{
			$party['event_id'] = $this->event_id;
			$party['party'] = $this->input->post('party', TRUE);
			$party['alias'] = $this->input->post('alias', TRUE);
			$party['description'] = $this->input->post('description', TRUE);
			$party['logo'] = ''; // TODO: Add upload
			if ($action == 'add')
			{
				$this->Party->insert($party);
				$this->session->set_flashdata('messages', array('success', 'The party has been successfully added.'));
				redirect('admin/parties/add');
			}
			else if ($action == 'edit')
			{
				$this->Party->update($party, $id);
				$this->session->set_flashdata('messages', array('success', 'The party has been successfully edited.'));
				redirect('admin/parties/edit/' . $id);
			}
		}
		$data['party'] = $party;
		$data['action'] = $action;
		$admin['title'] = ucfirst($action) . ' Party';
		$admin['body'] = $this->load->view('admin/party', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

}

/* End of file parties.php */
/* Location: ./application/controllers/admin/parties.php */
