<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function index()
	{
		$admin['title'] = 'Dashboard';
		$admin['body'] = $this->load->view('admin/dashboard', '', TRUE);
		$this->load->view('layouts/admin', $admin);
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */
