<?php	
	$this->table->clear();
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => lang('group_id'), 'width'=>'5%'),
		array('data' => lang('group_name')),
		array('data' => lang('group_type')),
		array('data' => ''),
		array('data' => ''),
		array('data' => '')
	);
	if(@$aaData)
	echo $this->table->generate($aaData);
	else 
	echo lang('no_groups');
?>