<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_model extends Db_lib {
	private $cats;
	
	public function __construct()
	{
		parent::__construct();
		$this->table = 'categories';
	}
	
	public function get_sorted_cats_select($exclude=array())
	{
		$cats = $this->get_sorted_cats($exclude);
		$ret['0'] = lang('none');
		foreach ($cats as $cat)
		{
			$ret[$cat['cat_id']] = nbs(5*$cat['level']).$cat['cat_name'];
		}
		
		return $ret;
	}
	
	public function get_sorted_cats($exclude=array())
	{
		return $this->_get_sorted_cats(0,0,$exclude);
	}
	
	public function get_next_order($parent_id=0)
	{
		$options = array(
			'where'=>array('parent_id'=>$parent_id),
			'max'=>'cat_order'
		);	
		$r = $this->get_row($options);	
		return $r + 1;
	}
	
	private function _get_sorted_cats($parent_id, $level, $exclude=array())
	{
		if( ! $level) // we do that 1 time only
		$exclude = $exclude ? array('cat_id'=> ! is_array($exclude) ? array($exclude) : $exclude) : array();
		if( ! $this->cats)
		{
			$options = array(
				'where_not_in'=>$exclude,
				'order_by'=>'cat_order'
			);
			$cats = $this->get($options);
			reset($cats);
			foreach ($cats as $cat)
			{
				$this->cats[$cat['parent_id']][] = $cat;
			}
		}
		$cats = (array)@$this->cats[$parent_id];

		$new_cats = array();
		foreach ($cats as $k => $value) 
		{
			$value['level'] = $level;
			$new_cats[$value['cat_id']] = $value;
			if($sub_cats=$this->_get_sorted_cats($value['cat_id'], $level+1, $exclude))
			{
				$new_cats = $new_cats+$sub_cats;
			}
		}
		return $new_cats;
	}
	
	
}
// END Categories_model class

/* End of file Categories_model.php */
/* location models/admin/Categories_model.php */