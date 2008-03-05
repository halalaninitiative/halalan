<?php

class Statistics extends Model {

	function Statistics()
	{
		parent::Model();
	}

	function count_all_voters()
	{
		$this->db->from('voters');
		return $this->db->count_all_results();
	}

	function count_voted()
	{
		$this->db->from('voters');
		$this->db->where(array('voted'=>'1'));
		return $this->db->count_all_results();
	}

}

?>
