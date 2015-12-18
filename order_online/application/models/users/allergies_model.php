<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Allergies_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'allergies';
	}
	
	public function get_user_allergies($member_id)
	{
		$ret = array();
		$res = $this->get(array('member_id'=>ci()->user_session_data['member_id']));
		foreach ($res as $allergy) 
		{
			$ret[] = $allergy['allergy'];
		}
		
		return $ret;
	}
}
// END Allergies_model class

/* End of file Allergies_model.php */
/* location models/admin/Allergies_model.php */