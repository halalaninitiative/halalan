<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = 'positions';
	}

}

/* End of file position.php */
/* Location: ./application/models/position.php */
