<div style="padding:5px">
<input type="submit" class="button" value="Add Production" name="image2" onclick="document.location.href='/admin/production/add'">
<?php	
	$this->table->clear();
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => '', ),
		array('data' => '', ),
		array('data' => '', ),
		array('data' => '')
	);

	echo $this->table->generate($aaData);
?>
</div>