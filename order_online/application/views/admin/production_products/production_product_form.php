<?= form_open($this->controller_base.$action, '', array('production_product_id'=> @$production_product_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
		$this->table->set_heading(
			array('data' => lang('preference'), 'width' => "40%"),
			array('data' => lang('value')));

		
	    $this->table->add_row(lang('product_name'), form_input('product_name', @$product_name));
	    $this->table->add_row(lang('product_type'), form_dropdown('production_product_type_id', @$product_types, @$production_product_type_id));
	   	$this->table->add_row(lang('ingredients'), form_multiselect('ingredients[]', @$ingredient_types, @$ingredients));
		$this->table->add_row(lang('product_quantity'), form_input('product_quantity', @$product_quantity, 'style="width:50px"') . nbs() . form_dropdown('weight_type',@$weight_types, @$weight_type, 'style="width:auto"'));
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>