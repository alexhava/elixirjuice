<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Start {
	var $models = 'admin/Categories_model';
	public function __construct()
	{
		ci()->load->library(array('javascript','image_lib', 'session', 'cart'));
		$vars['checkout_url'] = 'http://'.$_SERVER['SERVER_NAME'].'/cart/checkout';
		ci()->load->vars($vars);
		ci()->index_view = 'index2';
	}
	
	public function index()
	{
		$this->show_content('order-online');
	}	
	
	public function calendar()
	{
		ci()->load->library('cleanses_calendar');
		ci()->load->model(array('admin/stores_model', 'admin/shipping_schedule_model', 'cart_model'));
		$m = ci()->input->get('month');
		$y = ci()->input->get('year');
		$dt = ci()->input->get('delivery_type');
		$zip = ci()->input->get('zip');
		$options['store_id'] = ci()->input->get('store_id');

		if($dt == 'deliver')
		{
			$opt = array(
				'custom' => "delivery_zip like '%$zip%'" 
			);
			
			$store_data = ci()->stores_model->get_row($opt);	
			$store_data['open_days'] = serialize(array_values(unserialize($store_data['delivery_days'])));
			$store_id = ci()->input->get('store_id').'&delivery_type='.$dt.'&zip='.$zip;		
		}
		elseif($dt == 'shipping')
		{
			$shipping_schedules = ci()->shipping_schedule_model->format('shipping_days');
			$shipping_schedules_prio = ci()->shipping_schedule_model->format('prio');
			$store_data['open_days'] = serialize(ci()->cart_model->calc_shipping_schedule(ci()->cart->contents(), $shipping_schedules, $shipping_schedules_prio));
			$store_data['lead_time'] = 0;
		}
		else
		{
			$store_data = ci()->stores_model->get_row($options);
			$store_id = ci()->input->get('store_id');
		}
		
		
		echo ci()->cleanses_calendar->get_html($m, $y, $store_data, @$store_id, $dt);
		exit;
	}
	
	public function show_content($cat_title)
	{
		$args = func_get_args();
		switch ($args[0]) {
			case 'calendar':
				$this->calendar();break;
			case 'order-online':
			case 'menus-stories':
				$view = @$args[2] == 'product' ? 'product' : 'order_online';
				$this->_show_content('menus-stories', $view, $args, $args[0] == 'order-online', 'order_online', $args[0]);
				break;		
			default:
				$this->_show_content($args[0], 'order_online', $args);
				break;
		}
	}
	
	private function _show_content($cat_title, $view, $args, $order_online=false, $default_view='', $real_view)
	{
		if($real_view == 'order-online')
			$vars['hide_sub'] = true;
		
		ci()->load->model('admin/products_model');
		$cat_data = ci()->_model->get_row(array('cat_url_title'=>$cat_title));

		if( ! $cat_data) return ;
		
		$options['where'] = array('parent_id'=>$cat_data['cat_id']);
		$options['order_by'] = 'cat_order';
		if($order_online)
		{
			if(ci()->user_session_data['wholesale_enabled'] == 'n')
			$wholesale_where = " and wholesale_only != 'y'";
				
			$options['join']['table'] = 'products p';
			$options['join']['cond'] = 'p.cat_id=categories.cat_id and order_online="y"'.@$wholesale_where;
			$options['group_by']='categories.cat_id';
		}
		$sub_categories = ci()->_model->get($options);

		$default = isset($args[1]) ? $args[1] : '';
		$cat_content = $active = '';
		foreach ($sub_categories as $k=>$cat) 
		{
			if ($default and $cat['cat_url_title'] == $default) 
			{
				$cat_content = $cat['cat_description'];
				$active = $default;
				$parent_cat_id = $cat['cat_id'];
			}
			
			if($cat['visible'] == 'n')
				unset($sub_categories[$k]);
		}
		
		reset($sub_categories);
		if( ! @$active)
		{
			$cat = current($sub_categories);
			$cat_content = $cat['cat_description'];
			$active = $cat['cat_url_title'];
			$parent_cat_id = $cat['cat_id'];
		}
		
		if($order_online)
		{
			$product_options['where']['order_online'] = 'y';
			if(ci()->user_session_data['wholesale_enabled'] == 'n')
			$product_options['where']['wholesale_only !='] = 'y';
		}
		if(@$args[2] != 'product')
		{
			$product_options['where']['cat_id'] = $parent_cat_id;
			$product_options['order_by'] = 'product_order';
			$vars['products'] = ci()->products_model->get($product_options);
		}
		else
		{
			$product_options['where'] = array('product_id'=>$args[3]);
			$vars['product'] = ci()->products_model->get_row($product_options);
		}
		
		//prepare splash content
		unset($product_options['where']['cat_id']);
		$product_options['order_by'] = 'product_order';
		$product_options['dir'] = 'desc';
		$vars['products_splash'] = ci()->products_model->get($product_options);
		// still no content ? Trying 3d level menu
		$options['where'] = array('parent_id'=>$parent_cat_id, 'visible'=>'y');
		$sub_sub_categories = ci()->_model->get($options);
		if ($sub_sub_categories) 
		{
			$default2 = isset($args[2]) ? $args[2] : '';
			reset($sub_categories);
			$cat = current($sub_categories);
			foreach ($sub_sub_categories as $cat)
			{
				if ($default2 and $cat['cat_url_title'] == $default2)
				{
					$cat_content = $cat['cat_description'];
					$active2 = $default2;
				}

			}
			if( ! @$active2 )
			{
				reset($sub_sub_categories);
				$cat = current($sub_sub_categories);
				$cat_content = $cat['cat_description'];
				$active2 = $cat['cat_url_title'];
			}
			$vars['active2'] = $active2;
		}
		
		$vars['root'] = $args[0];
		$vars['active'] = $active;
		$vars['cat_content'] = $cat_content;
		$vars['sub_categories'] = $sub_categories;
		$vars['sub_sub_categories'] = $sub_sub_categories;
		
		
		ci()->javascript->compile();
		if(! isset($args[1]) and $default_view)	
		{
			$view = $default_view;
			$vars['active_splash'] = $vars['active'];
			$vars['active'] = false;
		}
		
		ci()->load->view($view, $vars);
	}
}
/* End of file Start.php */
/* Location: ./application/controllers/Start.php */