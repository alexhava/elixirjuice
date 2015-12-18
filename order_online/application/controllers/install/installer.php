<?php
class Installer {
	var $models = 'installer/installer_model';
	
	function index()
	{
		if( ! $this->_model->db->table_exists('members'))
		{
			$this->install_tables();
			redirect('install/installer/set_admin_pass');
		}	
		else 
		{
			$this->set_admin_pass();
		}		
	}
	
	public function set_admin_pass()
	{
		if($this->_model->get())
			redirect('admin/login');
			
		ci()->page_title(lang('header'));
		$vars = array();
		if( ! empty($_POST))
		{
			if ( ! ci()->input->post('password') or ! ci()->input->post('login') or ! ci()->input->post('confirm_password')) 
			{
				$vars['error'][] = lang('fill_all_fields');
			}
			
			if (ci()->input->post('password') != ci()->input->post('confirm_password')) 
			{
				$vars['error'][] = lang('passwords_not_match');
			}
			
			if ( ! @$vars['error']) 
			{
				$ins['username'] = 	ci()->input->post('login');
				$ins['password'] = md5( ci()->input->post('password') );
				$ins['email'] = ci()->input->post('email');
				$ins['group_id'] = 1;
				$ins['admin'] = 'y';
				$this->_model->insert($ins);
				redirect('admin/login');
			}
		}
		
		return ci()->load->view('install/set_admin_pass', $vars);
	}
	
