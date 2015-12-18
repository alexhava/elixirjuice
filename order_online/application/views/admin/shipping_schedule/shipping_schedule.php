<?php
	echo form_open(current_url(),'class="form1"');	
	$this->table->clear();
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => '', 'width'=>'5%'),
		array('data' => 'Prio', 'width'=>'5%'),
		array('data' => lang('schedule_id'), 'width'=>'5%'),
		array('data' => lang('name')),
		array('data' => ''),
		array('data' => '')
	);
	if(@$aaData)
	echo $this->table->generate($aaData);
	else 
	echo lang('no_types');
	
	echo form_close();
?>