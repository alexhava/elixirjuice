<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Allergies {
	var $_view_base;
	var $models = 'users/allergies_model';
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
		
		ci()->lang->load('admin/admin');
		ci()->load->helper(array('form', 'html'));
		ci()->load->library(array('table', 'javascript'));
		ci()->load->vars($vars);	
	}

	public function index()
	{
		$userdata = ci()->session->userdata('user');
		$opt['where'] = array('member_id'=>$userdata['member_id']);
		$opt['order_by'] = 'allergy';
		$vars['allergies'] = $this->_model->get($opt);
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/allergies.js', '', true));
		ci()->load->view($this->_view_base.'allergies',$vars);
	}
	
	public function add_allergy()
	{
		$userdata = ci()->session->userdata('user');
		@extract(ci()->input->post(NULL, true));
		if( ! empty($allergy))
		{
			$save = ci()->input->post(NULL, true);
			if ( ! @$vars['error']) 
			{
				$save['member_id'] 	=  $userdata['member_id'];
				$this->_model->save($save);
				notice(lang('allergy_saved'));
				ci()->output->print_js('document.location.reload();');
			}
		}
		exit;
	}
	public function edit_allergy()
	{
		$userdata = ci()->session->userdata('user');
		@extract(ci()->input->post(NULL, true));
		if( ! empty($allergy))
		{
			$save = ci()->input->post(NULL, true);
			if ( ! @$vars['error']) 
			{
				$w['member_id'] = $userdata['member_id'];
				$w['allergy_id'] = $allergy_id;
				$this->_model->save($save, $w);
				notice(lang('allergy_saved'));
			}
		}
		exit;
	}
	

	
	public function remove_allergy()
	{
		if ($allergy_id=ci()->input->get('allergy_id')) 
		{
			$this->_remove_allergy($allergy_id);
			ci()->output->print_js('notice.show("'.lang('allergy_deleted').'")');
			exit;
		}
	}
	
	private  function _remove_allergy($allergy_id)
	{
		if ($allergy_id) 
		{
			ci()->_model->delete(array('allergy_id'=>$allergy_id, 'member_id' => ci()->user_session_data['member_id']));
		}
	}	
}
/* End of file Allergies.php */
/* Location: ./application/controllers/users/Allergies.php */