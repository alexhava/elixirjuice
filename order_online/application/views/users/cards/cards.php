<?php echo $this->load->view('users/home','',TRUE) ?>
<div style="padding:5px">
<input type="submit" class="button" value="Add Card" name="image2" onclick="document.location.href='/users/cards/add'">
<?php	
	$this->table->clear();
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => '#', ),
		array('data' => 'Card Number', ),
		array('data' => 'Card Expiry', ),
		array('data' => 'Primary'),
		array('data' => ''),
		array('data' => '')
	);

	echo $this->table->generate($aaData);
?>
</div>