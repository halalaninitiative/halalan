<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blocks extends MY_Controller {

	private $election_id;

	public function __construct()
	{
		parent::__construct();
		$this->election_id = $this->session->userdata('manage_election_id');
	}

	public function index()
	{
		$where = array('election_id' => $this->election_id);
		$data['blocks'] = $this->Block->select_all_where($where);
		$admin['title'] = 'Manage Blocks';
		$admin['body'] = $this->load->view('admin/blocks', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

	public function add()
	{
		$block = array('block' => '', 'description' => '');
		$this->_block($block, 'add');
	}

	public function edit($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'election_id' => $this->election_id);
		$block = $this->Block->select_where($where);
		if ( ! $block)
		{
			show_404();
		}
		$this->_block($block, 'edit', $id);
	}

	public function delete($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'election_id' => $this->election_id);
		$block = $this->Block->select_where($where);
		if ( ! $block)
		{
			show_404();
		}
		$this->Block->delete($id);
		$this->session->set_flashdata('messages', array('success', 'The block has been successfully deleted.'));
		redirect('admin/blocks');
	}

	private function _block($block, $action, $id = NULL)
	{
		$this->form_validation->set_rules('block', 'block', 'required');
		$this->form_validation->set_rules('description', 'Description');
		if ($this->form_validation->run())
		{
			$block['election_id'] = $this->election_id;
			$block['block'] = $this->input->post('block', TRUE);
			$block['description'] = $this->input->post('description');
			if ($action == 'add')
			{
				$this->Block->insert($block);
				$this->session->set_flashdata('messages', array('success', 'The block has been successfully added.'));
				redirect('admin/blocks/add');
			}
			else if ($action == 'edit')
			{
				$this->Block->update($block, $id);
				$this->session->set_flashdata('messages', array('success', 'The block has been successfully edited.'));
				redirect('admin/blocks/edit/' . $id);
			}
		}
		$data['block'] = $block;
		$data['action'] = $action;
		$admin['title'] = ucfirst($action) . ' block';
		$admin['body'] = $this->load->view('admin/block', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

}

/* End of file blocks.php */
/* Location: ./application/controllers/admin/blocks.php */
