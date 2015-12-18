<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile {
	var $_view_base;
	var $models = 'admin/members_model';
	public function __construct()
	{
		$this->_view_base = '/'.ci()->current_dir.ci()->current_class.'/';
		
		ci()->lang->load('admin/admin');			
		ci()->load->helper(array('form', 'html'));
		ci()->load->library(array('table', 'javascript'));
	}
	
	public function edit($member_id='', $action='edit_member')
	{
		$vars = array();
		$session = ci()->session->userdata('user');
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$post = ci()->input->post(NULL, true);
			$member_data = ci()->_model->get_row(array('where'=>array('member_id'=>$session['member_id'])));
			
			if ( ! ci()->input->post('name') or ! ci()->input->post('phone') or ! ci()->input->post('email')) 
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			
			if (ci()->_model->get(array('where'=>array('email'=>$email, 'email !='=>$member_data['email'])))) 
			{
				$vars['error'][] = lang('email_exists');
			}
			
			if ( ! @$vars['error']) 
			{
				unset($post['password']);
				unset($post['username']);
				$this->_model->save($post, array('member_id'=>$session['member_id']));
				notice(lang('profile_updated'));
				redirect($this->_view_base.'edit');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('member_id'=>$session['member_id']))));
		if( ! @$vars['member_id'])
		{
			notice(lang('incorrect_member'), true);
			redirect('/users');
		}
		ci()->load->view($this->_view_base.'member_form',$vars);
	}	
	
	public function wholesale()
	{
		$vars = array();
		$session = ci()->session->userdata('user');
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$post = ci()->input->post(NULL, true);
			$member_data = ci()->_model->get_row(array('where'=>array('member_id'=>$session['member_id'])));
			
			if ( ! @$vars['error']) 
			{
				$this->_model->save($post, array('member_id'=>$session['member_id']));
				notice(lang('profile_updated'));
				redirect($this->_view_base.'wholesale');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}		
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('member_id'=>$session['member_id']))));
		ci()->load->view($this->_view_base.'wholesale',$vars);
	}
	
	public function change_password()
	{
		$session = ci()->session->userdata('user');
		$vars = array();
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$member_data = ci()->_model->get_row(array('where'=>array('member_id'=>$session['member_id'])));

			if ( ! ci()->input->post('password') or ! ci()->input->post('old_password') or ! ci()->input->post('confirm_password')) 
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			else
			{
				if ( md5(ci()->input->post('old_password')) != $member_data['password'])
				{
					$vars['error'][] = lang('wrong_old_password');
				}
			}
			
			if (ci()->input->post('password') != ci()->input->post('confirm_password')) 
			{
				$vars['error'][] = lang('passwords_not_match');
			}
			
			if ( ! @$vars['error']) 
			{
				$ins['password'] = md5( $password );
				$this->_model->save($ins, array('member_id'=>$session['member_id']));
				notice(lang('password_updated'));
				redirect($this->_view_base.'change_password');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('member_id'=>$session['member_id']))));
		if( ! @$vars['member_id'])
		{
			notice(lang('incorrect_member'), true);
			redirect('/users');
		}
		ci()->load->view($this->_view_base.'change_password',$vars);
	}
}
/* End of file Profile.php */
/* Location: ./application/controllers/users/Profile.php */