<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

use Saya\Validasi ;
use Saya\Upload;

class Manage_user_model extends CI_Model {
	static $_hasil= array('error'=>'Mode Not Found');
	
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
				case 'tambah-level': self::__add_level(); break;
				case 'hapus-level': self::__remove_level(); break;
								
				case 'tambah-user': self::__add_user(); break;
				case 'hapus-user': self::__remove_user(); break;
				
				case 'tambah-izin': self::__add_app_permission(); break;
				case 'hapus-izin': self::__remove_app_permission(); break;
				case 'view': self::__view(); break;
				default: break;
			}
			Saya\Template::view_json( self::$_hasil , TRUE);
			return true;
		}
		show_404();
	}
	
	/*================================================ Application =============================================*/
	private function __remove_app_permission(){
		self::$_hasil =array('error'=>'Gagal Dihapus');
		$lvl = $this->input->post('level');
		$lvl = explode('/', $lvl );
		$app = isset($lvl[1]) ? substr($lvl[1], 0,27) : '';
		$lvl = isset($lvl[0]) ? $lvl[0] : '';
		if(empty($app) || empty($lvl) ){
			self::$_hasil =array('error'=>'Level Dan Application Tidak Boleh Kosong !!!'); return;
		}
		
		$save=null;
		$set = Saya\Template::getData();
		try{
			$save = Saya\DB::table( KODE .'users_izin')->limit(1)->where('nama_app' , $app)->where('level', $lvl)->delete();
		}catch(PDOException $e){
			self::$_hasil= array('error' => empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di simpan data' : $e->getMessage() ); return;
		}
		if($save){
			self::$_hasil=array( 'berhasil'=>'Data Berhasil Dihapus ' );
		}else self::$_hasil=array('error'=>'Tidak Ada Data yg Dihapus');
	}
	private function __add_app_permission(){
		self::$_hasil =array('error'=>'Gagal Ditambahkan');
		$data =array(
			'app'=> $this->input->post('app' )
			,'level'=> $this->input->post('level' )
		);
		if( !Validasi::_array($data,'level|app') ){
			self::$_hasil =array('error'=>'Level Dan Modul Application Tidak Boleh Kosong !!!'); return;
		}
		
		$save=null; $baru=array();
		$set = Saya\Template::getData();
		$pdo = Saya\DB::connection()->getPdo()->prepare("INSERT INTO ". KODE ."users_izin(level,nama_app) VALUES(:level,:nama_app) ");
		
		foreach($data['app'] as $val)
		{
		try{
			$val = preg_replace('/[^0-9a-z_\-]/i','',substr( $val ,0,27) );
			if(empty($val))continue;
			$baru[]=array(
				'level'=> $data['level'] ,'ket'=>'[NEW]' ,'nama_app'=>$val ,'app'=>'Y' ,'keterangan'=>'[NEW]'
			);
			$save = $pdo->execute( array('level'=> $data['level'] ,'nama_app' =>  $val ) );
		}catch(PDOException $e){
			self::$_hasil= array('error' => empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di simpan data' : $e->getMessage() ); return;
		}
		
		}
		
		
		if($save){
			self::$_hasil=array(
				'berhasil'=>'Data Berhasil Disimpan ','baru'=>$baru
			);
			
		}else self::$_hasil=array('error'=>'Tidak Ada Data yg Disimpan');
	}
	/*================================================ End Of Application =============================================*/
	
	/*================================================ User =============================================*/
	private function __remove_user(){
		self::$_hasil =array('error'=>'Gagal Hapus Data');
		$lvl = $this->input->post('level');
		$block = $this->input->post('block');
		if(empty($lvl)){
			self::$_hasil =array('error'=>'Data yang dihapus/diblock tidak ditemukan'); return;
		}
		if( $lvl== Model\User::$data['id_user'] ){
			self::$_hasil =array('error'=>'Tidak Bisa Menghapus/Block id_user Sendiri'); return;
		}
		$save=null;
		$set = Saya\Template::getData();
		if( empty($set['sys_hapus']) && empty($block) ){
			self::$_hasil =array('error'=>'[System] Tidak Diizinkan Menghapus Data'); return;
		}
		
		try{
			if( empty($block) ){
				$save = Saya\DB::table(KODE .'users')->where('id_user',$lvl )->limit(1)->delete();
			}else{
				$save = Saya\DB::table(KODE .'users')->where('id_user',$lvl )->limit(1)->update( array('blokir'=> ($block == 'block')? 'Y' : 'N') );
			}
		}catch(PDOException $e){
			self::$_hasil= array('error' => empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di Database' : $e->getMessage() ); return;
		}
		
		if($save){
			if( empty($block) )self::$_hasil=array('berhasil'=>'Data Berhasil Dihapus' );
			else{
				self::$_hasil=array('berhasil'=>'Userid Ini Berhasil '.( ($block == 'block')? 'DiBlock' : 'DiUnblock' ) );
			}
			return;
		}
		if( !empty($block) ){
			self::$_hasil =array('error'=>' UserID Ini Telah '.( ($block == 'block')? 'DiBlock' : 'DiUnblock' ).' sebelum nya');
		}
	}
	
	private function __add_user(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$data =array(
			'username'=> $this->input->post('id_user' )
			,'email_users'=> $this->input->post('email' )
			,'sandiusers'=> $this->input->post('password' )
			,'namausers'=> $this->input->post('nama' )
			,'level'=> $this->input->post('level' )
		);
		if( !Validasi::_array($data,'username|email_users|sandiusers|namausers|level') ){
			self::$_hasil =array('error'=>'User id,email,password,nama , dan Level Tidak Boleh Kosong !!!'); return;
		}
		if ( !filter_var( $data['email_users'] , FILTER_VALIDATE_EMAIL)) {
			self::$_hasil =array('error'=> $data['email_users'].' Bukan email yang valid !!!'); return;
		}
		
		$data['sandiusers'] = password_hash($data['sandiusers'] , PASSWORD_DEFAULT );
		$data['username'] = preg_replace('/[^0-9a-z_]/i','',substr($data['username'],0,27) );
		$data['level'] = preg_replace('/[^0-9a-z_]/i','',substr($data['level'],0,27) );
		
		if( !Validasi::_array($data,'level|username') ){
			self::$_hasil =array('error'=>'Level dan Username Hanya dibolehkan a-z dan _ , 0-9 '); return;
		}
		$save=null;
		$set = Saya\Template::getData();
		try{
			$save = Saya\DB::table(KODE .'users')->insertGetId( $data );
		}catch(PDOException $e){
			self::$_hasil= array('error' => empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di simpan data' : $e->getMessage() ); return;
		}
		
		if($save){
			self::$_hasil=array(
				'berhasil'=>'Data Berhasil Disimpan '
				,'baru'=>array(
					'id_user'=>$save,'username'=>$data['username'],'email'=>$data['email_users'],'level'=>$data['level'],'nama'=>$data['namausers'],'buat'=>date('d F Y ~ H:i'),'block'=>'N'
				)
			);
			Saya\DB::insert("INSERT IGNORE INTO ". KODE ."users_ext VALUES(:id_user,:nama,:isi ) ",  array('id_user'=>$save ,'nama'=>'folder','isi'=>'') );
			Saya\DB::insert("INSERT IGNORE INTO ". KODE ."users_ext VALUES(:id_user,:nama,:isi ) ",  array('id_user'=>$save ,'nama'=>'profile_pic','isi'=>'no_image.jpg') );
		}else self::$_hasil=array('error'=>'Tidak Ada Data yg Diubah');
	}
	/*================================================ End Of User =============================================*/
	
	/*================================================ LeveL =============================================*/
	private function __remove_level(){
		self::$_hasil =array('error'=>'Gagal Hapus Data');
		$lvl = $this->input->post('level');
		if(empty($lvl)){
			self::$_hasil =array('error'=>'Data yang dihapus tidak ditemukan'); return;
		}
		if( $lvl=='admin'){
			self::$_hasil =array('error'=>'Tidak Diperbolehkan Menghapus Admin'); return;
		}
		$save=null;
		$set = Saya\Template::getData();
		if( empty($set['sys_hapus']) ){
			self::$_hasil =array('error'=>'[System] Tidak Diizinkan Menghapus Data'); return;
		}
		
		try{
			$save = Saya\DB::table(KODE .'users_lvl')->where('level',$lvl )->limit(1)->delete();
		}catch(PDOException $e){
			self::$_hasil= array('error' => empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di Database' : $e->getMessage() ); return;
		}
		
		if($save){
			self::$_hasil=array('berhasil'=>'Data Berhasil Dihapus' ); 
		}
	}
	private function __add_level(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$data =array(
			'level'=> $this->input->post('nama' )
			,'ket'=> $this->input->post('ket' )
			,'bintang'=> $this->input->post('rate' )
		);
		if( !Validasi::_array($data,'level|ket') ){
			self::$_hasil =array('error'=>'Level , dan Keterangan Tidak Boleh Kosong !!!'); return;
		}
		
		$data['level'] = preg_replace('/[^0-9a-z_]/i','',substr($data['level'],0,27) );
		$data['bintang'] = ( $data['bintang'] > 0 && $data['bintang'] < 6) ? $data['bintang'] : 0;
		
		if( !Validasi::_array($data,'level') ){
			self::$_hasil =array('error'=>'Level Hanya dibolehkan a-z dan _ , 0-9 '); return;
		}
		$save=null;
		$set = Saya\Template::getData();
		try{
			$save = Saya\DB::table(KODE .'users_lvl')->insert( $data );
		}catch(PDOException $e){
			self::$_hasil= array('error' => empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di simpan data' : $e->getMessage() ); return;
		}
		
		if($save){
			self::$_hasil=array(
				'berhasil'=>'Data Berhasil Disimpan '
				,'baru'=>$data
			); 
		}else self::$_hasil=array('error'=>'Tidak Ada Data yg Diubah');
	}
	/*============================================ End Of LeveL ============================================*/
	
	private function __view(){
		self::$_hasil =array('error'=>'Data Tidak Ditemukan');
		$hasil=array(); $limit=5;
		$opsi = $this->input->post('pilihan');
		$cari = $this->input->post('cari');
		$next = $this->input->post('page');
		
		if( !empty($opsi) && $opsi =='app'){
			$core = Saya\DB::table( 'z_aplikasi')->select( Saya\DB::raw('nama_app as app , keterangan as ket') ) ->limit( $limit );
			if($cari){
				$core->where('keterangan','LIKE', '%'.$cari .'%')->limit(7);
			}
			$core = $core->get();
			if(isset($core[0]) && is_array($core) )$hasil['app']=$core;
		}
		
		if( empty($opsi) || $opsi =='level'){
			$core = Saya\DB::table( KODE .'users_lvl')->select('level','ket','bintang') ->limit( $limit );
			if($cari){
				$core->where('ket','LIKE', '%'.$cari .'%')->limit(7);
			}
			if($next > 0){
				$offset = ($next - 1) * $limit;
				$core->skip( $offset )->take( $limit );
			}
			$core = $core->get();
			if(isset($core[0]) && is_array($core) )$hasil['level']=$core;
		}
		
		if( empty($opsi) || $opsi =='user'){
			$core = Saya\DB::table( Saya\DB::raw( KODE .'users a') )
						->select( Saya\DB::raw("a.id_user,a.username,a.email_users,b.ket,a.namausers,DATE_FORMAT(a.buat,'%d %M %Y ~ %H:%i') as buat,a.blokir as block") )
						->leftJoin( Saya\DB::raw( KODE .'users_lvl b') , 'b.level','=', 'a.level')
						->limit( $limit ) ;
			if($next > 0){
				$offset = ($next - 1) * $limit;
				$core->skip( $offset )->take( $limit );
			}
			$core = $core->get();
			if(isset($core[0]) && is_array($core) )$hasil['user']=$core;
		}
		if( empty($opsi) || $opsi =='izin'){
			$core = Saya\DB::table( Saya\DB::raw( KODE .'users_izin a') )
						->select( Saya\DB::raw("a.level,b.ket ,a.nama_app ,IF(c.nama_app IS NULL,'N','Y') as app , c.keterangan") )
						->leftJoin( Saya\DB::raw( KODE .'users_lvl b') , 'b.level','=', 'a.level')
						->leftJoin( Saya\DB::raw( 'z_aplikasi c') , 'c.nama_app','=', 'a.nama_app')
						->limit( $limit ) ;
			if($next > 0){
				$offset = ($next - 1) * $limit;
				$core->skip( $offset )->take( $limit );
			}
			$core = $core->get();
			
			if(isset($core[0]) && is_array($core) )$hasil['izin']=$core;
		}
		
		if( !empty($hasil) ){
			self::$_hasil = array('berhasil'=> $hasil );
		}
		if(empty($next)){
			self::$_hasil['total_level']= Saya\DB::table( KODE .'users_lvl')->count() ;
			self::$_hasil['total_user']= Saya\DB::table( KODE .'users')->count() ;
			self::$_hasil['total_izin']= Saya\DB::table( KODE .'users_izin')->count() ;
			self::$_hasil['limit']= $limit ;
		}
	}
}