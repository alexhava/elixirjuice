<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home {
	var $models = array('admin/orders_model');
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
		
		ci()->load->helper(array('form', 'html', 'security'));
		ci()->load->library(array('table', 'javascript'));

		// get statuses count
		$opt['select'] = 'count(order_status) as status_cnt, order_status';
		$opt['group_by'] = 'order_status';
		$opt['order_by'] = 'status_cnt';
		$opt['dir'] = 'desc';
		$vars['status_cnt'] = ci()->_model->get($opt);
		
		ci()->load->vars($vars);	
	}

	public function index()
	{
		ci()->load->view('admin/home');
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/admin/Home.php */