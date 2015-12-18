<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taxes_model extends Db_lib {
	public function __construct()
	{
		parent::__construct();
		$this->table = 'taxes';
	}
	
	public function get_state($region)
	{
		$states = $this->get_states();
		return @$states[$region];
	}
	
	public function get_stores_states()
	{
		ci()->load->model('admin/stores_model');
		$states = $this->get_states();
		$stores = $this->stores_model->get();
		foreach ($stores as $store) 
		{
			$state_ids[$store['state']] = 1;
		}
		return array_intersect_key($states, $state_ids);
	}
	
	public function get_state_by_id($state_id)
	{
		$states = $this->get_states();
		if(isset($states[$state_id]))
			return $states[$state_id];
	}
	
	public function get_states()
	{
		$states = '
<select name="zone_id"><option selected="" value="">Please Select</option><option value="1">Alabama</option><option value="2">Alaska</option><option value="3">American Samoa</option><option value="4">Arizona</option><option value="5">Arkansas</option><option value="6">Armed Forces Africa</option><option value="7">Armed Forces Americas</option><option value="8">Armed Forces Canada</option><option value="9">Armed Forces Europe</option><option value="10">Armed Forces Middle East</option><option value="11">Armed Forces Pacific</option><option value="12">California</option><option value="13">Colorado</option><option value="14">Connecticut</option><option value="15">Delaware</option><option value="16">District of Columbia</option><option value="17">Federated States Of Micronesia</option><option value="18">Florida</option><option value="19">Georgia</option><option value="20">Guam</option><option value="21">Hawaii</option><option value="22">Idaho</option><option value="23">Illinois</option><option value="24">Indiana</option><option value="25">Iowa</option><option value="26">Kansas</option><option value="27">Kentucky</option><option value="28">Louisiana</option><option value="29">Maine</option><option value="30">Marshall Islands</option><option value="31">Maryland</option><option value="32">Massachusetts</option><option value="33">Michigan</option><option value="34">Minnesota</option><option value="35">Mississippi</option><option value="36">Missouri</option><option value="37">Montana</option><option value="38">Nebraska</option><option value="39">Nevada</option><option value="40">New Hampshire</option><option value="41">New Jersey</option><option value="42">New Mexico</option><option value="43">New York</option><option value="44">North Carolina</option><option value="45">North Dakota</option><option value="46">Northern Mariana Islands</option><option value="47">Ohio</option><option value="48">Oklahoma</option><option value="49">Oregon</option><option value="50">Palau</option><option value="51">Pennsylvania</option><option value="52">Puerto Rico</option><option value="53">Rhode Island</option><option value="54">South Carolina</option><option value="55">South Dakota</option><option value="56">Tennessee</option><option value="57">Texas</option><option value="58">Utah</option><option value="59">Vermont</option><option value="60">Virgin Islands</option><option value="61">Virginia</option><option value="62">Washington</option><option value="63">West Virginia</option><option value="64">Wisconsin</option><option value="65">Wyoming</option></select>';
		preg_match_all('!<option value="(\d+)">(.*?)</option>!', $states, $m);
		foreach ($m[1] as $k => $v) 
		{
			$states_arr[$v] = $m[2][$k];
		}
		
		return $states_arr;
	}
	
	public function get_tax($state='')
	{
		if( ! $state)
		{
			$session = ci()->session->userdata('user');
			$state = $session['region'];
		}
		$taxes = $this->get_row(array('state'=>$state));
		return $taxes ? $taxes['ratio'] : 0;
	}
}
// END Taxes_model class

/* End of file Taxes_model.php */
/* location models/admin/Taxes_model.php */