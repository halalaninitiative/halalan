<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Positions extends MY_Controller {

	private $election_id;

	public function __construct()
	{
		parent::__construct();
		$this->election_id = $this->session->userdata('manage_election_id');
	}

	public function index()
	{
		$where = array('election_id' => $this->election_id);
		$data['positions'] = $this->Position->select_all_where($where);
		$admin['title'] = 'Manage Parties';
		$admin['body'] = $this->load->view('admin/positions', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

	public function add()
	{
		$position = array('position' => '', 'maximum' => 1, 'abstain' => 1);
		$this->_position($position, 'add');
	}

	public function edit($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'election_id' => $this->election_id);
		$position = $this->Position->select_where($where);
		if ( ! $position)
		{
			show_404();
		}
		$this->_position($position, 'edit', $id);
	}

	public function delete($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'election_id' => $this->election_id);
		$position = $this->Position->select_where($where);
		if ( ! $position)
		{
			show_404();
		}
		$this->Position->delete($id);
		$this->session->set_flashdata('messages', array('success', 'The position has been successfully deleted.'));
		redirect('admin/positions');
	}

	private function _position($position, $action, $id = NULL)
	{
		$this->form_validation->set_rules('position', 'Position', 'required');
		$this->form_validation->set_rules('maximum', 'Maximum', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('abstain', 'Abstain');
		if ($this->form_validation->run())
		{
			$position['election_id'] = $this->election_id;
			$position['position'] = $this->input->post('position', TRUE);
			$position['maximum'] = $this->input->post('maximum');
			$position['abstain'] = $this->input->post('abstain');
			if ($action == 'add')
			{
				$this->Position->insert($position);
				$this->session->set_flashdata('messages', array('success', 'The position has been successfully added.'));
				redirect('admin/positions/add');
			}
			else if ($action == 'edit')
			{
				$this->Position->update($position, $id);
				$this->session->set_flashdata('messages', array('success', 'The position has been successfully edited.'));
				redirect('admin/positions/edit/' . $id);
			}
		}
		$data['position'] = $position;
		$data['action'] = $action;
		$admin['title'] = ucfirst($action) . ' Position';
		$admin['body'] = $this->load->view('admin/position', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

}

/* End of file positions.php */
/* Location: ./application/controllers/admin/positions.php */
