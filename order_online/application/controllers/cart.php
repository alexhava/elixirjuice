<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart {
	var $models = 'admin/orders_model';
	
	private $_authorization_code = false;
	
	public function __construct()
	{
			
		ci()->load->helper(array('form'));
		ci()->load->library(array('javascript', 'session', 'cart'));
		
		// default global view variables
		$vars = array(
			'table_template' => array(
				'table_open'		=> '<table class="main_table" border="0" cellspacing="0" cellpadding="0">',
				'row_start'			=> '<tr class="even">',
				'row_alt_start'		=> '<tr class="odd">'
			),
		);	

		ci()->load->helper(array('form', 'html', 'security', 'order'));
		ci()->load->library(array('table', 'javascript', 'session', 'email'));
		ci()->load->model(array(
			'admin/order_items_model',
			'admin/products_model', 
			'users/allergies_model', 
			'users/address_book_model', 
			'admin/stores_model', 
			'admin/coupons_model'));

		
		$vars = $vars + (array)ci()->session->userdata('user');
		
		if(@ci()->user_session_data['member_id'])
		$vars['allergies'] = ci()->allergies_model->get_user_allergies(ci()->user_session_data['member_id']);
//		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/categories.js', '', true));
//		ci()->javascript->compile();	
		ci()->cart->product_name_rules = '\.\:\-_ a-z0-9\/';
		ci()->add_js_pack('validate_checkout');
		ci()->load->vars($vars);

		$redirect_methods = array('checkout');
		$redirect_methods_ajax = array('get_order_time');
		if( ! ci()->cart->contents() and in_array(ci()->current_method, $redirect_methods)) {
			redirect("/order-online/");
		}
		if( ! ci()->cart->contents() and in_array(ci()->current_method, $redirect_methods_ajax)) {
			echo '<script>document.location.href="/order-online/";</script>';
			exit;
		}
	}

	public function index()
	{
		ci()->index_view = 'index2';
		ci()->load->view('cart', array('cart', ci()->cart));
	}
	
	public function get_total_items()
	{
		echo ci()->cart->total_items();
		exit;
	}
	
	public function in_cart($item_id)
	{
		foreach (ci()->cart->contents() as $p)
		{
			if($p['id'] == $item_id)
			{
				return array($p['rowid'], $p['qty']);
			}
		}
	}
	
	public function add_to_cart($item_id='', $qty='', $rel='', $opt='')
	{
		$item_id = $item_id ? $item_id : ci()->input->get('id', true);
		$qty = $qty ? $qty : ci()->input->get('qty', true);
		
		$ret = $rel == -1 ? false : true;
		$rel = $rel == -1 ? '' : ci()->input->get('rel', true);
		$opt = $opt == -1 ? '' : ci()->input->get('opt', true);
		$product_data = ci()->products_model->get_row(array('product_id'=>$item_id));

		if($rel)
		{
			$rels = explode(',', $rel);
			$rel_qty = $product_data['product_options']->qty[$opt] * $qty;
			foreach ($rels as $r)
			{
				$this->add_to_cart($r, $rel_qty, -1, -1);
			}
		}

		if($opt)
			$item_id .= $opt;

		if( ! $item_data=$this->in_cart($item_id))
		{
			
			if($product_data)
			{
				$product_data['rel'] = $rel;
				$product_data['opt'] = $opt;
				$price = $opt !== ''  ? $product_data['product_options']->price[$opt] : $product_data['regular_price'];

				$data = array(
				                'id'      => $item_id,
				                'qty'     => $qty,
				                'price'   => $price,
				                'name'    => str_replace(array('(', ')', '&'), array('', '', ''), $product_data['product_title']),
				                'option' => $product_data
				             );
				
				 ci()->cart->insert($data);	
			}
		}
		else 
		{
			$data = array(
			    'rowid'   => $item_data[0],
			    'qty'     => $item_data[1]+$qty
			);
			ci()->cart->update($data);			
		}
		
		if($ret)
		exit;
	}	
	
	public function remove_cart_item()
	{
		ob_start();
		$row_id = ci()->input->get('id');
		$cart = ci()->cart->contents();
		$product_data = @$cart[$row_id];
		$rel = $product_data['option']['rel'];
		if($rel)
		{
			$rels = explode(',', $rel);
			foreach ($rels as $r)
			{
				$rel_data = $this->in_cart($r);
				$rel_update_data = array(
				'rowid'   => $rel_data[0],
				'qty'     => 0
				);
				ci()->cart->update($rel_update_data);
			}
		}
		$data = array(
		    'rowid'   => $row_id,
		    'qty'     => 0
		);
		ob_end_clean();
		ci()->cart->update($data);
		echo ci()->cart->format_number(ci()->cart->total());
		exit;
	}	
	
	public function update_cart()
	{
		$items = (array)ci()->input->post('qty');
		$cart = ci()->cart->contents();
		$locked = array();
		foreach($items as $row_id => $qty)
		{
			if($cart[$row_id]['qty'] != $qty)
			{
				$locked[] = $row_id;
			}
			$product_data = $cart[$row_id];
			$rel = $product_data['option']['rel'];
			$opt = $product_data['option']['opt'];
			if($rel)
			{
				$rels = explode(',', $rel);
				$rel_qty = $product_data['option']['product_options']->qty[$opt] * $qty;
				foreach ($rels as $r)
				{
					$rel_data = $this->in_cart($r);
					if( ! in_array($rel_data[1], $locked))
					{
						$rel_update_data = array(
							'rowid'   => $rel_data[0],
							'qty'     => $rel_qty
						);	
						ci()->cart->update($rel_update_data);
					}				
				}
			}			
			$data = array(
			'rowid'   => $row_id,
			'qty'     => $qty
			);
			ci()->cart->update($data);
		}
		exit;
	}
	
	public function cart_total()
	{
		echo  '$' . (ci()->cart->total() ? ci()->cart->format_number(ci()->cart->total()) : 0);
		exit;
	}
	
	public function get_grand_total()
	{
		echo ci()->cart->format_number($this->_get_grand_total());
		exit;
	}
	
	private function calc_coupon_discount($coupon_data, $amount)
	{
		$na = $coupon_data['percentage'] == 'y' ? ( $amount * (1-($coupon_data['amount'] > 1 ? $coupon_data['amount'] / 100 : $coupon_data['amount'])) ): $amount - $coupon_data['amount'];
		return $na;
	}
	
	public function _get_grand_total()
	{		
		$coupon = ci()->session->userdata('coupon');
		$user = ci()->session->userdata('user');
		extract(ci()->input->post(NULL, TRUE));
		$cart_total = ci()->cart->total();
		// we add shipping data
		$order_shipping_tax = $this->_getshipping($store_region);
		
		$zip = $_POST['shipping_same_as_billing'] == 'y' ? $x_zip : $delivery_zip;
		$order_tax = $this->getdelivery($zip, isset($deliver_option), 1);
		
		// coupon check
		if($coupon)
		{
			$coupon_check = ci()->coupons_model->coupon_valid(@$coupon['coupon_code'], $user['member_id']);
			
			if ( $coupon_check['status'] == 'ok')
			{
				$coupon_data = $coupon_check['result'];
				$coupon_allowed = true;
				$coupon_allowed = $coupon_data['minimum_amount'] and $coupon_data['minimum_amount'] < $cart_total ? true: false;
				if($coupon_data['apply_to_shipping'] == 'y' and $coupon_allowed)
				{
					$order_shipping_tax = $this->calc_coupon_discount($coupon_data, $order_shipping_tax);
				}
				elseif($coupon_data['apply_to_shipping'] == 'n' and $coupon_allowed)
				{
					$cart_total = $this->calc_coupon_discount($coupon_data, $cart_total);
				}
			}
		}

		$grand_total = $order_tax + $cart_total + $order_shipping_tax;
		return  $grand_total;
		exit;
	}
	
	public function apply_coupon()
	{
		$coupon_code = ci()->input->get('coupon_code');
		$coupon = ci()->session->userdata('coupon');
		if ( ! $coupon_code and $coupon) 
		{
			echo "<script>
				applyCoupon({$coupon['amount']});
			</script>";	
			exit;		
		}
		elseif ( ! $coupon_code and ! $coupon)
		{
			exit;
		}
		
		$user = ci()->session->userdata('user');
		$coupon_data = ci()->coupons_model->coupon_valid($coupon_code, $user['member_id']);

		if($coupon_data['status'] == 'ok')
		{
			ci()->session->set_userdata('coupon', $coupon_data['result']);
			echo "<script>
				applyCoupon({$coupon_data['result']['amount']});
			</script>";
		}
		else 
		{
			ci()->session->unset_userdata('coupon');
			echo "<font color='red'>Coupon not found</font><script>
				unapplyCoupon();
			</script>";			
		}
		exit;
	}
	
	public function getdelivery($zip='', $delivery_items='', $ret=false)
	{
		$zip = $zip ? $zip : ci()->input->get('zip');
		$delivery = ci()->input->get_post('delivery_type');
		$delAmount = 0;
			
		if($delivery == 'deliver')
			$delAmount = getdelivery($zip);
		
		if($ret) return $delAmount;		
		echo ci()->cart->format_number("$delAmount");	
		exit;
	}
	
	public function getshipping()
	{
		echo ci()->cart->format_number($this->_getshipping());	
		exit;
	}
	
	private function _getshipping()
	{
		ci()->load->model(array('admin/shipping_types_model', 'admin/shipping_methods_model', 'cart_model'));
		$dt = ci()->input->get_post('delivery_type');
		$method = ci()->cart_model->calc_shipping_method(ci()->cart->contents(), array_keys(ci()->shipping_methods_model->get()));
		$shipping_data = ci()->shipping_types_model->get_row(array('shipping_method' => $method));
		
		if($shipping_data)
		{
			return ci()->cart_model->calc_shipping_cost(ci()->cart->contents(), $shipping_data, $dt);
		}
	}
	
	public function get_order_time()
	{
		ci()->load->model('admin/stores_model');
		$options['store_id'] = ci()->input->get('store_id');
		$date = ci()->input->get('date');
		ci()->session->set_userdata('date',$date);
		$week_day = ci()->input->get('week_day');
		$selected = ci()->input->get('selected');
		$dt = ci()->input->get('delivery_type');
		$zip = ci()->input->get('zip');
		
		if ( ! $date) 
		{
			$stamp = strtotime('+1 Day');
			$cleanses_date[][$stamp] = $stamp;
		}
		else
		{
			$stamp = strtotime($date.' 23:59:59');
			$cleanses_date[][$stamp] = $stamp;
		}
		
		if($dt == 'deliver')
		{
			$opt = array(
				'custom' => "delivery_zip like '%$zip%'" 
			);
			
			$store_data = ci()->stores_model->get_row($opt);	
			$store_data['open_days'] = $store_data['delivery_days'];		
		}
		else
		{
			$store_data = ci()->stores_model->get_row($options);
		}		

		$lead_time = 0;
		foreach (ci()->cart->contents() as $k => $v)
		{
			$options['where']['product_id'] = $v['option']['product_id'];
			$product = ci()->products_model->get_row($options);
			if((int)$product['lead_time'] > $lead_time) $lead_time = (int)$product['lead_time'];
		}
		if($dt == 'deliver')
		{
			$store_data['open_days'] = serialize(array_values(unserialize($store_data['delivery_days'])));
			if($cleanses_time = calc_delivery_time($store_data['lead_time'], $store_data, $cleanses_date, $selected))
			echo '<label class="delivery-label">What time would you like it by?</label>' . $cleanses_time.'<br><sup style="color:red; ">note: <br>for 1, 2 & 3 day cleanses you will have 1 pickup day<br> for 4, 5 & 6+ day cleanses you will have 2(+) pickup days</sup>';		
		}
		elseif($dt == 'shipping')
		{
			echo '';
		}
		else
		{
			if($cleanses_time = calc_time($lead_time, $store_data, $dt, $cleanses_date, $selected))
			echo '<label class="delivery-label">What time would you like it ready by?</label>' . $cleanses_time.'<br><sup style="color:red; ">note: <br>for 1, 2 & 3 day cleanses you will have 1 pickup day<br> for 4, 5 & 6+ day cleanses you will have 2(+) pickup days</sup>';			
		}		

		exit;
	}
	
	public function calc_deliver_options()
	{
		ci()->load->model('admin/stores_model');
		$state = ci()->input->get('state');
		$zip = ci()->input->get('zip');
		if(! $state or ! $zip ) die('We need your state and ZIP code so we can calculate your delivery options');
		
		$stores = ci()->stores_model->get_stores($state, 'Open');
		$echo = array();		
		
		$opt = array(
			'custom' => "delivery_zip like '%$zip%'" 
		);
		
		$stores_delivery = ci()->stores_model->get_row($opt);
		
		
		$has_options = true;
				
		if($stores_delivery)
		{
			$has_options = true;
			$echo[] = form_radio("delivery_type", 'deliver', true, 'style="width:auto;" class="delivery_type"').' Delivery ';
		}
		else 
		{
			$echo[] = form_radio("delivery_type", 'shipping', true, 'style="width:auto;" class="delivery_type"').' Shipping ';
		}
		
		if($stores)
		{
			$has_options = true;
			$echo[] = form_radio("delivery_type", 'pickup', true, 'style="width:auto;" class="delivery_type"').' Pickup in Store ';
		}	
		
		if( ! isset($has_options))
			$echo[] = "This product can't be ordered in your state";
			
		echo implode(br(),$echo);	
		exit;
	}
	
	public function getstores()
	{
		
		$stores = ci()->stores_model->get_stores(ci()->input->get('state'), 'Open');
		$store = ci()->input->get('selected');
		if( ! $stores) $stores = array(''=>'There are no stores available in this state');
		$key = $store ? $store : key($stores);
		echo form_dropdown('store', $stores, $key, 'id="store" class="lst_fld"');
		exit;
	}

	public function checkout()
	{
		if( ! isset($_SERVER['HTTPS'])) redirect('https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);

		$session = ci()->session->userdata('user');

		ci()->load->model(array('admin/products_model', 'admin/order_items_model', 'admin/taxes_model'));

		$order['order_date'] = time();
		$order['ip_address'] = $_SERVER['REMOTE_ADDR'];
		$order['order_status'] = 'processing';
		$order['order_tax'] = round(ci()->system_settings['taxes_ratio'], 2);
		$order['order_subtotal'] = 0;
		$order['order_total'] = 0;

		foreach (ci()->cart->contents() as $k => $v)
		{
			$options['where']['product_id'] = $v['option']['product_id'];
			$product = ci()->products_model->get_row($options);
			$order['items'][$k]['id'] = $product['product_id'];
			$order['items'][$k]['title'] = ($v['option']['opt'] ? $v['option']['product_options']->description[$v['option']['opt']] : '').' '.$product['product_title'];
			$user_price = calc_user_price($product);
			$order['items'][$k]['regular_price'] = $v['option']['opt'] ? $v['option']['product_options']->price[$v['option']['opt']] : $user_price;
			$order['items'][$k]['item_qty'] = $v['qty'];
			$order['items'][$k]['item_total'] = $order['items'][$k]['regular_price'] * $v['qty'];
			$order['order_subtotal'] += $order['items'][$k]['regular_price'] * $v['qty'];
		}
		$order['order_total'] = $order['order_subtotal'];


		ci()->session->set_userdata('order', $order);


//		if( ! $session)
//		{
//			ci()->session->set_userdata('redirect_after_login', $_SERVER['REQUEST_URI']);
//			redirect('users/login');
//		}

		if( ! $order)
		redirect('/');

		if(ci()->get_user_session_data('member_id'))
		{
			$order['member_id'] = ci()->get_user_session_data('member_id');
			ci()->session->set_userdata('order', $order);
	
			$opt['member_id'] = ci()->user_session_data['member_id'];
			$opt['primary'] = 'y';
	
			$session = ci()->address_book_model->get_row($opt)+$session;
			$session = $session + $order;
			$session['first_name'] = $session['last_name'] = '';
			@list($session['first_name'], $session['last_name']) = explode(" ", @$session['name']);
		}
		
		ci()->add_foot_js(ci()->load->view('/javascript/cart_helper.js', $session, true));
		ci()->javascript->compile();		
		ci()->load->view('submit_data', $session);
	}

	private function _set_gateway_data($data_to_set)
	{
		ci()->system_settings['api_login_id'] = $data_to_set['api_login_id'];
		ci()->system_settings['transaction_key'] = $data_to_set['transaction_key'];
		ci()->system_settings['api_mode'] = $data_to_set['api_mode'];
	}
	
	private function set_gateway_data($store_id)
	{
		if($store_id)
		{
			ci()->load->model('stores_model');
			$store_data = ci()->stores_model->get_row(array('store_id' => $store_id));
			if($store_data and $store_data['store_anet_account'] and isset(ci()->system_settings['api'][$store_data['store_anet_account']]))
			{
				$this->_set_gateway_data(ci()->system_settings['api'][$store_data['store_anet_account']]);
			}
			elseif (isset(ci()->system_settings['api'][ci()->system_settings['api_default_id']]))
			{
				$this->_set_gateway_data(ci()->system_settings['api'][ci()->system_settings['api_default_id']]);
			}
		}
		else 
		{
			$this->_set_gateway_data(ci()->system_settings['api'][ci()->system_settings['api_default_id']]);
		}
	}
	
	public function test_payment()
	{
		if( ! ci()->cart->contents()) 
		{
			notice('Your cart is empty.', 'error');
			echo "<script>document.location.href='/order-online/'</script>";
			exit;
		}
		$card_num = ci()->input->post('card_number');
		$em = ci()->input->post('exp_month');
		$ey = ci()->input->post('exp_year');
		$store_id = ci()->input->post('store');
		$this->set_gateway_data($store_id);
		require_once APPPATH . 'libraries/anet/AuthorizeNet.php';
		$transaction = new AuthorizeNetAIM(ci()->system_settings['api_login_id'], ci()->system_settings['transaction_key']);
		$transaction->setSandbox((bool)ci()->system_settings['api_mode']);
        $transaction->setFields(
            array(
            'amount' => $this->_get_grand_total(),
//           'card_num' => '6011000000000012',
            'card_num' => $card_num,
            'exp_date' => "$em$ey"
            )
        );
        
        $response = $transaction->authorizeOnly();
        
		if ($response->approved) {
			
			ci()->session->set_userdata('authorization_code', $response->authorization_code);
			echo '<script>showStep()</script>';
			exit;
		}
        echo $response->response_reason_text;
        exit;	
	}

	public function do_payment($post_arr='')
	{
		$error = array();
		$allergies_content = '';
		
		$post = $post_arr ? $post_arr : ci()->input->post(NULL, TRUE);
		extract($post);
		
		if( ! $card_number)
			$error[] = 'Please provide your card number.';
		if( ! $exp_year and ! $exp_month)
			$error[] = 'Please provide your card\'s expiry date.';
		if( ! $first_name)
			$error[] = 'Please provide your billing first name';
		if( ! $last_name)
			$error[] = 'Please provide your billing last name';
		if( ! $x_email)
			$error[] = 'Please provide your billing email';
		if( ! $x_address)
			$error[] = 'Please provide your billing address';
		if( ! $x_phone)
			$error[] = 'Please provide your billing phone number';
		if( ! $region)
			$error[] = 'Please provide your billing state';
		if( ! $x_city)
			$error[] = 'Please provide your billing city';
		if( ! $x_zip)
			$error[] = 'Please provide your billing ZIP code';
		if( ! @$alergy)
			$error[] = 'Please answer if you have alergy';
		if( ! $order_data = ci()->session->userdata('order'))
			$error[] = 'Wrong order';

		if( ! $this->_authorization_code = ci()->session->userdata('authorization_code'))	
			$error[] = 'Wrong transaction';
			
		if(@$login_type == 'register')
		{
			include_once(APPPATH.'controllers/users/login.php');
			$_POST['username'] = $_POST['email'];
			$users = new Login();
			$order['member_id'] = $users->registration(true);
		}
		elseif ($session = ci()->session->userdata('user'))
		{
			$order['member_id'] = ci()->get_user_session_data('member_id');
		}
		
		if($shipping_same_as_billing == 'n')
		{
			if( ! $delivery_first_name)
				$error[] = 'Please provide your delivery first name';
			if( ! $delivery_last_name)
				$error[] = 'Please provide your delivery last name';
			if( ! $delivery_email)
				$error[] = 'Please provide your delivery email';
			if( ! $delivery_address)
				$error[] = 'Please provide your delivery address';
			if( ! $delivery_phone)
				$error[] = 'Please provide your delivery phone number';
			if( ! $store_region)
				$error[] = 'Please provide your delivery state';
			if( ! $delivery_city)
				$error[] = 'Please provide your delivery city';
			if( ! $delivery_zip)
				$error[] = 'Please provide your delivery ZIP code';	
				
			$order_data['shipping_name'] = $delivery_first_name . " " . $delivery_last_name;
			$order_data['shipping_email'] = $delivery_email;
			$order_data['shipping_address1'] = $delivery_address;
			$order_data['shipping_region'] = implode(', ', array(ci()->taxes_model->get_state($region), $x_city));
			$order_data['shipping_phone'] = $delivery_phone;
			$order_data['shipping_postcode'] = $delivery_zip;
						
		}
		else
		{
			$order_data['shipping_name'] = $first_name . " " . $last_name;
			$order_data['shipping_email'] = $x_email;
			$order_data['shipping_address1'] = $x_address;
			$order_data['shipping_region'] = implode(', ', array(ci()->taxes_model->get_state($region), $x_city));
			$order_data['shipping_phone'] = $x_phone;
			$order_data['shipping_postcode'] = $x_zip;
		}

		$exp_date = "{$exp_month}/{$exp_year}";
		
		if( ! isset($post['delivery_type']))
		$error[] = 'You can\'t order some of products in your state';
		else
		$order_data['delivery_type'] = $post['delivery_type'];
		
		foreach (ci()->cart->contents() as $k => $v)
		{

			$items_names[] = ($v['option']['opt'] ? $v['option']['product_options']->description[$v['option']['opt']] : '').' '. $v['option']['product_title'];
		}
		if( ! $error)
		{
			$this->set_gateway_data(@$store);
			require_once APPPATH . 'libraries/anet/AuthorizeNet.php';
			$transaction = new AuthorizeNetAIM(ci()->system_settings['api_login_id'], ci()->system_settings['transaction_key']);
			$transaction->setSandbox((bool)ci()->system_settings['api_mode']);
			// we add shipping data
			$order_data['order_shipping_tax'] = $this->_getshipping($store_region);
			$order_data['order_tax'] = $this->getdelivery($x_zip,isset($deliver_option),1);
			
			$order_data['order_total'] = $this->_get_grand_total();
			
			// coupon check
			if($coupon = ci()->session->userdata('coupon'))
			{
				$coupon_check = ci()->coupons_model->coupon_valid(@$coupon['coupon_code'], ci()->session->userdata('member_id'));

				if ( $coupon_check['status'] == 'ok')
				{
					$order_data['order_total'] -= $coupon['amount'];
					$order_data['coupon_code'] = $coupon['coupon_code'];
				}
			}

			$transaction->amount = $order_data['order_total'];
			$transaction->auth_code = $this->_authorization_code;
			
			$order_data['billing_name'] = $first_name . " " . $last_name;
			$order_data['order_email'] = $x_email;
			$order_data['billing_address1'] = $x_address;
			$order_data['billing_region'] = implode(', ', array(ci()->taxes_model->get_state($region), $x_city));
			$order_data['state_id'] = $region;
			$order_data['store_state_id'] = $store_region;

			$order_data['billing_phone'] = $x_phone;
			$order_data['billing_postcode'] = $x_zip;
			$order_data['notes'] = $notes;
			$order_data['alergy'] = $alergy;
			$order_data['client_allergies'] = @$allergies_content;
			$order_data['start_date'] = $delivery_date;
			$order_data['store_id'] = @$store;
			if(@$ready_time)
			{
				foreach ($ready_time as $stamp => $time) 
				{
					$order_data['start_date'] = date("m/d/Y", $stamp);
					$ready_time_arr[] = "for ". date("m/d/Y", $stamp). " on $time";
				}
				$order_data['ready_time'] = implode("<br>", $ready_time_arr);
			}
			$order_data['order_hash'] = md5(rand(333333,7777777).mktime());
			$order_data['items_names'] = implode(',', $items_names);
			
			$transaction->card_num = $card_number;
			$transaction->exp_date = $exp_date;

			$response = $transaction->captureOnly();
			if ($response->approved) {
				$order_data['order_paid_date'] = mktime();
				$order_data['order_status'] = 'Paid & Pending Processing';
				$order_data['transaction_id'] = $response->transaction_id;
				if( isset($order_data['order_id']) ) unset($order_data['order_id']);
				$order_data['order_id'] = $this->_model->save($order_data);
				foreach ($order_data['items'] as $k => $v)
				{
					$v['order_id'] = $order_data['order_id'];
					ci()->order_items_model->save($v);
				}
				ci()->session->unset_userdata('order');
				if ($coupon)
				{
					ci()->coupons_model->use_coupon($coupon['coupon_code'], ci()->user_session_data['member_id']);
					ci()->session->unset_userdata('coupon');
				}
				
				
				notice('Thank you for your order! You will receive an email confirmation shortly.');
				$order_data['stores'] = ci()->stores_model->get_stores($store_region, 'Open');
				$this->_send_email($order_data);
				// send admin email
				if(isset(ci()->system_settings['admin_email']))
				$this->_send_email($order_data,ci()->system_settings['admin_email']);
				
				ci()->cart->destroy();
				echo "<script> document.location.href='http://'+window.location.host+'/users/orders/view_order?hash={$order_data['order_hash']}&cart_empty=true'</script>";
				exit;
			} else {
				echo $response->response_reason_text;
			}
			
			exit;
		}	
		else 
		{
			if( ! $post_arr)
			{
				echo implode('<br>- ', $error); exit;
			}
			else 
			{ 
				return $error;
			}
		}

	}

	private function _to_arr(&$post)
	{
		foreach ($post as $k => $v)
		{
			if(strchr($k, '_'))
			{
				list($item, $name, $key) = explode('_', $k);
				$post[$item][$key][$name] = trim($v);
			}
		}
	}
	
	private function _send_email($order_data, $email='')
	{
		send_order_email($order_data, $email);
	}	
}
/* End of file Cart.php */
/* Location: ./application/controllers/Cart.php */