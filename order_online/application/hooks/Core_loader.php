<?php
if ( ! defined('DOCUMENT_ROOT')) 
{
	define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'].'/');
}

class Core_loader extends CI_Controller  {
	var $version = '2.5.8';
	var $page_title;
	var $sub_title;
	var $session_data;
	var $system_settings;
	var $js_pack=array();
	var $js_foot=array();
	var $index_view				='index';
	
	public function __construct()
	{
		date_default_timezone_set('UTC'); 
		parent::__construct();
		@session_start();
		// load database
		$this->load->database();
		//
		$this->load->library(array('session', 'javascript'));
		$this->load->helper(array('url_helper', 'language', 'date'));
		
		$RTR 		=& load_class('Router', 'core');
		$this->current_dir 		= $RTR->fetch_directory();	
		$this->current_class	= $RTR->fetch_class();
		$this->current_method 	= $RTR->fetch_method();	
		$this->controller_base 	= '/'.$this->current_dir.$this->current_class.'/';
		
		$doc_root = getcwd() . "/";
		if ( ! is_dir($doc_root.'images/upload')) 
		{
			if(is_really_writable($doc_root.'images'))
				mkdir($doc_root.'images/upload');
			else 
				show_error('Folder is not writable: '.$doc_root.'images' );	
		}
		
		$vars['controller'] = $this->current_class;
		$vars['method'] 	= $this->current_method;
		
		// load_models
		$this->_load_models(get_class_vars($this->current_class));
		
		$vars['checkout_url'] = 'http://'.$_SERVER['SERVER_NAME'].'/cart/checkout';
		$vars['base_url'] 	= $this->config->item('base_url');
		$vars['ci'] 	= $this;
		$this->load->vars($vars);
	}

	public function index()
	{			
		if($this->_is_system_installed())
		{
			$this->_check_updates();
			$this->_check_admin();
			$this->_check_client_login();
		}
		$this->_load_page_lang();
	}

	/**
	 * Load language package if exists
	 *
	 */
	private function _load_page_lang()
	{
		$dir 			= $this->current_dir;
		$current_class 	= $this->current_class;		
		$config =& get_config();

		$deft_lang = ( ! isset($config['language'])) ? 'english' : $config['language'];
		$idiom = ($deft_lang == '') ? 'english' : $deft_lang;
		$dir = trim($dir, '/');
		if(file_exists(APPPATH."language/$idiom/common_lang.php"))
			$this->lang->load("common");
		if(file_exists(APPPATH."language/$idiom/admin/admin_lang.php"))
			$this->lang->load("admin/admin");
		if(file_exists(APPPATH."language/$idiom/{$dir}/{$dir}_lang.php"))
			$this->lang->load("{$dir}/{$dir}");
		elseif (file_exists(APPPATH."language/$idiom/{$dir}_lang.php"))
			$this->lang->load($dir);
		elseif (file_exists(APPPATH."language/$idiom/{$current_class}_lang.php"))
			$this->lang->load($current_class);
		elseif (file_exists(APPPATH."language/$idiom/{$dir}/{$current_class}_lang.php"))
			$this->lang->load("{$dir}/{$current_class}");
	}

	private function _is_system_installed()
	{
		$dir 		= $this->current_dir;
		if( (! $this->db->table_exists('members') or ! $this->db->count_all_results('members') ) )
		{
			if($dir != 'install/')
			redirect('install/installer');
			return false;
		}
		return true;
	}

	private function _check_admin()
	{
		$this->load->library('encrypt');
		$class 		= $this->current_class;
		$method 	= $this->current_method;
		$dir 		= $this->current_dir;

		if($dir == 'admin/' and $class != 'login')
		{
			if( ! $this->session->userdata('admin'))
			{
				redirect('admin/login');
			}
			
			$this->session_data = $this->session->userdata('admin');
			$db_member_data = $this->db->where('username', $this->session_data['username'])->get('members')->row_array();
			if(! $db_member_data or $this->session_data['password'] != $db_member_data['password'])
			{
				$this->session->unset_userdata('admin');
				redirect('admin/login');
			}

			$this->_check_access();
			$this->_admin_menu();
		}
	}

	public function is_user_logged()
	{
		return $this->session->userdata('user');
	}
	
	private function _check_client_login()
	{
		$this->load->library('encrypt');
		$class 		= $this->current_class;
		$method 	= $this->current_method;
		$dir 		= $this->current_dir;
		
		$this->user_session_data = $this->session->userdata('user');
		$restricted_areas = array(
			'users/'=>array(
				'allow'=>array(
					array('class'=> array('reoccuring_orders'), 'method'=> array('make_order')),
					array('class'=> array('orders'), 'method'=> array('view_order')),
					array('class'=> array('login')),
					array('class'=> array('registration')),
				))
			);
			
		$denied = false;
		
		// check permission
		if (isset($restricted_areas[$dir])) 
		{
			$denied = true;
			if (isset($restricted_areas[$dir]['allow'])) 
			{
				foreach ($restricted_areas[$dir]['allow'] as $row)
				{
					if (isset($row['class']) and in_array($class, $row['class'])) 
					{
						$denied = false;
						if (isset($row['method']) and ! in_array($method, $row['method'])) 
						{
							$denied = true;
						}
						break;
					}
				}
			}
		}	
		
		$is_reoccuring_orders = ($class == 'reoccuring_orders' and $method == 'make_order');
		$is_hash_order = ($class == 'orders' and $method == 'view_order');

		if($denied)
		{
			if( ! $this->session->userdata('user'))
			{
				$this->session->set_userdata('redirect_after_login', $_SERVER['REQUEST_URI']);
				redirect('users/login');
			}
			
			$db_member_data = $this->db->where('username', $this->user_session_data['username'])->get('members')->row_array();

			if(! $db_member_data or $this->user_session_data['password'] != $db_member_data['password'])
			{
				$this->session->unset_userdata('admin');
				redirect('users/login');
			}
			if($db_member_data['ban'] == 'y')
			{
				$this->session->unset_userdata('admin');
				redirect('users/login');
			}

		}
		elseif ($this->user_session_data)
		{
			$db_member_data = $this->db->where('username', $this->user_session_data['username'])->get('members')->row_array();
			
			// update info
			$this->session->set_userdata('user', $db_member_data);
			$this->user_session_data = $this->session->userdata('user');
		}
	}

	public function get_user_session_data($var) 
	{
		if (isset($this->user_session_data[$var])) 
		{
			return $this->user_session_data[$var];
		}
	}
	
	private function _check_updates()
	{
		$this->load->model('admin/system_model');
		$this->load->library('update');
		$version = $this->system_model->get_version();
		$this->system_settings = $this->system_model->get_settings();//init settings
		if ( ! version_compare($this->version, $version, '=')) 
		{
			$this->update->start($version);
			$this->system_model->update_version($this->version);
		}
	}

	private function _check_access()
	{
		$this->load->model('admin/groups_model');

		if($this->session_data['admin'] == 'y')
		return true;// this is super admin
						
		$this->load->library('encrypt');
		$class 		= $this->current_class;
		$method 	= $this->current_method;
		$dir 		= $this->current_dir;

		if($class == 'login' or $method == 'logout')
			return true;
		$this->permissions = $permissions = $this->groups_model->get_permissions($this->session_data['group_id']);
		$page = "{$class}/$method";
		$page2 = "{$class}/";
		$path = $_SERVER['REQUEST_URI'];
		$path = parse_url($path);
		if( ! isset($permissions[$page]) and ! isset($permissions[$page2]) and ( ! isset($permissions[rtrim($path['path'], '/').'/']) and ! isset($permissions[rtrim($path['path'], '/')])))
		{
			show_error('Access Denied', '503');
		}
		return true;
	}
	
	public function page_title($title, $sub_title='')
	{
		$this->page_title = $title;
		$this->sub_title = $sub_title;
	}
	
	function add_foot_js($js)
	{
		$this->js_foot[] = $js;
	}	
	
	public function _output($output)
	{
		header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
		$RTR 		=& load_class('Router', 'core');
		$dir 		= $RTR->fetch_directory();	
		$controller	= $RTR->fetch_class();
		$method 	= $RTR->fetch_method();	
		
	
		$vars['content'] 	= $output;	
		$vars['page_title'] = $this->page_title;
		$vars['sub_title'] 	= $this->sub_title;
		$vars['js_pack'] 	= $this->get_js_pack_string();
		
		$vars['js_foot'] 	=  "<script type='text/javascript'>". implode(";\n", $this->js_foot)."</script>";
		if(@$this->force_view)
		{
			echo $output;
			$this->force_view = false;
			return ;
		}
		
		$this->javascript->compile();		

		if(file_exists(APPPATH.'views/'.$dir."{$this->index_view}.php"))
			echo $this->load->view($dir.$this->index_view, $vars, true);
		elseif (file_exists(APPPATH.'views/'."{$this->index_view}.php"))
			echo $this->load->view($this->index_view, $vars, true);
		else
			echo $output;
	}

