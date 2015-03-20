<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = 'events';
	}

}

/* End of file event.php */
/* Location: ./application/models/event.php */
