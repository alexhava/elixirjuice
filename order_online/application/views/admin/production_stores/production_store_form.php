<?= form_open($this->controller_base.$action, '', array('production_store_id'=> @$production_store_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
		$this->table->set_heading(
			array('data' => lang('preference'), 'width' => "40%"),
			array('data' => lang('value')));

		
	    $this->table->add_row(
	    	lang('store'),
	   		form_dropdown('store_id', $stores, @$store_id)
	    );	
	    	
	    $this->table->add_row(
	    	lang('production_group'),
	    	form_dropdown('production_group_id', $production_groups, @$production_group_id)
	    );
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>