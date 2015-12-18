<?= form_open($this->controller_base.$action, '', array('shipping_type_id'=> @$shipping_type_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "40%"),
		array('data' => lang('value')));


	    $this->table->add_row(lang('name'), form_input('name', @$name));
	    $this->table->add_row(lang('total_weight'), form_input('total_weight', @$total_weight));
	    $this->table->add_row(lang('cost'), form_input('cost', @$cost));
	    $this->table->add_row(lang('shipping_method'), form_dropdown('shipping_method', $shipping_methods, @$shipping_method));
		echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>