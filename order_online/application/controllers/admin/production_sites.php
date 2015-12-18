<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_sites {
	const DATATABLES_PAGE_SIZE=25;
	var $_view_base;
	var $models = 'admin/production_sites_model';
	public function __construct()
	{
		$this->_view_base = '/'.ci()->current_dir.ci()->current_class.'/';
		
		// default global view variables
		$vars = array(
			'table_template' => array(
				'table_open'		=> '<table class="main_table production_sites_table" border="0" cellspacing="0" cellpadding="0">',
				'row_start'			=> '<tr class="even">',
				'row_alt_start'		=> '<tr class="odd">'
			),
		);	
		
		$vars['product_types'] = ci()->_model->format_production_product_types('production_product_type_name',array('order_by'=>'production_product_type_name'));		
		$vars['production_groups'] = ci()->_model->format_production_groups('group_name');		
		$vars['products'] = ci()->_model->format_products();		
		ci()->load->helper(array('form', 'html'));
		ci()->load->library(array('table', 'javascript'));
		ci()->load->vars($vars);	
	}

	public function index()
	{
		ci()->add_js_pack('jquery.dataTables');

		ci()->page_title(lang('production_sites_list'),lang('production_sites_list'));
    	$options = array(
			'order_by' 	=> '',
			'direction' => 'ASC',
			'limit' => 10,
			'offset' => '0',
			'iTotalRecords' => '0',
			'iTotalDisplayRecords' => '0',
			'join'=>array(
				'cond'=>'pg.production_group_id=production_sites.production_group_id',
				'table'=>'production_groups pg',
				'type'=>'left'
			)			
		);
		
		$product_types = ci()->_model->format_production_product_types('production_product_type_name',array('order_by'=>'production_product_type_name'));		
		// colmap
		$col_map = array('production_site_id', 'name', 'group_name');

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
//			$options['custom'] = "(field = '$get')";
			$ajax=TRUE;
		}	
		$vars['default_sort'] = array(1, 'asc');
		$vars['non_sortable_columns'] = array(4,5,6,7);
		$vars['perpage_select_options'] = array( '10' => '10 '.lang('results'), '25' => '25 '.lang('results'), '50' => '50 '.lang('results'), '75' => '75 '.lang('results'), '100' => '100 '.lang('results'), '150' => '150 '.lang('results'));		
		$vars['aaData'] = array();
		$production_sites = ci()->_model->get($options);
		$options['count'] = TRUE;
		$vars['iTotalRecords'] = $vars['iTotalDisplayRecords'] = ci()->_model->get($options);		
		$vars['perpage'] = $options['limit'];
		$c = 0;
		foreach ($production_sites as $v) 
		{
			$vars['aaData'][] = array(
				$v['production_site_id'],
				"<a href='{$this->_view_base}edit?production_site_id={$v['production_site_id']}'> {$v['name']} </a>",
				$v['address'],
				$v['group_name'],
				ci()->_model->format_produced_products($v['production_site_id']),				
				'<a href="'.$this->_view_base.'edit?production_site_id='.$v['production_site_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove?production_site_id='.$v['production_site_id'].'" class="delete">'.lang('delete').'</a>',
				form_checkbox('bulk[]', $v['production_site_id'], '', 'class="bulk"')
			);
		}

		if ( ! @$ajax)
		{
			$js = $this->_datatables_js($this->_view_base, $vars['non_sortable_columns'], $vars['default_sort'], $options['limit']);
			$vars['js'] = $js;
			$vars['data'] = $production_sites;
		}
		else
		{
			ci()->output->send_ajax_response($vars);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/production_sites.js', '', true));
		ci()->load->view($this->_view_base.'production_sites',$vars);
	}
	
	private function _insert_produced_products($post)
	{
		if(@$post['production_site_id'])
		ci()->_model->delete(array('production_site_id'=>$post['production_site_id']), 'production_sites_produced_products');
		foreach ($post['products'] as $product)
		{
			$ins['production_site_id'] = $post['production_site_id'];
			$ins['production_product_id'] = $product;
			
			ci()->_model->save($ins,'','production_sites_produced_products');
		}
	}	
	
	public function edit()
{
		ci()->page_title(lang('edit_production_site'), lang('edit_production_site'));

		$vars['action'] = 'edit';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$post = ci()->input->post(NULL, true);
			
			if ( ! @$vars['error']) 
			{
				$this->_model->save($post);
				$this->_insert_produced_products($post);
				notice(lang('production_site_updated'));
				redirect('admin/production_sites');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('production_site_id'=>(ci()->input->get('production_site_id', true))))));
		if( ! @$vars['production_site_id'])
		{
			notice(lang('incorrect_production_site'), true);
			redirect('admin/production_sites');
		}
		$vars['produced_products'] = ci()->_model->format_production_sites_produced_products('production_product_id', array('production_site_id'=>$vars['production_site_id']));

		ci()->load->view($this->_view_base.'production_site_form',$vars);
	}
		
	public function add()
	{
		ci()->page_title(lang('add_production_site'), lang('add_production_site'));


		$vars['action'] = 'add';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$post = ci()->input->post(NULL, true);
			
			if ( ! @$vars['error']) 
			{
				$post['production_site_id'] = $this->_model->save($post);
				$this->_insert_produced_products($post);
				notice(lang('production_site_added'));
				redirect('admin/production_sites');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		
		ci()->load->view($this->_view_base.'production_site_form',$vars);
	}
	
	public function remove()
	{
		if ($production_site_id=ci()->input->get('production_site_id')) 
		{
			$this->_remove($production_site_id);
			ci()->output->print_js('notice.show("'.lang('production_site_deleted').'")');
			exit;
		}
	}
	
	public function bulk_remove()
	{
		$production_site_ids=ci()->input->post('bulk');
		if (is_array($production_site_ids)) 
		{
			foreach ($production_site_ids as $production_site_id) 
			{
				$this->_remove($production_site_id);
				ci()->output->print_js('notice.show("'. $production_site_id.' - '.lang('production_site_deleted').'")');				
			}
		}
		exit;
	}	
	
	private  function _remove($production_site_id)
	{
		if ($production_site_id) 
		{
			ci()->_model->delete(array('production_site_id'=>$production_site_id));
			ci()->_model->delete(array('production_site_id'=>$production_site_id), 'production_sites_produced_products');
		}
	}
	
	private function _datatables_js($ajax_method='index', $non_sortable_columns, $default_sort, $perpage=10)
	{
		$col_defs = array(
			array('bSortable' => false, 'aTargets' => $non_sortable_columns),
		);		
		$js = '
			oTable = $(".production_sites_table").dataTable({
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
							$(".production_sites_table").dataTable().fnSettings()._iDisplayLength = parseInt(extraData[i].value);
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
/* End of file production_sites.php */
/* Location: ./application/controllers/admin/production_sitesproduction_sites.php */