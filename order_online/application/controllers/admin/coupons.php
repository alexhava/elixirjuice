<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupons {
	var $_view_base;
	var $models = 'admin/coupons_model';
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
		
		ci()->load->model('admin/members_model');
		ci()->load->helper(array('form', 'html'));
		ci()->load->library(array('table', 'javascript'));
		ci()->load->vars($vars);	
	}

	public function index()
	{
		redirect($this->_view_base.'coupons_list');
	}	
	
	public function coupons_list()
	{
		ci()->page_title(lang('coupons_list'),lang('coupons_list'));
    	$options = array(
			'order_by' 	=> 'coupon_code',
			'direction' => 'ASC',
			'limit' => 10,
			'offset' => '0',
			'iTotalRecords' => '0',
			'iTotalDisplayRecords' => '0',
		);

		$col_map = array('coupon_id', 'coupons.member_id', 'use_type', 'coupon_code', 'valid_to', 'amount', 'used');
		$members = ci()->members_model->get_members();

		/* Ordering */
		if (($order_by = ci()->input->get('iSortCol_0')) !== FALSE)
		{

			if (isset($col_map[$order_by]))
			{
				$col = $col_map[$order_by];
				$options['order_by'] = $col;
				$options['dir'] = ci()->input->get('sSortDir_0');
			}
			
			$options['limit'] = ci()->input->get_post('perpage') ? (int)ci()->input->get_post('perpage') : self::DATATABLES_PAGE_SIZE;
			$options['offset'] = (int)ci()->input->get_post('iDisplayStart');
			$vars['sEcho'] = (int)ci()->input->get_post('sEcho');
			$get = ci()->input->get_post('keyword');
			if($gr = ci()->input->get_post('member_id'))
				$options['where']['coupons.member_id'] = $gr;
			if($gr = ci()->input->get_post('used'))
				$options['where']['used'] = $gr;
			if( ! ci()->input->get_post('exact_match'))
				$options['custom'] = "(coupon_code like '%$get%')";
			else 
				$options['custom'] = "(coupon_code = '$get')";
			$ajax=TRUE;
		}	
		$vars['default_sort'] = array(2, 'asc');
		$vars['non_sortable_columns'] = array(6,7,8);
		$vars['perpage_select_options'] = array( '10' => '10 '.lang('results'), '25' => '25 '.lang('results'), '50' => '50 '.lang('results'), '75' => '75 '.lang('results'), '100' => '100 '.lang('results'), '150' => '150 '.lang('results'));		
		$vars['aaData'] = array();
		$coupons = ci()->_model->get($options);
		$options['count'] = TRUE;
		$vars['iTotalRecords'] = $vars['iTotalDisplayRecords'] = ci()->_model->get($options);		
		$vars['perpage'] = $options['limit'];
		$c = 0;
		foreach ($coupons as $v) 
		{
			$vars['aaData'][] = array(
				$v['coupon_id'],
				"<a href='{$this->_view_base}edit_coupon?coupon_id={$v['coupon_id']}'> {$v['coupon_code']} </a>",
				$v['use_type'],
				$v['valid_to'],
				$v['amount'],
				$v['used'],
				'<a href="'.$this->_view_base.'edit_coupon?coupon_id='.$v['coupon_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove_coupon?coupon_id='.$v['coupon_id'].'" class="delete">'.lang('delete').'</a>',
				form_checkbox('bulk[]', $v['coupon_id'], '', 'class="bulk"')
			);
		}
		$vars['members'] = array(''=> 'All Members') + $members;
		if ( ! @$ajax)
		{
			$js = $this->_datatables_js($this->_view_base.'coupons_list', $vars['non_sortable_columns'], $vars['default_sort'], $options['limit']);
			$vars['js'] = $js;
			$vars['data'] = $coupons;
		}
		else
		{
			ci()->output->send_ajax_response($vars);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/coupons.js', '', true));
		ci()->javascript->compile();
		ci()->load->view($this->_view_base.'coupons', $vars);
	}
	
	public function edit_coupon($coupon_id='', $action='edit_coupon')
{
		ci()->page_title(lang('edit_coupon'), lang('edit_coupon'));

		$vars['action'] = 'edit_coupon';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$post = ci()->input->post(NULL, true);
			
			$coupon_data = ci()->_model->get_row(array('where'=>array('coupon_id'=>$coupon_id)));
			if (  ! ci()->input->post('valid_to')
		  	   or ! ci()->input->post('coupon_code')
				 ) 
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			
			if ( ! @$vars['error']) 
			{
				$this->_model->save($post);
				notice(lang('coupon_updated'));
				redirect('admin/coupons/'.$vars['action'].'?coupon_id='.$coupon_id);
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('coupon_id'=>($coupon_id ? $coupon_id : ci()->input->get('coupon_id', true))))));
		if( ! @$vars['coupon_id'])
		{
			notice(lang('incorrect_coupon'), true);
			redirect('admin/coupons/coupons_list');
		}
		$vars['members'] = ci()->members_model->get_members();
		ci()->load->view($this->_view_base.'coupon_form',$vars);
	}
		
	public function add_coupon()
	{
		ci()->page_title(lang('add_coupon'), lang('add_coupon'));


		$vars['action'] = 'add_coupon';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$post = ci()->input->post(NULL, true);
			
			$coupon_data = ci()->_model->get_row(array('where'=>array('coupon_id'=>$coupon_id)));
			if (! ci()->input->post('valid_to')
		  	  or ! ci()->input->post('coupon_code')
				 ) 
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			
			if ( ! @$vars['error']) 
			{
				$this->_model->save($post);
				notice(lang('coupon_updated'));
				redirect('admin/coupons/'.$vars['action'].'?coupon_id='.$coupon_id);
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		
		$vars['members'] = ci()->members_model->get_members();
		ci()->load->view($this->_view_base.'coupon_form',$vars);
	}
	
	public function bulk_remove_coupon()
	{
		extract(ci()->input->get());
		if (isset($bulk) and count($bulk))
		{
			foreach ($bulk as $coupon_id)
			{
				$this->_remove_coupon($coupon_id);
			}
			ci()->output->print_js('notice.show("'.lang('coupon_deleted').'")');
			
		}
		exit;
	}
	
	public function remove_coupon()
	{
		if ($coupon_id=ci()->input->get('coupon_id')) 
		{
			$this->_remove_coupon($coupon_id);
			ci()->output->print_js('notice.show("'.lang('coupon_deleted').'")');
			exit;
		}
	}
	
	private  function _remove_coupon($coupon_id)
	{
		if ($coupon_id) 
		{
			ci()->_model->delete(array('coupon_id'=>$coupon_id));
		}
	}
	
	private function _datatables_js($ajax_method='index', $non_sortable_columns, $default_sort, $perpage=10)
	{
		$col_defs = array(
			array('bSortable' => false, 'aTargets' => $non_sortable_columns),
		);		
		$js = '
			oTable = $("#coupons_table").dataTable({
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
							$("#coupons_table").dataTable().fnSettings()._iDisplayLength = parseInt(extraData[i].value);
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
/* End of file Coupons.php */
/* Location: ./application/controllers/admin/Coupons.php */