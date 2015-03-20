<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	public function is_unique_x($str, $param)
	{
		list($action, $table, $field, $id) = explode('.', $param);
		if ($action == 'edit')
		{
			$query = $this->CI->db->limit(1)->get_where($table, array('id' => $id));
			$row = $query->row_array();
			if ($str == $row[$field])
			{
				return TRUE;
			}
		}
		if ( ! $this->CI->form_validation->is_unique($str, $table . '.' . $field))
		{
			$this->CI->form_validation->set_message('is_unique_x', 'The %s field must contain a unique value.');
			return FALSE;
		}
		return TRUE;
	}

}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */
