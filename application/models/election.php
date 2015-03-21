<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Election extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = 'elections';
	}

	public function get_admin_ids($event_id)
	{
		$where = array('event_id' => $event_id);
		$elections = $this->select_all_where($where);
		$admin_ids = array();
		foreach ($elections as $election)
		{
			$admin_ids[] = $election['admin_id'];
		}
		return array_unique($admin_ids);
	}

}

/* End of file election.php */
/* Location: ./application/models/election.php */
