<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'] 	= array(
                                 'class'    => 'Post_loader',
                                 'function' => 'load_models',
                                 'filename' => 'Post_loader.php',
                                 'filepath' => 'hooks',
                                 'params'   => array()
                                 );

$hook['pre_controller'] = array(
                                 'class'    => 'Core_loader',
                                 'function' => 'index',
                                 'filename' => 'Core_loader.php',
                                 'filepath' => 'hooks',
                                 'params'   => array()
                                 );

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */