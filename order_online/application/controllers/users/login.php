<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login {
	var $models = 'admin/admin_model';


	public function __construct()
	{
		ci()->load->library(array('email', 'parser'));
		ci()->load->helper(array('form', 'html'));
		ci()->lang->load('admin/admin');		
	}
	
	public function index($redirect=true)
	{
		ci()->lang->load("admin/admin");
		$vars['page_title'] = lang('header');
		if( ! empty($_POST))
		{
			if(ci()->input->post('registration'))
			{
				$this->registration();
				ci()->load->view('users/login_form', $vars);
				return ;
			}
			
			if ( ! ci()->input->post('password') or ! ci()->input->post('login'))
			{
				$vars['error'][] = lang('fill_all_fields');
			}

			$member_data = $this->_model->get_row(array('or_where'=>array('username'=>ci()->input->post('login'), 'email'=>ci()->input->post('login'))));

			if ($member_data)
			{
				if($member_data['password'] != md5(ci()->input->post('password')))
				$vars['error'][] = lang('passwords_not_match');
				elseif ($member_data['active'] == 'n' and ci()->system_settings['need_user_activation'] == 'y')
				$vars['error'][] = lang('account_not_active');
			}
			else {
				$vars['error'][] = lang('account_not_exists');
			}
			if ( ! @$vars['error'])
			{
				ci()->session->set_userdata('user', $member_data);
				$redirect_url = ci()->session->userdata('redirect_after_login') ?  ci()->session->userdata('redirect_after_login') : 'users/home';
				ci()->session->unset_userdata('redirect_after_login');
				if($redirect) redirect($redirect_url);
				else{echo "<script>document.location.reload()</script>"; exit;}
			}
		}

		if( ! $redirect) {echo "<script>notice.show('".implode(" | ", $vars['error'])."', 'error');</script>"; exit;}
		ci()->load->view('users/login_form', $vars);
	}
	
	public function ajaxlogin()
	{
		$this->index(false);
		exit;
	}
	
	public function password_changed()
	{
		ci()->load->view('users/success', array('message'=>lang('password_changed')));
	}
	
	public function logout()
	{
		ci()->session->unset_userdata('user');
		redirect('/');
	}
	
	public function forgotpassword()
	{
		if( ! empty($_POST) and ci()->input->post('email'))
		{
			$user_data = $this->_model->get_row(array('email'=>ci()->input->post('email')));
			if($user_data)
			{
				$user_data['recovery_hash'] = md5( rand(333333,7777777).mktime() );
				$this->_model->save($user_data, 'password_recovery');
				$this->_send_recovery_email($user_data);
			}
			ci()->load->view('users/success', array('message'=>lang('forgotpassword_mailed')));
			return; 
		}
		ci()->load->view('users/forgotpassword');
	}
	
	public function change_password()
	{
		$vars = ci()->input->get(NULL, true);
		if( ! empty($_POST))
		{		
			$vars = ci()->input->post(NULL, true);

			extract(ci()->input->post());
			$user_data = $this->_model->get_row(array('recovery_hash'=>$code), 'password_recovery');
			if (ci()->input->post('password') != ci()->input->post('confirm_password')) 
			{
				$vars['error'][] = lang('passwords_not_match');
			}	
			if ( ! @$vars['error'] and $user_data) 
			{
				$user_data['password'] = md5( $password );
				$this->_model->save($user_data);
				redirect('users/login/password_changed');
			}					
		}
	
		ci()->load->view('users/change_password', $vars);
	}

	public function registrationajax($return=false)
	{
		$_POST['confirm_password'] = $_POST['password_confirm'];
		$_POST['firstname'] = $_POST['first_name'];
		$_POST['lastname'] = $_POST['last_name'];
		$_POST['email'] = $_POST['x_email'];
		$_POST['username'] = $_POST['x_email'];
		$_POST['postcode'] = $_POST['x_zip'];
		$_POST['address1'] = $_POST['x_address'];
		$_POST['address3'] = $_POST['x_city'];
		$_POST['phone'] = $_POST['x_phone'];
		$reg = $this->registration(true);
		if(is_array($reg))
		{
			$err = implode(' | ', $reg);
			echo "<script> alert('$err'); </script>";
		}
		else 
		{
			echo "<script> showStep(); 
			$('[name=\"login_type\"]').removeAttr('checked'); 
			$('[name=\"login\"]').val('{$_POST['email']}');
			$('[name=\"password\"]').val('{$_POST['password']}');
			</script>";
		}
		exit;
	}
	
	public function registration($return=false)
	{
		
		if( ! empty($_POST))
		{
			$post = ci()->input->post(NULL, true);
			extract($post);
			if ( ! ci()->input->post('firstname') or ! ci()->input->post('lastname') or ! ci()->input->post('phone') or ! ci()->input->post('region') or ! ci()->input->post('address1') or ! ci()->input->post('postcode') or ! ci()->input->post('address3') or ! ci()->input->post('password') or ! ci()->input->post('email') or ! ci()->input->post('username') or ! ci()->input->post('confirm_password')) 
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			
			if (ci()->input->post('password') != ci()->input->post('confirm_password')) 
			{
				$vars['error'][] = lang('passwords_not_match');
			}
			
			if (ci()->_model->get(array('where'=>array('username'=>$username)))) 
			{
				$vars['error'][] = lang('login_exists');
			}
			
			if (ci()->_model->get(array('where'=>array('email'=>$email)))) 
			{
				$vars['error'][] = lang('email_exists');
			}
			if ( ! preg_match('!.+?\@.+?\..+!', $email)) 
			{
				$vars['error'][] = lang('email_invalid');
			}
			
			if ( ! @$vars['error']) 
			{
				$post['name'] = 	$firstname . ' ' . $lastname;
				$post['password'] = md5( $password );
				$post['activation_key'] = md5( rand(333333,7777777).mktime() );
				
				// save customer
				$post['member_id'] = $this->_model->save($post);
				$post['primary'] = 'y';
				
				// save primary
				$member_id = $this->_model->save($post, 'addresses');
				
				//auto login
				ci()->session->set_userdata('user', $post);

				if(ci()->system_settings['need_user_activation'] == 'y')
				$this->_send_email($post);
				
				if( ! $return)
				{
					//
					$redirect_url =  ci()->session->userdata('order') ? '/cart/checkout' : ci()->session->userdata('redirect_after_login') ?  ci()->session->userdata('redirect_after_login') : 'users/registration/success';
					ci()->session->unset_userdata('redirect_after_login');
					notice('Registration successful');
					redirect($redirect_url);
				}
				
				return $member_id;
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
			}
		}
		if($return) return $vars['error'];
		$vars2['registration_vars'] = $vars;
		ci()->load->vars($vars2);
	}	
	
	private function _send_recovery_email($post)
	{
		$admin = $this->_model->get_row(array('admin'=>'y'));
		ci()->email->from($admin['email'], 'elixirjuice');
		ci()->email->to($post['email']);
		
		$post['url'] = 'http://'.$_SERVER['SERVER_NAME'].'/users/login/change_password?code='.$post['recovery_hash'];
		$body = ci()->parser->parse_string(lang('forgotpassword_content'), $post, TRUE);
		ci()->email->subject(lang('forgotpassword_subject'));
		ci()->email->message($body);

		ci()->email->send();
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
/* End of file Login.php */
/* Location: ./application/controllers/admin/Login.php */