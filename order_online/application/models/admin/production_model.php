<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'production';
	}
}
// END Production_model class

/* End of file production_model.php */