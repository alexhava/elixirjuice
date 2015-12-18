<?php
$uniq = time();
echo form_hidden("uniq2", $uniq);
echo form_hidden("uniq", $uniq);
$this->table->add_row(lang('api_name'), form_input("api[$uniq][api_name]",'', 'class="add-inputs"'));
$this->table->add_row(lang('api_login_id'), form_input("api[$uniq][api_login_id]",'', 'class="add-inputs"'));
$this->table->add_row(lang('transaction_key'), form_input("api[$uniq][transaction_key]",'', 'class="add-inputs"'));
$this->table->add_row(lang('mode'), form_dropdown("api[$uniq][api_mode]", array("0"=>'Live', "1"=>"Sandbox"),'0', 'class="add-inputs"'));
$this->table->add_row(lang('default'), form_dropdown("api[$uniq][api_default]", array("0"=>'No', "1"=>"Yes"),'0', 'class="api-default add-inputs" '));

$this->table->add_row('',  form_reset(array('name' => 'reset', 'value' => lang('Clear'), 'class' => 'button')));
echo form_hidden('api_default_id', @$api_default_id);
if(@$api)
{
	$table = "<table width='100%'>";
	foreach ($api as $k => $v)
	{
		echo "<div id='h$k'>";
		echo form_hidden("api[$k][api_name]",$v['api_name']);
		echo form_hidden("api[$k][api_login_id]",$v['api_login_id']);
		echo form_hidden("api[$k][transaction_key]",$v['transaction_key']);
		echo form_hidden("api[$k][api_mode]",$v['api_mode']);
		echo form_hidden("api[$k][api_default]",@$v['api_default']);
		echo '</div>';
		$table .= "<tr>
		<td>$v[api_name]</td>
		<td><a href='#' id='edit_$k' class='edit-api'>Edit</a></td>
		<td><a href='#' id='remove_$k' class='rm-api'>Remove</a></td>
		</tr>";
	}
	$table .= "</table>";
	
	$this->table->add_row(array('data'=>$table, 'colspan'=>2));
}