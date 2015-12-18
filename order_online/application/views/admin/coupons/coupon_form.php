<?= form_open($this->controller_base.$action, '', array('coupon_id'=> @$coupon_id, 'apply_to_shipping' => 'n', 'percentage' => 'n')); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "40%"),
		array('data' => lang('value')));
	    $this->table->add_row('Coupon Code', form_input('coupon_code', @$coupon_code));
	    $this->table->add_row('Valid_to', form_input('valid_to', @$valid_to));
	    $this->table->add_row('Amount', form_input('amount', @$amount));
	    $this->table->add_row('Rules', 
	    	'<table border=0 style="border-top:1px solid #D0D7DF!important;">'.
	    	'<tr><td>Minimum amount</td><td>' . form_input('minimum_amount', @$minimum_amount) . '</td></tr>'. 
	    	'<tr><td>Percentage</td><td>' . form_checkbox('percentage', 'y', @$percentage == 'y') . '</td></tr>'. 
	    	'<tr><td>Apply to shipping</td><td>' . form_checkbox('apply_to_shipping', 'y', @$apply_to_shipping == 'y') . '</td></tr>'. 
	    	'</table>' 
	    );
	    $this->table->add_row('Type', 
	    	'<table border=0 style="border-top:1px solid #D0D7DF!important;">'.
	    	'<tr><td>One time use</td><td>' . form_radio('use_type', '', @$use_type == '') . '</td></tr>'. 
	    	'<tr><td>One time use for all members</td><td>' . form_radio('use_type', 'common', @$use_type == 'common') . '</td></tr>'. 
	    	'<tr><td>Unlimited</td><td>' . form_radio('use_type', 'unlimit', @$use_type == 'unlimit') . '</td></tr>'. 
	    	'<tr><td>Every month use for all members</td><td>' . form_radio('use_type', 'regular', @$use_type == 'regular') . '</td></tr></table>' 
	    );
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>
<script>

$( "[name='valid_to']" ).datepicker({ dateFormat: "yy-mm-dd" });
</script>