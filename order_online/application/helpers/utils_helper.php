<?php
if ( ! defined('NBS'))
{
	define('NBS', "&nbsp;");
}

if ( ! function_exists('ci'))
{
	function ci()
	{
		$ci =& get_instance();
		return $ci;
	}
}


if ( ! function_exists('notice'))
{
	function notice($mes, $is_error=false)
	{
		if( ! $is_error)
		ci()->session->set_flashdata('notice', $mes);
		else
		ci()->session->set_flashdata('error', $mes);
	}
}

if ( ! function_exists('my_img_resize'))
{
	function my_img_resize($config)
	{
		ci()->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['create_thumb'] = TRUE;
		$config['quality'] = '100%';

		$marker = "_thumb".@$config['width'].@$config['height'];
		$thumb = preg_replace("!\.([^/]+?)$!", $marker.".\$1", $config['source_image']);
		if( ! file_exists($thumb))
		{
			$config['thumb_marker'] = $marker;
			$list=getimagesize($config['source_image']);
			$width=$list[0];
			$height=$list[1];
			if( ! isset($config['width']) or ! isset($config['height']))
			{
				$ratio = $width/$height;

				if(! isset($config['width']))
				$config['width'] = $config['height']*$ratio;
				else
				$config['height'] = $config['width']*$ratio;
			}
			ci()->image_lib->clear();
			ci()->image_lib->initialize($config);
			if( ! ci()->image_lib->resize())
			echo ci()->image_lib->display_errors();
		}
		return substr($thumb,strlen(DOCUMENT_ROOT)-1);
	}
}

if ( ! function_exists('myd'))
{
	function myd($arr,$exit=false)
	{
		if (isset($GLOBALS['debugifon']) and !isset($_REQUEST['debug'])) {
			return ;
		}
		if (is_array($arr)) {
			echo "<pre>";
			print_r($arr);
			echo "</pre>";
		} elseif (is_string($arr)) {
			echo $arr."<br>";
		} elseif (is_object($arr)) {
			echo "<pre>";
			var_export($arr)."<br>";
			echo "</pre>";
		} else {
			echo ($arr)."<br>";
		}

		if ($exit) exit;
	}
}

if ( ! function_exists('hours_arr'))
{
	function hours_arr()
	{
		$hoursam = $hourspm = array();

		for ($i=1;$i<=12;$i++)
		{
			if($i>6)
			{
				$hoursam[$i] = $i.'am';
			}
			if($i<9)
			{
				$hourspm[$i+12] = $i.'pm';
			}
		}
		$hours = $hoursam + $hourspm;
		
		return $hours;
	}
}

if ( ! function_exists('week_days'))
{
	function week_days()
	{
		$w = array('Mon'=>'Mon', 'Tue'=>'Tue', 'Wed'=>'Wed', 'Thu'=>'Thu', 'Fri'=>'Fri', 'Sat'=>'Sat', 'Sun'=>'Sun');
		
		return $w;
	}
}

if ( ! function_exists('prep_select'))
{
	function prep_select($arr, $key_field='', $title_field)
	{
		$ret = array();
		if($arr)
		{
			foreach ($arr as $key => $row)
			{
				if($key_field)
				$ret[$row[$key_field]] = $row[$title_field];
				else
				$ret[$key] = $row[$title_field];
			}
		}
		
		return $ret;
	}
}
/* End of file Utils_helper.php */
/* Location: ./application/helpers/Utils_helper.php */