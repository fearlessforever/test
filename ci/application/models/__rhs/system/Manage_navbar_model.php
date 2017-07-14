<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

use Saya\Validasi ;
use Saya\DB;

class Manage_navbar_model extends CI_Model {
	var $_hasil= array('error'=>'Mode Not Found');
	
	function __construct() {
		parent::__construct();
	}
	
	public function run(){
		$check = $this->input->is_ajax_request();
		if($check){
			try{
				header('Content-Type:application/json'); 
				if( Model\User::$data['level'] != 'admin'){
					throw new Exception('Selain admin Tidak Diizinkan');
				}
				$mode = $this->input->post('mode');
				switch($mode){
					case 'edit-sub': $this->__simpan_sub(); break;
					case 'edit': $this->__simpan(); break;
					case 'view': $this->__view(); break;
					default: break;
				}				
			}catch(Exception $e){
				$this->_hasil = array('error'=>$e->getMessage() );
			}catch(PDOException $e){
				$this->_hasil = array('error'=>$e->getMessage() );
			}
			Saya\Template::view_json( $this->_hasil , TRUE);
			return true;
		}
		show_404();
	}
	private function __simpan_sub(){
		$this->_hasil=array('berhasil'=>'Oke !!!');
		$opsi = $this->input->post('pilihan');
		$data=array(
			'id'=> $this->input->post('id')
		);
		if(empty($data['id'])){
			throw new Exception('[APP] Id Tidak Ditemukan !!!');
		}
		//check ada tidak data dengan id berikut
		$check = DB::table('z_aplikasi_navbar')->select('id','sub')->where('id',$data['id'])->limit(1)->first();
		if(!isset($check['id'])){
			throw new Exception('[DB] Data Tidak Valid !!!');
		}
		$check = json_decode($check['sub'],TRUE);
		
		switch($opsi){
			case 'tambah': 
				$data2 = array(
					'url'=> $this->input->post('url')
					,'ket'=> $this->input->post('ket')
					,'icon'=> $this->input->post('icon')
				);
				if(!Validasi::_array( $data2 ,'ket|icon|url')){
					throw new Exception('[APP] Keterangan,Class icon , dan Link tidak boleh kosong ');
				}
				$check[]=$data2;
				$proses = DB::table('z_aplikasi_navbar')->where('id',$data['id'])->limit(1)->update(array('sub'=>json_encode($check ) ));
				if($proses){
					$this->_hasil['berhasil']='[DB] Data telah berhasil ditambahkan';
				}else{
					$this->_hasil['error']='[DB] Gagal menambahkan data';
				}
				break;
			case 'hapus':
				$idc	= $this->input->post('idc');
				if(!isset($check[$idc])){
					throw new Exception('[DB] Data Sub ID Tidak Valid !!!');
				}
				$set = Saya\Template::getData();
				if( empty($set['sys_hapus']) ){
					throw new Exception( '[System] Tidak Diizinkan Menghapus Data');
				}
				unset($check[$idc]);
				$proses = DB::table('z_aplikasi_navbar')->where('id',$data['id'])->limit(1)->update(array('sub'=>json_encode($check ) ));
				if($proses){
					$this->_hasil['berhasil']='[DB] Data telah Dihapus';
				}else{
					$this->_hasil['error']='[DB] Gagal Hapus data';
				}
				break;
			default:
				$idc	= $this->input->post('idc');
				if(!isset($check[$idc])){
					throw new Exception('[DB] Data Sub ID Tidak Valid !!!');
				}
				$check[$idc] = array(
					'url'=> $this->input->post('url')
					,'ket'=> $this->input->post('ket')
					,'icon'=> $this->input->post('icon')
				);				
				if(!Validasi::_array( $check[$idc] ,'ket|icon|url')){
					throw new Exception('[APP] Keterangan,Class icon , dan Link tidak boleh kosong ');
				}
				$proses = DB::table('z_aplikasi_navbar')->where('id',$data['id'])->limit(1)->update(array('sub'=>json_encode($check ) ));
				if($proses){
					$this->_hasil['berhasil']='[DB] Data telah Disimpan';
				}else{
					$this->_hasil['error']='[DB] Data tidak ada yang diubah';
				}
				break;
		}
	}
	private function __simpan(){
		$this->_hasil=array('berhasil'=>'Oke !!!');
		$opsi = $this->input->post('pilihan');
		$data=array(
			'id'=> $this->input->post('id')
		);
		if(empty($data['id']) && $opsi != 'tambah'){
			throw new Exception('[APP] Id Tidak Ditemukan !!!');
		}
		switch($opsi){
			case 'hapus':
				$set = Saya\Template::getData();
				if( empty($set['sys_hapus']) ){
					throw new Exception( '[System] Tidak Diizinkan Menghapus Data');
				}
				$proses = DB::table('z_aplikasi_navbar')->where('id',$data['id'])->limit(1)->delete($data );
				if($proses){
					$this->_hasil['berhasil']='[DB] Data telah Dihapus';
				}else{
					$this->_hasil['error']='[DB] Gagal menghapus data';
				}
				break;
			case 'tambah':
				$data['ket']= $this->input->post('ket');
				$data['icon']= $this->input->post('icon');
				$data['link']= $this->input->post('url');
				if(!Validasi::_array($data ,'ket|icon|link')){
					throw new Exception('[APP] Keterangan,Class icon , dan Link tidak boleh kosong ');
				}
				$proses = DB::table('z_aplikasi_navbar')->insert($data );
				if($proses){
					$this->_hasil['berhasil']='[DB] Data telah Ditambah';
				}else{
					$this->_hasil['error']='[DB] Gagal menambahkan data';
				}
				break;
			default:
				$data['ket']= $this->input->post('ket');
				$data['icon']= $this->input->post('icon');
				$data['link']= $this->input->post('url');
				if(!Validasi::_array($data ,'ket|icon|link')){
					throw new Exception('[APP] Keterangan,Class icon , dan Link tidak boleh kosong ');
				}
				$proses = DB::table('z_aplikasi_navbar')->where('id',$data['id'])->update($data );
				if($proses){
					$this->_hasil['berhasil']='[DB] Data telah Disimpan';
				}else{
					$this->_hasil['error']='[DB] Data tidak ada yang diubah';
				}
				break;
		}
	}
	private function __view(){
		$next = $this->input->post('page');
		$id = $this->input->post('id');
		$opsi = $this->input->post('pilihan');
		$this->_hasil=array(
			'limit'=> 7
		);
		$core = DB::table('z_aplikasi_navbar')
			->select(DB::raw('id,ket,icon,link as url') )->limit( $this->_hasil['limit'] );
		if(!empty($id)){
			$core->where('id',$id)->limit(1);
			if(!empty($opsi))$core->select('sub');
		}
		if($next > 0){
			$offset = ($next - 1) * $limit;
			$core->skip( $offset )->take( $limit );
		}
		$core = $core->get();
		if(isset($core[0]) && is_array($core)){
			$this->_hasil['berhasil']=empty($id) ? $core : '[DB] Data Found !!!';
			if(!empty($id))$this->_hasil['z']= $core;
		}else{
			$this->_hasil =array('error'=>'[DB] Data Not Found !!! ');
		}
	}
	
}