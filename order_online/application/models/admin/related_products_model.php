<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Related_products_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'related_products';
	}
	
	public function save($related_products, $parent_product_id)
	{
		$this->delete(array('parent_product_id' => $parent_product_id));
		foreach ($related_products as $k => $v)
		{
			$ins['product_id'] = $v;
			$ins['parent_product_id'] = $parent_product_id;
			parent::save($ins);
		}
	}
}
// END Related_products_model class

/* End of file related_products_model.php */
/* location models/admin/related_products_model.php */