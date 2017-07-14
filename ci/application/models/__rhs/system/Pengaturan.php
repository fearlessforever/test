<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

use Saya\Validasi ;
use Saya\Upload;
class Pengaturan extends CI_Model {
	static $_hasil= array('error'=>'Mode Not Found');
	
	function __construct() {
		parent::__construct();
	}
	
	public function run(){
		$check = $this->input->is_ajax_request();
			if( Model\User::$data['level'] != 'admin'){
				if($check){
					Saya\Template::view_json( array('error'=>'Selain admin Tidak Diizinkan') , TRUE); return true;
				}
				return;
			}
			
			$mode = $this->input->post('mode');
			switch($mode){
				case 'simpan': 
					if($check){
						self::__simpan(); 
						Saya\Template::view_json( self::$_hasil ,TRUE);
						return true;
					}
					break;
				case 'setting-background':
					self::__set_background();
					$_referer = $this->input->get_request_header('Referer') ;
					$_referer .= '#'. $this->uri->segment(3) .'.html';
					echo self::$_hasil ; @header( 'Refresh:2,' .$_referer ,'refresh');
					return true ;
					break;
				case 'delete-background':
					if($check){
						self::__hapus(); 
						Saya\Template::view_json( self::$_hasil ,TRUE);
						return true;
					}
					break;
				case 'delete-notif':
					if($check){
						self::__hapus_notif(); 
						Saya\Template::view_json( self::$_hasil ,TRUE);
						return true;
					}
					break;
				default: break;
			}
		show_404();
	}
	
	private function __hapus_notif()
	{
		$set = Saya\Template::getData();
		try{
			Saya\DB::statement("TRUNCATE TABLE z_notif ");
		}catch(PDOException $e){
			Saya\Notif::set( 2 , 'Gagal Bersihin Notif Log', Model\User::$data['id_user'] );
			self::$_hasil= array('error' => empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di modifikasi data' : $e->getMessage() ); return;
		}
		Saya\Notif::set( 1 , 'System Log Has Been Clear', Model\User::$data['id_user'] );
		self::$_hasil=array('berhasil'=>'Log Notifikasi Telah Dihapus');
	}
	
	private function __hapus(){
		self::$_hasil =array('error'=>'Gagal Hapus Background');
		$save =null;
		$set = Saya\Template::getData();

		try{
			$save = Saya\DB::insert("DELETE FROM ". KODE ."pengaturan WHERE nama=:nama LIMIT 1 ",array('nama'=>'sys_bg')  );
		}catch(PDOException $e){
			self::$_hasil= array('error' => empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di modifikasi data' : $e->getMessage() ); return;
		}
		
		if($save){
			Saya\Notif::set( 1 , ' System\'s Background Removed ', Model\User::$data['id_user'] );
			
			self::$_hasil =array('berhasil'=>'Background Telah Dihapus');
		}
	}
	
	private function __set_background(){
		self::$_hasil ='<h1 style="text-align:center; font-weight:bold; color:red;">Gagal Simpan Background !!!</h1>';
		
		if(!isset( $_FILES['upload_image']['tmp_name'] ))return;
		
		$_nama = md5('backgroundHlasflJKln890').'.jpg';
		//Upload::$_folder = 'upload/'.date('Y').'/'.date('m').'/'.date('d').'/';
		//Upload::$_max_width=1920; Upload::$_max_height=915;
		Upload::imageSet([
			'folder'=> 'upload/'.date('Y').'/'.date('m').'/'.date('d').'/'
			,'max_width'=> 1920
			,'max_height'=> 915
			,'quality'=> 91
			,'mode'=> 'crop'
		]);
		$_check_img = Upload::generate_image_thumbnail($_FILES['upload_image']['tmp_name'] , $_nama );
		if(!$_check_img)return;
		$data =array(
			'nama'=>'sys_bg','isi1'=>$_nama,'isi2'=> Upload::$_folder
		);
		if( !Validasi::_array($data,'nama|isi1|isi2') ){
			return;
		}
		$save =null;
		$set = Saya\Template::getData();
		try{
			$save = Saya\DB::insert("INSERT INTO ". KODE ."pengaturan(nama,isi1,isi2) VALUES(:nama,:isi1,:isi2) ON DUPLICATE KEY UPDATE isi1=VALUES(isi1),isi2=VALUES(isi2) " ,$data);
		}catch(PDOException $e){
			self::$_hasil= empty($set['sys_debug_db']) ? '[DB] Ada Kesalahan di simpan data' : $e->getMessage() ; return;
		}
		
		if($save){
			Saya\Notif::set( 1 , ' Set Background ', Model\User::$data['id_user'] );			
			self::$_hasil='<h1 style="text-align:center; font-weight:bold; margin:30px auto;"> Background Telah Disimpan</h1>';
		}
	}
	
	private function __simpan(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$data =array(
			'alamat'=> $this->input->post('alamat',TRUE)
			,'title'=> $this->input->post('title',TRUE)
			,'sys_hapus'=> $this->input->post('hapus_boleh',TRUE)
			,'sys_debug_db'=> $this->input->post('debug_db',TRUE)
			,'sys_notif'=> $this->input->post('sys_notif' )
		);
		$data['sys_hapus'] = empty($data['sys_hapus']) ? 0 : 1 ;
		$data['sys_debug_db'] = empty($data['sys_debug_db']) ? 0 : 1 ;
		$data['sys_notif'] = empty($data['sys_notif']) ? 0 : 1 ;
		if( !Validasi::_array($data,'alamat|title') ){
			self::$_hasil =array('error'=>'Alamat Dan nama System Tidak Boleh Kosong !!! '); return;
		}
		$set = Saya\Template::getData();
		$save=false;
		try{
		$save = Saya\DB::update("
			UPDATE ". KODE ."pengaturan SET isi1=CASE
			WHEN nama = 'alamat' THEN :alamat
			WHEN nama = 'title' THEN :title
			WHEN nama = 'sys_hapus' THEN :sys_hapus
			WHEN nama = 'sys_debug_db' THEN :sys_debug_db
			WHEN nama = 'sys_notif' THEN :sys_notif
			ELSE isi1
			END
			WHERE nama IN ('alamat','title','sys_hapus','sys_debug_db','sys_notif' ) 
		" , $data);
		}catch(Exception $e){
			if(($set['sys_debug_db']))return self::$_hasil=array('error'=> $e->getMessage() );
		}
		if( $save ){
			Saya\Notif::set( 1 , ' Settingan System' , Model\User::$data['id_user'] );
			
			self::$_hasil= array('berhasil'=>'Data Berhasil Disimpan ') ;
		}else{
			self::$_hasil=array('error'=> 'Tidak Ada Data Yang Berubah' );
		}
	}
}