<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products {
	var $_view_base;
	var $models = array('admin/products_model', 'admin/related_products_model', 'admin/shipping_methods_model', 'admin/shipping_schedule_model');
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
		ci()->load->model('admin/categories_model');
		ci()->db->query('update ej_products set product_order=product_id where product_order=0');
		$vars['shipping_types'] = ci()->shipping_methods_model->get();
		$vars['shipping_schedules'] = ci()->shipping_schedule_model->format('name');
		ci()->load->vars($vars);	
	}

	public function index()
	{
		redirect($this->_view_base.'products_list');
	}	
	
	public function products_list()
	{
		ci()->load->model('admin/categories_model');
		ci()->page_title(lang('products_list'),lang('products_list'));
    	$options = array(
			'order_by' 	=> 'product_order',
			'direction' => 'ASC',
			'limit' => 10,
			'offset' => '0',
			'iTotalRecords' => '0',
			'iTotalDisplayRecords' => '0',
		);

		$col_map = array('product_order', 'product_id', 'product_title', 'cat_id', 'regular_price');
		$categories = ci()->categories_model->get_sorted_cats_select();

		/* Ordering */
//		if (1==1 or ($order_by = ci()->input->get('iSortCol_0')) !== FALSE)
		if (($order_by = ci()->input->get('iSortCol_0')) !== FALSE)
		{
			if (isset($col_map[$order_by]))
			{
				$options['order_by'] = $col_map[$order_by];
				$options['dir'] = ci()->input->get('sSortDir_0');
				if($col_map[$order_by] == 'cat_id')
				{
					$options['join']['table'] = 'categories c';
					$options['join']['cond'] = ' products.cat_id=c.cat_id';
					$options['join']['type'] = 'left';
					$options['order_by'] = 'cat_name';
				}				
			}
			
			$options['limit'] = ci()->input->get_post('perpage') ? (int)ci()->input->get_post('perpage') : 10;
			$options['offset'] = (int)ci()->input->get_post('iDisplayStart');
			
			$vars['sEcho'] = (int)ci()->input->get_post('sEcho');
			$get = ci()->input->get_post('keyword');
			
			if($gr = ci()->input->get_post('cat_id'))
			{
				$options['where']['products.cat_id'] = $gr;
			}
			if( ! ci()->input->get_post('exact_match'))
				$options['custom'] = "(product_title like '%$get%' or product_description like '%$get%' or product_ingredients like '%$get%')";
			else 
				$options['custom'] = "(product_title = '$get' or product_description = '$get' or product_ingredients = '$get')";
				
			$ajax=TRUE;
		}	
		
		$vars['default_sort'] = array(0, 'asc');
		$vars['non_sortable_columns'] = array(5,6,7);
		$vars['perpage_select_options'] = array( '10' => '10 '.lang('results'), '25' => '25 '.lang('results'), '50' => '50 '.lang('results'), '75' => '75 '.lang('results'), '100' => '100 '.lang('results'), '150' => '150 '.lang('results'));		
		$vars['aaData'] = array();
		$products = ci()->_model->get($options);
		$options['count'] = TRUE;
		$vars['iTotalRecords'] = $vars['iTotalDisplayRecords'] = ci()->_model->get($options);		
		$vars['perpage'] = $options['limit'];
		$c = 0;
		foreach ($products as $v) 
		{
			$vars['aaData'][] = array(
				'<span class="ui-icon ui-icon-arrowthick-2-n-s" trid="s_'.$v['product_id'].'_'.$v['product_order'].'"></span>'.
				form_hidden("product_order[{$v['product_id']}]", $v['product_order']),
				$v['product_id'],
				"<a href='{$this->_view_base}edit_product?product_id={$v['product_id']}'> {$v['product_title']} </a>",
				@$categories[$v['cat_id']],
				$v['regular_price'],
				'<a href="'.$this->_view_base.'edit_product?product_id='.$v['product_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove_product?product_id='.$v['product_id'].'" class="delete">'.lang('delete').'</a>',
				form_checkbox('bulk[]', $v['product_id'], '', 'class="bulk"')
			);
		}
		$vars['categories'] = ci()->categories_model->get_sorted_cats_select();
		if ( ! @$ajax)
		{
			$js = $this->_datatables_js($this->_view_base.'products_list', $vars['non_sortable_columns'], $vars['default_sort'], $options['limit']);
			$vars['js'] = $js;
			$vars['data'] = $products;
		}
		else
		{
			ci()->output->send_ajax_response($vars);
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/products.js', '', true));
		ci()->javascript->compile();
		ci()->load->view($this->_view_base.'products', $vars);
	}
	
	public function change_order()
	{
//		file_put_contents('order', var_export($_POST, true));
//		
//		return ;
		foreach ($_POST['product_order'] as $id => $order) 
		{
			$where['product_id'] = $id;
			$upd['product_order'] = $order;
			$this->_model->save($upd, $where);
			ci()->db->query('update ej_products set product_order=product_id where product_order=0');
		}
		ob_start();
		ci()->output->print_js('notice.show("'.lang('order_changed').'")');
		ob_end_flush();
		exit;
	}	
	
	public function edit_product()
	{
		ci()->page_title(lang('edit_product'), lang('edit_product'));
		$vars['products'] = ci()->_model->format('product_title', array('order_by' => 'product_title'));
		$vars['action'] = 'edit_product';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post());
			$post = ci()->input->post();
			
			$product_data = ci()->_model->get_row(array('where'=>array('product_id'=>$product_id)));
			if ( ! ci()->input->post('product_title') ) 
			{
				$vars['error'][] = lang('product_title_empty');
			}

			if(! @$vars['error'] and @$_FILES['image']['error'] == 0)
			{
				$post['image'] =	$filename = $_FILES['image']['name'];
				$dest_file = DOCUMENT_ROOT . 'images/upload/'.$filename;
//				myd($dest_file);
				if( ! move_uploaded_file($_FILES['image']['tmp_name'], $dest_file) )
				{
					$vars['error'][] = lang('image_not_uploaded');
				}
			}
			
			if ( ! @$vars['error']) 
			{
				$this->_model->save($post);
				// save related products
				if(isset($post['related_products']))
				ci()->related_products_model->save(@$post['related_products'], $product_id);
				//
				if(@count($shipping_areas))
				{
					$this->_model->delete(array('product_id'=>$product_id), 'products_shipping');
					foreach ($shipping_areas as $area) 
					{
						$ins['state'] = $area;
						$ins['product_id'] = $product_id;
						ci()->query->save($ins, '', 'products_shipping');
					}
				}
				notice(lang('product_updated'));
				redirect('admin/products/products_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars = array_merge($vars, ci()->_model->get_row(array('where'=>array('product_id'=>ci()->input->get('product_id', true)))));

		if( ! @$vars['product_id'])
		{
			notice(lang('incorrect_product'), true);
			redirect('admin/products/products_list');
		}
		$vars['categories'] = ci()->categories_model->get_sorted_cats_select();
		$vars['product_shipping_areas'] = ci()->_model->get_product_shipping_areas($vars['product_id']);
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/products.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'product_form',$vars);
	}
		
	public function add_product()
	{
		ci()->page_title(lang('add_product'), lang('add_product'));

		$vars['action'] = 'add_product';
		$vars['categories'] = ci()->categories_model->get_sorted_cats_select();
		$vars['products'] = ci()->_model->format('product_title', array('order_by' => 'product_title'));
		
		if( ! empty($_POST))
		{
			
			extract(ci()->input->post());
			$post = ci()->input->post();
			if ( ! ci()->input->post('product_title') ) 
			{
				$vars['error'][] = lang('product_title_empty');
			}

			if(! @$vars['error'] and @$_FILES['image']['error'] == 0)
			{
				$post['image'] =	$filename = $_FILES['image']['name'];
				$dest_file = DOCUMENT_ROOT . 'images/upload/'.$filename;
				if( ! move_uploaded_file($_FILES['image']['tmp_name'], $dest_file) )
				{
					$vars['error'][] = lang('image_not_uploaded');
				}
			}
			
			if ( ! @$vars['error']) 
			{
				$product_id = $this->_model->save($post);
				// save related products
				if(isset($post['related_products']))
				ci()->related_products_model->save(@$post['related_products'], $product_id);
								
				if(@count($shipping_areas))
				{
					foreach ($shipping_areas as $area) 
					{
						$ins['state'] = $area;
						$ins['product_id'] = $product_id;
						ci()->query->save($ins, '', 'products_shipping');
					}
				}				
				notice(lang('product_created'));
				redirect('admin/products/products_list');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars['categories'] = ci()->categories_model->get_sorted_cats_select();
			ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/products.js', '', true));
		ci()->javascript->compile();		
		ci()->load->view($this->_view_base.'product_form', $vars);
	}
	
	public function bulk_remove_product()
	{
		extract(ci()->input->get());
		if (isset($bulk) and count($bulk))
		{
			foreach ($bulk as $product_id)
			{
				$this->_remove_product($product_id);
			}
			ci()->output->print_js('notice.show("'.lang('product_deleted').'")');
			
		}
		exit;
	}
	
	public function delete_image()
	{
		if ($product_id=ci()->input->get('product_id')) 
		{
			$product = ci()->_model->get_row(array('product_id' => $product_id));
			$dest_file = DOCUMENT_ROOT . 'images/upload/'.$product['image'];
			unlink($dest_file);
			ci()->_model->save(array('image' => ''), array('product_id' => $product_id));
			ci()->output->print_js('$(".delete-image").closest("td").find("img").remove();notice.show("'.lang('product_deleted').'")');
			exit;
		}
	}
	
	public function remove_product()
	{
		if ($product_id=ci()->input->get('product_id')) 
		{
			$this->_remove_product($product_id);
			ci()->output->print_js('notice.show("'.lang('product_deleted').'")');
			exit;
		}
	}
	
	private  function _remove_product($product_id)
	{
		if ($product_id) 
		{
			ci()->_model->delete(array('product_id'=>$product_id));
		}
	}
	
	private function _datatables_js($ajax_method='index', $non_sortable_columns, $default_sort, $perpage=10)
	{
		$col_defs = array(
			array('bSortable' => false, 'aTargets' => $non_sortable_columns),
		);		
		$js = '
			oTable = $("#products_table").dataTable({
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
							$("#products_table").dataTable().fnSettings()._iDisplayLength = parseInt(extraData[i].value);
						}
						aoData.push(extraData[i]);
					}
					
					$.getJSON(sSource, aoData, fnCallback);
				},
				"fnDrawCallback": function( oSettings ) {
					 makeMainTableSortable();
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
/* End of file Products.php */
/* Location: ./application/controllers/admin/Products.php */