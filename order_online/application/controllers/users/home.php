<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home {
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

		ci()->load->vars($vars);	
	}

	public function index()
	{
		$vars['table'] = 1;
		ci()->load->view('users/home_index', $vars);
	}
}
/* End of file home.php */
/* Location: ./application/controllers/users/home.php */