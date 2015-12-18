<?php

class Post_loader {
	
	public function load_models()
	{
		$this->_load_models($GLOBALS['CI']);
	}
	
	public function _load_models(&$CI)
	{
		$CI->_model =& ci()->_model;
	}
}
/* End of file Post_loader.php */
/* Location: ./application/hooks/Post_loader.php */