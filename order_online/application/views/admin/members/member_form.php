<?= form_open($this->controller_base.$action, '', array('member_id'=> @$member_id, 'wholesale_enabled'=> 'n')); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "40%"),
		array('data' => lang('value')));


	    $this->table->add_row(lang('login'), form_input('username', @$username));
	    $this->table->add_row(lang('password'), form_password('password', @$password));
	    $this->table->add_row(lang('confirm_password'), form_password('confirm_password',@$confirm_password));
	    $this->table->add_row(lang('name'), form_input('name', @$name));
	    $this->table->add_row(lang('email'), form_input('email', @$email));
	    $this->table->add_row(lang('group'), form_dropdown('group_id', @$groups, @$group_id));
	    $this->table->add_row('Enable Wholesale Account', form_checkbox('wholesale_enabled', 'y', @$wholesale_enabled == 'y'));
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>