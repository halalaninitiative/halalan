<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// check for installer
		$this->load->helper('url');
		if (file_exists(APPPATH . 'controllers/install.php'))
		{
			redirect('install');
		}
	}

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
