<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings {
	var $_view_base;

	public function __construct()
	{
//		if($_SERVER['SERVER_PORT'] != 443)
//		{
//			$url = "https://$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]";
//			redirect($url);
//		}


		$this->_view_base = '/'.ci()->current_dir.ci()->current_class.'/';
		
		// default global view variables
		$vars = array(
			'table_template' => array(
				'table_open'		=> '<table class="main_table" border="0" cellspacing="0" cellpadding="0">',
				'row_start'			=> '<tr class="even">',
				'row_alt_start'		=> '<tr class="odd">'
			),
		);	
		$vars = $vars + ci()->system_settings;
		
		ci()->load->helper(array('form', 'html'));
		ci()->load->library(array('table', 'javascript'));
		
		ci()->javascript->output(ci()->load->view($this->_view_base.'javascript/anet.js', '', true));
		ci()->load->vars($vars);	
	}

	public function index()
	{
		$vars['action'] = ci()->input->get_post('type');
		ci()->page_title(lang($vars['action']), lang($vars['action']));
		if( ! empty($_POST))
		{
			$post = ci()->input->post();
			unset($post['submit']);
			if (isset($post['api'])) 
			{
				unset(ci()->system_settings['api']);
			}
			
			ci()->system_settings = $post+ci()->system_settings;
//			unset(ci()->system_settings['api']);
			ci()->system_model->save_settings();
			notice(lang('settings_updated'));
			redirect('/admin/settings/?type='.$vars['action']);
		}
		ci()->load->view($this->_view_base.'settings', $vars);
	}	
		
	public function general()
	{
		ci()->page_title(lang('general_settings'), lang('general_settings'));
		$vars['action'] = 'general';
		if( ! empty($_POST))
		{
			ci()->system_settings['taxes_ratio'] = ci()->input->get_post('taxes_ratio');
			ci()->system_settings['shipping_tax'] = ci()->input->get_post('shipping_tax');
			ci()->system_model->save_settings();
			notice(lang('settings_updated'));
			redirect('/admin/settings/general');
		}
		ci()->load->view($this->_view_base.'general', $vars);
	}
		
	public function authorizenet()
	{
		ci()->page_title(lang('authorize.net'), lang('authorize.net'));
		$vars['action'] = 'authorizenet';
		if( ! empty($_POST))
		{
			$uniq = ci()->input->get_post('uniq');
			ci()->system_settings['api'][$uniq]['api_name'] = ci()->input->get_post('api_name');
			ci()->system_settings['api'][$uniq]['api_login_id'] = ci()->input->get_post('api_login_id');
			ci()->system_settings['api'][$uniq]['transaction_key'] = ci()->input->get_post('transaction_key');
			ci()->system_model->save_settings();
			notice(lang('settings_updated'));
			redirect('/admin/settings/'.$vars['action']);
		}
		ci()->load->view($this->_view_base.'authorizenet', $vars);
	}
}

function array_join() 
 { 
     // Get array arguments 
     $arrays = func_get_args(); 

     // Define the original array 
     $original = array_shift($arrays); 

     // Loop through arrays 
     foreach ($arrays as $array) 
     { 
         // Loop through array key/value pairs 
         foreach ($array as $key => $value) 
         { 
             // Value is an array 
             if (is_array($value)) 
             { 
                 // Traverse the array; replace or add result to original array 
                 $original[$key] = array_join($original[$key], $array[$key]); 
             } 

             // Value is not an array 
             else 
             { 
                 // Replace or add current value to original array 
                 $original[$key] = $value; 
             } 
         } 
     } 

     // Return the joined array 
     return $original; 
 }
/* End of file Settings.php */
/* Location: ./application/controllers/admin/Settings.php */