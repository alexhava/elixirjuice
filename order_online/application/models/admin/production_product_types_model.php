<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_product_types_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'production_product_types';
	}
}
// END Production_product_types_model class

/* End of file production_product_types_model.php */
/* location models/admin/production_product_types_model.php */