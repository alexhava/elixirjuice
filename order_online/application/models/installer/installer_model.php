<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Installer_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'members';
	}
}
// END Installer_model class

/* End of file Installer_model.php */
/* location models/installer/Installer_model.php */