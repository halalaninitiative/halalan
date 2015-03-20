<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends MY_Controller {

	public function index()
	{
		$where = array('admin_id' => $this->admin['id']);
		$data['events'] = $this->Event->select_all_where($where);
		$admin['title'] = 'Manage Events';
		$admin['body'] = $this->load->view('admin/events', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

	public function add()
	{
		$event = array('event' => '', 'slug' => '');
		$this->_event($event, 'add');
	}

	public function edit($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'admin_id' => $this->admin['id']);
		$event = $this->Event->select_where($where);
		if ( ! $event)
		{
			show_404();
		}
		$this->_event($event, 'edit', $id);
	}

	public function delete($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'admin_id' => $this->admin['id']);
		$event = $this->Event->select_where($where);
		if ( ! $event)
		{
			show_404();
		}
		$this->Event->delete($id);
		$this->session->set_flashdata('messages', array('success', 'The event has been successfully deleted.'));
		redirect('admin/events');
	}

	public function manage($id = NULL)
	{
		if ( ! $id)
		{
			show_404();
		}
		$where = array('id' => $id, 'admin_id' => $this->admin['id']);
		$event = $this->Event->select_where($where);
		if ( ! $event)
		{
			show_404();
		}
		$this->session->set_userdata('manage_event_id', $event['id']);
		$this->session->set_userdata('manage_event_event', $event['event']);
		$this->session->set_flashdata('messages', array('success', 'The event has been successfully chosen.'));
		redirect('admin/events');
	}

	private function _event($event, $action, $id = NULL)
	{
		$this->form_validation->set_rules('event', 'Event', 'required');
		$this->form_validation->set_rules('slug', 'Slug', 'required|is_unique_x[' . $action . '.events.slug.' . $id . ']');
		if ($this->form_validation->run())
		{
			$event['admin_id'] = $this->admin['id'];
			$event['event'] = $this->input->post('event', TRUE);
			$event['slug'] = $this->input->post('slug', TRUE);
			if ($action == 'add')
			{
				$this->Event->insert($event);
				$this->session->set_flashdata('messages', array('success', 'The event has been successfully added.'));
				redirect('admin/events/add');
			}
			else if ($action == 'edit')
			{
				$this->Event->update($event, $id);
				$this->session->set_flashdata('messages', array('success', 'The event has been successfully edited.'));
				redirect('admin/events/edit/' . $id);
			}
		}
		$data['event'] = $event;
		$data['action'] = $action;
		$admin['title'] = ucfirst($action) . ' Event';
		$admin['body'] = $this->load->view('admin/event', $data, TRUE);
		$this->load->view('layouts/admin', $admin);
	}

}

/* End of file events.php */
/* Location: ./application/controllers/admin/events.php */
