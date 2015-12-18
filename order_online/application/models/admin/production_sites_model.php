<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_sites_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'production_sites';
	}
	
	public function format_produced_products($site_id, $type='implode')
	{
		$options['where'] =  array('production_site_id'=>$site_id);
		$options['join'] = array(
			'table' => 'production_products pp',
			'cond' => 'pp.production_product_id=production_sites_produced_products.production_product_id'
		);
		$products = $this->format('product_name', $options, null, 'production_sites_produced_products');
		if($type == "implode")
		return implode(', ', $products);
		
		return $products;
	}	
	
	public function format_products()
	{
		$ret = array();
		$options['join'] = array(
				'cond'=>'pt.production_product_type_id=production_products.production_product_type_id',
				'table'=>'production_product_types pt',
				'type'=>'left'
			);
		$options['order_by'] = 'product_name';	
		$products = $this->get($options, 'production_products');
		foreach ($products as $k => $v) 
		{
			$ret[$v['production_product_type_name']]['products'][$v['production_product_id']] = $v['product_name'];
		}
		
		return $ret;
	}	
}
// END Production_sites_model class

/* End of file production_sites_model.php */
/* location models/admin/production_sites_model.php */