	public function _admin_menu()
	{
		$menu = array(
			'home' => array(
				'url' => 'home/',
				'sub_menu' => array(
				) 
			),
			'categories' => array(
				'url' => '',
				'sub_menu' => array(
					'categories_list' => 'categories/categories_list',
					'add_category' => 'categories/add_category',
				) 
			),
//			'production' => array(
//				'url' => '',
//				'sub_menu' => array(
//					'stores' => array('production_stores'=>array(''=>'list', 'add'=>'add')),
//					'groups' => array('production_groups'=>array(''=>'list', 'add'=>'add')),
//					'product_types' => array('production_product_types'=>array(''=>'list', 'add'=>'add')),
//					'ingredients' => array('production_ingredients'=>array(''=>'list', 'add'=>'add')),
//					'products' => array('production_products'=>array(''=>'list', 'add'=>'add')),
//					'sites' => array('production_sites'=>array(''=>'list', 'add'=>'add')),
//				), 
//				'group' => array('production_sites', 'production_products', 'production_groups', 'production_stores', 'production_product_types', 'production_ingredients')
//			),
			'products' => array(
				'url' => '',
				'sub_menu' => array(
					'products_list' => 'products/products_list',
					'add_product' => 'products/add_product',
				) 
			),
			'orders' => array(
				'url' => '',
				'sub_menu' => array(
					'orders_list' => 'orders/orders_list',
				) 
			),
			'members' => array(
				'url' => '',
				'sub_menu' => array(
					'members_list' => 'members/members_list',
					'add_member' => 'members/add_member',
					'edit_personal_info' => 'members/edit_personal_info',
				) 
			),
			'coupons' => array(
				'url' => '',
				'sub_menu' => array(
					'coupons_list' => 'coupons/coupons_list',
					'add_coupon' => 'coupons/add_coupon',
				) 
			),
			'groups' => array(
				'url' => '',
				'sub_menu' => array(
					'groups_list' => 'groups/groups_list',
					'add_group' => 'groups/add_group',
				) 
			),
			'taxes' => array(
				'url' => '',
				'sub_menu' => array(
					'taxes_list' => 'taxes/taxes_list',
					'add_tax' => 'taxes/add_tax',
				) 
			),
			'shipping_types' => array(
				'url' => '',
				'sub_menu' => array(
					'shipping_types_list' => 'shipping_types/shipping_types_list',
					'add_shipping_type' => 'shipping_types/add_shipping_type',
				) 
			),
			'shipping_schedule' => array(
				'url' => '',
				'sub_menu' => array(
					'shipping_schedule_list' => 'shipping_schedule/shipping_schedule_list',
					'add_shipping_schedule' => 'shipping_schedule/add_shipping_schedule',
				) 
			),
			'stores' => array(
				'url' => '',
				'sub_menu' => array(
					'stores_list' => 'stores/stores_list',
					'add_store' => 'stores/add_store',
				) 
			),
			'calendar' => array(
				'url' => '',
				'sub_menu' => array(
					'date_list' => 'calendar/date_list',
					'add_off_date' => 'calendar/add_off_date',
				) 
			),
			'settings' => array(
				'url' => '',
				'sub_menu' => array(
					'general' => 'settings/?type=general',
					'order_taxes' => 'settings/?type=order_taxes',
					'shipping' => 'settings/?type=shipping',
					'authorizenet' => 'settings/?type=authorizenet',
					'statuses' => 'settings/?type=statuses',
				) 
			),
		);
		
		if(isset($this->permissions))
		{
			foreach ($menu as $k => $v)
			{
				if ($v['url'] and ! isset($this->permissions[$v['url']]))
				{
					$menu[$k]['url'] = '';
				}

				foreach ($v['sub_menu'] as $k1 => $v1)
				{
					if( ! is_array($v1))
					{
						if( ! isset($this->permissions[$v1]))
						{
							unset($menu[$k]['sub_menu'][$k1]);
						}
					}
				}

				if( ! $menu[$k]['url'] and ! $menu[$k]['sub_menu'])
				unset($menu[$k]);
			}
		}
		
		$vars['admin_menu'] = $menu;
		
		// get new orders
		$vars['new_orders_count'] = $this->db->from("orders")->where("is_new", "y")->count_all_results();
		$this->load->vars($vars);		
		return $menu;
	}	
	
	public function _load_models($vars)
	{
 		if(isset($vars['models']) and $vars['models'])
		{
			if(is_array($vars['models']))
			{
				$model_name = explode('/', $vars['models'][0]);
				$this->load->model($vars['models']);
			}
			else
			{
				$model_name = explode('/', $vars['models']);
				$this->load->model($vars['models']);
			}

			$this->_model =& $this->{$model_name[count($model_name)-1]};
		}
	}	
	
	public function add_js_pack($pack)
	{
		if(is_array($pack))
		$this->js_pack += $pack;
		else
 		$this->js_pack[$pack] = $pack;
	}
	
	public function get_js_pack_string()
	{
		if( ! $this->js_pack);
 		$pkgs = implode(',',$this->js_pack);
 		
 		return "<script type='text/javascript' src='/js/load?js=$pkgs'></script>\n";
	}	
}
/* End of file Core_loader.php */
/* Location: ./application/hooks/Core_loader.php */