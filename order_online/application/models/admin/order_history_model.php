<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_history_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'order_history';
	}
	
	public function write_history($order_data)
	{
		$save['order_id'] = $order_data['order_id'];
		$save['order_status'] = $order_data['order_status'];
		$save['change_date'] = mktime();
		
		return $this->save($save);
	}
}
// END Order_history_model class

/* End of file Order_history_model.php */
/* location models/admin/Order_history_model.php */