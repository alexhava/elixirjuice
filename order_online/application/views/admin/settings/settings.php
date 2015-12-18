<?=form_open($this->controller_base."?type=$action", 'id="form1"'); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "40%"),
		array('data' => lang('value')));
	    echo $this->view($this->controller_base.$action,'',true);
    
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit1', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>