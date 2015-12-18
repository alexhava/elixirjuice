<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'members';
	}
}
// END Admin_model class

/* End of file Admin_model.php */
/* location models/admin/Admin_model.php */