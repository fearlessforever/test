<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha extends CI_Controller {
	function __construct(){
		parent::__construct(); 
		$this->load->helper('load');
		Saya\Session::ci2();
	}
	
	public function index()
	{
		$this->umum();
		
	}
	public function login(){ 
		$alphaNumeric  = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		$random = substr(str_shuffle($alphaNumeric), 0, 5);
		$image = imagecreatefromjpeg("assets/background-captcha.jpg");
		$textColor = imagecolorallocate ($image, 0, 0, 0); //black
		imagestring ($image, 5, 5, 8,  $random, $textColor); 
		
		$data_login=array(
				'hel_system_login'=>md5(md5($random.'hel'.KODE))
				);
		$this->session->set_userdata($data_login); 
		
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false); 
		header("Pragma: no-cache"); 	
		header('Content-type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
	private function umum(){
		$alphaNumeric  = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		$random = substr(str_shuffle($alphaNumeric), 0, 5);
		$image = imagecreatefromjpeg("assets/background-captcha.jpg");
		$textColor = imagecolorallocate ($image, 0, 0, 0); //black
		imagestring ($image, 5, 5, 8,  $random, $textColor); 
		$codex="hel".$random."fearless";
		$data_login=array(
				'image_random_value'=>md5(base64_encode(md5($codex)))
				);
		$this->session->set_userdata($data_login);
		 
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false); 
		header("Pragma: no-cache"); 	
		header('Content-type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
	public function keamanan(){
		$alphaNumeric  = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		$random = substr(str_shuffle($alphaNumeric), 0, 5);
		$image = imagecreatefromjpeg("assets/background-captcha.jpg");
		$textColor = imagecolorallocate ($image, 0, 0, 0); //black
		imagestring ($image, 5, 5, 8,  $random, $textColor); 
		$codex="helmi".$random."fearless";
		$data_login=array(
				'image_keamanan'=>md5(base64_encode(md5($codex)))
				);
		$this->session->set_userdata($data_login);
		 
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false); 
		header("Pragma: no-cache"); 	
		header('Content-type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
}

/* End of file adminpanel.php */
/* Location: ./application/controllers/adminpanel.php */