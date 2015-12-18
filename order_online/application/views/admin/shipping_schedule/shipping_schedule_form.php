<?= form_open($this->controller_base.$action, '', array('shipping_schedule_id'=> @$shipping_schedule_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "40%"),
		array('data' => lang('value')));


	    $this->table->add_row(lang('name'), form_input('name', @$name));
	    $this->table->add_row(lang('shipping_days'), form_multiselect('shipping_days[]', array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"), @$shipping_days));
		echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>