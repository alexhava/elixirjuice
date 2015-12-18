<?= form_open($this->controller_base.$action, '', array('store_id'=> @$store_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "20%"),
		array('data' => lang('value')));


	    $this->table->add_row(array('data'=>'<h3 align="center">General</h3>', 'colspan'=>2));
	    $this->table->add_row(lang('lead_time'), form_input('lead_time', @$lead_time));
	    $this->table->add_row(lang('store_address'), form_input('store_address', @$store_address));
	    $this->table->add_row(lang('state'), form_dropdown('state', $this->taxes_model->get_states(), @$state));
	    $this->table->add_row(lang('status'), form_dropdown('store_status', $this->_model->get_statuses(), @$store_status));
	    $this->table->add_row('Anet Account', form_dropdown('store_anet_account', prep_select(ci()->system_settings['api'], '', 'api_name'), @$store_anet_account));
	    
	    $this->table->add_row(array('data'=>'<h3 align="center">Open time</h3>', 'colspan'=>2));
	    $this->table->add_row('Open Hour', form_dropdown('open_hour', hours_arr(), @$open_hour));
	    $this->table->add_row('Close Hour', form_dropdown('close_hour', hours_arr(), @$close_hour));
	    

	    if(@$open_days)
	    {
	    	$open_days = unserialize($open_days);
	    }
	    $this->table->add_row('Open Days', form_multiselect('open_days[]', week_days(), @$open_days));	    
	    
	    $this->table->add_row(array('data'=>'<h3 align="center">Delivery</h3>', 'colspan'=>2));
	    

	    if(@$delivery_days)
	    {
	    	$delivery_days = unserialize($delivery_days);
	    }
	    
	    if(@$delivery_hours)
	    {
	    	$delivery_hours = unserialize($delivery_hours);
	    }
	    $days_out = array();
	    $delivery_table = '<table border=0 class="simple-table" cellspacing=0 cellpadding=0><tr>';
	    $delivery_table .= '<td style=""><b>Days</b></td><td style=""><input type="checkbox" class="all-days"/></td><td align="right"><b>Time:</b></td>';
	    foreach (hours_arr() as $k => $v)
	    {
			$delivery_table .= "<td style='width:5%;border:0!important'><b>$v</b></td>";	    	
	    }
	    $delivery_table .= '<td></td></tr>';
	    
	    foreach (week_days() as $k => $v) 
	    {
	    	$days_out = form_checkbox("delivery_days[$k]", $k, isset($delivery_days[$k]), 'class="delivery-days" style="width:auto"');
	    	$delivery_table .= "<tr><td style='border:0!important'>$k</td><td style='border:0!important'>$days_out</td><td><input type='checkbox' class='all-hours'/></td>";
		    foreach (hours_arr() as $k1 => $v1)
		    {
				$delivery_table .= "<td style='border:0!important'>".form_checkbox("delivery_hours[$k][$k1]", $k1, isset($delivery_hours[$k][$k1]), 'class="delivery-hours" style="width:auto"')."</td>";	    	
		    }	    	
	    	$delivery_table .= "<td><a href='#' class='apply-hours'>Apply for all</a></td></tr>";
	    }
	    $delivery_table .= "</table>";
	    $this->table->add_row('Delivery Days', $delivery_table);
		$this->table->add_row(lang('minimum_amount'), form_input('minimum_amount', @$minimum_amount));
		$this->table->add_row(lang('delivery_fee'), form_input('delivery_fee', @$delivery_fee));
		$this->table->add_row(lang('delivery_zip'), form_textarea('delivery_zip', @$delivery_zip));
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>