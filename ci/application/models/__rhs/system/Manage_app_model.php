<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

use Saya\Validasi ;
use Saya\Upload;

class Manage_app_model extends CI_Model {
	static $_hasil= array('error'=>'Mode Not Found');
	static $ini ='manage-app';
	function __construct() {
		parent::__construct();
	}
	
	public function run(){
		$check = $this->input->is_ajax_request();
		if($check){
			header('Content-Type:application/json'); 
			if( Model\User::$data['level'] != 'admin'){
				Saya\Template::view_json( array('error'=>'Selain admin Tidak Diizinkan') , TRUE); return true;
			}
			$mode = $this->input->post('mode');
			switch($mode){
				case 'tambah-app': self::__add_app(); break;
				case 'hapus-app': self::__remove_app(); break;
				
				case 'view': self::__view(); break;
				default: break;
			}
			Saya\Template::view_json( self::$_hasil , TRUE);
			return true;
		}
		show_404();
	}
	
	/*================================================ Application =============================================*/
	private function __remove_app(){
		self::$_hasil =array('error'=>'Gagal Hapus !!!');
		$lvl = $this->input->post('level');
		$block = $this->input->post('block');
		if(empty($lvl)){
			self::$_hasil =array('error'=>'Data yang dihapus/diblock tidak ditemukan'); return;
		}
		if( $lvl== self::$ini ){
			self::$_hasil =array('error'=>'Tidak Bisa Menghapus/Block Aplikasi ini'); return;
		}
		$save=null;
		$set = Saya\Template::getData();
		if( empty($set['sys_hapus']) && empty($block) ){
			self::$_hasil =array('error'=>'[System] Tidak Diizinkan Menghapus Data'); return;
		}
		
		try{
			if( empty($block) ){
				$save = Saya\DB::table( 'z_aplikasi')->where('nama_app',$lvl )->where('mode','!=','__rhs/system')->limit(1)->delete();
			}else{
				$save = Saya\DB::table( 'z_aplikasi')->where('nama_app',$lvl )->limit(1)->update( array('perawatan'=> ($block == 'block')? 1 : 0 ) );
			}
		}catch(PDOException $e){
			self::$_hasil= array('error' => empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di Database' : $e->getMessage() ); return;
		}
		
		if($save){
			if( empty($block) )self::$_hasil=array('berhasil'=>'Data Berhasil Dihapus' );
			else{
				self::$_hasil=array('berhasil'=>'App ID Ini Berhasil '.( ($block == 'block')? 'Di Non Aktifkan' : 'Di Aktifkan' ) );
			}
			return;
		}
		if( !empty($block) ){
			self::$_hasil =array('error'=>' App ID Ini Telah '.( ($block == 'block')? 'Di Non Aktifkan' : 'Di Aktifkan' ).' sebelum nya');
		}
	}
	private function __add_app (){
		self::$_hasil =array('error'=>'Gagal Ditambahkan');
		$data =array(
			'nama_app'=> $this->input->post('app' )
			,'mode'=> $this->input->post('folder' )
			,'file_view'=> $this->input->post('file_view' )
			,'file_model'=> $this->input->post('file_model' )
			,'keterangan'=> $this->input->post('ket' )
		);
		if( !Validasi::_array($data,'nama_app|mode|file_view|file_model|keterangan') ){
			self::$_hasil =array('error'=>'App id , Folder, File view , File Model dan Keterangan App tidak boleh kosong !!!'); return;
		}
		foreach( array('nama_app','file_view','file_model') as $val){
			$data[ $val ] = preg_replace('/[^0-9a-z_\-]/i','',substr( $data[ $val ] ,0,60) );
		}
		
		$data['mode'] = trim( preg_replace('/[^0-9a-z_\-\/]|(:?\/{2}+)/i','',substr( $data['mode'] ,0,50) ) ,'/');
		if( !Validasi::_array($data,'nama_app|mode|file_view|file_model|keterangan') ){
			self::$_hasil =array('error'=>'App id , Folder, File view , File Model dan Keterangan App tidak boleh kosong !!!'); return;
		}
		/* $data[]='{memory_usage}';
		self::$_hasil=$data; return; */
		$save=null; 
		$set = Saya\Template::getData();
		
		try{
			$save = Saya\DB::table('z_aplikasi')->insert( $data );
		}catch(PDOException $e){
			self::$_hasil= array('error' => empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di simpan data' : $e->getMessage() ); return;
		} 
		
		
		if($save){
			self::$_hasil=array(
				'berhasil'=>'Data Berhasil Disimpan '
				,'baru'=>array('app'=>$data['nama_app'] ,'ket'=>$data['keterangan'],'folder'=> $data['mode'],'view'=> $data['file_view'],'model'=>$data['file_model'],'mainten'=>0)
			);
			
		}else self::$_hasil=array('error'=>'Tidak Ada Data yg Disimpan');
	}
	/*================================================ End Of Application =============================================*/
	
	private function __view(){
		self::$_hasil =array('error'=>'Data Tidak Ditemukan'); //sleep(9);
		$hasil=array();
		$limit = 7;
		$opsi = $this->input->post('pilihan');
		$cari = false; //$this->input->post('cari');
		$next = $this->input->post('page');
		$core = Saya\DB::table( 'z_aplikasi')
			->select( Saya\DB::raw('nama_app as app , keterangan as ket,mode as folder,file_view as view,file_model as model,perawatan as mainten') )
			->limit( $limit );
		if($cari){
			$core->where('keterangan','LIKE', '%'.$cari .'%')->limit(7);
		}
		if($next > 0){
			$offset = ($next - 1) * $limit;
			$core->skip( $offset )->take( $limit );
		}
			
		$core = $core->get();
		
		if(isset($core[0]) && is_array($core) ){
			self::$_hasil = array('berhasil'=> $core );
		}
		if(empty($next)){
			$core = Saya\DB::table('z_aplikasi')->count();
			self::$_hasil['total']=$core ;
			self::$_hasil['limit']= $limit ;
		}
	}
}