<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipping_methods_model extends Db_lib {
	public function get($return_obj=false)
	{
		$arr = array('usps' => 'USPS', 'fedex' => 'FedEx');
		
		if(is_string($return_obj) and isset($arr[$return_obj]))
		return $arr[$return_obj];
		
		if( ! $return_obj)
		return array('usps' => 'USPS', 'fedex' => 'FedEx');
		return (object)array('usps' => 'USPS', 'fedex' => 'FedEx');
	}
}
// END shipping_methods_model class

/* End of file shipping_methods_model.php */