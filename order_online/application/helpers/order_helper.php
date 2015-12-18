<?php
function calc_time($time_gap, $store_data, $dt, $cleanses_date='', $selected='')
{
	$time_gap = $store_data['lead_time'];
	if($cleanses_date)
	{
		foreach ($cleanses_date as $k => $v) 
		{
			foreach ($v as $k1 => $v1) 
			{
				$dates[] = $k1;
			}
		}
	}
	else {
		return ;
	}
	
	if( ! $store_data) return;
	$ret = array();
	
	asort($dates);

	$min_date = min($dates);
	$cnt = 0;
	$now_h = date('H');
	$make_next_js_day = false;
	$open_days = $store_data['open_days'] ? unserialize($store_data['open_days']) : array();
	$now_stamp = mktime($now_h+$time_gap,0,0,date('m'),date('d'),date('y'));
	
	$now_day = date('d');
	$now = date("m/d/Y H",$now_stamp);
	$store_data['open_hour'] = $store_data['open_hour'] ? $store_data['open_hour'] : 8;
	$store_data['close_hour'] = $store_data['close_hour'] ? $store_data['close_hour'] : 18;

	while ($date = current($dates))
	{
		$key = key($dates);
		next($dates);
		if(@$c2++ > 20) {
			exit;
		}
		if($cnt > 2) $cnt = 0;
		if($cnt++ > 0) {continue;}
		$hoursam = $hourspm = array();

		for ($i=1;$i<=12;$i++)
		{
			if($i>=$store_data['open_hour'])
			{
				$this_stamp = strtotime(date("m/d/Y ". ($i-1) .":59:59", $date)."am");
				$this_h = date('H', $this_stamp);
				if($now_day == date('d', $date) and $this_stamp < $now_stamp)
				{
					continue;
				}
				if($store_data['open_hour'] > $this_h or $store_data['close_hour'] < $this_h)
				continue;				
				$hoursam[$i.'am'] = $i.'am';

			}
			if($i<=$store_data['close_hour']-12)
			{
				$this_stamp = strtotime(date("m/d/Y ". ($i) .":00:01", $date)."pm");
//myd("now_stamp = ".date("m/d/Y H",$now_stamp) ." {$i}: this_stamp = " .date("m/d/Y H",$this_stamp)." : " . date("m/d/Y H", $this_stamp));	
				$this_h = date('H', $this_stamp);
				if($now_day == date('d', $date) and $this_stamp < $now_stamp)
				{
					continue;
				}
				if($store_data['open_hour'] > $this_h or $store_data['close_hour'] < $this_h)
				continue;
				$hourspm[$i.'pm'] = $i.'pm';
			}
		}
		$hours = $hoursam + $hourspm;
		if($hours)
		{
			if($make_next_js_day)
			$js = "<script>
			$('[name=\"date\"]').val($('.cleanses_calendar_day_active:eq(1)').attr('data-date'));</script>";
			$ret[] =  @$js.form_dropdown('ready_time['.$date.']', $hours,$selected, 'id="ready_time" style="width:60px;"');
			unset($dates[$key]);
		}
		else 
		{
			$make_next_js_day = true;
			$dates[$key] = strtotime("+1 Day", $date);
			reset($dates);
			$cnt = 0;
		}
		
	}
	
	return implode(br(), $ret);
}

