<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'orders';
	}
	
	public function get_statuses()
	{
		$options['group_by'] = 'order_status';
		$options['order_by'] = 'order_status';
		$res = $this->get($options);
		$statuses = array();
		foreach ($res as $row) 
		{
			$statuses[$row['order_status']] = $row['order_status'];
		}
		if(@ci()->system_settings['order_statuses'])
		{
			$order_statuses = explode("\n", ci()->system_settings['order_statuses']);
			foreach ($order_statuses as $status)
			{
				$statuses[$status] = $status;
			}
		}
		asort($statuses);
		$statuses = array(''=>'- ' . lang('order_status') . ' - ')+$statuses;
		return $statuses;
	}
	
	public function delete($arr)
	{
		if($arr)
		{
			parent::delete($arr);
			parent::delete($arr, 'order_items');
		}
	}
}
// END Orders_model class

/* End of file Orders_model.php */
/* location models/admin/Orders_model.php */