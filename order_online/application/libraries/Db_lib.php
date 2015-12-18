<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! class_exists('CI_Model'))
{
	load_class('Model', 'core');
}

if( ! function_exists('ci'))
{
	function ci()
	{
		return get_instance();
	}
}

class Db_lib extends CI_Model {
	public  $table;
	public  $Db_lib_version = '1.23';
	public  $field_defaults;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_field_defaults();
	}
	
	private function set_field_defaults()
	{
		$this->field_defaults = array(
			'char' => '',
			'varchar' => '',
			'int' => 0,
			'bigint' => 0,
			'tinyint' => 0,
			'smallint' => 0,
			'decimal' => 0.00,
			'float' => 0.00,
		);
	}
	
	public function debug()
	{
		return  $this->db->_compile_select();
	}
	
	public function get($options=array(), $table='', $type='result', $protect=true)
	{
		// we can also pass all as one array
		@extract($options);
		
		// if options is a number then we want get by primary key
		if(is_numeric($options))
		{
			$table = $table ? $table : $this->table;
			$primary = $this->get_primary_field($table);
			$where = array($primary=>$options);
			$options = array();
			$options['where'] = $where;
		}

		// for older version
		if( ! is_array($options) and $options and is_array($table))
		{
			list($table, $options) = array($options, $table);
		}
		
		$type = $type ? $type : 'result';
		$func = "{$type}_array";
		////////////////////////////////////////		
		$table = $table ? $table : $this->table;
		
		$option_match = false;
		if(isset($options['from']))
		{
			$table = $options['from'];
			$option_match = true;
		}		
		
		$this->db->from($table);

		
		if(isset($options['select']))
		{
			$this->db->select($options['select']);
			$option_match = true;
		}		
		
		if(isset($options['where']))
		{
			$this->db->where($options['where'], null, $protect);
			$option_match = true;
		}
		
		if(isset($options['join']))
		{
			
			if(is_array($options) and ! isset($options['join']['table']))
			{
				foreach ($options['join'] as $join) 
				{
					$this->db->join($join['table'], $join['cond'], @$join['type']);
				}
			}
			elseif(is_array($options)) 
			{
				$this->db->join($options['join']['table'], $options['join']['cond'], @$options['join']['type']);
			}
			$option_match = true;
		}
		
		if(isset($options['or_where']))
		{
			$this->db->or_where($options['or_where']);
			$option_match = true;
		}
		
		if(isset($options['custom']))
		{
			$this->db->where($options['custom']);
			$option_match = true;
		}		

		
		if(isset($options['where_in']))
		{
			$this->db->where_in(key($options['where_in']),current($options['where_in']));
			$option_match = true;
		}
		
		if(isset($options['where_not_in']))
		{
			$this->db->where_not_in(key($options['where_not_in']),current($options['where_not_in']));
			$option_match = true;
		}
		
		if(isset($options['group_by']))
		{
			$this->db->group_by($options['group_by']);
			$option_match = true;
		}
				
		if(isset($options['count']))
		{
			return $this->db->count_all_results();
		}
		
		if(isset($options['max']))
		{
			return $this->db->select_max($options['max'])->get()->row($options['max']);
		}	
			
		if(isset($options['order_by']) and $options['order_by'])
		{
			$this->db->order_by($options['order_by'], @$options['dir']);
			$option_match = true;
		}	
			
		if(isset($options['limit']))
		{
			$this->db->limit($options['limit'], @$options['offset']);
			$option_match = true;
		}
		
		if(isset($colomn)) $option_match = true;
		
		// if no options match we use most common option
		if($options and ! $option_match)
		{
			$this->db->where($options, null, $protect);
		}
		
		if(isset($options['debug']))
		{
			if($options['debug'] == '1')
			echo $this->debug();
			else
			file_put_contents('sql_debug.txt', $this->debug()."\n\n", FILE_APPEND);
		}
		
		$res = $this->db->get()->$func(@$colomn);
//		if($this->table == 'transactions'){myd($res);}
		if(isset($colomn))
		{
			if($type == 'result' and $res)
			{
				return $res[0][$colomn];
			}
			elseif($res)
			{
				return $res[$colomn];
			}
		}
		return $res;
	}
		
	public function get_row($options=array(), $table='')
	{
		return $this->get($options, $table, 'row');
	}
	
	public function delete($where=array(), $table='')
	{
		if(is_array($table))
		{
			list($table,$where) = array($where, $table);
		}			
		$table = $table ? $table : $this->table;
		if($where)
		return $this->db->where($where)->delete($table);
	}
	
	public function save($data, $where=array(), $table='', $exclude=array())
	{
		if( $where and ! is_array($where) and $this->table_exists($where))
		{
			$table_ = $where;
			$table = $where;
			$where = $table_;
		}
		
		$table = $table ? $table : $this->table;
		$primary_key = $this->_get_primary_key($table);		

		if( ! is_array($where) )
			$where = array($primary_key => $where);
		
		if(isset($data[$primary_key]) and $data[$primary_key])
		{
			$where[$primary_key] = $data[$primary_key];
			$copy_primary_key = $data[$primary_key];
			unset($data[$primary_key]);
		}
		elseif (isset($data[$primary_key]) and ! $data[$primary_key])
		{
			$copy_primary_key = $data[$primary_key];
			unset($data[$primary_key]);
		}
		
		$fields = array_flip($this->db->list_fields($table));
		$data = @array_intersect_key($data, $fields);
		
		
		
		if($where and ($row=$this->get_row($where, $table)))
		{
			foreach ($exclude as $ex)
			{
				if (isset($data[$ex])) 
				{
					unset($data[$ex]);
				}
			}
			$this->update($table, $where, $data);
			return $row[$primary_key];
		}
		else 
		{
			if(@$copy_primary_key)
			$data[$primary_key] = $copy_primary_key;
			$this->insert($table, $data);
			return $this->db->insert_id();
		}
	}
	
	private function set_defaults($data, $table)
	{
		$table = $this->db->dbprefix($table);
		foreach ($this->db->field_data($table) as $row)
		{
			$row = (array)$row;
			$fields[$row['name']] = $row['type'];
		}

		foreach ($data as $k => $v)
		{
			if( ! $v and isset($this->field_defaults[$fields[$k]]))
			{
				$data[$k] = $this->field_defaults[$fields[$k]];
			}
		}

		return $data;
	}
	
	public function insert($table, $data=array(), $batch=false)
	{
		if(func_num_args() == 1)
		{
			$data = $table;
			$table = '';
		}
		
		if(is_array($table))
		{
			list($table, $data) = array($options, $data);
		}		
		$table = $table ? $table : $this->table;
		$insert_func = $batch ? 'insert_batch' : 'insert';
		
		$data = $this->set_defaults($data, $table);
		$this->db->$insert_func($table, $data);
		return $this->db->insert_id();
	}
	
	public function update($table='', $where=array(), $data=array())
	{

		if(is_array($table))
		{
			list($table, $data) = array($data, $table);
			$table = '';
		}

		if( ! $data) return ;
		$table = $table ? $table : $this->table;
		$data = $this->set_defaults($data, $table);
		$this->db->where($where)->update($table, $data);
	}
	
	public function _get_primary_key($table)
	{
		$fields = $this->db->field_data($table);
		foreach ($fields as $f) 
		{
			if($f->primary_key)
				return $f->name;
		}
	}
	
	public function get_tables()
	{
		$tables = $this->db->list_tables();
		foreach ($tables as $t) 
		{
			$ret[$t] = $t;
		}
		
		return $ret;
	}

	public function __call($func, $arg=array())
	{
		if(strstr($func, '_get_by_'))
		{
			preg_match("!(.*?)_get_by_(.*)!", $func, $m);
			
			if($this->table_exists($m[1]))
			{
				$options['where'][$m[2]] = $arg[0];
				$data = $this->get_row($options, $m[1]);
				return @$data;
			}			
		}
		elseif(strstr($func, '_by_'))
		{
			preg_match("!(.*?)_get_(.*)_by_(.*)!", $func, $m);
			
			if(@$this->table_exists($m[1]))
			{
				if(isset($arg[1]))
				$options = $arg[1];
				$options['where'][$m[3]] = $arg[0];
				$data = $this->get_row($options, $m[1]);
				return @$data[$m[2]];
			}	
			elseif ($this->get_table() and preg_match("!get_(.*)_by_(.*)!", $func, $m))
			{
				if(isset($arg[1]))
				$options = $arg[1];
				$options['where'][$m[2]] = $arg[0];
				$data = $this->get_row($options);
				return @$data[$m[1]];				
			}
			elseif ($this->get_table() and preg_match("!get_by_id!", $func, $m))
			{
				if(isset($arg[1]))
				$options = $arg[1];
				$idf = $this->get_primary_field($this->get_table());
				$options['where'][$idf] = $arg[0];
				$data = $this->get_row($options);
				return @$data;				
			}
		}
		elseif(strstr($func, 'get_'))
		{
			preg_match("!get_(.*)!", $func, $m);
			if($this->table_exists($m[1]))
			{
				return $this->get(@$arg[0], $m[1]);
			}
			elseif($this->field_exists($m[1]))
			{
				if(isset($arg[1]))
				$options = $arg[1];
				$options['where'][$this->get_primary_field()] = $arg[0];
				$data = $this->get_row($options);
				return @$data[$m[1]];				
			}
		}
		elseif(strstr($func, 'format_'))
		{
			preg_match("!format_(.*)!", $func, $m);
			return $this->format(@$arg[0], @$arg[1], @$arg[2], $m[1], @$arg[4]);
		}
		else 
		{
			throw new Exception("Function $arg[0] not found in ". __FILE__. " on line".__LINE__);
		}
	}	
	
	public function table_exists($table)
	{
		return $this->db->table_exists($table);
	}	
	
	public function create_unique_index($table_name, $col_names)
	{
		$table_name = $this->db->protect_identifiers($table_name, TRUE);

		if (is_array($col_names))
		{
			$index_name = implode('_', $col_names);
			foreach ($col_names as $key => $col)
			{
				$col_names[$key] = $this->db->protect_identifiers($col);
			}
			$col_names = implode(',', $col_names);
		}
		else
		{
			$index_name = $col_names;
			$col_names = $this->db->protect_identifiers($col_names);
		}

		$sql = "CREATE UNIQUE INDEX ";
		$sql .= "$index_name ON $table_name ($col_names)";
		return $this->db->query($sql);		
	}
	
	public function field_exists($field_name, $table='')
	{
		$table = $table ? $table : $this->table;
		$fields = $this->db->field_data($table);
		foreach ($fields as $f) 
		{
			if($f->name == $field_name) return true;
		}		
	}
	
	public function get_primary_field($table='')
	{
		$table = $table ? $table : $this->table;
		$fields = $this->db->field_data($table);
		foreach ($fields as $f) 
		{
			if($f->primary_key) return $f->name;
		}
	}
	
	/**
	 * Usually use for select dropdown
	 *
	 * @param string $val_field = field_naem
	 * @param array $options for query
	 * @param string $key_field if need different key then primary 
	 * @param string $table
	 * @param array $default - init values 
	 * @return array in format field_id => field_name
	 */
	public function format($val_field, $options=array(), $key_field='', $table='', $default=array())
	{
		$table = $table ? $table : $this->table;

		$key_field = $key_field ? $key_field : $this->get_primary_field($table);
		$data = $this->get($options, $table);
		$ret = isset($options['default_value']) ? $options['default_value'] : $default;

		foreach ($data as $k => $row) 
		{
			$ret[$row[$key_field]] = $row[$val_field];
		}
		
		return $ret;
	}	
	
	public function set_table($table)
	{
		$this->table = $table;
	}
	
	public function get_table()
	{
		return $this->table;
	}
}

/* End of file db_lib.php */