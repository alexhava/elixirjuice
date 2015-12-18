<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'groups';
	}
	
	public function get_permissions($group_id)
	{
		$group_data = $this->get(array('where'=>array('group_id'=>$group_id)), 'permissions');
		$ret = array();
		foreach ($group_data as $k => $row) 
		{
			$ret[$row['page']] = 1;
		}
		return $ret;
	}
	
	public function get_group_types()
	{
		return array(lang('administrators'), lang('users'));
	}
	
	public function get_groups()
	{
		$group_data = $this->get();
		$ret = array();
		foreach ($group_data as $k => $row) 
		{
			$ret[$row['group_id']] = $row['group_name'];
		}
		return $ret;
	}
}
// END Groups_model class

/* End of file Groups_model.php */
/* location models/admin/Groups_model.php */