function calc_delivery_time($time_gap, $store_data, $cleanses_date='', $selected='')
{
	if($cleanses_date)
	{
		foreach ($cleanses_date as $k => $v) 
		{
			foreach ($v as $k1 => $v1) 
			{
				$dates[] = $k1;
			}
		}
	}
	else {
		return ;
	}
	
	if( ! $store_data) return;
	$ret = array();
	
	asort($dates);

	$min_date = min($dates);
	$cnt = 0;
	$now_h = date('H');

	$open_days = $store_data['open_days'] ? unserialize($store_data['open_days']) : array();
	$now_stamp = mktime($now_h+$time_gap,0,0,date('m'),date('d'),date('y'));
	$delete_days = array();
	$now_day = date('d');
	$now = date("m/d/Y H",$now_stamp);
	$store_data['open_hour'] = $store_data['open_hour'] ? $store_data['open_hour'] : 8;
	$store_data['close_hour'] = $store_data['close_hour'] ? $store_data['close_hour'] : 18;
	while ($date = current($dates))
	{
		$key = key($dates);
		next($dates);
		if(@$c2++ > 20) {
			exit;
		}
		if($cnt > 2) $cnt = 0;
		if($cnt++ > 0) {continue;}
		$hoursam = $hourspm = array();

		$date_now = mktime(date('H'),0,0,date('m'), date('d'), date('Y'))+($time_gap*3600);
		
		if( ($open_days AND ! @in_array(date('D',$date), $open_days)) OR $date < $date_now) 
		{
			$delete_days[] = date('m/d/Y', $date);
			$dates[$key] = strtotime("+1 Day", $date);
			reset($dates);
			$cnt = 0;
			continue;
		}
		else if( ! $open_days)
		{
			$open_days = Array
			(
			0 => 'Mon',
			1 => 'Tue',
			2 => 'Wed',
			3 => 'Thu',
			4 => 'Fri',
			5 => 'Sat',
			6 => 'Sun',
			);
		}

		$delivery_hours = unserialize($store_data['delivery_hours']);
		
		if (isset($delivery_hours[date('D', $date)])) 
		{
			while($i = current($delivery_hours[date('D', $date_now)]))
			{
				next($delivery_hours[date('D', $date_now)]);
				if($i<=12)
				{
					$this_stamp = strtotime(date("m/d/Y ". ($i-1) .":59:59", $date_now)."am");
					if($this_stamp > $date_now)
					$hoursam[$i.'am'] = $i.'am';
				}
				if($i>12)
				{
					$i -= 12;
					$this_stamp = strtotime(date("m/d/Y ". ($i) .":00:01", $date_now)."pm");
					if($this_stamp > $date_now)
					$hourspm[$i.'pm'] = $i.'pm';
				}
			}
		}

		$hours = $hoursam + $hourspm;
		if($hours)
		{
			$js = "<script>$('[name=\"date\"]').val('".date("m/d/Y", $date_now)."');</script>";
			for($i=0; $i<count($delete_days); $i++)
			{ 	
				$js .= "<script>$('[data-date=\"{$delete_days[$i]}\"]').removeClass('cleanses_calendar_day_active').addClass('cleanses_calendar_day_unactive');</script>";
			}
			$ret[] =  $js.form_dropdown('ready_time['.$date_now.']', $hours,$selected, 'id="ready_time" style="width:60px;"');
			unset($dates[$key]);
		}
		else 
		{
			$dates[$key] = strtotime("+1 Day", $date);
			reset($dates);
			$cnt = 0;
		}
		
	}
	
	return implode(br(), $ret);
}

function _mktime($h='', $m='', $s='', $mon='', $day='', $y='')
{
	$s = mktime($h, $m, $s, $mon, $day, $y);
	return gmt_to_local($s, ci()->system_settings['timezones']);
}

function _mdate($str, $stamp='')
{
	$stamp = $stamp ? local_to_gmt($stamp) : now();
	$local_stamp = gmt_to_local($stamp, ci()->system_settings['timezones']);
	
	return gmdate($str, $local_stamp);
}

function getdelivery($zip='', $delivery_items='', $order_items='')
{
		$total = $delAmount = 0;

		$opt = array(
			'custom' => "delivery_zip like '%$zip%'"
		);

		$store_data = ci()->stores_model->get_row($opt);		

		$free_delivery_zips = explode(',',ci()->system_settings['free_delivery_zip']);
		
		$store_data['delivery_zip'] = explode(',',$store_data['delivery_zip']);
		foreach ($store_data['delivery_zip'] as $k=>$v)
		{
			$delivery_zips[$k] = trim($v);
		}


		if(ci()->cart->total() <= $store_data['minimum_amount'] and ! in_array($zip, $free_delivery_zips))
			$delAmount = $store_data['delivery_fee'];	
			
		return $delAmount;
}

function send_order_email($order_data, $email='')
{
	ci()->load->library('email');
	$config['mailtype'] = 'html';
	ci()->email->initialize($config);
	ci()->email->from('order@juicesupply.com', 'Juice Supply');
	ci()->email->to($email ? $email : $order_data['order_email']);
	$body = ci()->load->view('email_order', $order_data, true);
	ci()->email->subject("Order confirmation Juice Supply");
	ci()->email->message($body);
	ci()->email->send();
}

function calc_user_price($product)
{
	if (@ci()->user_session_data['wholesale_enabled'] == 'y' and $product['wholesale_price']) 
	{
		return $product['wholesale_price'];
	}
	
	return $product['regular_price'];
}
/* End of file order_helper.php */
/* Location: ./application/helpers/order_helper.php */