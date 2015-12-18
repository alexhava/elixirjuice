<div style="padding:5px">
<input type="submit" class="button" value="Add Production Ingredient" name="image2" onclick="document.location.href='/admin/production_ingredients/add'">
<div class="fr"><input type="submit" href='<?=$this->controller_base.'bulk_remove'?>' class="button bulk_delete" value="Bulk Delete" name="image3" ></div>
<?php	
	$this->table->clear();
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => lang('ID'), ),
		array('data' => lang('ingredient_name') ),
		array('data' => lang('ingredient_type') ),
		array('data' => lang('ingredient_form') ),
		array('data' => lang('ingredient_source') ),
		array('data' => ''),
		array('data' => ''),
		array('data' => '')
	);

	echo $this->table->generate($aaData);
?>
</div>