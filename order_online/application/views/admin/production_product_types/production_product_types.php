<div style="padding:5px">
<input type="submit" class="button" value="Add Production Product Type" name="image2" onclick="document.location.href='/admin/production_product_types/add'">
<div class="fr"><input type="submit" href='<?=$this->controller_base.'bulk_remove'?>' class="button bulk_delete" value="Bulk Delete" name="image3" ></div>
<?php	
	$this->table->clear();
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => 'ID', ),
		array('data' => lang('name'), ),
		array('data' => '', ),
		array('data' => '', ),
		array('data' => '')
	);

	echo $this->table->generate($aaData);
?>
</div>