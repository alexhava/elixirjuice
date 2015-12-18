<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stores {
	var $_view_base;
	var $models = array('admin/stores_model', 'admin/taxes_model');
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
		redirect($this->_view_base.'stores_list');
	}	
		
	public function stores_list()
	{
		ci()->page_title(lang('stores_list'),lang('stores_list'));
		$vars = array('states'=>ci()->taxes_model->get_states());
		$stores = ci()->_model->get();
		foreach ($stores as $v) 
		{
			$vars['aaData'][] = array(
				$v['store_id'],
				"<a href='{$this->_view_base}edit_store?store_id={$v['store_id']}'> {$v['store_address']} </a>",
				$vars['states'][$v['state']],
				$v['store_status'],
				'<a href="'.$this->_view_base.'edit_store?store_id='.$v['store_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove_store?store_id='.$v['store_id'].'" class="delete">'.lang('delete').'</a>',
			);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/stores.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'stores', $vars);
	}
	
	public function edit_store()
	{
		ci()->page_title(lang('edit_store'), lang('edit_store'));

		$vars['action'] = 'edit_store';
		
		if( ! empty($_POST))
		{
			$post = ci()->input->post(NULL, true);
			$post['open_days'] = @serialize(@$post['open_days']);
			$post['delivery_hours'] = @serialize(@$post['delivery_hours']);
			$post['delivery_days'] = @serialize(@$post['delivery_days']);
			if ( ! @$vars['error'])
			{

				$this->_model->save($post);
				notice(lang('store_updated'));
				redirect('admin/stores/stores_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('store_id'=>ci()->input->get('store_id', true)))));
		if( ! @$vars['store_id'])
		{
			notice(lang('incorrect_store'), true);
			redirect('admin/stores/stores_list');
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/stores.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'store_form',$vars);
	}
		
	public function add_store()
	{
		ci()->page_title(lang('add_store'), lang('add_store'));

		$vars['action'] = 'add_store';
		
		if( ! empty($_POST))
		{
			if ( ! @$vars['error'])
			{
				$post = ci()->input->post(NULL, true);
				$post['open_days'] = serialize($post['open_days']);
				$post['delivery_hours'] = @serialize(@$post['delivery_hours']);
				$this->_model->save($post);
				notice(lang('store_created'));
				redirect('admin/stores/stores_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/stores.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'store_form',$vars);
	}
	
	public function remove_store()
	{
		if ($store_id=ci()->input->get('store_id')) 
		{
			$this->_remove_store($store_id);
			ci()->output->print_js('notice.show("'.lang('store_deleted').'")');
			exit;
		}
	}
	
	private  function _remove_store($store_id)
	{
		if ($store_id) 
		{
			ci()->_model->delete(array('store_id'=>$store_id));
		}
	}
}
/* End of file Stores.php */
/* Location: ./application/controllers/admin/Stores.php */