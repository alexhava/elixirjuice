<?php	
	$this->table->clear();
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => lang('tax_id'), 'width'=>'5%'),
		array('data' => lang('store_address')),
		array('data' => lang('state')),
		array('data' => lang('status')),
		array('data' => ''),
		array('data' => '')
	);
	if(@$aaData)
	echo $this->table->generate($aaData);
	else 
	echo lang('no_stores');
?>