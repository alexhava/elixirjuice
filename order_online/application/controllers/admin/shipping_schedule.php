<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipping_schedule {
	var $_view_base;
	var $models = array('admin/shipping_schedule_model', 'admin/shipping_methods_model');
	public function __construct()
	{
		$this->_view_base = '/'.ci()->current_dir.ci()->current_class.'/';
		
		// default global view variables
		$vars = array(
			'table_template' => array(
				'table_open'		=> '<table class="shipping-schedule main_table" border="0" cellspacing="0" cellpadding="0">',
				'row_start'			=> '<tr class="even">',
				'row_alt_start'		=> '<tr class="odd">'
			),
		);	
		
		ci()->load->helper(array('form', 'html'));
		ci()->load->library(array('table', 'javascript'));
		$vars['shipping_methods'] = ci()->shipping_methods_model->get();
		ci()->load->vars($vars);	
	}
	public function change_order()
	{
		foreach ($_POST['prio'] as $k => $r)
		{
			$ins['shipping_schedule_id'] = $r;
			$ins['prio'] = $k;			
			$this->_model->save($ins);
		}
		
		exit;
	}
	
	public function index()
	{
		redirect($this->_view_base.'shipping_schedule_list');
	}	
		
	public function shipping_schedule_list()
	{
		ci()->page_title(lang('shipping_schedule_list'),lang('shipping_schedule_list'));
		$vars = array('states'=>ci()->_model->get_states());
		$shipping_schedule = ci()->_model->get(array('order_by' => 'prio'));
		foreach ($shipping_schedule as $v) 
		{
			$vars['aaData'][] = array(
				'<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.form_hidden('prio[]', $v['shipping_schedule_id']),
				$v['prio'],
				$v['shipping_schedule_id'],
				$v['name'],
				'<a href="'.$this->_view_base.'edit_shipping_schedule?shipping_schedule_id='.$v['shipping_schedule_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove_shipping_schedule?shipping_schedule_id='.$v['shipping_schedule_id'].'" class="delete">'.lang('delete').'</a>',
			);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/shipping_schedule.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'shipping_schedule', $vars);
	}
	
	public function edit_shipping_schedule()
	{
		ci()->page_title(lang('edit_shipping_schedule'), lang('edit_shipping_schedule'));

		$vars['action'] = 'edit_shipping_schedule';
		
		if( ! empty($_POST))
		{
			$post = ci()->input->post(NULL, true);
			if ( ! @$vars['error'])
			{
				if(@$post['shipping_days'])
				$post['shipping_days'] = json_encode($post['shipping_days']);
				$this->_model->save($post);
				notice(lang('shipping_schedule_updated'));
				redirect('admin/shipping_schedule/shipping_schedule_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('shipping_schedule_id'=>ci()->input->get('shipping_schedule_id', true)))));
		
		if( ! @$vars['shipping_schedule_id'])
		{
			notice(lang('incorrect_shipping_schedule'), true);
			redirect('admin/shipping_schedule/shipping_schedule_list');
		}
		if($vars['shipping_days'])
		$vars['shipping_days'] = json_decode($vars['shipping_days']);
		ci()->load->view($this->_view_base.'shipping_schedule_form',$vars);
	}
		
	public function add_shipping_schedule()
	{
		ci()->page_title(lang('add_shipping_schedule'), lang('add_shipping_schedule'));

		$vars['action'] = 'add_shipping_schedule';
		
		if( ! empty($_POST))
		{
			$post = ci()->input->post(NULL, true);
			extract(ci()->input->post(NULL, true));
			
			if ( ! @$vars['error']) 
			{
				if(@$post['shipping_days'])
				$post['prio'] = ci()->_model->get_row(array(
															'max'=>'prio',
															'order_by'=>'prio',
															'dir'=>'desc',
															)) + 1;
				$post['shipping_days'] = json_encode($post['shipping_days']);
				$this->_model->save($post);
				notice(lang('shipping_schedule_created'));
				redirect('admin/shipping_schedule/shipping_schedule_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		ci()->load->view($this->_view_base.'shipping_schedule_form',$vars);
	}
	
	public function remove_shipping_schedule()
	{
		if ($shipping_schedule_id=ci()->input->get('shipping_schedule_id')) 
		{
			$this->_remove_shipping_schedule($shipping_schedule_id);
			ci()->output->print_js('notice.show("'.lang('shipping_schedule_deleted').'")');
			exit;
		}
	}
	
	private  function _remove_shipping_schedule($shipping_schedule_id)
	{
		if ($shipping_schedule_id) 
		{
			ci()->_model->delete(array('shipping_schedule_id'=>$shipping_schedule_id));
		}
	}
}
/* End of file shipping_schedule.php */
/* Location: ./application/controllers/admin/shipping_schedule.php */