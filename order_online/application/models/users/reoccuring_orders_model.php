<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reoccuring_orders_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'reoccuring_orders';
	}
	
	public function get_reoccuring_orders($opt)
	{
		$opt['join'][0]['table'] = 'addresses a';
		$opt['join'][0]['cond'] = 'a.address_id=reoccuring_orders.address_id';
		$opt['join'][0]['type'] = 'left';
		$opt['join'][1]['table'] = 'members m';
		$opt['join'][1]['cond'] = 'm.member_id=reoccuring_orders.member_id';
		$opt['join'][1]['type'] = 'left';
		$opt['join'][2]['table'] = 'cards c';
		$opt['join'][2]['cond'] = 'c.card_id=reoccuring_orders.card_id';	
		$opt['join'][2]['type'] = 'left';
		
		$res = $this->get($opt);
		$opt['join']['table'] = 'products p';
		$opt['join']['cond'] = 'p.product_id=reoccuring_order_products.product_id';
		foreach ($res as $k => $ro) 
		{
			$opt['where'] = array('reoccuring_order_id'=>$ro['reoccuring_order_id']);
			$res[$k]['products'] = $this->get($opt, 'reoccuring_order_products');
			foreach ($res[$k]['products'] as $k1 => $product)
			{
				$res[$k]['qty'][$k1] = $product['qty'];
				$res[$k]['delivery_type'][$product['product_id']] = $product['delivery_type'];
			}
		}
		
		return $res;
	}
	
	public function get_reoccuring_order($opt)
	{
		$opt['join'][0]['table'] = 'addresses a';
		$opt['join'][0]['cond'] = 'a.address_id=reoccuring_orders.address_id';
		$opt['join'][0]['type'] = 'left';
		$opt['join'][1]['table'] = 'members m';
		$opt['join'][1]['cond'] = 'm.member_id=reoccuring_orders.member_id';
		$opt['join'][1]['type'] = 'left';
		$opt['join'][2]['table'] = 'cards c';
		$opt['join'][2]['cond'] = 'c.card_id=reoccuring_orders.card_id';	
		$opt['join'][2]['type'] = 'left';		
		$res = $this->get_row($opt);
		$opt['order_by'] = '';
		$opt['join']['table'] = 'products p';
		$opt['join']['cond'] = 'p.product_id=reoccuring_order_products.product_id';
		$opt['where'] = array('reoccuring_order_id'=>$res['reoccuring_order_id']);
		$products = $this->get($opt, 'reoccuring_order_products');

		foreach ($products as $k => $product) 
		{
			$res['products'][$k] = $product['product_id'];
			$res['qty'][$k] = $product['qty'];
			$res['delivery_type'][$product['product_id']] = $product['delivery_type'];
		}
		

		return $res;
	}
	
	public function prepare_products($products, $glue='<br>')
	{
		$arr = array();
		foreach ($products as $k => $v) 
		{
			$arr[] = $v['product_title'];
		}
		
		return implode($glue, $arr);
	}
}
// END Reoccuring_orders_model class

/* End of file reoccuring_orders_model.php */
/* location models/users/reoccuring_orders_model.php */