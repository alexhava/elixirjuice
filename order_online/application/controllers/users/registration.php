<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration {
	var $models = 'admin/admin_model';
	
	public function __construct()
	{
		ci()->load->model(array('admin/taxes_model'));
		ci()->load->helper(array('form', 'html'));
		ci()->load->library(array('table', 'javascript', 'email', 'parser'));
	}	
	
	public function activation()
	{
		extract(ci()->input->get(NULL, true));
		$user_data = $this->_model->get_row(array('activation_key'=>$code));
		if( ! $user_data)
			$vars['message'] = lang('activation_incomplete');
		else 
		{
			$save['active'] = 'y';
			$save['member_id'] = $user_data['member_id'];
			$this->_model->save($save);
			$vars['message'] = lang('activation_success');
		}	
		ci()->load->view('users/success', $vars);
	}
	
	public function success()
	{
		$vars['message'] = lang('registration_success');
		if(ci()->system_settings['need_user_activation'] == 'y')
			$vars['message'] = lang('registration_success_with_activation');
		ci()->load->view('users/success', $vars);
	}
	

	
	private function _send_email($post)
	{
		$admin = $this->_model->get_row(array('admin'=>'y'));
		ci()->email->from($admin['email'], 'elixirjuice');
		ci()->email->to($post['email']);
		
		$post['url'] = 'http://'.$_SERVER['SERVER_NAME'].'/users/registration/activation?code='.$post['activation_key'];
		$body = ci()->parser->parse_string(lang('activation_content'), $post, TRUE);
		ci()->email->subject(lang('activation_subject'));
		ci()->email->message($body);

		ci()->email->send();
	}
}
/* End of file registration.php */
/* Location: ./application/controllers/users/registration.php */