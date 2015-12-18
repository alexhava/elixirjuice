<?php echo $this->load->view('users/home','',TRUE) ?>
<div style="padding:10px;">
<?php 

for ($i=0;$i<8;$i++)
{
	$years[date("y") + $i] = date("y") + $i;
}

for ($i=1;$i<13;$i++)
{
	$month[sprintf("%02d", $i)] = sprintf("%02d", $i);
}

?>
<?= form_open($this->controller_base.$action, '', array('card_id'=> @$card_id, 'primary'=>'N')); ?>

<?php
if (@$card_exp) 
{
	list($exp_month, $exp_year) = explode('/', $card_exp);
}
$this->table->clear();
$this->table->set_template($table_template);
$this->table->set_heading(
array('data' => lang('preference'), 'width' => "40%"),
array('data' => lang('value')));

$this->table->add_row('Card Number', form_input('card_num', @$card_num));
$this->table->add_row('Expiry', "Month ".form_dropdown("exp_month", $month, @$exp_month, 'style="width:50px"')." Year ".form_dropdown("exp_year", $years, @$exp_year, 'style="width:50px"'));
$this->table->add_row('Primary', form_checkbox('primary', 'Y', @$primary == 'Y'));
echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>
</div>