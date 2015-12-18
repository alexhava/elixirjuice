<?= form_open($this->controller_base.$action, '', array('tax_id'=> @$tax_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "40%"),
		array('data' => lang('value')));


	    $this->table->add_row(lang('ratio'), form_input('ratio', @$ratio));
	    $this->table->add_row(lang('state'), form_dropdown('state', $this->_model->get_states(), @$state));
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>