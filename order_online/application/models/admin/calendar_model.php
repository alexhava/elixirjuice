<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'calendar_days_off';
	}
	
	public function get_stamps(){
		$data = $this->get();
		$r = array();
		foreach ($data as $row) 
		{
			$day = $row['day'] ? $row['day'] : date('d');
			$month = $row['month'] ? $row['month'] : date('m');
			$year = $row['year'] ? $row['month'] : date('y');
			$stamp = mktime(0,0,0,$month, $day, $year);
			$r[$stamp] = $row['note'];
		}
		
		return $r;
	}
}
// END Calendar_model class

/* End of file Calendar_model.php */
/* location models/admin/Calendar_model.php */