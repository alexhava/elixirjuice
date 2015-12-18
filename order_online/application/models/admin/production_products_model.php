<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_products_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'production_products';
	}
	
	public function format_product_ingredients($product_id, $type='implode')
	{
		$options['where'] =  array('production_product_id'=>$product_id);
		$options['join'] = array(
			'table' => 'production_product_ingredients',
			'cond' => 'production_ingredients.production_ingredient_id=production_product_ingredients.production_ingredient_id'
		);
		$products = $this->format('ingredient_name', $options, null, 'production_ingredients');
		if($type == "implode")
		return implode(', ', $products);
		
		return $products;
	}
	
	public function get_weight_types()
	{
		return array('oz', 'ml', 'lb', 'tsp', 'tbsp');
	}
}
// END Production_products_model class

/* End of file production_products_model.php */
/* location models/admin/production_products_model.php */