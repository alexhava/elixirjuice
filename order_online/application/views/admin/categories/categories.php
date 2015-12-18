<?php	
	$this->table->clear();
	$table_template['table_open'] = '<table class="main_table sort" border="0" cellspacing="0" cellpadding="0">';
	$this->table->set_template($table_template);

	$this->table->set_heading(
		array('data' => '', 'width'=>'5%'),
		array('data' => lang('category_id'), 'width'=>'5%'),
		array('data' => lang('category_name')),
		array('data' => lang('visible')),
		array('data' => ''),
		array('data' => '')
	);
	if(@$categories){
		
		foreach ($categories as $v)
		{
			$sub_cat_img = $v['parent_id'] ? '<img src="/images/admin/cat_marker.gif"/>' : '';
			
			$this->table->add_row(array(
				array('data'=>'<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>', 'id'=> 's_'.$v['cat_id'],'level'=>$v['level'],'parent'=>$v['parent_id']),
				$v['cat_id'],
				array('data'=>"{$sub_cat_img}<a href='{$this->controller_base}edit_category?category_id={$v['cat_id']}'> {$v['cat_name']} </a>", 'style'=>'padding-left:'.$v['level']*30 . 'px'),
				form_checkbox('visible', 'y', $v['visible']=='y', "id='$v[cat_id]'  class='change_visible'"),
				'<a href="'.$this->controller_base.'edit_category?category_id='.$v['cat_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->controller_base.'remove_category?category_id='.$v['cat_id'].'" class="delete">'.lang('delete').'</a>',
			));
		}
		echo $this->table->generate();
	}
	
	else 
	echo lang('no_categories');
?>