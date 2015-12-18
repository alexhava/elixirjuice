<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members {
	var $_view_base;
	var $models = 'admin/members_model';
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
		redirect($this->_view_base.'members_list');
	}	
	
	public function logout()
	{
		ci()->session->unset_userdata('admin');
		redirect('admin/login');
	}
	
	public function members_list()
	{
		ci()->page_title(lang('members_list'),lang('members_list'));
    	$options = array(
			'order_by' 	=> 'name',
			'direction' => 'ASC',
			'limit' => 10,
			'offset' => '0',
			'iTotalRecords' => '0',
			'iTotalDisplayRecords' => '0',
		);

		$col_map = array('member_id', 'username', 'name', 'group', 'email', 'active', 'ban');
		$groups = ci()->groups_model->get_groups();

		/* Ordering */
		if (($order_by = ci()->input->get('iSortCol_0')) !== FALSE)
		{

			if (isset($col_map[$order_by]))
			{
				$col = $col_map[$order_by];
				if($col == 'group')
				{
					$options['join']['table'] = 'groups g';
					$options['join']['cond'] = 'g.group_id=members.group_id';
					$col = 'group_name';
				}
				$options['order_by'] = $col;
				$options['dir'] = ci()->input->get('sSortDir_0');
			}
			
			$options['limit'] = ci()->input->get_post('perpage') ? (int)ci()->input->get_post('perpage') : self::DATATABLES_PAGE_SIZE;
			$options['offset'] = (int)ci()->input->get_post('iDisplayStart');
			$vars['sEcho'] = (int)ci()->input->get_post('sEcho');
			$get = ci()->input->get_post('keyword');
			if($gr = ci()->input->get_post('wholesale'))
			{
				$options['where']['wholesale_enabled !='] = 'y';
				$options['where']['wholesale'] = 'y';
			}
			
			if($gr = ci()->input->get_post('group_id'))
				$options['where']['group_id'] = $gr;
			if($gr = ci()->input->get_post('ban'))
				$options['where']['ban'] = $gr;
			if( ! ci()->input->get_post('exact_match'))
				$options['custom'] = "(name like '%$get%' or username like '%$get%' or email like '%$get%')";
			else 
				$options['custom'] = "(name = '$get' or username = '$get' or email = '$get')";
			$ajax=TRUE;
		}	
		$vars['default_sort'] = array(1, 'asc');
		$vars['non_sortable_columns'] = array(7,8,9);
		$vars['perpage_select_options'] = array( '10' => '10 '.lang('results'), '25' => '25 '.lang('results'), '50' => '50 '.lang('results'), '75' => '75 '.lang('results'), '100' => '100 '.lang('results'), '150' => '150 '.lang('results'));		
		$vars['aaData'] = array();
		$members = ci()->_model->get($options);
		$options['count'] = TRUE;
		$vars['iTotalRecords'] = $vars['iTotalDisplayRecords'] = ci()->_model->get($options);		
		$vars['perpage'] = $options['limit'];
		$c = 0;
		foreach ($members as $v) 
		{
			$vars['aaData'][] = array(
				$v['member_id'],
				"<a href='{$this->_view_base}edit_member?member_id={$v['member_id']}'> {$v['username']} </a>",
				$v['name'],
				@$groups[$v['group_id']],
				$v['email'],
				$v['active']=='y' ? lang('activated') : lang('not_activated'),
				'<a class="ban" href="'.$this->_view_base.'ban_member?member_id='.$v['member_id'].'&ban='.($v['ban']=='y' ? 'n' : 'y').'">'.($v['ban']=='y' ? lang('unban') : lang('ban')).'</a>',
				'<a href="'.$this->_view_base.'edit_member?member_id='.$v['member_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove_member?member_id='.$v['member_id'].'" class="delete">'.lang('delete').'</a>',
				form_checkbox('bulk[]', $v['member_id'], '', 'class="bulk"')
			);
		}
		$vars['groups'] = array(''=> lang('all_groups')) + $groups;
		// get wholesale requests
		$options2['where']['wholesale_enabled !='] = 'y';
		$options2['where']['wholesale'] = 'y';
		$options2['count'] = TRUE;
		$vars['wholesale_cnt']  = ci()->_model->get($options2);
		if ( ! @$ajax)
		{
			$js = $this->_datatables_js($this->_view_base.'members_list?'.$_SERVER['QUERY_STRING'], $vars['non_sortable_columns'], $vars['default_sort'], $options['limit']);
			$vars['js'] = $js;
			$vars['data'] = $members;
		}
		else
		{
			ci()->output->send_ajax_response($vars);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/members.js', '', true));
		ci()->javascript->compile();
		ci()->load->view($this->_view_base.'members', $vars);
	}
	
	public function edit_member($member_id='', $action='edit_member')
{
		ci()->page_title(lang('edit_member'), lang('edit_member'));

		$vars['action'] = $action;
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$member_data = ci()->_model->get_row(array('where'=>array('member_id'=>$member_id)));
			if ( ! ci()->input->post('username') or ! ci()->input->post('email')) 
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			
			if (ci()->input->post('password') and ci()->input->post('password') != ci()->input->post('confirm_password')) 
			{
				$vars['error'][] = lang('passwords_not_match');
			}
			
			if (ci()->_model->get(array('where'=>array('username'=>$username, 'username !='=>$member_data['username'])))) 
			{
				$vars['error'][] = lang('login_exists');
			}
			
			if (ci()->_model->get(array('where'=>array('email'=>$email, 'email !='=>$member_data['email'])))) 
			{
				$vars['error'][] = lang('email_exists');
			}
			
			if ( ! @$vars['error']) 
			{
				$ins['username'] = 	$username;
				$ins['name'] = 	$name;
				$ins['group_id'] = 	$group_id;
				if($password)
				$ins['password'] = md5( $password );
				$ins['email'] = $email;
				$ins['wholesale_enabled'] = @$wholesale_enabled;
				$this->_model->save($ins, array('member_id'=>$member_id));
				notice(lang('member_updated'));
				redirect('admin/members/'.$vars['action'].'?member_id='.$member_id);
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('member_id'=>($member_id ? $member_id : ci()->input->get('member_id', true))))));
		if( ! @$vars['member_id'])
		{
			notice(lang('incorrect_member'), true);
			redirect('admin/members/members_list');
		}
		$vars['groups'] = ci()->groups_model->get_groups();
		ci()->load->view($this->_view_base.'member_form',$vars);
	}
		
	public function add_member()
	{
		ci()->page_title(lang('add_member'), lang('add_member'));

		$vars['action'] = 'add_member';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			if ( ! ci()->input->post('password') or ! ci()->input->post('email') or ! ci()->input->post('username') or ! ci()->input->post('confirm_password')) 
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
			
			if ( ! @$vars['error']) 
			{
				$ins['username'] = 	$username;
				$ins['name'] = 	$name;
				$ins['group_id'] = 	$group_id;
				$ins['password'] = md5( $password );
				$ins['email'] = $email;
				$ins['wholesale_enabled'] = @$wholesale_enabled;
				$this->_model->insert($ins);
				notice(lang('member_created'));
				redirect('admin/members/members_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars['groups'] = ci()->groups_model->get_groups();
		ci()->load->view($this->_view_base.'member_form',$vars);
	}
	
	public function bulk_remove_member()
	{
		extract(ci()->input->get());
		if (isset($bulk) and count($bulk))
		{
			foreach ($bulk as $member_id)
			{
				$this->_remove_member($member_id);
			}
			ci()->output->print_js('notice.show("'.lang('member_deleted').'")');
			
		}
		exit;
	}
	
	public function remove_member()
	{
		if ($member_id=ci()->input->get('member_id')) 
		{
			$this->_remove_member($member_id);
			ci()->output->print_js('notice.show("'.lang('member_deleted').'")');
			exit;
		}
	}
	
	private  function _remove_member($member_id)
	{
		if ($member_id) 
		{
			ci()->_model->delete(array('member_id'=>$member_id, 'admin !='=>'y'));
		}
	}
	
	public function edit_personal_info()
	{
		$userdata = ci()->session->userdata('admin');
		$this->edit_member($userdata['member_id'], 'edit_personal_info');
	}
	
	public function ban_member()
	{
		// check
		$vars = ci()->_model->get_row(array('where'=>array('member_id'=>ci()->input->get('member_id', true))));
		if( ! @$vars['member_id'])
		{
			ci()->output->print_js('notice.show("'.lang('incorrect_member').'", "error")');
			exit;
		}
		
		extract(ci()->input->get(NULL, true));
		
		$ins['ban'] = $ban;
		$this->_model->save($ins, array('member_id'=>$member_id));
		
		ci()->output->print_js('notice.show("'.lang('member_banned').'")');
		ci()->output->print_js("\$('#members_table').dataTable().fnDraw();");
		exit;
	}	
	
	private function _datatables_js($ajax_method='index', $non_sortable_columns, $default_sort, $perpage=10)
	{
		$col_defs = array(
			array('bSortable' => false, 'aTargets' => $non_sortable_columns),
		);		
		$js = '
			oTable = $("#members_table").dataTable({
				"sPaginationType": "full_numbers",
				"bLengthChange": false,
				"aaSorting": '.ci()->javascript->generate_json(array($default_sort), true).',
				"bFilter": false,
				"bAutoWidth": false,
				"iDisplayLength": '.$perpage.',
				"aoColumnDefs" : '.ci()->javascript->generate_json($col_defs, true).',
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "'.html_entity_decode($ajax_method).'",
				"fnServerData": function (sSource, aoData, fnCallback) {
					var extraData = $("#form1").serializeArray();
					for (var i = 0; i < extraData.length; i++) {
						if (extraData[i].name == "perpage") {
							$("#members_table").dataTable().fnSettings()._iDisplayLength = parseInt(extraData[i].value);
						}
						aoData.push(extraData[i]);
					}
					
					$.getJSON(sSource, aoData, fnCallback);
				},
				"fnDrawCallback": function( oSettings ) {
		        },
				"oLanguage": {
					"sProcessing": "'.lang('dataTables_processing').'",
					"sZeroRecords": "'.lang('no_entries_matching_that_criteria').'",
					"sInfo": "'.lang('dataTables_info').'",
					"sInfoEmpty": "'.lang('dataTables_info_empty').'",
					"sInfoFiltered": "'.lang('dataTables_info_filtered').'",
					"oPaginate": {
						"sFirst": "<img src=\"/images/pagination_first_button.gif\" width=\"13\" height=\"13\" alt=\"&lt; &lt;\" />",
						"sPrevious": "<img src=\"/images/pagination_prev_button.gif\" width=\"13\" height=\"13\" alt=\"&lt;\" />",
						"sNext": "<img src=\"/images/pagination_next_button.gif\" width=\"13\" height=\"13\" alt=\"&gt;\" />",
						"sLast": "<img src=\"/images/pagination_last_button.gif\" width=\"13\" height=\"13\" alt=\"&gt; &gt;\" />"
					}
				},
				"fnRowCallback": function(nRow,aData,iDisplayIndex) {
                             $(nRow).addClass("collapse");
                             return nRow;
                }
			});
			oSettings = oTable.fnSettings();
			oSettings.oClasses.sSortAsc = "headerSortUp";
			oSettings.oClasses.sSortDesc = "headerSortDown";
		';

		ci()->javascript->output($js);
	} 	
}
/* End of file Members.php */
/* Location: ./application/controllers/admin/Members.php */