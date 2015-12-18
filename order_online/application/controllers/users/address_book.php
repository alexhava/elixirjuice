<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address_book {
	var $_view_base;
	var $models = array('users/address_book_model', 'admin/taxes_model');
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
		ci()->lang->load('admin/admin');
		ci()->load->vars($vars);
	}

	public function index()
	{
		redirect($this->_view_base.'address_book_list');
	}

	public function browse()
	{
		ci()->page_title(lang('address_book_list'),lang('address_book_list'));
		$vars = array('states'=>ci()->taxes_model->get_states());
		$opt['member_id'] = ci()->user_session_data['member_id'];
		$vars['addresses'] = ci()->_model->get($opt);
		$opt['primary'] = 'y';
		$vars['primary_data'] = ci()->_model->get_row($opt);
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/address_book.js', '', true));
		ci()->load->view($this->_view_base.'list', $vars);
	}

	public function edit_address()
	{
		ci()->page_title(lang('edit_address'), lang('edit_address'));

		$vars['action'] = 'edit_address';
		$vars['action_text'] = 'Update';

		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$post = ci()->input->post(NULL, true);

			if ( ! ci()->input->post('name') or ! ci()->input->post('region') or ! ci()->input->post('address1') or ! ci()->input->post('postcode') or ! ci()->input->post('address3') )
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			
			if( ! @$post['address_id'])
			{
				$vars['error'][] = lang('incorrect_address');
			}
			
			if ( ! @$vars['error'])
			{
				if(isset($primary))
				{
					$upd['primary'] = 'n';
					$this->_model->save($upd, array('member_id'=>ci()->user_session_data['member_id']));
				}
				$this->_model->save($post, array('member_id'=>ci()->user_session_data['member_id'], 'address_id'=>$address_id));
				notice(lang('address_updated'));
				redirect($this->_view_base.'browse');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice('- '.implode('<br>- ', $vars['error']), true);
			}
		}
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('address_id'=>ci()->input->get('address_id', true), 'member_id'=>ci()->user_session_data['member_id']))));
		if( ! @$vars['address_id'])
		{
			notice(lang('incorrect_address'), true);
			redirect($this->_view_base.'browse');
		}
		ci()->load->view($this->_view_base.'address_form',$vars);
	}
	
	public function add_address()
	{
		ci()->page_title(lang('add_address'), lang('add_address'));

		$vars['action'] = 'add_address';
		$vars['action_text'] = 'Add';

		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$post = ci()->input->post(NULL, true);

			if ( ! ci()->input->post('name') or ! ci()->input->post('region') or ! ci()->input->post('address1') or ! ci()->input->post('postcode') or ! ci()->input->post('address3') )
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			
			if ( ! @$vars['error'])
			{
				if(isset($primary))
				{
					$upd['primary'] = 'n';
					$this->_model->save($upd, array('member_id'=>ci()->user_session_data['member_id']));
				}
				$post['member_id'] = ci()->user_session_data['member_id'];
				$this->_model->save($post);
				notice(lang('address_added'));
				redirect($this->_view_base.'browse');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice('- '.implode('<br>- ', $vars['error']), true);
			}
		}
		ci()->load->view($this->_view_base.'address_form',$vars);
	}

	public function remove_address_book()
	{
		if ($address_id=ci()->input->get('address_id'))
		{
			$this->_remove_address($address_id);
			ci()->output->print_js('notice.show("'.lang('address_deleted').'")');
			exit;
		}
	}

	private  function _remove_address($address_id)
	{
		if ($address_id)
		{
			ci()->_model->delete(array('address_id'=>$address_id, 'primary !='=>'y'));
		}
	}
}
/* End of file Address_book.php */
/* Location: ./application/controllers/admin/Address_book.php */