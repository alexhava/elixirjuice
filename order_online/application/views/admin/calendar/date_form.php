<?= form_open($this->controller_base.$action, '', array('off_id'=> @$off_id)); ?>
*You may leave fields blank so it will use current date on rendering. Ex. year blank, month=11, day=10 and it will disable 11.10 for every year 
<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "40%"),
		array('data' => lang('value')));


	    $this->table->add_row(lang('month'), form_input('month', @$month));
	    $this->table->add_row(lang('day'), form_input('day', @$day));
	    $this->table->add_row(lang('year'), form_input('year', @$year));
	    $this->table->add_row(lang('note'), form_input('note', @$note));
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>