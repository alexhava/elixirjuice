<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipping_types {
	var $_view_base;
	var $models = arraY('admin/shipping_types_model', 'admin/shipping_methods_model');
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
		$vars['shipping_methods'] = ci()->shipping_methods_model->get();
		ci()->load->vars($vars);	
	}

	public function index()
	{
		redirect($this->_view_base.'shipping_types_list');
	}	
		
	public function shipping_types_list()
	{
		ci()->page_title(lang('shipping_types_list'),lang('shipping_types_list'));
		$vars = array('states'=>ci()->_model->get_states());
		$shipping_types = ci()->_model->get();
		foreach ($shipping_types as $v) 
		{
			$vars['aaData'][] = array(
				$v['shipping_type_id'],
				$v['name'],
				$v['total_weight'],
				$v['cost'],
				$v['shipping_method'] ? ci()->shipping_methods_model->get(true)->{$v['shipping_method']} : '',
				'<a href="'.$this->_view_base.'edit_shipping_type?shipping_type_id='.$v['shipping_type_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove_shipping_type?shipping_type_id='.$v['shipping_type_id'].'" class="delete">'.lang('delete').'</a>',
			);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/shipping_types.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'shipping_types', $vars);
	}
	
	public function edit_shipping_type()
	{
		ci()->page_title(lang('edit_shipping_type'), lang('edit_shipping_type'));

		$vars['action'] = 'edit_shipping_type';
		
		if( ! empty($_POST))
		{
			$post = ci()->input->post(NULL, true);
			if ( ! @$vars['error'])
			{

				$this->_model->save($post);
				notice(lang('shipping_type_updated'));
				redirect('admin/shipping_types/shipping_types_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('shipping_type_id'=>ci()->input->get('shipping_type_id', true)))));
		if( ! @$vars['shipping_type_id'])
		{
			notice(lang('incorrect_shipping_type'), true);
			redirect('admin/shipping_types/shipping_types_list');
		}
		ci()->load->view($this->_view_base.'shipping_type_form',$vars);
	}
		
	public function add_shipping_type()
	{
		ci()->page_title(lang('add_shipping_type'), lang('add_shipping_type'));

		$vars['action'] = 'add_shipping_type';
		
		if( ! empty($_POST))
		{
			$post = ci()->input->post(NULL, true);
			extract(ci()->input->post(NULL, true));
			
			if ( ! @$vars['error']) 
			{
				$this->_model->save($post);
				notice(lang('shipping_type_created'));
				redirect('admin/shipping_types/shipping_types_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		ci()->load->view($this->_view_base.'shipping_type_form',$vars);
	}
	
	public function remove_shipping_type()
	{
		if ($shipping_type_id=ci()->input->get('shipping_type_id')) 
		{
			$this->_remove_shipping_type($shipping_type_id);
			ci()->output->print_js('notice.show("'.lang('shipping_type_deleted').'")');
			exit;
		}
	}
	
	private  function _remove_shipping_type($shipping_type_id)
	{
		if ($shipping_type_id) 
		{
			ci()->_model->delete(array('shipping_type_id'=>$shipping_type_id));
		}
	}
}
/* End of file shipping_types.php */
/* Location: ./application/controllers/admin/shipping_types.php */