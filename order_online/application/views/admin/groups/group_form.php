<?= form_open($this->controller_base.$action, '', array('group_id'=> @$group_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "40%"),
		array('data' => lang('value')));


	    $this->table->add_row(lang('group_name'), form_input('group_name', @$group_name));
	    $this->table->add_row(lang('group_type'), form_dropdown('group_type', $this->_model->get_group_types(), @$group_type));
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>