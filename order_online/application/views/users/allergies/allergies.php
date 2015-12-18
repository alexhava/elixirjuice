<?php echo $this->load->view('users/home','',TRUE) ?>
<div style="padding:5px"><?php	
	$this->table->clear();
	$this->table->set_template($table_template);

	$add_alergy = form_input('allergy', '', 'class="add_allergy" style="width:300px"'); 
	$add_alergy .= nbs().form_button('add_allergy', 'Add Allergy', 'class="button"').br(2);
	$this->table->set_heading(
		array('data' => '<div style="float:left;">Alergy</div><div style="float:right;">'.$add_alergy.'</div>', 'width'=>'70%'),
		array('data' => '', 'width'=>'15%'),
		array('data' => '')
	);
	if(@$allergies)
	{
		foreach ($allergies as $allergy) 
		{
			$edit =  "<div id='edit{$allergy['allergy_id']}'><a href='#' class='edit_allergy' id='{$allergy['allergy_id']}'>Edit</a></div>";
			$delete =  "<a href='".$this->controller_base."remove_allergy?allergy_id=".$allergy['allergy_id']."' class='delete' >Delete</a>";
			$edit_input =  "<div style='display:none;' class='edit_text'  id='edit_text{$allergy['allergy_id']}'>".form_input('allergy', $allergy['allergy'], 'class="add_allergy"')."</div>";
			$edit_button =  "<div style='display:none;' id='edit_button{$allergy['allergy_id']}'>".form_button('edit_allergy', 'Save', 'class="button"')."</div>";
			$text =  "<div id='text{$allergy['allergy_id']}'>".$allergy['allergy']."</div>";
			$this->table->add_row($text.$edit_input, $edit.$edit_button, $delete);
		}
	}
	
	else 
	$this->table->add_row(array('data'=>'<h3>There is no allergy added yet</h3>', 'colspan'=>3));
			echo $this->table->generate();

?></div>