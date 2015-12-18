<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders {
	var $_view_base;
	var $models = 'admin/orders_model';
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
		ci()->load->model(array('admin/categories_model', 'admin/order_history_model', 'admin/stores_model'));
		
		ci()->lang->load("admin/admin");
		ci()->load->vars($vars);	
	}

	public function index()
	{
		redirect($this->_view_base.'orders_list');
	}	
	
	public function orders_list()
	{
		ci()->load->model('admin/categories_model');
		ci()->page_title(lang('orders_list'),lang('orders_list'));
		$session = ci()->session->userdata('user');
    	$options = array(
			'where' 	=> array('member_id'=>$session['member_id']),
			'order_by' 	=> 'order_date',
			'direction' => 'DESC',
			'limit' => 10,
			'offset' => '0',
			'iTotalRecords' => '0',
			'iTotalDisplayRecords' => '0',
		);

		$col_map = array('order_id', 'order_date', 'billing_name', 'order_total', 'order_status');
		$statuses = $this->_model->get_statuses();

		/* Ordering */
		if (($order_by = ci()->input->get('iSortCol_0')) !== FALSE)
		{
			if (isset($col_map[$order_by]))
			{
				$options['order_by'] = $col_map[$order_by];
				$options['dir'] = ci()->input->get('sSortDir_0');
			}
			
			$options['limit'] = ci()->input->get_post('perpage') ? (int)ci()->input->get_post('perpage') : self::DATATABLES_PAGE_SIZE;
			$options['offset'] = (int)ci()->input->get_post('iDisplayStart');
			
			$vars['sEcho'] = (int)ci()->input->get_post('sEcho');
			
			if($get = ci()->input->get_post('status'))
			{
				$options['where']['order_status'] = $get;
			}	
					
			if($get = ci()->input->get_post('date1'))
			{
				$time  = strtotime($get." 00:00:00");
				$options['where']['order_date >='] = $time;
			}
					
			if($get = ci()->input->get_post('date2'))
			{
				$time  = strtotime($get.' 23:59:59');
				$options['where']['order_date <='] = $time;
			}
			
			if($get = ci()->input->get_post('order_id'))
				$options['where']['order_id'] = $get;
				
			$ajax=TRUE;
		}	
		
		$vars['default_sort'] = array(1, 'desc');
		$vars['non_sortable_columns'] = array(2,4,5);
		$vars['perpage_select_options'] = array( '10' => '10 '.lang('results'), '25' => '25 '.lang('results'), '50' => '50 '.lang('results'), '75' => '75 '.lang('results'), '100' => '100 '.lang('results'), '150' => '150 '.lang('results'));		
		$vars['aaData'] = array();
		$vars['statuses'] = $statuses;
		$orders = $this->_model->get($options);
		$options['count'] = TRUE;
		$vars['iTotalRecords'] = $vars['iTotalDisplayRecords'] = ci()->_model->get($options);		
		$vars['perpage'] = $options['limit'];
		$c = 0;
		foreach ($orders as $v) 
		{
			$vars['aaData'][] = array(
				"<a href='{$this->_view_base}view_order?order_id={$v['order_id']}'> {$v['order_id']} </a>",
				date('m/d/Y H:i', $v['order_date']),
				$v['items_names'],
				$v['order_total'],
				$v['shipping_name'],
				'<a href="'.$this->_view_base.'view_order?order_id='.$v['order_id'].'">'.lang('view_order').'</a>',
			);
		}
		
		if ( ! @$ajax)
		{
			$js = $this->_datatables_js($this->_view_base.'orders_list', $vars['non_sortable_columns'], $vars['default_sort'], $options['limit']);
			$vars['js'] = $js;
			$vars['data'] = $orders;
		}
		else
		{
			ci()->output->send_ajax_response($vars);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/orders.js', '', true));
		ci()->javascript->compile();
		ci()->load->view($this->_view_base.'orders', $vars);
	}
	
	public function view_order()
{
		ci()->page_title(lang('view_order'), lang('view_order'));
		$session = ci()->session->userdata('user');

		if($hash=ci()->input->get('hash'))
		{
			$vars = ci()->_model->get_row(array('where'=>array('order_hash'=>$hash)));
		}
		else {
			$vars = ci()->_model->get_row(array('where'=>array('member_id'=>$session['member_id'],'order_id'=>ci()->input->get('order_id', true))));
		}
		
		if( ! @$vars['order_id'])
		{
			notice(lang('incorrect_order'), true);
			redirect('users/orders/orders_list');
		}
		$vars['order_items'] = ci()->_model->get(array('where'=>array('order_id'=>$vars['order_id'])), 'order_items');			$vars['stores'] = ci()->stores_model->get_stores($vars['store_state_id']);		
		$vars['order_history'] = ci()->order_history_model->get(array('where'=>array('order_id'=>$vars['order_id']), 'order_by'=>'change_date', 'dir'=>'desc'));			
		ci()->load->view($this->_view_base.'view_order',$vars);
	}
	
	public function update_order()
	{
		$allowed_fields = array('notes','order_id','alergy','store_id','client_allergies');
		$post = ci()->input->post(NULL, true);
		$session = ci()->session->userdata('user');
		$order_data = $this->_model->get_row(array('order_id'=>$post['order_id'], 'member_id'=>$session['member_id']));
		if($order_data['changeable'] == 'y')
		{
			$post = array_intersect_key($post, array_flip($allowed_fields));	
			$this->_model->save($post,array('order_id'=>$post['order_id'], 'member_id'=>$session['member_id']));
			notice(lang('order_updated'));
		}
		else 
			notice(lang('order_not_changeable'), true);
		redirect($this->_view_base.'view_order?order_id='.$post['order_id']);
	}	
		
	private function _datatables_js($ajax_method='index', $non_sortable_columns, $default_sort, $perpage=10)
	{
		$col_defs = array(
			array('bSortable' => false, 'aTargets' => $non_sortable_columns),
		);		
		$js = '
			oTable = $("#orders_table").dataTable({
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
							$("#orders_table").dataTable().fnSettings()._iDisplayLength = parseInt(extraData[i].value);
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
/* End of file Orders.php */
/* Location: ./application/controllers/admin/Orders.php */