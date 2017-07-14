<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

use Saya\Validasi ;
use Saya\DB;

class Data_task_list_model extends CI_Model {
	var $_hasil= array('error'=>'Mode Not Found');
	
	function __construct() {
		parent::__construct();
	}
	
	public function run(){
		$check = $this->input->is_ajax_request();
		if($check){
			try{
				header('Content-Type:application/json');
				
				$mode = $this->input->post('mode');
				switch($mode){
					case 'save': $this->__simpan(); break;
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
					throw new Exception( '[System] Delete data is not permitted .');
				}
				$proses = DB::table('soding_test')->where('id',$data['id'])->limit(1)->delete($data );
				if($proses){
					$this->_hasil['berhasil']='[DB] Data has been deleted';
				}else{
					$this->_hasil['error']='[DB] Fail Remove data !!!';
				}
				break;
			case 'tambah':
				$data['nama']= $this->input->post('task_name',TRUE);
				$data['ket']= $this->input->post('task_desc',TRUE);
				
				if(!Validasi::_array($data ,'nama|ket')){
					throw new Exception('[APP] Task Name and Task Description are not allowed Empty ');
				}
				$proses = DB::table('soding_test')->insert($data );
				if($proses){
					$this->_hasil['berhasil']='[DB] Data Added';
				}else{
					$this->_hasil['error']='[DB] Fail adding data';
				}
				break;
			default:
				$data['nama']= $this->input->post('task_name',TRUE);
				$data['ket']= $this->input->post('task_desc',TRUE);
				if(!Validasi::_array($data ,'nama|ket')){
					throw new Exception('[APP] Task Name and Task Description are not allowed Empty ');
				}
				$proses = DB::table('soding_test')->where('id',$data['id'])->update($data );
				if($proses){
					$this->_hasil['berhasil']='[DB] Data Updated';
				}else{
					$this->_hasil['error']='[DB] No Data Updated';
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
		$core = DB::table('soding_test')
			->select(DB::raw("id,nama,DATE_FORMAT(tanggal_ct ,'%d %M %y ~ %H:%i') as tgl") )->limit( $this->_hasil['limit'] );
		if(!empty($id)){
			$this->_hasil['limit']=1;
			$core->where('id',$id)->limit(1)->select( DB::raw("id,nama as task_name,ket as task_desc,DATE_FORMAT(tanggal_ct ,'%d %M %y ~ %H:%i') as tgl") );
		}else{
			$this->_hasil['total'] = DB::table('soding_test')->count();
			$this->_hasil['limit'] = ( $this->_hasil['limit'] > $this->_hasil['total'] ) ? $this->_hasil['total'] : $this->_hasil['limit'];
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