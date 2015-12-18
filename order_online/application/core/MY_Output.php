<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Output extends CI_Output {

	// --------------------------------------------------------------------

	/**
	 * Send AJAX response
	 *
	 * Outputs and exits content, makes sure profiler is disabled
	 * and sends 500 status header on error
	 *
	 * @access	public
	 * @param	string
	 * @param	bool	whether or not the response is an error
	 * @return	void
	 */
	function send_ajax_response($msg, $error = FALSE)
	{
		@header('Content-Type: application/json');
		
		ci()->load->library('javascript');
		exit(ci()->javascript->generate_json($msg, TRUE));
	}
	
	function print_js($js)
	{
		echo "<script type='text/javascript'>$js</script>";
	}
	// --------------------------------------------------------------------
}
// END CLASS

/* End of file MY_Output.php */
/* Location: ./application/core/MY_Output.php */