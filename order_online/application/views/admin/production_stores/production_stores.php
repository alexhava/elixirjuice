<div style="padding:5px">
<input type="submit" class="button" value="Add Production Store" name="image2" onclick="document.location.href='/admin/production_stores/add'">
<div class="fr"><input type="submit" href='<?=$this->controller_base.'bulk_remove'?>' class="button bulk_delete" value="Bulk Delete" name="image3" ></div>
<?php	
	$this->table->clear();
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => lang('ID'), ),
		array('data' => lang('store'), ),
		array('data' => lang('production_group'), ),
		array('data' => '', ),
		array('data' => '', ),
		array('data' => '')
	);

	echo $this->table->generate($aaData);
?>
</div>