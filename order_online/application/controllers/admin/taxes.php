<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taxes {
	var $_view_base;
	var $models = 'admin/taxes_model';
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
		redirect($this->_view_base.'taxes_list');
	}	
		
	public function taxes_list()
	{
		ci()->page_title(lang('taxes_list'),lang('taxes_list'));
		$vars = array('states'=>ci()->_model->get_states());
		$taxes = ci()->_model->get();
		foreach ($taxes as $v) 
		{
			$vars['aaData'][] = array(
				$v['tax_id'],
				"<a href='{$this->_view_base}edit_tax?tax_id={$v['tax_id']}'> {$vars['states'][$v['state']]} </a>",
				$v['ratio'],
				'<a href="'.$this->_view_base.'edit_tax?tax_id='.$v['tax_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove_tax?tax_id='.$v['tax_id'].'" class="delete">'.lang('delete').'</a>',
			);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/taxes.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'taxes', $vars);
	}
	
	public function edit_tax()
	{
		ci()->page_title(lang('edit_tax'), lang('edit_tax'));

		$vars['action'] = 'edit_tax';
		
		if( ! empty($_POST))
		{
			$post = ci()->input->post(NULL, true);
			if ( ! @$vars['error'])
			{

				$this->_model->save($post);
				notice(lang('tax_updated'));
				redirect('admin/taxes/taxes_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('tax_id'=>ci()->input->get('tax_id', true)))));
		if( ! @$vars['tax_id'])
		{
			notice(lang('incorrect_tax'), true);
			redirect('admin/taxes/taxes_list');
		}
		ci()->load->view($this->_view_base.'tax_form',$vars);
	}
		
	public function add_tax()
	{
		ci()->page_title(lang('add_tax'), lang('add_tax'));

		$vars['action'] = 'add_tax';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			
			if ( ! @$vars['error']) 
			{
				$ins['state'] = 	$state;
				$ins['ratio'] = 	$ratio;
				$this->_model->insert($ins);
				notice(lang('tax_created'));
				redirect('admin/taxes/taxes_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		ci()->load->view($this->_view_base.'tax_form',$vars);
	}
	
	public function remove_tax()
	{
		if ($tax_id=ci()->input->get('tax_id')) 
		{
			$this->_remove_tax($tax_id);
			ci()->output->print_js('notice.show("'.lang('tax_deleted').'")');
			exit;
		}
	}
	
	private  function _remove_tax($tax_id)
	{
		if ($tax_id) 
		{
			ci()->_model->delete(array('tax_id'=>$tax_id));
		}
	}
}
/* End of file Taxes.php */
/* Location: ./application/controllers/admin/Taxes.php */