<?= form_open($this->controller_base.$action, '', array('production_ingredient_id'=> @$production_ingredient_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
		$this->table->set_heading(
			array('data' => lang('preference'), 'width' => "40%"),
			array('data' => lang('value')));

		
	    $this->table->add_row(lang('ingredient_name'), form_input('ingredient_name', @$ingredient_name));
	    $this->table->add_row(lang('ingredient_type'), form_dropdown('ingredient_type', @$ingredient_types, @$ingredient_type));
	    $this->table->add_row(lang('ingredient_form'), form_dropdown('ingredient_form', @$ingredient_forms, @$ingredient_form));
	    $this->table->add_row(lang('ingredient_source'), form_textarea('ingredient_source', @$ingredient_source));
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>