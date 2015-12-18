<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address_book_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'addresses';
	}
	
	public function get_by_id($address_id)
	{
		$r = $this->get_row(array('address_id'=>$address_id, 'member_id'=>ci()->user_session_data['member_id']));
		
		return $r;
	}
	
	public function primary()
	{
		$r = $this->get_row(array('primary'=>'y', 'member_id'=>ci()->user_session_data['member_id']));
		if($r)
		return $r['address_id'];
	}

	public function get_addresses()
	{
		$ret = array();
		$arr = $this->get(array('member_id'=>ci()->user_session_data['member_id']));
		if($arr)
		{
			foreach ($arr as $row)
			{
				$ret[$row['address_id']] = "{$row['name']}, {$row['address1']}, ".ci()->taxes_model->get_state_by_id($row['region']).", {$row['postcode']}";
			}
		}
		
		return $ret;
	}	
}
// END Address_book_model class

/* End of file Address_book_model.php */
/* location models/admin/Address_book_model.php */