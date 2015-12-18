<?php	
	$this->table->clear();
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => lang('date_id'), 'width'=>'5%'),
		array('data' => lang('month')),
		array('data' => lang('day')),
		array('data' => lang('year')),
		array('note' => lang('note')),
		array('data' => ''),
		array('data' => '')
	);
	if(@$aaData)
	echo $this->table->generate($aaData);
	else 
	echo lang('no_date');
?>