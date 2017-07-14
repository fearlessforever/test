<?php
namespace NoDirect\TraitList ;
use \Saya\DB;

trait JsonQueryBuilder{
	private $_limit = 7 ;
	private $_decode = false ;
	private $_where = false ;
	private $_where_d = array() ;
	private $_decode_object = false ;
	private static $instance = false ;

	function __construct(){
		$a=__CLASS__ ;
		self::$instance = self::$instance ? self::$instance : new $a ;
	}
	
	private static function __getInstance(){
		$a=__CLASS__ ;
		self::$instance = self::$instance ? self::$instance : new $a ;
		return self::$instance;
	}

	public static function fetch($kondisi =false, $data=array() )
	{
		return self::__getInstance()->get($kondisi , $data );
	}
	public static function table($tbl=false)
	{
		$a =self::__getInstance();
		if(!isset($a->__tableName) && !$tbl){
			throw new \Exception ("Please set the table name in <strong>". __CLASS__ .'</strong> <br/>example : private $_tableName= "MyTable"; OR <strong>'.__CLASS__.'::table("MyTable") </strong>' );
		} 
		if(is_string($tbl)){
			$a->__tableName = $tbl ;
		}
		return  self::__getInstance();
	}	
	public function limit($no=1)
	{
		self::$instance->_limit = ($no > 0) ? $no : 1;
		return self::$instance;
	}
	public function decode($obj=true)
	{
		self::$instance->_decode = true;
		self::$instance->_decode_object = (bool)$obj;
		return self::$instance;
	}
	public function whereJson($where)
	{
		
	}
	public function get($kondisi =false, $data=null)
	{
		$kond='';
		$data=is_array($data) ?$data :array();
		if(is_array($this->_where)){
			if(is_string($kondisi)){
				$this->_where[] = $kondisi;
			}
			$kondisi = ($kondisi == false ) ? $this->_where : array_merge($kondisi , $this->_where);
			$data = array_merge($data , $this->_where_d);
		}
		$limit = ($this->_limit > 0) ? $this->_limit : 7;
		switch(true){
			case is_string($kondisi):
				$kond = ' WHERE '. $kondisi ;
				break;
			case is_array($kondisi):
				$kond = ' WHERE '. implode(' AND ',$kondisi) ;
				break;
			default: break;
		}
		(!DB::$koneksi_status )? DB::koneksi():false;
		try{
			$data = DB::select("
				SELECT nama,COLUMN_JSON(jsonnya) as jsonnya 
				FROM ". $this->__tableName ." {$kond} LIMIT ".$limit
			,$data );
		}catch(\PDOException $e){
			self::$errorMsg = $e->getMessage() ;
			self::$errorCode = $e->getCode() ;
			return array();
		}
		if($this->_decode && !empty($data)){
			self::decodeJson('jsonnya',$data , $this->_decode_object );
		}
		return empty($data) ? array() : $data;
	}

	public function insert($key ='', $jsonArray=array() )
	{
		(!DB::$koneksi_status )? DB::koneksi():false;
		self::$data['nama']=$key;
		try{
			DB::insert (" INSERT INTO ". $this->__tableName ." VALUES( :nama, ".self::createColumn($jsonArray) ." ) ".$this->__insertExtra ,self::$data);
		}catch(\PDOException $e){
			self::$errorMsg = $e->getMessage() .' <pre>'.print_r(self::$data,TRUE) .'</pre>';
			self::$errorCode = $e->getCode() ;
			return false;
		}
		return true;
	}
	public function insertExtra($str)
	{
		if(!is_string($str)){
			throw new Exception (' Please input string type Data ');
		}
		$this->__insertExtra = $str;
		return $this;
	}
}