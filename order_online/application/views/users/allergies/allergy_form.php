<?php echo $this->load->view('users/home','',TRUE) ?>
<div style="padding:10px;">
	<?= form_open($this->controller_base.'add_allergy', '', array('allergies_id'=> @$allergies_id)); ?>
	
	<?php
		$this->table->clear();
		$this->table->set_template($table_template);
		$this->table->set_heading(
			array('data' => lang('preference'), 'width' => "40%"),
			array('data' => lang('value')));
	
	
		    $this->table->add_row(lang('has_allergies'), lang('yes').nbs().form_radio('has_allergy', 'y', @$has_allergy == 'y', 'style="width:auto;"').nbs().lang('no').nbs().form_radio('has_allergy', 'n', @$has_allergy == 'n', 'style="width:auto;"'));
		    $this->table->add_row(lang('put_allergies_here'), form_textarea('allergies', @$allergies));
		echo $this->table->generate();
	?>
	
	<div style="text-align: right;margin-top:5px;">
		<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
	</div>
	<?= form_close(); ?>
</div>