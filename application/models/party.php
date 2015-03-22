<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Party extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = 'parties';
	}

}

/* End of file party.php */
/* Location: ./application/models/party.php */
