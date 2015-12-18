<?= form_open($this->controller_base.'update_order', '', array('order_id'=> @$order_id)); ?>
<?php 
	foreach ($statuses as $k => $v) 
	{
		if($k and $k != $order_status )
		echo form_submit(array('name' => 'order_status', 'value' => $v, 'class' => 'button')).nbs();
	}
?>
<h3><?=lang('order_items')?></h3>
<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('title')),
		array('data' => lang('deliver_type')),
		array('data' => lang('regular_price')),
		array('data' => lang('item_quantity')),
		array('data' => lang('item_total')));
		
		foreach ($order_items as $order_items)
		{
			$this->table->add_row($order_items['title'],$order_items['modifiers'],$order_items['regular_price'],$order_items['item_qty'],$order_items['item_total']);
		}

	echo $this->table->generate();
?>
<h3><?=lang('view_order')?></h3>
<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "15%"),
		array('data' => lang('value')));


	    $this->table->add_row(lang('order_id'), $order_id);
	    $this->table->add_row(lang('transaction_id'), $transaction_id);
	    $this->table->add_row(lang('order_status'), $order_status);
	    $this->table->add_row(lang('type'), $delivery_type);
	    $this->table->add_row(lang('changeable'), form_dropdown('changeable', array('y'=>lang('yes'), 'n'=>lang('no')), $changeable));
	    $this->table->add_row(lang('order_date'), date('m/d/Y H:i', $order_date));
	    $this->table->add_row(lang('order_hash'), $order_hash);
	    $this->table->add_row(lang('order_subtotal'), $order_subtotal);
	    $this->table->add_row(lang('order_delivery_tax'), $order_tax);
	    $this->table->add_row(lang('order_shipping_tax'), $order_shipping_tax);
	    $this->table->add_row(lang('order_total'), $order_total);
	    $this->table->add_row('Coupon', @$coupon_code);
	    $this->table->add_row(lang('alergy'), lang('yes').nbs(). form_radio('alergy', 'yes', $alergy=='yes', 'style="width:auto;"').lang('no').nbs().form_radio('alergy', 'no', $alergy=='no', 'style="width:auto;"'));
	    $this->table->add_row(lang('allergies'),  $client_allergies);
		 $this->table->add_row(lang('start_date'), $start_date);
	    if(isset($stores[$store_id]))
	    {
	    	$this->table->add_row(lang('store_for_pickup'), form_dropdown('store_id', $stores, $store_id));
	    	$this->table->add_row('Time what would like it ready by ', $ready_time);
	    }
	    $this->table->add_row(lang('order_paid_date'), $order_paid_date ? date('m/d/Y H:i', $order_paid_date) : '-');
	    $this->table->add_row(lang('notes'),  form_textarea('notes', $notes));
	echo $this->table->generate();
?>
<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>
<?php if($order_history): ?>
<h3><?=lang('status_history')?></h3>
<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('order_status')),
		array('data' => lang('Change Date'))
		);
		
		foreach ($order_history as $item)
		{
			$this->table->add_row($item['order_status'],date('m/d/Y H:i', $item['change_date']));
		}

	echo $this->table->generate();
	endif;
?>
<h3><?=lang('client_info')?></h3>
<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "15%"),
		array('data' => lang('value')));
	    $this->table->add_row(array('data'=>'<h3>Billings Address</h3>', 'colspan'=>2));
	    $this->table->add_row(lang('billing_name'), $billing_name);
	    $this->table->add_row(lang('billing_address1'), $billing_address1);
	    $this->table->add_row(lang('billing_region'), $billing_region);
	    $this->table->add_row(lang('billing_postcode'), $billing_postcode);
	    $this->table->add_row(lang('billing_phone'), $billing_phone);
	    $this->table->add_row(lang('order_email'), $order_email);	
	        
	    $this->table->add_row(array('data'=>'<h3>Delivery Address</h3>', 'colspan'=>2));
	    $this->table->add_row(lang('name'), $shipping_name);
	    $this->table->add_row(lang('address1'), $shipping_address1);
	    $this->table->add_row(lang('region'), $shipping_region);
	    $this->table->add_row(lang('postcode'), $shipping_postcode);
	    $this->table->add_row(lang('phone'), $shipping_phone);
	    $this->table->add_row(lang('email'), $shipping_email);
	echo $this->table->generate();
?>