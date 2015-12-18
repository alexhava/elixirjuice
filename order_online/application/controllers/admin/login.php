<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login {
	var $models = 'admin/admin_model';
	public function index()
	{
		$vars['page_title'] = lang('header');
		if( ! empty($_POST))
		{
			if ( ! ci()->input->post('password') or ! ci()->input->post('login')) 
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			
			$member_data = $this->_model->get_row(array('where'=>array('username'=>ci()->input->post('login'))));

			if ($member_data) 
			{
				if($member_data['password'] != md5(ci()->input->post('password')))
				$vars['error'][] = lang('passwords_not_match');
			}
			else {
				$vars['error'][] = lang('passwords_not_match');
			}
			
			if ( ! @$vars['error']) 
			{
				ci()->session->set_userdata('admin', $member_data);
				redirect('admin/home');
			}
		}
		
		ci()->force_view = true;
		ci()->load->view('admin/login_form', $vars);
	}
}
/* End of file Login.php */
/* Location: ./application/controllers/admin/Login.php */