<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories {
	var $_view_base;
	var $models = 'admin/categories_model';
	public function __construct()
	{
		$this->_view_base = '/'.ci()->current_dir.ci()->current_class.'/';
		
		// default global view variables
		$vars = array(
			'table_template' => array(
				'table_open'		=> '<table class="main_table" border="0" cellspacing="0" cellpadding="0">',
				'row_start'			=> '<tr class="even">',
				'row_alt_start'		=> '<tr class="odd">'
			),
		);	
		
		ci()->load->helper(array('form', 'html'));
		ci()->load->library(array('table', 'javascript'));
		ci()->load->vars($vars);	
	}

	public function index()
	{
		redirect($this->_view_base.'categories_list');
	}	
		
	public function categories_list($return=false)
	{
		ci()->page_title(lang('categories_list'),lang('categories_list'));
		$vars = array();
		$options['order_by'] = 'category_name';
		$vars['categories'] = ci()->_model->get_sorted_cats();
		
		if ($return) return ci()->load->view($this->_view_base.'categories', $vars, true);

		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/categories.js', '', true));
		ci()->javascript->compile();
		ci()->load->view($this->_view_base.'categories', $vars);
	}
	
	public function change_visible()
	{
		// check
		$vars = ci()->_model->get_row(array('where'=>array('cat_id'=>ci()->input->get('cat_id', true))));
		if( ! @$vars['cat_id'])
		{
			ci()->output->print_js('notice.show("'.lang('incorrect_category').'", "error")');
			exit;
		}
		
		extract(ci()->input->get(NULL, true));
		
		$ins['visible'] = $state;
		$this->_model->save($ins, array('cat_id'=>$cat_id));
		
		ci()->output->print_js('notice.show("'.lang('category_updated').'")');
		exit;
	}
	
	public function change_order()
	{
		$cat_ids = (array)array_shift($_POST);
		foreach ($cat_ids as $order => $id) 
		{
			$where['cat_id'] = $id;
			$upd['cat_order'] = $order;
			$this->_model->save($upd, $where);
		}
		ob_start();
		ci()->output->print_js('notice.show("'.lang('order_changed').'")');
		ci()->output->print_js('var prevElement = $( ".main_table " ).prev()');
		ci()->output->print_js('$(".main_table").remove();');
		$new_table = str_replace("\n",'', addslashes($this->categories_list(true)));

		ci()->output->print_js('prevElement.after("'.$new_table.'");');
		ob_end_flush();
		exit;
	}
	
	public function edit_category()
	{
		ci()->page_title(lang('edit_category'), lang('edit_category'));

		$vars['action'] = 'edit_category';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post());
			$category_data = ci()->_model->get_row(array('where'=>array('cat_id'=>$cat_id)));
			if ( ! ci()->input->post('cat_name') ) 
			{
				$vars['error'][] = lang('fill_cat_name');
			}
			
			if ( ! ci()->input->post('cat_url_title') ) 
			{
				$vars['error'][] = lang('fill_cat_url');
			}
			
			if ($category_data['cat_url_title'] != ci()->input->post('cat_url_title', true) and ci()->_model->get_row(array('where'=>array('cat_url_title'=>ci()->input->post('cat_url_title', true), 'parent_id'=>$parent_id)))) 
			{
				$vars['error'][] = lang('cat_url_exist');
			}	
					
			if ( ! @$vars['error']) 
			{
				$ins['cat_name'] = 	$cat_name;
				$ins['cat_description'] = 	$cat_description;
				if(@$parent_id)$ins['parent_id'] = 	$parent_id;
				$ins['cat_url_title'] = preg_replace('![^a-zA-Z0-9-_]!', '', $cat_url_title);
				$ins['visible'] = $visible;
				$this->_model->save($ins, array('cat_id'=>$cat_id));
				notice(lang('category_updated'));
				redirect('admin/categories/categories_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('cat_id'=>ci()->input->get('category_id', true)))));
		if( ! @$vars['cat_id'])
		{
			notice(lang('incorrect_category'), true);
			redirect('admin/categories/categories_list');
		}
		$vars['categories'] = ci()->_model->get_sorted_cats_select($vars['cat_id']);
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/categories.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'category_form',$vars);
	}
		
	public function add_category()
	{
		ci()->page_title(lang('add_category'), lang('add_category'));

		$vars['action'] = 'add_category';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			if ( ! ci()->input->post('cat_name') ) 
			{
				$vars['error'][] = lang('fill_cat_name');
			}
			
			if ( ! ci()->input->post('cat_url_title') ) 
			{
				$vars['error'][] = lang('fill_cat_url');
			}
			
			if ($t = ci()->_model->get_row(array('where'=>array('cat_url_title'=>ci()->input->post('cat_url_title', true), 'parent_id'=>$parent_id)))) 
			{
				$vars['error'][] = lang('cat_url_exist');
			}
			
			if ( ! @$vars['error']) 
			{
				$ins['cat_name'] = 	$cat_name;
				$ins['cat_description'] = 	$cat_description;
				if(@$parent_id)$ins['parent_id'] = 	$parent_id;
				$ins['cat_url_title'] = preg_replace('![^a-zA-Z0-9-_]!', '', $cat_url_title);
				$ins['visible'] = $visible;
				$ins['cat_order'] = ci()->_model->get_next_order(@$parent_id);
				$this->_model->insert($ins);
				notice(lang('category_created'));
				redirect('admin/categories/categories_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars['categories'] = ci()->_model->get_sorted_cats_select();
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/categories.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'category_form',$vars);
	}
	
	public function remove_category()
	{
		if ($category_id=ci()->input->get('category_id')) 
		{
			$cat_data = $this->_model->get_row(array('where'=>array('cat_id'=>$category_id)));
			$this->_remove_category($category_id);
			$this->_model->update(array('parent_id'=>$cat_data['parent_id']), array('parent_id'=>$category_id));
			ci()->output->print_js('notice.show("'.lang('category_deleted').'")');
			
		}
		exit;
	}
	
	private  function _remove_category($category_id)
	{
		if ($category_id) 
		{
			ci()->_model->delete(array('cat_id'=>$category_id));
		}
	}
}
/* End of file Categories.php */
/* Location: ./application/controllers/admin/Categories.php */