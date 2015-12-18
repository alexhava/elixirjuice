<script type="text/javascript" src="/js/jquery.dataTables.js"></script>

<?=form_open($this->controller_base, array('name'=>'form1', 'id'=>'form1'))?>
<fieldset>
<legend><b><?=lang('search_options')?></b></legend>
<div></div>
<div style="float:left;padding:10px 5px;">
	<?=lang('date_from')?><?=form_input('date1', '', 'id="date1" style = "width:80px;" maxlength = 100')?>
	<?=lang('to')?><?=form_input('date2', '', 'id="date2" style = "width:80px;" maxlength = 100')?>
	<?=lang('order_id', 'order_id')?> <?=form_input('order_id', '', 'class = "field_shun" style = "width:100px;" maxlength = 100')?>
	<?=form_dropdown('status', $statuses, '',' style="width:120px;"')?>
	<?=form_dropdown('perpage', $perpage_select_options, $perpage,' style="width:100px;"')?>
	<?=form_submit('search_submit', lang('search'), 'class="button"')?>
	<?=form_submit('reset_button', lang('reset'), 'class="button"')?>
</div>
<div style="float:right;padding:10px 5px;">
	<?= form_submit(array('name' => 'remove_selected', 'value' => lang('remove_selected'), 'class' => 'button')); ?>
</div>
</fieldset><br/>


<div style="clear:both"></div>
<?php	
	$this->table->clear();
	$table_template['table_open'] = '<table class="main_table datatable" id="orders_table" cellspacing="0" cellpadding="0" border="0">';
	
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => '', 'width'=>'10px' ),
		array('data' => lang('order_id'), ),
		array('data' => lang('order_date'), ),
		array('data' => lang('client_name'), ),
		array('data' => lang('order_total'), 'width'=>'15%'),
		array('data' => lang('order_status')),
		array('data' => '', ),
		array('data' => ''),
		array('data' => form_checkbox('select_all_orders','1',''), 'width' => '1%')
	);

	echo $this->table->generate($aaData);
?>
<?= form_close(); ?>
<script>

$( "#date1" ).datepicker();
$( "#date2" ).datepicker();
</script>