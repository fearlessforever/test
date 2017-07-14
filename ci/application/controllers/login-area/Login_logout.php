<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Saya\PubTemplate as Temp;
use Model\User;

class Login_logout extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('load');
		Saya\Session::ci2();
	}
	public function index()
	{
		$ajax = $this->input->is_ajax_request();
		if( User::is_logged_in() ){
			$dashboard = $this->config->item('dashboard');
			if($ajax){
				Temp::view_json(
					array('berhasil'=>'You Have Logged In','location'=>$dashboard )
				, TRUE );
				return;
			}else{
				redirect( base_url( $dashboard ) );
			}
		}
		
		if($ajax){
			$hasil=array('error' => 'Not Found ');
			$data = array(
				'id_user'=> $this->input->post('username')
				,'password'=> $this->input->post('password')
				,'remember'=> $this->input->post('remember')
			);
			$session = $this->session->userdata();
			if(isset( $session['hel_system_login'] )){
				$captcha = $this->input->post('captcha');
				if(!empty($captcha) && ( $session['hel_system_login'] == md5(md5($captcha.'hel'. KODE)) ) ){
					$session['hel_system_login'] = 'login dah';
				}else{
					$data = null; $hasil=array('error' => 'Please type the Captcha again !'); $session['hel_system_login'] = 'gagal';
				}				
			}
			if( !empty($data['id_user']) && !empty($data['password']) ){
				$hasil= User::login($data) ;
			}
			Temp::view_json($hasil , TRUE );
		}else{
			$data = &Temp::getData();
			$data['theme']='default';
			$data['__tema']=$data['asset'] .'tema/' . $data['theme'] .'/' ;
			$data['__error_login']= $this->session->flashdata('__error_login' );
			//Temp::view_json( $data ); return;
			Temp::$data['halaman_js'] =$this->load->view('__rhs/login/login-js', $data , TRUE);
			Temp::view(
				$this->load->view('__rhs/login/login', $data , TRUE)
			);
		}
		
	}
	public function logout()
	{
		$ajax = $this->input->is_ajax_request();
		if( User::is_logged_in() ){
			$this->session->sess_destroy();
			if($ajax){
				Temp::view_json(
					array('berhasil'=>'You Have Logout','location'=>base_url() )
				, TRUE );
				return;
			}else{
				redirect( base_url( ) );
			}
		}else{
			redirect( base_url( ) ,'refresh');
		}
	}
	
	public function facebook()
	{
		redirect( base_url('login') );
	}
	
}
