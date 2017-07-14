<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Saya\PubTemplate as Temp;

class Public_home extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('load');
		Saya\Session::close();
		//Saya\Session::ci2();
	}
	public function index()
	{
		redirect(base_url('login')); 
		
	}
	
}
