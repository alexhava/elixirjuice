<?php echo $this->load->view('users/home','',TRUE) ?>
<script type="text/javascript" src="/js/jquery.dataTables.js"></script>
<div style="padding:10px;">
<?=form_open($this->controller_base, array('name'=>'form1', 'id'=>'form1'))?>
<fieldset>
<legend><b><?=lang('search_options')?></b></legend>
<div></div>
<div style="float:left;padding:10px 5px;">
	<?=lang('date_from')?><?=form_input('date1', '', 'id="date1" style = "width:80px;" maxlength = 100')?>
	<?=lang('to')?><?=form_input('date2', '', 'id="date2" style = "width:80px;" maxlength = 100')?>
	<?=lang('order_id', 'order_id')?> <?=form_input('order_id', '', 'class = "field_shun" style = "width:100px;" maxlength = 100')?>
	<?=form_dropdown('perpage', $perpage_select_options, $perpage,' style="width:100px;"')?>
	<?=form_submit('search_submit', lang('search'), 'class="button"')?>
	<?=form_submit('reset_button', lang('reset'), 'class="button"')?>
</div>
</fieldset><br/>


<div style="clear:both"></div>
<?php	
	$this->table->clear();
	$table_template['table_open'] = '<table class="main_table datatable" id="orders_table" cellspacing="0" cellpadding="0" border="0">';
	
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => lang('order_id'), ),
		array('data' => lang('order_date'), ),
		array('data' => lang('items_names'), ),
		array('data' => lang('order_total'), 'width'=>'15%'),
		array('data' => lang('shipping_name')),
		array('data' => '', )
	);

	echo $this->table->generate($aaData);
?>
<?= form_close(); ?>

</div>
<script>

$( "#date1" ).datepicker();
$( "#date2" ).datepicker();
</script>