<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_stores_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'production_stores';
	}
}
// END Production_stores_model class

/* End of file production_stores_model.php */
/* location models/admin/production_stores_model.php */