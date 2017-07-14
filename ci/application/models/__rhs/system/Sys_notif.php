<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

use Saya\Notif ;

class Sys_notif extends CI_Model {
	static $_hasil= array('error'=>'Mode Not Found');
	function __construct() {
		parent::__construct();
	}
	
	public function run(){
		$check = $this->input->is_ajax_request();
		if($check){
			$mode = $this->input->post('mode');
			switch($mode){
				case 'get-notif': 
					self::$_hasil = Notif::get( 5 , Model\User::$data['id_user'] ) ; 
					break;
				case 'check-notif': 
					$a = isset( Model\User::$data['extra']['last_seen_notif'] ) ? Model\User::$data['extra']['last_seen_notif'] : 0;
					self::$_hasil = Notif::check( $a ) ;
					//self::$_hasil[]='{memory_usage}';
					break;
				default: break;
			}
			Saya\Template::view_json( self::$_hasil ,TRUE);
			return true;
		}show_404();
	}
	
}