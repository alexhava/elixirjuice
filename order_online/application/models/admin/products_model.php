<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'products';
	}
	
	public function get_product($product_id)
	{
		return $this->get_row(array('product_id'=>$product_id));
	}
	
	public function get_sale_products()
	{
		$ret = array();
		$opt['where']['order_online'] = 'y';
		$opt['orderby'] = 'product_title';
		$rows = $this->get($opt);
		foreach ($rows as $row) 
		{
			$ret['- Select Product -'][$row['product_id']] = $row['product_title'];
		}
		return $ret;
	}
	
	public function get_product_shipping_areas($product_id)
	{
		$data = $this->get(array('product_id'=>$product_id), 'products_shipping');
		$ret = array();
		foreach ($data as $v)
		{
			$ret[] = $v['state'];
		}
		return $ret;
	}
	
	public function save($data, $where=array(), $table='', $exclude=array())
	{
		
		if(isset($data['product_options']))
		{
			$data['product_options'] = base64_encode(json_encode($data['product_options']));
		}

		return parent::save($data, $where, $table, $exclude);
	}
	
	public function get($opts, $table='', $type='result', $protect=true)
	{
		ci()->load->model('admin/related_products_model');
		$res = parent::get($opts, $table, $type, $protect);
		if(is_array($res)) 
		{
			foreach ($res as $k => $r) 
			{
				if(is_array($r) and isset($r['product_id']))
				{
					$related_products = ci()->related_products_model->format('product_id', array('parent_product_id' => $r['product_id']));
					$res[$k]['related_products'] = $related_products;
					$res[$k]['product_options'] = json_decode(base64_decode($r['product_options']));		
				}
			}
		}
		return $res;
	}
	
	public function get_row($opts, $table='', $type='result', $protect=true)
	{
		$product_id = isset($opts['where']) ? $opts['where']['product_id'] : $opts['product_id'];
		ci()->load->model('admin/related_products_model');
		$res = parent::get_row($opts, $table, $type, $protect);
		$related_products = ci()->related_products_model->format('product_id', array('parent_product_id' => $product_id));
		$res['related_products'] = $related_products;
		$res['product_options'] = json_decode(base64_decode($res['product_options']));
		
		return $res;
	}
	
}
// END Products_model class

/* End of file Products_model.php */
/* location models/admin/Products_model.php */