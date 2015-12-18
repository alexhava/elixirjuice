<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cards_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'cards';
	}
	
	public function primary()
	{
		$r = $this->get_row(array('primary'=>'Y','member_id'=>ci()->user_session_data['member_id']));
		if($r)
		return $r['card_id'];
	}
	
	public function get_cards()
	{
		$ret = array();
		$arr = $this->get(array('member_id'=>ci()->user_session_data['member_id']));
		if($arr)
		{
			foreach ($arr as $row)
			{
				$ret[$row['card_id']] = '****'.substr_replace($row['card_num'],'',0,12)." ({$row['card_exp']})";
			}
		}
		
		return $ret;
	}
}
// END Cards_model class

/* End of file cards_model.php */
/* location models/users/_model.php */