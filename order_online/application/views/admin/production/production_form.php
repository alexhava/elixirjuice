<?= form_open($this->controller_base.$action, '', array('production_id'=> @$production_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
		$this->table->set_heading(
			array('data' => lang('preference'), 'width' => "40%"),
			array('data' => lang('value')));

		
	    $this->table->add_row();
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>