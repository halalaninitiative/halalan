<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $admin;

	public function __construct()
	{
		parent::__construct();

		// check for installer
		if (file_exists(APPPATH . 'controllers/install.php'))
		{
			$this->load->helper('url');
			redirect('install');
		}

		// autoload
		$this->load->library(array('form_validation', 'session'));
		$this->load->helper(array('form', 'halalan', 'password', 'url'));
		$this->load->model(array('Abmin', 'Block', 'Candidate', 'Election', 'Event', 'Party', 'Position'));

		// get the current class
		$class = get_class($this);

		// check if signed in
		if ($class != 'Gate')
		{
			$this->admin = $this->session->userdata('admin');
			if ( ! $this->admin)
			{
				show_error('Forbidden', 403);
			}
		}

		// check Admin access
		if ($class == 'Admins')
		{
			if ( ! in_array($this->admin['type'], array('super', 'event')))
			{
				show_error('Forbidden', 403);
			}
		}

		// check if an event is chosen
		if (in_array($class, array('Elections', 'Parties')))
		{
			if ( ! $this->session->userdata('manage_event_id'))
			{
				$this->session->set_flashdata('messages', array('danger', 'Choose an event to manage first.'));
				redirect('admin/events');
			}
		}

		// check if an election is chosen
		if (in_array($class, array('Blocks', 'Candidates', 'Positions')))
		{
			if ( ! $this->session->userdata('manage_election_id'))
			{
				$this->session->set_flashdata('messages', array('danger', 'Choose an election to manage first.'));
				redirect('admin/elections');
			}
		}
	}

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
