<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Abmin extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = 'admins';
	}

	public function authenticate($username, $password)
	{
		$admin = $this->select_where(array('username' => $username));
		if ($admin)
		{
			if (password_verify($password, $admin['password']))
			{
				return $admin;
			}
		}
		return FALSE;
	}

}

/* End of file abmin.php */
/* Location: ./application/models/abmin.php */
