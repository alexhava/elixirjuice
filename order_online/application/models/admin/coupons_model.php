<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupons_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'coupons';
	}
	
	public function coupon_valid($coupon_code, $member_id)
	{
		$opt['coupon_code'] = $coupon_code;
		$opt['used'] = 'N';
		$opt['valid_to >='] = date('Y-m-d');
		$first_check = $this->get_row($opt);
		if($first_check)
		{
			return array(
						'status' => 'ok',
						'result' => $first_check,
						'message' => '//1st check'
					);
		}			
			
		//2nd check		
		$opt2['coupon_code'] = $coupon_code;
		$opt2['use_type'] = 'common';
		$second_check = $this->get_row($opt2);
		if($second_check and $member_id)
		{
				$opt2['coupon_code'] = $coupon_code;
				$opt2['use_type'] = 'common';
				$opt2['join']['table'] = 'used_coupons uc';		
				$opt2['join']['cond'] = 'coupons.coupon_id = uc.coupon_id and uc.member_id='.$member_id;
				$second_check2 = $this->get_row($opt2);	
				if( ! $second_check2)			
				return array(
						'status' => 'ok',
						'result' => $second_check,
						'message' => '//2nd check'
					);
		}	

		$opt3['coupon_code'] = $coupon_code;
		$opt3['use_type'] = 'regular';
		$res = $this->get_row($opt3);
		if($res and $member_id)
		{
			$date = date("Y-m-01");
			$opt4['coupon_id'] = $res['coupon_id'];
			$opt4['member_id'] = $member_id;
			$opt4['used_date >='] = $date;
			if($this->get_row($opt4, 'used_coupons'))
			{
				return array(
					'status' => 'fail',
					'message' => 'You have already used coupon this month'
				);
			}
			//3rd check
			return array(
				'status' => 'ok',
				'result' => $res,
				'message' => '3rd check'
			);
		}
		
		// unlimited
		$opt['coupon_code'] = $coupon_code;
		$opt['use_type'] = 'unlimit';
		$unlim_check = $this->get_row($opt);

		if($unlim_check)
		{
			return array(
						'status' => 'ok',
						'result' => $first_check,
						'message' => '//unlim check'
					);
		}		
					
		return array(
						'status' => 'fail',
						'message' => 'coupon not valid'
					);
	}	
	
	public function use_coupon($coupon_code, $member_id)
	{
		// check use type.
		$opt['coupon_code'] = $coupon_code;
		$check = $this->get_row($opt);
		
		$opt['coupon_code'] = $coupon_code;
		$upd['used'] = 'Y';
		if($this->coupon_valid($coupon_code, $member_id))
		{
			if( ! $check['use_type'])
			$row = $this->save($upd, $opt);
			
			$upd2['coupon_id'] = $row['coupon_id'];
			$upd2['member_id'] = $member_id;
			$upd2['used_date'] = date("Y-m-d");
			$this->save($upd2, "used_coupons");
		}
		
	}
}
// END Coupons_model class

/* End of file coupons_model.php */
/* location models/admin/coupons_model.php */