<script type="text/javascript" src="/js/jquery.dataTables.js"></script>

<?=form_open($this->controller_base, array('name'=>'form1', 'id'=>'form1'))?>
<fieldset>
<legend><b><?=lang('search_options')?></b></legend>

<div style="float:left;padding:15px 5px;">
	<?=lang('keyword', 'keyword')?> <?=form_input('keyword', '', 'class = "field_shun" style = "width:260px;" maxlength = 100')?>
	<div style="position:absolute; left:390px;"> <?=form_checkbox('exact_match', 'y')?> <?=lang('exact_match', 'exact_match').NBS.NBS?></div> 
	<?=form_dropdown('group_id', $groups, '',' style="width:100px;"')?>
	<?=form_dropdown('perpage', $perpage_select_options, $perpage,' style="width:100px;"')?>
	<?=form_dropdown('ban', array(''=>lang('member_status'), 'y'=>lang('banned'), 'n'=>lang('active')), $perpage,' style="width:100px;"')?>
	<?=form_submit('search_submit', lang('search'), 'class="button"')?>
	<?=form_submit('reset_button', lang('reset'), 'class="button"')?>
</div>
<div style="float:right;padding:10px 5px;">
	<?= form_submit(array('name' => 'remove_selected', 'value' => lang('remove_selected'), 'class' => 'button')); ?>
</div>
</fieldset><br/>

<?php if( ! $this->input->get('wholesale')) :?>
<a href="?wholesale=true">Wholesale Requests (<?=@$wholesale_cnt?>)</a>
<?php else :?>
<a href="?all">All Members</a>
<?php endif;?>
<div style="clear:both"></div>
<?php	
	$this->table->clear();
	$table_template['table_open'] = '<table class="main_table datatable" id="members_table" cellspacing="0" cellpadding="0" border="0">';
	
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => lang('member_id'), 'width'=>'5%'),
		array('data' => lang('username'), 'width'=>'15%'),
		array('data' => lang('name'), 'width'=>'15%'),
		array('data' => lang('group'), 'width'=>'15%'),
		array('data' => lang('email'), 'width'=>'15%'),
		array('data' => '', ),
		array('data' => '', ),
		array('data' => '', ),
		array('data' => ''),
		array('data' => form_checkbox('select_all_members','1',''), 'width' => '1%')
	);

	echo $this->table->generate($aaData);
?>
<?= form_close(); ?>