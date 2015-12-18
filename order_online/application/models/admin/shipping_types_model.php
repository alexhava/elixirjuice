<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipping_types_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'shipping_types';
	}
}
// END shipping_types_model class

/* End of file shipping_types_model.php */