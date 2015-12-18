<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update {
	public function start($version)
	{
		ci()->load->dbforge();
		if (version_compare($version, '1.0.1', '<'))
		{
			$this->update101();
		}
		if (version_compare($version, '1.0.2', '<'))
		{
			$this->update102();
		}
		if (version_compare($version, '1.0.3', '<'))
		{
			$this->update103();
		}
		if (version_compare($version, '1.0.4', '<'))
		{
			$this->update104();
		}
		if (version_compare($version, '1.0.5', '<'))
		{
			$this->update105();
		}
		if (version_compare($version, '1.0.6', '<'))
		{
			$this->update106();
		}
		if (version_compare($version, '1.0.7', '<'))
		{
			$this->update107();
		}
		if (version_compare($version, '1.0.8', '<'))
		{
			$this->update108();
		}
		if (version_compare($version, '1.1.1', '<'))
		{
			$this->update111();
		}
		if (version_compare($version, '1.1.2', '<'))
		{
			$this->update112();
		}
		if (version_compare($version, '1.1.3', '<'))
		{
			$this->update113();
		}
		if (version_compare($version, '1.1.4', '<'))
		{
			$this->update114();
		}
		if (version_compare($version, '1.1.5', '<'))
		{
			$this->update115();
		}
		if (version_compare($version, '1.1.6', '<'))
		{
			$this->update116();
		}
		if (version_compare($version, '1.1.7', '<'))
		{
			$this->update117();
		}
		if (version_compare($version, '1.1.8', '<'))
		{
			//			$this->update118();
		}
		if (version_compare($version, '1.1.9', '<'))
		{
			$this->update119();
		}
		if (version_compare($version, '2.0.0', '<'))
		{
			$this->update200();
		}
		if (version_compare($version, '2.0.1', '<'))
		{
			$this->update201();
		}
		if (version_compare($version, '2.0.2', '<'))
		{
			$this->update202();
		}
		if (version_compare($version, '2.0.3', '<'))
		{
			$this->update203();
		}
		if (version_compare($version, '2.0.4', '<'))
		{
			$this->update204();
		}
		if (version_compare($version, '2.0.5', '<'))
		{
			$this->update205();
		}
		if (version_compare($version, '2.0.6', '<'))
		{
			$this->update206();
		}
		if (version_compare($version, '2.0.7', '<'))
		{
			$this->update207();
		}
		if (version_compare($version, '2.0.8', '<'))
		{
			$this->update208();
		}
		if (version_compare($version, '2.0.9', '<'))
		{
			$this->update209();
		}
		if (version_compare($version, '2.1.0', '<'))
		{
			$this->update210();
		}
		if (version_compare($version, '2.1.1', '<'))
		{
		}
		if (version_compare($version, '2.1.2', '<'))
		{
		}
		if (version_compare($version, '2.1.3', '<'))
		{
			$this->update213();
		}
		if (version_compare($version, '2.1.4', '<'))
		{
		}
		if (version_compare($version, '2.1.5', '<'))
		{
			$this->update215();
		}
		if (version_compare($version, '2.1.6', '<'))
		{
			$this->update216();
		}
		if (version_compare($version, '2.1.7', '<'))
		{
			$this->update217();
		}
		if (version_compare($version, '2.1.8', '<'))
		{
			$this->update218();
		}
		if (version_compare($version, '2.1.9', '<'))
		{
			$this->update219();
		}
		if (version_compare($version, '2.2.0', '<'))
		{
			$this->update220();
		}
		if (version_compare($version, '2.2.1', '<'))
		{
			$this->update221();
		}
		if (version_compare($version, '2.2.2', '<'))
		{
			$this->update222();
		}
		if (version_compare($version, '2.2.3', '<'))
		{
			$this->update223();
		}
		if (version_compare($version, '2.2.4', '<'))
		{
			$this->update224();
		}
		if (version_compare($version, '2.2.5', '<'))
		{
			$this->update225();
		}
		if (version_compare($version, '2.2.6', '<'))
		{
			$this->update226();
		}
		if (version_compare($version, '2.2.7', '<'))
		{
			$this->update227();
		}
		if (version_compare($version, '2.2.8', '<'))
		{
			$this->update228();
		}
		if (version_compare($version, '2.2.9', '<'))
		{
			$this->update229();
		}
		if (version_compare($version, '2.3.0', '<'))
		{
			$this->update230();
		}
		if (version_compare($version, '2.3.1', '<'))
		{
			$this->update231();
		}
		if (version_compare($version, '2.3.2', '<'))
		{
			$this->update232();
		}
		if (version_compare($version, '2.3.3', '<'))
		{
			$this->update233();
		}
		if (version_compare($version, '2.3.4', '<'))
		{
			$this->update234();
		}
		if (version_compare($version, '2.3.5', '<'))
		{
			$this->update235();
		}
		if (version_compare($version, '2.3.6', '<'))
		{
			$this->update236();
		}
		if (version_compare($version, '2.3.7', '<'))
		{
			$this->update237();
		}
		if (version_compare($version, '2.3.8', '<'))
		{
			$this->update238();
		}
		if (version_compare($version, '2.3.9', '<'))
		{
			$this->update239();
		}
		if (version_compare($version, '2.4.0', '<'))
		{
			$this->update240();
		}
		if (version_compare($version, '2.4.1', '<'))
		{
			$this->update241();
		}
		if (version_compare($version, '2.4.2', '<'))
		{
			$this->update242();
		}
		if (version_compare($version, '2.4.3', '<'))
		{
			$this->update243();
		}
		if (version_compare($version, '2.4.4', '<'))
		{
			$this->update244();
		}
		if (version_compare($version, '2.4.5', '<'))
		{
			$this->update245();
		}
		if (version_compare($version, '2.4.7', '<'))
		{
			$this->update247();
		}
		if (version_compare($version, '2.4.8', '<'))
		{
			$this->update248();
		}
		if (version_compare($version, '2.4.9', '<'))
		{
			$this->update249();
		}
		if (version_compare($version, '2.5.0', '<'))
		{
			$this->update250();
		}
		if (version_compare($version, '2.5.1', '<'))
		{
			$this->update251();
		}
		if (version_compare($version, '2.5.2', '<'))
		{
			$this->update252();
		}
		if (version_compare($version, '2.5.3', '<'))
		{
			$this->update253();
		}
		if (version_compare($version, '2.5.4', '<'))
		{
			$this->update254();
		}
		if (version_compare($version, '2.5.5', '<'))
		{
			$this->update255();
		}
		if (version_compare($version, '2.5.7', '<'))
		{
			$this->update257();
		}
		if (version_compare($version, '2.5.8', '<'))
		{
			$this->update258();
		}
	}

	// update 2.5.8
	private function update258()
	{
		ci()->dbforge->add_column('coupons', array(
		'minimum_amount'			=> array('type' => 'decimal', 'constraint' => array(19,2)),
		'percentage'				=> array('type' => 'varchar', 'constraint' => 1),
		'apply_to_shipping'			=> array('type' => 'varchar', 'constraint' => 1),
		));
	}

	// update 2.5.7
	private function update257()
	{
//		$fields = array(
//			'shipping_weight' => array(
//				'name' => 'shipping_weight',
//				'type' => 'float',
//				'constraint' => 1,
//			),
//		);
//		ci()->dbforge->modify_column('products', $fields);	
	}

	// update 2.5.5
	private function update255()
	{
		ci()->dbforge->add_field(array(
		'shipping_schedule_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'name'								=> array('type' => 'char', 'constraint' => 50, 'null' => FALSE),
		'prio'								=> array('type' => 'int', 'constraint' => 1, 'null' => FALSE),
		'shipping_days'						=> array('type' => 'text'),
		));
		ci()->dbforge->add_key('shipping_schedule_id', TRUE);
		ci()->dbforge->create_table('shipping_schedule');

		ci()->dbforge->add_column('products', array(
		'shipping_schedule_id'		=> array('type' => 'int', 'constraint' => '1'),
		));		
	}	
	
	// update 2.5.4
	private function update254()
	{
		ci()->dbforge->add_field(array(
		'shipping_type_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'name'							=> array('type' => 'char', 'constraint' => 50, 'null' => FALSE),
		'total_weight'					=> array('type' => 'int', 'constraint' => 1, 'null' => FALSE),
		'cost'							=> array('type' => 'decimal', 'constraint' => array(19,2)),
		'shipping_method'				=> array('type' => 'char', 'constraint' => 50, 'null' => FALSE),
		));
		ci()->dbforge->add_key('shipping_type_id', TRUE);
		ci()->dbforge->create_table('shipping_types');

		ci()->dbforge->add_column('products', array(
		'shipping_weight'		=> array('type' => 'int', 'constraint' => '1'),
		'shipping_type'			=> array('type' => 'varchar', 'constraint' => '255'),
		));		
	}
	
	// update 2.5.3
	private function update253()
	{
		ci()->dbforge->add_column('products', array(
			'product_options'		=> array('type' => 'text', 'null' => true),
		));
		
		ci()->dbforge->add_field(array(
		'related_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'product_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'parent_product_id'			=> array('type' => 'int', 'constraint' => 10, 'null' => FALSE),
		));
		ci()->dbforge->add_key('related_id', TRUE);
		ci()->dbforge->add_key('parent_product_id');
		ci()->dbforge->create_table('related_products');		
	}
	
	// update 2.5.2
	private function update252()
	{

	}
	
	// update 2.5.1
	private function update251()
	{
		$this->update250();
	}
	
	// update 2.5.0
	private function update250()
	{
		$tables = ci()->db->list_tables();

		foreach ($tables as $table)
		{
			$result = ci()->db->query("SHOW COLUMNS FROM $table");
			$table = str_replace('ej_', '', $table);
			$fields = array();
			while ($row = mysql_fetch_assoc($result->result_id)) {
				
				if($row['Null'] == 'NO' and  ! $row['Default'] and $row["Key"] != "PRI")
				{
					$fields[$row['Field']] = array(
					'name' => $row['Field'],
					'type' => $row['Type'],
					);
					
					switch ($row['Type']) {
						case 'text':
							$fields[$row['Field']]['null'] = true;
							break;
						case 'date':
							$fields[$row['Field']]['default'] = '0000-00-00';
							break;
					
						default:
							$fields[$row['Field']]['default'] = '0';
							break;
					}
				}
			}
			ci()->dbforge->modify_column($table, $fields);
		}
	}

	// update 2.4.8
	private function update249()
	{
		ci()->dbforge->add_column('stores', array(
		'lead_time'			=> array('type' => 'int', 'constraint' => '1'),
		));
	}

	// update 2.4.8
	private function update248()
	{
		ci()->dbforge->add_column('products', array(
		'lead_time'			=> array('type' => 'char', 'constraint' => '3'),
		));
	}

	// update 2.4.7
	private function update247()
	{
		ci()->dbforge->add_column('stores', array(
		'minimum_amount'			=> array('type' => 'decimal', 'constraint' => array(19,2)),
		'delivery_fee'			=> array('type' => 'decimal', 'constraint' => array(19,2)),
		));
	}

	// update 2.4.5
	private function update245()
	{
		ci()->dbforge->add_column('stores', array(
		'delivery_zip'			=> array('type' => 'text'),
		));
	}

	// update 2.4.4
	private function update244()
	{
		ci()->dbforge->add_column('stores', array(
		'delivery_days'				=> array('type' => 'text'),
		'delivery_hours'			=> array('type' => 'text'),
		));
	}

	// update 2.4.3
	private function update243()
	{
		ci()->dbforge->add_column('stores', array(
		'store_anet_account'				=> array('type' => 'varchar', 'constraint' => '12'),
		));
	}

	// update 2.4.2
	private function update242()
	{
		ci()->dbforge->add_column('orders', array(
		'delivery_type'				=> array('type' => 'varchar', 'constraint' => '10'),
		));
	}

	// update 2.4.1
	private function update241()
	{
		ci()->dbforge->add_column('orders', array(
		'shipping_email'				=> array('type' => 'varchar', 'constraint' => '255'),
		));
	}

	// update 2.4.0
	private function update240()
	{
		ci()->db->query("
CREATE TABLE IF NOT EXISTS  `ej_sessions` (
	session_id varchar(40) DEFAULT '0' NOT NULL,
	ip_address varchar(45) DEFAULT '0' NOT NULL,
	user_agent varchar(120) NOT NULL,
	last_activity int(10) unsigned DEFAULT 0 NOT NULL,
	user_data text NOT NULL,
	PRIMARY KEY (session_id),
	KEY `last_activity_idx` (`last_activity`)
);		
		");
	}

	// update 2.3.9
	private function update239()
	{
		ci()->dbforge->drop_column('members', 'country');
	}

	// update 2.3.8
	private function update238()
	{
		ci()->dbforge->add_field(array(
		'production_site_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'name'				=> array('type' => 'char', 'constraint' => 50, 'null' => FALSE),
		'address'			=> array('type' => 'char', 'constraint' => 255, 'null' => FALSE),
		'production_group_id'	=> array('type' => 'int', 'constraint' => 3, 'null' => FALSE),
		));
		ci()->dbforge->add_key('production_site_id', TRUE);
		ci()->dbforge->add_key('production_group_id');
		ci()->dbforge->create_table('production_sites');

		//
		ci()->dbforge->add_field(array(
		'production_site_produced_product_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'production_product_id'			=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'production_site_id'			=> array('type' => 'int', 'constraint' => 10, 'null' => FALSE),
		));
		ci()->dbforge->add_key('production_site_produced_product_id', TRUE);
		ci()->dbforge->add_key('production_site_id');
		ci()->dbforge->create_table('production_sites_produced_products');
	}

	// update 2.3.7
	private function update237()
	{
		ci()->dbforge->add_field(array(
		'production_product_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'product_name'				=> array('type' => 'char', 'constraint' => 50, 'null' => FALSE),
		'production_product_type_id'	=> array('type' => 'int', 'constraint' => 10),
		'product_quantity'	=> array('type' => 'int', 'constraint' => 10),
		'size_in_oz'	=> array('type' => 'char', 'constraint' => 255),
		'weight_type'	=> array('type' => 'char', 'constraint' => 5),
		'ingredient_source'	=> array('type' => 'text'),
		));
		ci()->dbforge->add_key('production_product_id', TRUE);
		ci()->dbforge->add_key('production_product_type_id');
		ci()->dbforge->create_table('production_products');

		ci()->dbforge->add_field(array(
		'production_product_ingredient_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'production_product_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'production_ingredient_id'			=> array('type' => 'int', 'constraint' => 10, 'null' => FALSE),
		));
		ci()->dbforge->add_key('production_product_ingredient_id', TRUE);
		ci()->dbforge->add_key('production_product_id');
		ci()->dbforge->create_table('production_product_ingredients');
	}

	// update 2.3.6
	private function update236()
	{
		ci()->dbforge->add_field(array(
		'production_ingredient_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'ingredient_name'				=> array('type' => 'char', 'constraint' => 50, 'null' => FALSE),
		'ingredient_type'	=> array('type' => 'tinyint', 'constraint' => 1),
		'ingredient_form'	=> array('type' => 'tinyint', 'constraint' => 1),
		'ingredient_source'	=> array('type' => 'text'),
		));
		ci()->dbforge->add_key('production_ingredient_id', TRUE);
		ci()->dbforge->create_table('production_ingredients');
	}

	// update 2.3.5
	private function update235()
	{
		ci()->dbforge->add_field(array(
		'production_product_type_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'production_product_type_name'			=> array('type' => 'char', 'constraint' => 50, 'null' => FALSE),
		));
		ci()->dbforge->add_key('production_product_type_id', TRUE);
		ci()->dbforge->create_table('production_product_types');
	}

	// update 2.3.4
	private function update234()
	{
		ci()->dbforge->add_field(array(
		'production_store_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'store_id'			=> array('type' => 'int', 'constraint' => 10, 'null' => FALSE),
		'production_group_id'			=> array('type' => 'int', 'constraint' => 10, 'null' => FALSE),
		));
		ci()->dbforge->add_key('production_store_id', TRUE);
		ci()->dbforge->add_key('store_id');
		ci()->dbforge->add_key('production_group_id');
		ci()->dbforge->create_table('production_stores');
	}

	// update 2.3.3
	private function update233()
	{
		ci()->dbforge->add_field(array(
		'production_group_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'group_name'			=> array('type' => 'char', 'constraint' => 50, 'null' => FALSE),
		));
		ci()->dbforge->add_key('production_group_id', TRUE);
		ci()->dbforge->create_table('production_groups');
	}

	// update 2.3.2
	private function update232()
	{
		ci()->dbforge->add_column('members', array(
		'wholesale_enabled'		=> array('type' => 'char', 'constraint' => 1),
		'wholesale'				=> array('type' => 'char', 'constraint' => 1, 'default'=>'n')
		));
	}

	// update 2.3.1
	private function update231()
	{
		ci()->dbforge->add_column('products', array(
		'wholesale_price'				=> array('type' => 'decimal', 'constraint' => array(19,2)),
		'wholesale_only'				=> array('type' => 'char', 'constraint' => 1)
		));
	}

	// update 2.3.0
	private function update230()
	{
		ci()->dbforge->add_column('reoccuring_orders', array(
		'notes'				=> array('type' => 'TEXT'),
		));
	}

	// update 2.2.9
	private function update229()
	{
		ci()->dbforge->add_column('reoccuring_orders', array(
		'store'				=> array('type' => 'int', 'constraint' => 3),
		));
	}

	// update 2.2.8
	private function update228()
	{
		$fields = array(
		'store_state_id' => array(
		'name' => 'store_region',
		'type' => 'int',
		'constraint' => 1,
		),
		);
		ci()->dbforge->modify_column('reoccuring_orders', $fields);
	}

	// update 2.2.7
	private function update227()
	{
		ci()->dbforge->add_column('reoccuring_order_products', array(
		'delivery_type'				=> array('type' => 'varchar', 'constraint' => 15),
		));
	}

	// update 2.2.6
	private function update226()
	{
		ci()->dbforge->add_column('reoccuring_orders', array(
		'allergies'				=> array('type' => 'TEXT'),
		));

	}

	// update 2.2.5
	private function update225()
	{
		ci()->dbforge->add_column('reoccuring_orders', array(
		'ready_time' 	=> array('type' => 'varchar', 'constraint' => 5, 'default'=> ''),
		'store_state_id' 	=> array('type' => 'varchar', 'constraint' => 5, 'default'=> ''),
		));

	}

	// update 2.2.4
	private function update224()
	{
		ci()->dbforge->add_field(array(
		'card_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'member_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'card_num'				=> array('type' => 'char', 'constraint' => 20, 'null' => FALSE),
		'card_exp'				=> array('type' => 'char', 'constraint' => 5, 'null' => FALSE),
		'primary'				=> array('type' => 'char', 'constraint' => 1),
		));
		ci()->dbforge->add_key('card_id', TRUE);
		ci()->dbforge->add_key('member_id');
		ci()->dbforge->create_table('cards');

		ci()->dbforge->drop_column('reoccuring_orders', 'card_num');
		ci()->dbforge->drop_column('reoccuring_orders', 'card_exp');

		ci()->dbforge->add_column('reoccuring_orders', array(
		'card_id'		=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		));

	}

	// update 2.2.3
	private function update223()
	{
		ci()->dbforge->add_field(array(
		'reoccuring_order_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'member_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'address_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'card_num'					=> array('type' => 'char', 'constraint' => 20, 'null' => FALSE),
		'card_exp'					=> array('type' => 'char', 'constraint' => 5, 'null' => FALSE),
		'period'					=> array('type' => 'char', 'constraint' => 1),
		'week_day'					=> array('type' => 'char', 'constraint' => 1),
		'last_run'					=> array('type' => 'date'),
		'next_run'					=> array('type' => 'date'),
		'total'						=> array('type' => 'decimal', 'constraint' => array(19,2)),
		));
		ci()->dbforge->add_key('reoccuring_order_id', TRUE);
		ci()->dbforge->add_key('address_id');
		ci()->dbforge->add_key('member_id');
		ci()->dbforge->create_table('reoccuring_orders');

		ci()->dbforge->add_field(array(
		'id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'product_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'reoccuring_order_id'		=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'qty'						=> array('type' => 'tinyint', 'constraint' => 1),
		));
		ci()->dbforge->add_key('id', TRUE);
		ci()->dbforge->add_key('reoccuring_order_id');
		ci()->dbforge->create_table('reoccuring_order_products');

	}

	// update 2.2.2
	private function update222()
	{
		ci()->dbforge->add_field(array(
		'id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'coupon_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'member_id'					=> array('type' => 'int', 'constraint' => 10, 'null' => FALSE),
		'used_date'					=> array('type' => 'date'),
		));

		ci()->dbforge->add_key('id', TRUE);
		ci()->dbforge->add_key('coupon_id');
		ci()->dbforge->add_key('member_id');
		ci()->dbforge->create_table('used_coupons');

		ci()->dbforge->add_column('coupons', array(
		'use_type' 	=> array('type' => 'varchar', 'constraint' => '10'),
		'repeat_type' 	=> array('type' => 'varchar', 'constraint' => '1'),
		));
	}

	// update 2.2.1
	private function update221()
	{
		ci()->dbforge->add_column('orders', array(
		'coupon_code' 	=> array('type' => 'char', 'constraint' => 50),
		));
	}

	// update 2.2.0
	private function update220()
	{
		ci()->dbforge->add_column('coupons', array(
		'amount' 	=> array('type' => 'decimal', 'constraint' => array(19,2)),
		));
	}

	// update 2.1.9
	private function update219()
	{
		ci()->dbforge->add_field(array(
		'coupon_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'member_id'					=> array('type' => 'int', 'constraint' => 10, 'null' => FALSE),
		'valid_to'					=> array('type' => 'date'),
		'coupon_code'				=> array('type' => 'char', 'constraint' => 50 ),
		'used'						=> array('type' => 'char', 'constraint' => 1, 'default'=> 'N' ),
		));

		ci()->dbforge->add_key('coupon_id', TRUE);
		ci()->dbforge->add_key('member_id');
		ci()->dbforge->create_table('coupons');
	}

	// update 2.1.8
	private function update218()
	{
		$fields = array(
		'open_days' => array(
		'name' => 'open_days',
		'type' => 'char',
		'constraint' => 255,
		),
		);
		ci()->dbforge->modify_column('stores', $fields);
	}

	// update 2.1.7
	private function update217()
	{
		ci()->dbforge->add_column('stores', array(
		'open_hour' 	=> array('type' => 'char', 'constraint' => 2),
		'close_hour' 	=> array('type' => 'char', 'constraint' => 2),
		'open_days' 	=> array('type' => 'char', 'constraint' => 30),
		));
	}

	// update 2.1.6
	private function update216()
	{
		$fields = array(
		'ready_time' => array(
		'name' => 'ready_time',
		'type' => 'TEXT',
		),
		);
		ci()->dbforge->modify_column('orders', $fields);
	}

	// update 2.1.5
	private function update215()
	{
		ci()->dbforge->add_column('orders', array(
		'store_state_id' 	=> array('type' => 'int', 'constraint' => 1),
		));
	}

	// update 2.1.3
	private function update213()
	{
		ci()->dbforge->add_column('orders', array(
		'ready_time' 	=> array('type' => 'varchar', 'constraint' => 5, 'default'=> ''),
		'is_new' 		=> array('type' => 'varchar', 'constraint' => 1, 'default'=> 'y')
		));
	}

	// update 2.1.0
	private function update210()
	{

		$fields = array(
		'off_id'		=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'day'				=> array('type' => 'varchar', 'constraint' => 2, 'default'=> ''),
		'month'			=> array('type' => 'varchar', 'constraint' => 2, 'default'=> ''),
		'year'			=> array('type' => 'varchar', 'constraint' => 4, 'default'=> ''),
		'note'			=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
		);

		ci()->dbforge->add_field($fields);

		ci()->dbforge->add_key('off_id', TRUE);
		ci()->dbforge->add_key('day');
		ci()->dbforge->add_key('month');
		ci()->dbforge->add_key('year');
		ci()->dbforge->create_table('calendar_days_off');
	}

	// update 2.0.9
	private function update209()
	{
		$fields = array(
		'start_date' => array(
		'name' => 'start_date',
		'type' => 'TEXT',
		),
		);
		ci()->dbforge->modify_column('orders', $fields);
	}

	// update 2.0.8
	private function update208()
	{
		ci()->dbforge->add_column('products', array(
		'show_calendar' => array('type' => 'VARCHAR','constraint' => '1','default'=>'n')
		));
	}

	// update 2.0.7
	private function update207()
	{
		$fields = array(
		'order_status' => array(
		'name' => 'order_status',
		'type' => 'VARCHAR',
		'constraint' => '80'
		),
		);
		ci()->dbforge->modify_column('orders', $fields);
	}

	// update 2.0.6
	private function update206()
	{
		$fields = array(
		'allergy_id' => array(
		'name' => 'allergy_id',
		'type' => 'INT',
		'constraint' => '10',
		'unsigned' => TRUE,
		'auto_increment' => TRUE
		),
		);
		ci()->dbforge->modify_column('allergies', $fields);
	}
	// update 2.0.5
	private function update205()
	{
		$fields = array(
		'allergies_id' => array(
		'name' => 'allergy_id',
		'type' => 'INT',
		'constraint' => '10'
		),
		);
		ci()->dbforge->modify_column('allergies', $fields);
	}
	// update 2.0.4
	private function update204()
	{
		$fields = array(
		'allergies' => array(
		'name' => 'allergy',
		'type' => 'VARCHAR',
		'constraint' => '255'
		),
		);
		ci()->dbforge->modify_column('allergies', $fields);
		ci()->dbforge->drop_column('allergies', 'has_allergy');
	}

	// update 2.0.3
	private function update203()
	{
		ci()->dbforge->add_column('stores', array(
		'store_status' => array('type' => 'VARCHAR','constraint' => '10','default'=>'')
		));
	}

	// update 2.0.2
	private function update202()
	{

		$fields = array(
		'address_id'		=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'member_id'			=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'name'				=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
		'address1'			=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
		'address2'			=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
		'address3'			=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
		'region'			=> array('type' => 'varchar', 'constraint' => 255, 'default'=> ''),
		'postcode'			=> array('type' => 'varchar', 'constraint' => 10, 'default'=> ''),
		'primary'			=> array('type' => 'varchar', 'constraint' => 1, 'default'=> 'n'),
		);

		ci()->dbforge->add_field($fields);

		ci()->dbforge->add_key('address_id', TRUE);
		ci()->dbforge->add_key('member_id');
		ci()->dbforge->create_table('addresses');

		$members = ci()->db->get('members')->result_array();
		foreach ($members as $member)
		{
			$member = array_intersect_key($member, $fields);
			$member['primary'] = 'y';
			ci()->db->insert('addresses', $member);
		}
	}

	// update 2.0.1
	private function update201()
	{
		ci()->dbforge->add_column('orders', array(
		'client_allergies' 		=> array('type' => 'TEXT'),
		));
	}

	// update 2.0.0
	private function update200()
	{
		ci()->dbforge->add_field(array(
		'allergies_id'			=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'member_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'allergies'				=> array('type' => 'TEXT'),
		'has_allergy'		    => array('type' => 'CHAR', 'constraint' => 1, 'null' => FALSE),
		));

		ci()->dbforge->add_key('allergies_id', TRUE);
		ci()->dbforge->add_key('member_id');
		ci()->dbforge->create_table('allergies');
	}

	// update 1.0.9
	private function update119()
	{
		ci()->dbforge->add_column('orders', array(
		'items_names' 		=> array('type' => 'TEXT'),
		));
	}

	// update 1.0.7
	private function update117()
	{
		ci()->dbforge->add_column('orders', array(
		'store_id' 		=> array('type' => 'INT', 'constraint' => 1,	'null' => TRUE),
		'state_id' 		=> array('type' => 'INT', 'constraint' => 1,	'null' => TRUE)
		));
	}

	// update 1.1.6
	private function update116()
	{
		ci()->dbforge->add_column('products', array(
		'shipping_only' => array('type' => 'VARCHAR','constraint' => '1','default'=>'n')
		));

		ci()->dbforge->add_field(array(
		'shipping_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'product_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE),
		'state'					=> array('type' => 'int', 'constraint' => 1, 'null' => FALSE),
		));

		ci()->dbforge->add_key('shipping_id', TRUE);
		ci()->dbforge->add_key('product_id');
		ci()->dbforge->create_table('products_shipping');
	}

	// update 1.1.5
	private function update115()
	{
		ci()->dbforge->add_field(array(
		'store_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'state'					=> array('type' => 'int', 'constraint' => 1, 'null' => FALSE),
		'store_address'			=> array('type' => 'VARCHAR', 'constraint' => '100'),
		));

		ci()->dbforge->add_key('store_id', TRUE);
		ci()->dbforge->add_key('state');
		ci()->dbforge->create_table('stores');
	}

	// update 1.1.4
	private function update114()
	{
		ci()->dbforge->add_column('orders', array(
		'changeable' => array('type' => 'CHAR','constraint' => '1', 'default'=>'y'),
		));
	}

	// update 1.1.3
	private function update113()
	{
		ci()->dbforge->add_column('members', array(
		'company_name' => array('type' => 'VARCHAR','constraint' => '30'),
		));
		ci()->dbforge->add_column('order_history', array(
		'change_date' => array('type' => 'BIGINT','constraint' => '3'),
		));
	}

	// update 1.1.2
	private function update112()
	{
		ci()->dbforge->add_field(array(
		'tax_id'				=> array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
		'state'					=> array('type' => 'int', 'constraint' => 1, 'null' => FALSE),
		'ratio'					=> array('type' => 'float'),
		));

		ci()->dbforge->add_key('tax_id', TRUE);
		ci()->dbforge->add_key('state');
		ci()->dbforge->create_table('taxes');
	}

	// update 1.1.1
	private function update111()
	{
		ci()->dbforge->modify_column('groups', array(
		'group_name'			=> array('type' => 'VARCHAR', 'constraint' => '30'),
		));
		ci()->dbforge->modify_column('groups', array(
		'group_type'			=> array('type' => 'INT', 'constraint' => 1,	'null' => TRUE),
		));
	}

	// update 1.0.8
	private function update108()
	{
		ci()->dbforge->add_column('products', array(
		'order_online' => array('type' => 'VARCHAR','constraint' => '1','default'=>'n')
		));
	}

	// update 1.0.7
	private function update107()
	{
		ci()->dbforge->add_column('orders', array(
		'notes' 			=> array('type' => 'TEXT')
		));
	}

	// update 1.0.6
	private function update106()
	{
		ci()->dbforge->add_column('orders', array(
		'transaction_id' 			=> array('type' => 'BIGINT', 'constraint' => 1,	'null' => TRUE)
		));
	}

	// update 1.0.5
	private function update105()
	{
		ci()->dbforge->modify_column('products', array(
		'regular_price'			=> array('type' => 'decimal', 'constraint' => array('19,2'), 'null' => FALSE),
		));
	}

	// update 1.0.4
	private function update104()
	{
		ci()->dbforge->add_column('products', array(
		'product_nutrition' 			=> array('type' => 'TEXT')
		));
	}

	// update 1.0.3
	private function update103()
	{
		ci()->dbforge->add_column('products', array(
		'cat_id' 			=> array('type' => 'INT', 'constraint' => 1,	'null' => TRUE)
		));
	}

	// update 1.0.2
	private function update102()
	{
		ci()->dbforge->add_column('products', array(
		'product_title' => array('type' => 'VARCHAR','constraint' => '255'),
		'product_description' => array('type' => 'TEXT'),
		'product_ingredients' => array('type' => 'TEXT'),
		));
	}

	// update 1.0.1
	private function update101()
	{
		ci()->dbforge->add_column('products', array(
		'image' => array('type' => 'VARCHAR','constraint' => '255')
		));
	}

}

/* End of file db_lib.php */