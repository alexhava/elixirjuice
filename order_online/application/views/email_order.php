<h3><?=lang('order_items')?></h3>
<?php
	$table_template = array(
				'table_open'		=> '<table width="100%" border="0" cellspacing="0" cellpadding="4">',
				'row_start'			=> '<tr style="background:#ffffff">',
				'row_alt_start'		=> '<tr style="background:#eeeeee">'
			);
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('title'), "align"=>"left", "style"=>"background:#cccccc"),
		array('data' => lang('deliver_type'), "align"=>"left", "style"=>"background:#cccccc"),
		array('data' => lang('regular_price'), "align"=>"left", "style"=>"background:#cccccc"),
		array('data' => lang('item_quantity'), "align"=>"left", "style"=>"background:#cccccc"),
		array('data' => lang('item_total'), "align"=>"left", "style"=>"background:#cccccc"));
		
		foreach ($items as $order_items)
		{
			$this->table->add_row($order_items['title'],@$order_items['modifiers'],'$'.$order_items['regular_price'],$order_items['item_qty'],$order_items['item_total']);
		}

	echo $this->table->generate();
?>
<h3><?=lang('order_details')?></h3>
<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'),  "align"=>"left", "style"=>"background:#cccccc"),
		array('data' => lang('value'), "align"=>"left", "style"=>"background:#cccccc"));
	    $this->table->add_row(lang('order_status'),  ucfirst($order_status));
	    $this->table->add_row(lang('order_date'), date('m/d/Y H:i', $order_date));
	    $this->table->add_row(lang('order_subtotal'), $order_subtotal);
	    $this->table->add_row(lang('order_delivery_tax'), $order_tax);
	    $this->table->add_row(lang('order_shipping_tax'), $order_shipping_tax);
	    $this->table->add_row(lang('order_total'), $order_total);
	    $this->table->add_row('Coupon', @$coupon_code);
	    $this->table->add_row(lang('start_date'), ci()->load->view('cleanses_date_info',array('cleanses_date'=> @unserialize($start_date)), true));
	    if(isset($stores[$store_id])) 
	    {
	    	$this->table->add_row('Location fulfilling order', @$stores[@$store_id]);
	    	$this->table->add_row('Time what would like it ready by', @$ready_time);
	    }
	    $this->table->add_row(lang('order_paid_date'), $order_paid_date ? date('m/d/Y H:i', $order_paid_date) : '-');
	    $this->table->add_row(lang('notes'),  $notes);
	    $this->table->add_row(lang('billing_name'), $billing_name);
	    $this->table->add_row(lang('billing_address1'), $billing_address1);
	    $this->table->add_row(lang('billing_region'), $billing_region);
	    $this->table->add_row(lang('billing_postcode'), $billing_postcode);
	    $this->table->add_row(lang('billing_phone'), $billing_phone);
	    $this->table->add_row(lang('order_email'), $order_email);	    
	echo $this->table->generate();
?>

<a href="https://order.juicesupply.com">Juice Supply</a>