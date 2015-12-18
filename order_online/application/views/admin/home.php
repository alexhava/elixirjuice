<h2 class="big"><?=lang('home_info')?></h2>
<div class="status_cnt">
<?php
$out = array(); 
foreach ($status_cnt as $stat) 
{
	$out[] = "{$stat['order_status']}:{$stat['status_cnt']}";
}

echo implode(', ', $out);
?>
</div>
<b><?=lang('home_info2')?></b>
<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	foreach ($admin_menu as $menu_name => $menu_item):
		if($menu_item['sub_menu'] ):
			$heading[] = array('data' => lang($menu_name));
		endif;
	endforeach;
	$this->table->set_heading($heading);
	foreach ($admin_menu as $menu_name => $menu_item):
		$sub_menu_str = '';
		if($menu_item['sub_menu'] ):
		foreach ($menu_item['sub_menu'] as $sub_menu_name => $sub_menu_item):
			if(is_array($sub_menu_item))
			{
				$tmp_arr = current($sub_menu_item);
				$sub_menu_item = key($sub_menu_item);
			}
			$sub_menu_str .= '<p><a href="/admin/'.$sub_menu_item.'" title="'.lang($sub_menu_name).'">'.lang($sub_menu_name).'</a></p>';
			endforeach;
		$row[] = array('data'=>$sub_menu_str, 'valign'=>"top" );
		endif;

	endforeach;	
	   
	    $this->table->add_row($row);
    
	echo $this->table->generate();
?>
