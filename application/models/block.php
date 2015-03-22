<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Block extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = 'blocks';
	}

}

/* End of file block.php */
/* Location: ./application/models/block.php */
