<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed');

use Saya\Template as Temp;
class Dashboard extends CI_Model {
	static $_hasil= array('error'=>'Mode Not Found');
	function __construct() {
		parent::__construct();
		//$this->load->helper('validasi');
	}
	
	public function run(){
		$check = $this->input->is_ajax_request();
		if($check){
			//header('Content-Type:application/json');
			$mode = $this->input->post('mode');
			switch($mode){
				case 'view': Temp::view_json( array('{memory_usage}' ) , TRUE);
					//self::__view(); 
					break;
				default: break;
			}
			//echo json_js_array(json_encode(self::$_hasil));
			return true;
		}show_404();
	}
	
	private function __view(){
		$hasil = '';
		$core = $this->db->query("
			SELECT 
				SUM( if(a.tipe =0 , a.total_h , 0) ) as pendapatan , SUM( if(a.tipe !=0 , a.total_h , 0) ) as pengeluaran,
				SUM( if(a.tipe =0 , 1 , 0) ) as trans_pendapatan , SUM( if(a.tipe !=0 , 1 , 0) ) as trans_pengeluaran
			FROM ".DB_KODE."transaksi a  
			WHERE MONTH(a.tanggal ) = MONTH( CURRENT_DATE() )
			LIMIT 1" )->row_array();
		if(isset($core['pendapatan']) && is_array($core) ){
			$hasil['bulan_ini']=$core;
		}
		$core = $this->db->query(
			"SELECT 'barang' as header,count(1) as jml FROM ".DB_KODE."data_barang
			UNION ALL SELECT 'supplier',count(1) FROM ".DB_KODE."data_supplier
			UNION ALL SELECT 'tipe',count(1) FROM ".DB_KODE."data_tipe
			"
			)->result_array();
		if(isset($core[0]) && is_array($core) ){
			$hasil['info']=array(
				'barang' => isset($core[0]['jml']) ? $core[0]['jml'] : 0
				,'supplier' => isset($core[1]['jml']) ? $core[1]['jml'] : 0
				,'tipe' => isset($core[2]['jml']) ? $core[2]['jml'] : 0
			);
		}
		$core = $this->db->query("
			SELECT id_transaksi as nota,tanggal,DATE_FORMAT(waktu, '%d %M %Y ~%H:%i') as waktu_e,tipe,total_h FROM ".DB_KODE."transaksi ORDER BY waktu DESC LIMIT 5
		")->result_array();
		if(isset($core[0]) && is_array($core) ){
			$hasil['latest']= $core;
		}
			/*
			SELECT a.tanggal,a.id_barang as code , SUM( if(a.tipe = 0,a.jumlah,0) ) as pendapatan, SUM( if(a.tipe != 0,a.jumlah,0) ) as pengeluaran
			FROM ".DB_KODE."transaksi_detail a 
			WHERE YEARWEEK(a.tanggal, 1) = YEARWEEK(CURDATE(), 1) 
			GROUP BY a.id_barang
			*/
		$core =$this->db->query("
			SELECT aa.*,bb.nama_barang as nama FROM (
			SELECT a.tanggal,a.id_barang as code , a.jumlah as pendapatan 
			FROM ".DB_KODE."transaksi_detail a 
			WHERE YEARWEEK(a.tanggal, 1) = YEARWEEK(CURDATE(), 1) AND a.tipe=0 
			ORDER BY a.tanggal DESC LIMIT 1000
			) aa LEFT JOIN ".DB_KODE."data_barang bb ON aa.code=bb.id_barang
		")->result_array();
		if(isset($core[0]) && is_array($core) ){
			$_label = array(); $_ykey =array(); $_ykey_c =array(); $_tanggal_c =array(); $_baru=array(); $no=0;
			foreach($core as $val){
				if(!isset($_ykey_c[$val['code']] )){
					$_ykey_c[$val['code']]=$val['code'];
					$_ykey[]=$val['code']; $_label[]=$val['nama'];
				}
				if( !isset($_tanggal_c[$val['tanggal']] ) ){
					$_tanggal_c[$val['tanggal']]=$no ;
					$_baru[$no]['periode']=$val['tanggal'];
					$_baru[$no][$val['code']] =$val['pendapatan']; 
					$no++;
				}else{
					$_baru[ $_tanggal_c[$val['tanggal']] ][$val['code']] = isset($_baru[ $_tanggal_c[$val['tanggal']] ][$val['code']]) ? ($_baru[ $_tanggal_c[$val['tanggal']] ][$val['code']] + $val['pendapatan']) : $val['pendapatan'];; 
				}
			}
			$core=null;
			$hasil['graph']= array('detail'=>$_baru , 'label'=>$_label ,'ykey'=>$_ykey );
		}
		
		if(isset($hasil) && is_array($hasil)){
			self::$_hasil = array('berhasil'=>$hasil);
		}
	}
}