<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_model extends Db_lib {
	var $row;
	public function __construct()
	{
		parent::__construct();
		$this->table = 'sys_settings';
	}
	
	public function get_version()
	{
		$this->row = $data = $this->get_row();
		return $data['version'];
	}
	
	public function get_settings()
	{
		$this->row = $data = $this->get_row();
		return (array)@unserialize($data['settings']);
	}
	
	public function update_version($version)
	{
		$upd['version'] = $version;
		$this->save($upd, array('setting_id'=>$this->row['setting_id']));
	}
	
	public function save_settings()
	{
		$upd['settings'] = serialize(ci()->system_settings);
		$this->save($upd, array('setting_id'=>$this->row['setting_id']));
	}
}
// END System_model class

/* End of file System_model.php */
/* location models/admin/System_model.php */