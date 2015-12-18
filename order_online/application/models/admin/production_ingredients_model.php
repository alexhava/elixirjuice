<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_ingredients_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'production_ingredients';
	}
	
	public function get_types()
	{
		return array(lang('fruit'), lang('vegetable'), lang('supplement'));
	}
	
	public function get_forms()
	{
		return array(lang('raw_solid'), lang('liquid'), lang('frozen', 'prepackaged'));
	}
	
	
}
// END Production_ingredients_model class

/* End of file production_ingredients_model.php */
/* location models/admin/production_ingredients_model.php */