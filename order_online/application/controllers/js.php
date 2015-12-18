<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Js {
	public function __construct()
	{
		
	}
	
	public function load()
	{
		ci()->config->load('javascript');
		$js_location = rtrim(DOCUMENT_ROOT . ci()->config->item('javascript_location'), '/').'/';
		$js_files = explode(",", ci()->input->get('js'));
		header("Content-type: application/javascript");
		if($js_files)
		{
			foreach ($js_files as $js_file) 
			{
				$f = $js_location . $js_file . '.js';
				if(is_file($f))
				{
					echo file_get_contents($f);
				}
			}
		}
		exit;
	}	
}
/* End of file js.php */
/* Location: ./application/controllers/js.php */