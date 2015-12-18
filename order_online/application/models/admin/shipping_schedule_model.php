<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipping_schedule_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'shipping_schedule';
	}
}
// END shipping_schedule_model class

/* End of file shipping_schedule_model.php */