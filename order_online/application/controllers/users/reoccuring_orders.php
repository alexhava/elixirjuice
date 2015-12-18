<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reoccuring_orders {
	const DATATABLES_PAGE_SIZE=25;
	var $_view_base;
	var $models = 'users/reoccuring_orders_model';
	public function __construct()
	{
		$this->_view_base = '/'.ci()->current_dir.ci()->current_class.'/';
		
		// default global view variables
		$vars = array(
			'table_template' => array(
				'table_open'		=> '<table class="main_table reoccuring_orders_table" border="0" cellspacing="0" cellpadding="0">',
				'row_start'			=> '<tr class="even">',
				'row_alt_start'		=> '<tr class="odd">'
			),
		);	
		ci()->load->helper(array('form', 'html', 'order'));
		ci()->load->library(array('table', 'javascript', 'email'));
		ci()->load->model(array('admin/stores_model', 'admin/order_items_model', 'admin/orders_model', 'admin/taxes_model', 'admin/products_model', 'admin/products_model', 'users/cards_model', 'users/address_book_model', 'users/allergies_model'));

		ci()->load->vars($vars);	
	}

	public function make_order()
	{
		//		if( ! ci()->input->is_cli_request())
		//		exit;
		$options['where']['next_run'] = date("Y-m-d");
		$reoccuring_orders = ci()->_model->get_reoccuring_orders($options);
		foreach ($reoccuring_orders as $k => $v)
		{
			extract($v);
			$total_cnt = 0;
			$order_data['order_subtotal'] = 0;
			foreach ($v['products'] as $k1 => $v1)
			{
				$total_cnt += $v1['qty'];
				$order_data['items'][$k1]['id'] = $v1['product_id'];
				$order_data['items'][$k1]['title'] = $v1['product_title'];
				$order_data['items'][$k1]['regular_price'] = calc_user_price($v1);
				$order_data['items'][$k1]['item_qty'] = $v1['qty'];
				$order_data['items'][$k1]['item_total'] = calc_user_price($v1)*$v1['qty'];
				$order_data['order_subtotal'] += $order_data['items'][$k1]['item_total'];
				$items_names[] = $v1['product_title'];
				$cleanses_dates[$v1['product_title']] = array(strtotime($next_run) => array("cnt"=>$v1['qty']));
			}

			require_once APPPATH . 'libraries/anet/AuthorizeNet.php';
			$transaction = new AuthorizeNetAIM(ci()->system_settings['api_login_id'], ci()->system_settings['transaction_key']);
			$transaction->setSandbox((bool)ci()->system_settings['api_mode']);
			// we add shipping data
			$order_data['order_total'] = $v['total'];

			$transaction->amount = $order_data['order_total'];
			$order_data['order_shipping_tax'] = $this->_getshipping($store_region);
			$order_data['order_tax'] = getdelivery($postcode, $this->_has_delivery($v['delivery_type']), $order_data['items']);;
			$order_data['billing_name'] = $name;
			$order_data['order_date'] = time();
			$order_data['order_email'] = $email;
			$order_data['member_id'] = $member_id;
			$order_data['billing_address1'] = $address1;
			$order_data['billing_region'] = implode(', ', array(ci()->taxes_model->get_state($region), $address3));
			$order_data['state_id'] = $region;
			$order_data['store_state_id'] = $store_region;

			$order_data['billing_phone'] = $phone;
			$order_data['billing_postcode'] = $postcode;
			$order_data['notes'] = $notes;
			$order_data['alergy'] = $allergies ? 'yes' : 'no';
			$order_data['client_allergies'] = @$allergies;
			$order_data['start_date'] = serialize($cleanses_dates);
			$order_data['store_id'] = @$store;
			
			if(@$v['ready_time'])
			$order_data['ready_time'] = date('m/d/Y', strtotime($v['ready_time']));
			$order_data['order_hash'] = md5(rand(333333,7777777).mktime());
			$order_data['items_names'] = implode(',', $items_names);
			$order_data['shipping_name'] = implode(',', $delivery_type);

			list($order_data['first_name'], $order_data['last_name']) = explode(' ',$name);

			$transaction->card_num = $card_num;
			$transaction->exp_date = $card_exp;

			$response = $transaction->authorizeAndCapture();
			if ($response->approved) {
				$order_data['order_paid_date'] = mktime();
				$order_data['order_status'] = 'Paid & Pending Processing';
				$order_data['transaction_id'] = $response->transaction_id;
				if( isset($order_data['order_id']) ) unset($order_data['order_id']);
				$order_data['order_id'] = ci()->orders_model->save($order_data);
				foreach ($products as $product)
				{
					$product['order_id'] = $order_data['order_id'];
					$product['modifiers'] = $v['delivery_type'][$product['product_id']];
					$product['item_qty'] = $product['qty'];
					$product['title'] = $product['product_title'];
					$product['item_total'] = $product['qty']*calc_user_price($product);
					ci()->order_items_model->save($product);
				}
				
				$order_data['stores'] = ci()->stores_model->get_stores($store_region, 'Open');
				send_order_email($order_data);
				// send admin email
				if(isset(ci()->system_settings['admin_email']))
				send_order_email($order_data,ci()->system_settings['admin_email']);
			} else {
				$order_data['transaction_id'] = $response->transaction_id;
				$order_data['notes'] = $response->response_reason_text;
				$order_data['order_status'] = 'fail';
				$order_data['order_id'] = ci()->orders_model->save($order_data);
				list($order_data['first_name'], $order_data['last_name']) = explode(' ',$name);
				foreach ($order_data['items'] as $k => $v)
				{
					$v['order_id'] = $order_data['order_id'];
					ci()->order_items_model->save($v);
				}
			}
			
			$ins['last_run'] = $v['next_run'];
			$ins['next_run'] = $this->_create_next($v);
			ci()->_model->save($ins, array('reoccuring_order_id'=>$v['reoccuring_order_id']));
		}
		exit;
	}
	
	public function index()
	{
		ci()->add_js_pack('jquery.dataTables');

		ci()->page_title(lang('reoccuring_orders_list'),lang('reoccuring_orders_list'));
    	$options = array(
			'direction' => 'desc',
			'limit' => 10,
			'offset' => '0',
			'iTotalRecords' => '0',
			'iTotalDisplayRecords' => '0',
			'where' => array('reoccuring_orders.member_id' => ci()->user_session_data['member_id']),
		);
		
		// colmap
		$col_map = array('reoccuring_order_id','','','last_run','next_run','total');

		/* Ordering */
		if (($order_by = ci()->input->get('iSortCol_0')) !== FALSE)
		{
			if (isset($col_map[$order_by]) and $col_map[$order_by])
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
		$vars['default_sort'] = array(2, 'asc');
		$vars['non_sortable_columns'] = array(1,2,6,7);
		$vars['perpage_select_options'] = array( '10' => '10 '.lang('results'), '25' => '25 '.lang('results'), '50' => '50 '.lang('results'), '75' => '75 '.lang('results'), '100' => '100 '.lang('results'), '150' => '150 '.lang('results'));		
		$vars['aaData'] = array();
		
		$reoccuring_orders = ci()->_model->get_reoccuring_orders($options);
		$options['count'] = TRUE;
		$vars['iTotalRecords'] = $vars['iTotalDisplayRecords'] = ci()->_model->get($options);		
		$vars['perpage'] = $options['limit'];
		$c = 0;
		foreach ($reoccuring_orders as $v) 
		{
			$vars['aaData'][] = array(
				$v['reoccuring_order_id'],
				ci()->_model->prepare_products($v['products']),
				"{$v['name']}, {$v['address1']},".ci()->taxes_model->get_state_by_id($v['region']).", {$v['postcode']}",
				$v['last_run'],
				$v['next_run'],
				$v['total'],
				'<a href="'.$this->_view_base.'edit?reoccuring_order_id='.$v['reoccuring_order_id'].'">'.lang('edit').'</a>',
				'<a href="'.$this->_view_base.'remove?reoccuring_order_id='.$v['reoccuring_order_id'].'" class="delete">'.lang('delete').'</a>',
			);
		}

		if ( ! @$ajax)
		{
			$js = $this->_datatables_js($this->_view_base, $vars['non_sortable_columns'], $vars['default_sort'], $options['limit']);
			$vars['js'] = $js;
			$vars['data'] = $reoccuring_orders;
		}
		else
		{
			ci()->output->send_ajax_response($vars);
		}
				
		
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/reoccuring_orders.js', $vars, true));
		ci()->load->view($this->_view_base.'reoccuring_orders',$vars);
	}

	private function _insert_products_data($post, $reoccuring_order_id)
	{
		ci()->db_lib->delete(array('reoccuring_order_id'=>$reoccuring_order_id), 'reoccuring_order_products');
		foreach ($post['products'] as $key => $id)
		{
			$ins['reoccuring_order_id']	= $reoccuring_order_id;		
			$ins['product_id'] = $id;		
			$ins['qty'] = $post['qty'][$key];
			$ins['delivery_type'] = $post['delivery_type'][$id];
			
			ci()->db_lib->insert('reoccuring_order_products', $ins);		
		}
	}
	
	private function _has_delivery2($delivery_type)
	{
		$has = 0;
		if (is_array($delivery_type)) 
		{
			foreach ($delivery_type as $k => $v) 
			{
				if ($v['delivery_type'] == 'deliver') 
				{
					$has++;
				}
			}
		}
		
		return $has;
	}
	
	private function _has_delivery($delivery_type)
	{
		$has = 0;
		if (is_array($delivery_type)) 
		{
			foreach ($delivery_type as $k => $v) 
			{
				if ($v == 'deliver') 
				{
					$has++;
				}
			}
		}
		
		return $has;
	}
	
	private function _create_next($post)
	{
		$days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
		switch ($post['period']) {
			case 'd':
				$date_str = '+1 Days';
				break;
			case 'w':
				$date_str = "Next {$days[$post['week_day']]}";
				break;
		
			default:
				break;
		}

		return date("Y-m-d", strtotime($date_str));		
	}
	private function _syntonize_insert_data($post)
	{
		$post['next_run'] = $this->_create_next($post);
				

		// total
		$items_total = $this->get_total($post['products'],$post['qty'], true);
		$order_shipping_tax = $this->_getshipping($post['store_region']);
		$address_data = ci()->address_book_model->get_by_id($post['address_id']);
		$order_tax = getdelivery($address_data['postcode'],$this->_has_delivery($post['delivery_type']),$post['products']);
		$items_total += $order_shipping_tax + $order_tax;
		
		$post['total'] = $items_total;

		//
		if(isset($post['ready_time']))
		$post['ready_time'] = array_shift($post['ready_time']);
		$post['allergies'] = @$post['allergies'] ? @implode(',', @$post['allergies']) : ' ';
		
		//
		$post['member_id'] = ci()->user_session_data['member_id'];
		
		//
		return $post;
	}
	
	private function _syntonize_order_data($post)
	{
		// make items
		foreach ($post['products'] as $id) 
		{
			$options['where']['product_id'] = $id;
			$product = ci()->products_model->get_row($options);	
			$post['items'][$id]['id'] = $id;		
			$post['items'][$id]['title'] = $product['product_title'];		
		}
		
		//
		$card_data = $this->cards_model->cards_get_by_card_id($post['card_id']);
		$post['card_number'] = $card_data['card_num'];
//		$exp = explode('card_exp')
		$post['card_number'] = $card_data['card_num'];
		if( ! $card_number)
			$error[] = 'Please provide your card number.';
		if( ! $exp_year and ! $exp_month)
			$error[] = 'Please provide your card\'s expiry date.';
		if( ! $first_name)
			$error[] = 'Please provide your first name';
		if( ! $last_name)
			$error[] = 'Please provide your last name';
		if( ! $x_email)
			$error[] = 'Please provide your email';
		if( ! $x_address)
			$error[] = 'Please provide your address';
		if( ! $x_phone)
			$error[] = 'Please provide your phone number';
		if( ! $region)
			$error[] = 'Please provide your state';
		if( ! $x_city)
			$error[] = 'Please provide your city';
		if( ! $x_zip)
			$error[] = 'Please provide your ZIP code';
		if( ! @$alergy)
			$error[] = 'Please answer if you have alergy';
		if( ! $order_data=ci()->session->userdata('order'))
			$error[] = 'Wrong order';		
	}
	
	private function _check_data($post)
	{
		$errors = array();
		if ( ! @$post['products']) 
		{
			$errors[] = 'Product(s) not set';
		}
		
		if ( ! @$post['address_id']) 
		{
			$errors[] = 'Address not set';
		}
		
		if ( ! @$post['card_id']) 
		{
			$errors[] = 'Card not set';
		}
		
		if ( ! @$post['period']) 
		{
			$errors[] = 'Period not set';
		}
		
		if (@$post['period'] == 'w' and ! @$post['week_day']) 
		{
			$errors[] = 'Day of Week to Ship not set';
		}
		
		foreach ($post['products'] as $k => $v)
		{
			if( ! isset($post['delivery_type'][$v['id']]))
				$errors[] = 'You can\'t order some of products in your state';
		}
		
		return  $errors;
	}
	
	public function edit()
	{
		ci()->page_title(lang('edit_reoccuring_order'), lang('edit_reoccuring_order'));

		$vars['action'] = 'edit';
		
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$post = ci()->input->post(NULL, true);
			$vars['error'] = $this->_check_data($post);
			
			if ( ! @$vars['error']) 
			{
				$post = $this->_syntonize_insert_data($post);
				$id = $this->_model->save($post);
				$this->_insert_products_data($post, $post['reoccuring_order_id']);
				notice(lang('reoccuring_order_updated'));
				redirect('users/reoccuring_orders');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		$vars = array_merge($vars, ci()->_model->get_reoccuring_order(array('where'=>array('reoccuring_order_id'=>(ci()->input->get('reoccuring_order_id', true))))));
		$this->_form_vars();
		if( ! @$vars['reoccuring_order_id'])
		{
			notice(lang('incorrect_reoccuring_order'), true);
			redirect('users/');
		}
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/reoccuring_orders.js', $vars, true));
		ci()->load->view($this->_view_base.'reoccuring_order_form',$vars);
	}
		
	public function add()
	{
		ci()->page_title(lang('add_reoccuring_order'), lang('add_reoccuring_order'));

		$vars['action'] = 'add';
		if( ! empty($_POST))
		{
			extract(ci()->input->post(NULL, true));
			$post = ci()->input->post(NULL, true);
			$vars['error'] = $this->_check_data($post);
			
			if ( ! @$vars['error']) 
			{
				$post = $this->_syntonize_insert_data($post);
				$id = $this->_model->save($post);
				$this->_insert_products_data($post, $id);
				notice(lang('reoccuring_order_updated'));
				redirect('users/reoccuring_orders');
			}
			else
			{
				$vars = array_merge($vars, ci()->input->post(NULL, true));
				notice(implode('<br>', $vars['error']), true);
			}
		}
		
		$this->_form_vars();
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/reoccuring_orders.js', $vars, true));
		ci()->load->view($this->_view_base.'reoccuring_order_form',$vars);
	}
	
	public function _form_vars($allergies='')
	{
		$vars['online_products'] = ci()->products_model->get_sale_products();
		$vars['cards'] = ci()->cards_model->get_cards();
		$vars['primary'] = ci()->cards_model->primary();
		$vars['addresses'] = ci()->address_book_model->get_addresses();
		$vars['primary_addr'] = ci()->address_book_model->primary();
		$vars['allergies'] = ci()->allergies_model->get_user_allergies(ci()->user_session_data['member_id']);
		
		$allergies_pieaces = $allergies ? explode(',', $allergies) : array();
		if(@$vars['allergies'])
		{
			foreach ($vars['allergies'] as $allergy)
			{
				$allergy_arr[] = $allergy;
				if($allergies_pieaces and ! in_array($allergy, $allergies_pieaces)) continue;
				$table_arr[] = form_checkbox('allergies[]', $allergy, true, 'class="alergy_checkbox"') . nbs() . $allergy;				
			}

			$vars['allergies_table'] = ci()->table->generate(ci()->table->make_columns($table_arr, 6));
			$vars['allergies_str'] = implode(', ', $allergy_arr);
			
		}
		ci()->load->vars($vars);
	}

	public function remove()
	{
		if ($reoccuring_order_id=ci()->input->get('reoccuring_order_id')) 
		{
			$this->_remove($reoccuring_order_id);
			ci()->output->print_js('notice.show("'.lang('reoccuring_order_deleted').'")');
			exit;
		}
	}
	
	private  function _remove($reoccuring_order_id)
	{
		if ($reoccuring_order_id) 
		{
			ci()->_model->delete(array('reoccuring_order_id'=>$reoccuring_order_id));
		}
	}
	
	private function _getshipping($state)
	{
		ci()->load->model('taxes_model');
		$taxes = ci()->taxes_model->get_row(array('state'=>$state));
		
		return (@$taxes['ratio']?$taxes['ratio']:0);
	}
		
	public function getdelivery($zip='', $delivery_items='', $ret=false, $address_id='')
	{
		$delivery_items = $delivery_items ? $delivery_items : ci()->input->get('delivery_items');
		
		$address_id = $address_id ? $address_id :ci()->input->get('address_id');
		$address_data = ci()->address_book_model->get_by_id($address_id);
		$items = ci()->input->get('items');
		$delAmount = getdelivery($address_data['postcode'], $delivery_items, $items);

		if($ret) return $delAmount;		
		echo $delAmount;	
		exit;
	}
	
	public function get_total($items = '', $qty='', $ret=false)
	{
		$items = $items ? $items : explode(',', ci()->input->get('items'));
		$qty = $qty ? $qty : explode(',', ci()->input->get('qty'));
		
		$total = $this->_get_items_total($items, $qty);
		if ($ret) return $total;
		echo $total;
		exit;
	}
		
	private function _get_items_total($items, $qty)
	{
		$total = 0;
		foreach ($items as $k => $v)
		{
			$options['where']['product_id'] = $v;
			$product = ci()->products_model->get_row($options);
			$total += calc_user_price($product) * $qty[$k];
		}	
		
		return $total;	
	}
	
	private function _datatables_js($ajax_method='index', $non_sortable_columns, $default_sort, $perpage=10)
	{
		$col_defs = array(
			array('bSortable' => false, 'aTargets' => $non_sortable_columns),
		);		
		$js = '
			oTable = $(".reoccuring_orders_table").dataTable({
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
							$(".reoccuring_orders_table").dataTable().fnSettings()._iDisplayLength = parseInt(extraData[i].value);
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
/* End of file reoccuring_orders.php */
/* Location: ./application/controllers/users/reoccuring_orders.php */