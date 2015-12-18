<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart_model extends CI_Model {
	public function calc_shipping_schedule($cart_items, $shipping_schedules, $shipping_schedule_prio)
	{
		$schedule_prio = 10000;
		$schedule = '';
		foreach ($cart_items as $i)
		{
			$id = $i['option']['shipping_schedule_id'];
			if( ! isset($shipping_schedule_prio[$id])) continue;

			if((int)@$schedule_prio >= (int)$shipping_schedule_prio[$id])
			{
				$schedule_prio = $shipping_schedule_prio[$id];
				$schedule = $id;
			}
		}

		return array_flip(json_decode($shipping_schedules[$schedule]));
	}

	public function calc_shipping_method($cart_items, $shipping_methods)
	{
		$method = $shipping_methods[0];
		foreach ($cart_items as $i)
		{
			if($i['option']['shipping_type'] != $method)
			return $i['option']['shipping_type'];
		}

		return $method;
	}

	public function calc_shipping_cost($cart_items, $shipping_data, $dt)
	{
		if($dt != 'shipping') return '0.00';

		$total_items_weight = 0;
		foreach ($cart_items as $i)
		{
			$total_items_weight += ($i['option']['opt'] ? $i['option']['product_options']->weight[$i['option']['opt']] : $i['option']['shipping_weight']) * $i['qty'];
		}


		$packages = ceil($total_items_weight/$shipping_data['total_weight']);
		return $packages * $shipping_data['cost'];
	}
}
// END cart_model class

/* End of file cart_model.php */
