<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_items_model extends Db_lib {
	
	public function __construct()
	{
		parent::__construct();
		$this->table = 'order_items';
	}
}
// END Order_items_model class

/* End of file Order_items_model.php */
/* location models/admin/Order_items_model.php */