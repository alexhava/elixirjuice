
<?= form_open($this->controller_base.$action, '', array('group_id'=> @$group_id)); ?>
<?php
$this->table->clear();
$this->table->set_template($table_template);
$this->table->set_heading(
	array('data' => lang('title'), 'width' => "20%"),
	array('data' => lang('page'), 'width' => "40%"),
	array('data' => lang('is_access').br().form_checkbox('select_all_permissions', 1)));
foreach (ci()->_admin_menu() as $key => $item)
{
	$this->table->add_row(array('data' =>"<h3>".lang($key)."</h3>", 'colspan' => 3));
	if(isset($item['url']) and $item['url'])
	{
		$this->table->add_row(lang($key), "/admin/".$item['url'], form_checkbox('permissions[]', $item['url'], @$permissions[$item['url']]));
	}
	if(isset($item['sub_menu']) and $item['sub_menu'])
	{
		foreach ($item['sub_menu'] as $key1 => $item1)
		{
			if( ! is_array($item1))
			{
				$this->table->add_row(lang($key1), "/admin/".$item1, form_checkbox('permissions[]', $item1, @$permissions[$item1]));
			}
			else
			{
				foreach ($item1 as $key2 => $item2)
				{				
					foreach ($item2 as $key3 => $item3)
					{
						$this->table->add_row(lang($key2).NBS.lang($key3), "/admin/$key2/".$key3, form_checkbox('permissions[]', "/admin/$key2/".$key3, @$permissions["/admin/$key2/".$key3]));
					}
				}
			}
		}
	}
}
echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>