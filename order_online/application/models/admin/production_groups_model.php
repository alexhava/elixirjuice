<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_groups_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'production_groups';
	}
	
	public function get_production_groups()
	{
		$options['order_by'] = 'group_name';
		$data = $this->get($options);
		$ret = array();
		foreach ($data as $k => $row) 
		{
			$ret[$row['production_group_id']] = $row['group_name'];
		}
		return $ret;
	}	
}
// END Production_groups_model class

/* End of file production_groups_model.php */
/* location models/admin/production_groups_model.php */