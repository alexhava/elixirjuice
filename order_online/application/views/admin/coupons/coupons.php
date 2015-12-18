<script type="text/javascript" src="/js/jquery.dataTables.js"></script>

<?=form_open($this->controller_base, array('name'=>'form1', 'id'=>'form1'))?>
<fieldset>
<legend><b><?=lang('search_options')?></b></legend>

<div style="float:left;padding:10px 5px;">
	<?=lang('keyword', 'keyword')?> <?=form_input('keyword', '', 'class = "field_shun" style = "width:260px;" maxlength = 100')?>
	<div style="position:absolute; left:20em;"> <?=form_checkbox('exact_match', 'y')?> <?=lang('exact_match', 'exact_match').NBS.NBS?></div> 
	<?=form_dropdown('member_id', $members, '',' style="width:100px;"')?>
	<?=form_dropdown('perpage', $perpage_select_options, $perpage,' style="width:100px;"')?>
	<?=form_dropdown('used', array(''=>lang('coupon_status'), 'Y'=>'YES', 'N'=>'NO'), ''	,' style="width:100px;"')?>
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
	$table_template['table_open'] = '<table class="main_table datatable" id="coupons_table" cellspacing="0" cellpadding="0" border="0">';
	
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => 'ID', 'width'=>'5%'),
		array('data' => 'Coupon Code', 'width'=>'15%'),
		array('data' => 'Type', 'width'=>'15%'),
		array('data' => 'Valid to', 'width'=>'15%'),
		array('data' => 'Amount', 'width'=>'15%'),
		array('data' => 'Used', 'width'=>'15%'),
		array('data' => '', ),
		array('data' => ''),
		array('data' => form_checkbox('select_all_coupons','1',''), 'width' => '1%')
	);

	echo $this->table->generate($aaData);
?>
<?= form_close(); ?>