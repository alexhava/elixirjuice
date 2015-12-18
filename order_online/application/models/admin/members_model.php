<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'members';
	}


	public function get_members()
	{
		$data = $this->get(array('order_by'=>'name'));
		$ret = array();
		foreach ($data as $k => $row)
		{
			$ret[$row['member_id']] = $row['username'];
		}
		return $ret;
	}
}
// END Members_model class

/* End of file Members_model.php */
/* location models/admin/Members_model.php */