	public function install_tables()
	{
		if ($this->_model->db->table_exists('system')) return ;
		
		ci()->load->dbforge();
		
		// sys_settings table
		$fields = array(
			'setting_id' 		=> array('type' => 'TINYINT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'version'			=> array('type' => 'VARCHAR', 'constraint' => 5),
			'settings'				=> array('type' => 'TEXT'),
			
		);
		ci()->dbforge->add_field($fields);
		ci()->dbforge->add_key('setting_id', TRUE);
		ci()->dbforge->create_table('sys_settings');
		$ins['version'] = ci()->version;
		ci()->db->insert('sys_settings', $ins);
		
		// member table
		$fields = array(
			'member_id' 		=> array('type' => 'BIGINT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'username' 			=> array('type' => 'VARCHAR', 'constraint' => 30, 'null' => FALSE),
			'password' 			=> array('type' => 'VARCHAR', 'constraint' => 32, 'null' => FALSE),
			'group_id' 			=> array('type' => 'INT', 'constraint' => 1,	'null' => TRUE),
			'email'				=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
			'name'				=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
			'address1'			=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
			'address2'			=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
			'address3'			=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
			'region'			=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
			'country'			=> array('type' => 'char', 'constraint' => 2, 'default'=> ''),
			'postcode'			=> array('type' => 'varchar', 'constraint' => 10, 'default'=> ''),
			'phone'				=> array('type' => 'varchar', 'constraint' => 15, 'default'=> ''),
			'ban'				=> array('type' => 'varchar', 'constraint' => 1, 'default'=> 'n'),
			'admin'				=> array('type' => 'varchar', 'constraint' => 1, 'default'=> 'n'),
			'active'			=> array('type' => 'varchar', 'constraint' => 1, 'default'=> 'n'),
			'activation_key'	=> array('type' => 'varchar', 'constraint' => 32, 'default'=> ''),
			
		);
		ci()->dbforge->add_field($fields);
		ci()->dbforge->add_key('member_id', TRUE);
		ci()->dbforge->add_key('username');
		ci()->dbforge->add_key('ban');
		ci()->dbforge->add_key('active');
		ci()->dbforge->create_table('members');
		
		// groups table
		$fields = array(
			'group_id' 		=> array('type' => 'BIGINT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'group_type'	=> array('type' => 'INT', 'constraint' => 1,	'null' => TRUE),
			'group_name'	=> array('type' => 'VARCHAR', 'constraint' => 30, 'null' => FALSE),
		);
		ci()->dbforge->add_field($fields);
		ci()->dbforge->add_key('group_id', TRUE);
		ci()->dbforge->create_table('groups');
		
		// permissions table
		$fields = array(
			'permission_id' 		=> array('type' => 'BIGINT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'group_id' 			=> array('type' => 'INT', 'constraint' => 1,	'null' => TRUE),
			'page'			=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
		);
		ci()->dbforge->add_field($fields);
		ci()->dbforge->add_key('permission_id', TRUE);
		ci()->dbforge->create_table('permissions');
		
		// password recovery table
		$fields = array(
			'recovery_id'					=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'recovery_hash'				=> array('type' => 'varchar', 'constraint' => 32, 'null' => FALSE),
			'member_id'					=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
			'recovery_date'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'ip_address'				=> array('type' => 'varchar', 'constraint' => 40, 'null' => FALSE),
		);
		ci()->dbforge->add_field($fields);
		ci()->dbforge->add_key('recovery_id', TRUE);
		ci()->dbforge->add_key('member_id');
		ci()->dbforge->add_key('recovery_hash');
		ci()->dbforge->create_table('password_recovery');
		
		// orders table
		$fields = array(
			'order_id'					=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'order_hash'				=> array('type' => 'varchar', 'constraint' => 32, 'null' => FALSE),
			'member_id'					=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
			'order_date'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'order_completed_date'		=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => TRUE),
			'ip_address'				=> array('type' => 'varchar', 'constraint' => 40, 'null' => FALSE),
			'order_status'				=> array('type' => 'varchar', 'constraint' => 20, 'null' => TRUE),
			'order_status_updated'		=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => TRUE),
			'order_status_member'		=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'order_qty'					=> array('type' => 'int', 'constraint' => 4, 'unsigned' => TRUE, 'null' => FALSE),
			'order_subtotal'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_subtotal_tax'		=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_discount'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_discount_tax'		=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_shipping'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_shipping_tax'		=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_handling'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_handling_tax'		=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_tax'					=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_total'				=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_paid'				=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'order_paid_date'			=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => TRUE),
			'order_email'				=> array('type' => 'varchar', 'constraint' => 100),
			'promo_code_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
			'promo_code'				=> array('type' => 'varchar', 'constraint' => 20, 'null' => TRUE),
			'payment_method' 			=> array('type' => 'varchar', 'constraint' => 50),
			'tax_id'					=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
			'tax_name'					=> array('type' => 'varchar', 'constraint' => 40),
			'tax_rate'					=> array('type' => 'double', 'null' => FALSE),
			'billing_name'				=> array('type' => 'varchar', 'constraint' => 255),
			'billing_address1'			=> array('type' => 'varchar', 'constraint' => 255),
			'billing_address2'			=> array('type' => 'varchar', 'constraint' => 255),
			'billing_address3'			=> array('type' => 'varchar', 'constraint' => 255),
			'billing_region'			=> array('type' => 'varchar', 'constraint' => 255),
			'billing_country'			=> array('type' => 'char', 'constraint' => 2),
			'billing_postcode'			=> array('type' => 'varchar', 'constraint' => 10),
			'billing_phone'				=> array('type' => 'varchar', 'constraint' => 15),
			'shipping_name'				=> array('type' => 'varchar', 'constraint' => 255),
			'shipping_address1'			=> array('type' => 'varchar', 'constraint' => 255),
			'shipping_address2'			=> array('type' => 'varchar', 'constraint' => 255),
			'shipping_address3'			=> array('type' => 'varchar', 'constraint' => 255),
			'shipping_region'			=> array('type' => 'varchar', 'constraint' => 255),
			'shipping_country'			=> array('type' => 'char', 'constraint' => 2),
			'shipping_postcode'			=> array('type' => 'varchar', 'constraint' => 10),
			'shipping_phone'			=> array('type' => 'varchar', 'constraint' => 15),
			'billing_same_as_shipping'	=> array('type' => 'char', 'constraint' => 1, 'null' => FALSE),
			'shipping_same_as_billing'	=> array('type' => 'char', 'constraint' => 1, 'null' => FALSE),
			'return_url'				=> array('type' => 'varchar', 'constraint' => 255),
			'cancel_url'				=> array('type' => 'varchar', 'constraint' => 255)
		);
		ci()->dbforge->add_field($fields);
		ci()->dbforge->add_key('order_id', TRUE);
		ci()->dbforge->add_key('member_id');
		ci()->dbforge->add_key('order_date');
		ci()->dbforge->create_table('orders');
		$this->_model->create_unique_index('orders', 'order_hash');
		
		// order history table
		ci()->dbforge->add_field(array(
			'order_history_id'		=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'order_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'order_status'			=> array('type' => 'varchar', 'constraint' => 20, 'null' => FALSE),
			'order_status_updated'	=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'order_status_member'	=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE, 'default' => 0),
			'message'				=> array('type' => 'text', 'null' => TRUE)));
		ci()->dbforge->add_key('order_history_id', TRUE);
		ci()->dbforge->add_key('order_id');
		ci()->dbforge->create_table('order_history');
		
		// order items table
		ci()->dbforge->add_field(array(
			'order_item_id'			=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'order_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'entry_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'null' => TRUE),
			'sku'					=> array('type' => 'varchar', 'constraint' => 20, 'null' => FALSE),
			'title'					=> array('type' => 'varchar', 'constraint' => 100, 'null' => FALSE),
			'modifiers'				=> array('type' => 'text', 'null' => TRUE),
			'price'					=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'price_inc_tax'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'regular_price'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'regular_price_inc_tax' => array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'on_sale'				=> array('type' => 'char', 'constraint' => 1, 'null' => FALSE),
			'weight'				=> array('type' => 'double'),
			'length'				=> array('type' => 'double'),
			'width'					=> array('type' => 'double'),
			'height'				=> array('type' => 'double'),
			'handling'				=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'handling_tax'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'free_shipping'			=> array('type' => 'char', 'constraint' => 1, 'null' => FALSE),
			'tax_exempt'			=> array('type' => 'char', 'constraint' => 1, 'null' => FALSE),
			'item_qty'				=> array('type' => 'int', 'constraint' => 4, 'unsigned' => TRUE, 'null' => FALSE),
			'item_subtotal'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'item_tax'				=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'item_total'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE)));
		ci()->dbforge->add_key('order_item_id', TRUE);
		ci()->dbforge->add_key('order_id');
		ci()->dbforge->create_table('order_items');
		
		// products table
		ci()->dbforge->add_field(array(
			'product_id'			=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'regular_price'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'sale_price'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => TRUE),
			'sale_price_enabled'	=> array('type' => 'char', 'constraint' => 1, 'null' => FALSE),
			'sale_start_date'		=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
			'sale_end_date'			=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
			'weight'				=> array('type' => 'double'),
			'dimension_l'			=> array('type' => 'double'),
			'dimension_w'			=> array('type' => 'double'),
			'dimension_h'			=> array('type' => 'double'),
			'handling'				=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
			'free_shipping'			=> array('type' => 'char', 'constraint' => 1, 'null' => FALSE),
			'tax_exempt'			=> array('type' => 'char', 'constraint' => 1, 'null' => FALSE)));
		ci()->dbforge->add_key('product_id', TRUE);
		ci()->dbforge->create_table('products');
		
		// categories table
		ci()->dbforge->add_field(array(
			'cat_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'parent_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'default'=>0),
			'cat_order'				=> array('type' => 'int', 'constraint' => 4, 'unsigned' => TRUE),
			'cat_name'				=> array('type' => 'char', 'constraint' => 50, 'null' => FALSE),
			'cat_url_title'			=> array('type' => 'char', 'constraint' => 50),
			'cat_img'				=> array('type' => 'char', 'constraint' => 255),
			'visible'				=> array('type' => 'char', 'constraint' => 1, 'default'=>'y'),
			'cat_description'		=> array('type' => 'text'),
			));
			
		ci()->dbforge->add_key('cat_id', TRUE);
		ci()->dbforge->add_key('parent_id');
		ci()->dbforge->create_table('categories');		
	}
}
/* End of file Installer.php */
/* Location: ./application/controllers/Installer.php */