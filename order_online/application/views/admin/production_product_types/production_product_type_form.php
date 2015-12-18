<?= form_open($this->controller_base.$action, '', array('production_product_type_id'=> @$production_product_type_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
		$this->table->set_heading(
			array('data' => lang('preference'), 'width' => "40%"),
			array('data' => lang('value')));

		
	     $this->table->add_row(lang('production_product_type_name'), form_input('production_product_type_name', @$production_product_type_name));
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>