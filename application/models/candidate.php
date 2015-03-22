<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = 'candidates';
	}

}

/* End of file candidate.php */
/* Location: ./application/models/candidate.php */
