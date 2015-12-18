<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar {
	var $_view_base;
	var $models = array('admin/calendar_model');
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
		redirect($this->_view_base.'calendar_list');
	}	
		
	public function date_list()
	{
		ci()->page_title(lang('date_list'),lang('date_list'));
		$calendar = ci()->_model->get();
		foreach ($calendar as $v) 
		{
			$vars['aaData'][] = array(
				$v['off_id'],
				$v['month'],
				$v['day'],
				$v['year'],
				$v['note'],
				'<a href="'.$this->_view_base.'edit_off_date?off_id='.$v['off_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove_off_date?off_id='.$v['off_id'].'" class="delete">'.lang('delete').'</a>',
			);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/calendar.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'calendar', @$vars);
	}
	
	public function edit_off_date()
	{
		ci()->page_title(lang('edit_off_date'), lang('edit_off_date'));

		$vars['action'] = 'edit_off_date';
		
		if( ! empty($_POST))
		{
			$post = ci()->input->post(NULL, true);
			if ( ! @$vars['error'])
			{

				$this->_model->save($post);
				notice(lang('date_updated'));
				redirect('admin/calendar/date_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('off_id'=>ci()->input->get('off_id', true)))));
		if( ! @$vars['off_id'])
		{
			notice(lang('incorrect_record'), true);
			redirect('admin/calendar/calendar_list');
		}
		ci()->load->view($this->_view_base.'date_form',$vars);
	}
		
	public function add_off_date()
	{
		ci()->page_title(lang('add_off_date'), lang('add_off_date'));

		$vars['action'] = 'add_off_date';
		
		if( ! empty($_POST))
		{
			if ( ! @$vars['error']) 
			{
				$this->_model->save(ci()->input->post(NULL, true));
				notice(lang('date_created'));
				redirect('admin/calendar/date_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		ci()->load->view($this->_view_base.'date_form',$vars);
	}
	
	public function remove_off_date()
	{
		if ($off_id=ci()->input->get('off_id')) 
		{
			$this->_remove_off_date($off_id);
			ci()->output->print_js('notice.show("'.lang('date_deleted').'")');
		}
		exit;
	}
	
	private  function _remove_off_date($off_id)
	{
		if ($off_id) 
		{
			ci()->_model->delete(array('off_id'=>$off_id));
		}
	}
}
/* End of file Calendar.php */
/* Location: ./application/controllers/admin/Calendar.php */