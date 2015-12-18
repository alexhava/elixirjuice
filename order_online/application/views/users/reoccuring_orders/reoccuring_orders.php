<?php echo $this->load->view('users/home','',TRUE) ?>
<div style="padding:5px">
<input type="submit" class="button" value="Add Reoccuring Order" name="image2" onclick="document.location.href='/users/reoccuring_orders/add'">
<?php	
	$this->table->clear();
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => '#', ),
		array('data' => 'Products', ),
		array('data' => 'Address', ),
		array('data' => 'Last Run', ),
		array('data' => 'Next Run', ),
		array('data' => 'Order Total', ),
		array('data' => ''),
		array('data' => '', )
	);

	echo $this->table->generate($aaData);
?>
</div>