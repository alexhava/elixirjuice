<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stores_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'stores';
	}
	
	public function get_statuses()
	{
		return array(
			'Open' => 'Open',
			'Closed' => 'Closed',
			'Coming Soon' => 'Coming Soon',
		);
	}
	
	public function get_stores($state='', $status=false)
	{
		$options = ! $state ? array() : array('where'=>array('state'=>$state));
		if($status)
			$options['where']['store_status'] = $status;
		$data = $this->get($options);
		$ret = array();
		foreach ($data as $k => $row) 
		{
			$ret[$row['store_id']] = $row['store_address'];
		}
		return $ret;
	}	
}
// END Stores_model class

/* End of file Stores_model.php */
/* location models/admin/Stores_model.php */