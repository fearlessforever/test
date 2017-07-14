<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Saya\DB ;
class Status extends CI_Controller { 
	function __construct(){
		parent::__construct(); 
		$this->load->helper('load');
		Saya\Session::close();
	}
	public function pfftt(){
		///$this->load->model('m_database','zzzzz',true);
		//$this->zzzzz->statistik();
		DB::koneksi();
		DB::insert("INSERT INTO ". KODE ."statistiks  VALUES (:ip, CURRENT_DATE() ,1,UNIX_TIMESTAMP() ) ON DUPLICATE KEY UPDATE mengunjungi=mengunjungi+1 , online=UNIX_TIMESTAMP() ", ['ip' => $this->input->ip_address()  ] );
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false); 
		header("Pragma: no-cache"); 	
		header('Content-type: image/jpeg');
		$im = @imagecreate(1, 1); imagejpeg($im); imagedestroy($im);
	}
	
	public function get()
	{
		$this->output->cache(1);
		DB::koneksi();
		Saya\Template::view_json(
			DB::select("
				SELECT SUM(mengunjungi) as hasil FROM ".KODE."statistiks UNION ALL
				SELECT COUNT(1) FROM ".KODE."statistiks UNION ALL
				SELECT SUM(mengunjungi) FROM ".KODE."statistiks WHERE tanggal=CURRENT_DATE() UNION ALL
				SELECT COUNT(2) FROM ".KODE."statistiks WHERE tanggal=CURRENT_DATE() UNION ALL
				SELECT COUNT(3) FROM ".KODE."statistiks WHERE online > ( UNIX_TIMESTAMP() - 3600 )
			")
		);
	}
}
