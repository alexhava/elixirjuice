<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups {
	var $_view_base;
	var $models = 'admin/groups_model';
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
		redirect($this->_view_base.'groups_list');
	}	
		
	public function groups_list()
	{
		ci()->page_title(lang('groups_list'),lang('groups_list'));
		$vars = array('group_types'=>ci()->_model->get_group_types());
		$group_types = ci()->_model->get_group_types();
		$options['order_by'] = 'group_name';
		$groups = ci()->_model->get($options);
		foreach ($groups as $v) 
		{
			$vars['aaData'][] = array(
				$v['group_id'],
				"<a href='{$this->_view_base}edit_group?group_id={$v['group_id']}'> {$v['group_name']} </a>",
				$group_types[$v['group_type']],
				'<a href="'.$this->_view_base.'permissions?group_id='.$v['group_id'].'">'.lang('permissions').'</a>',
				'<a href="'.$this->_view_base.'edit_group?group_id='.$v['group_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove_group?group_id='.$v['group_id'].'" class="delete">'.lang('delete').'</a>',
			);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/groups.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'groups', $vars);
	}
	
	public function edit_group()
	{
		ci()->page_title(lang('edit_group'), lang('edit_group'));

		$vars['action'] = 'edit_group';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$group_data = ci()->_model->get_row(array('where'=>array('group_id'=>$group_id)));
			if ( ! ci()->input->post('group_name') )
			{
				$vars['error'][] = lang('fill_all_fields');
			}

			if ( ! @$vars['error'])
			{
				$ins['group_name'] = 	$group_name;
				$ins['group_type'] = 	$group_type;
				$this->_model->save($ins, array('group_id'=>$group_id));
				notice(lang('group_updated'));
				redirect('admin/groups/groups_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('group_id'=>ci()->input->get('group_id', true)))));
		if( ! @$vars['group_id'])
		{
			notice(lang('incorrect_group'), true);
			redirect('admin/groups/groups_list');
		}
		ci()->load->view($this->_view_base.'group_form',$vars);
	}
		
	public function add_group()
	{
		ci()->page_title(lang('add_group'), lang('add_group'));

		$vars['action'] = 'add_group';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			if ( ! ci()->input->post('group_name') ) 
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			
			if ( ! @$vars['error']) 
			{
				$ins['group_name'] = 	$group_name;
				$ins['group_type'] = 	$group_type;
				$this->_model->insert($ins);
				notice(lang('group_created'));
				redirect('admin/groups/groups_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		ci()->load->view($this->_view_base.'group_form',$vars);
	}
	
	public function permissions()
	{
		$group_id = ci()->input->get_post('group_id', true);
		if( ! @$group_id)
		{
			notice(lang('incorrect_group'), true);
			redirect('admin/groups/groups_list');
		}
		$vars['group_id'] = $group_id;		
		
		$group_types = ci()->_model->get_group_types();
		$group_data = ci()->_model->get_row(array('where'=>array('group_id'=>$group_id)));
		if( ! @$group_data)
		{
			notice(lang('incorrect_group'), true);
			redirect('admin/groups/groups_list');
		}	
			
		ci()->page_title(lang('edit_permissions'), lang('edit_permissions')."'{$group_types[$group_data['group_type']]}'");

		$vars['action'] = 'permissions';

		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			if ( ! $group_id )
			{
				$vars['error'][] = lang('incorrect_group');
			}

			if ( ! @$vars['error'])
			{
				$ins['group_id'] = 	$group_id;
				$this->_model->delete(array('group_id'=>$group_id), 'permissions');
				foreach ($permissions as $page)
				{
					$ins['page'] = 	$page;
					$this->_model->insert($ins, 'permissions');
				}
				
				notice(lang('group_permissions_updated'));
				redirect('admin/groups/groups_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars['permissions'] = ci()->_model->get_permissions($group_id);
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/groups.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'permissions',$vars);
	}
	
	public function remove_group()
	{
		if ($group_id=ci()->input->get('group_id')) 
		{
			$this->_remove_group($group_id);
			ci()->output->print_js('notice.show("'.lang('group_deleted').'")');
			exit;
		}
	}
	
	private  function _remove_group($group_id)
	{
		if ($group_id) 
		{
			ci()->_model->delete(array('group_id'=>$group_id));
		}
	}
}
/* End of file Groups.php */
/* Location: ./application/controllers/admin/Groups.php */