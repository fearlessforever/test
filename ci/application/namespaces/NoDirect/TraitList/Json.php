<?php
namespace NoDirect\TraitList;
/* 
	TRAIT CLass ini untuk TABEL JSON dari COLUMN json Khusus MariaDB
*/

trait Json{
	public static $data =array();
	public static $reset = false;
	private static $no =0;
	
	private final static function __jsonArray_toCreateColumn($d=array()){
		if(!is_array($d) || empty($d) )return '';
		$a='';
		foreach($d as $k => $v){
			++self::$no;
			if($a)$a.=',';
			if(is_array($v)){
				self::$data['key'.self::$no ]=$k;
				$a .= ':key'.self::$no .',COLUMN_CREATE('.self::__jsonArray_toCreateColumn($v) .')';
				continue;
			}
			$a .= ':key'.self::$no.',:val'.self::$no ;
			self::$data['key'.self::$no ]=$k;
			self::$data['val'.self::$no ]=$v;
		}
		return $a;
	}
	protected static function createColumn($data )
	{
		//if(self::$reset)self::$no=0; 
		return ' COLUMN_CREATE('. self::__jsonArray_toCreateColumn($data) .') ';
	}
	protected static function addColumn($kolom , $data )
	{
		//if(self::$reset)self::$no=0; 
		return ' COLUMN_ADD('.$kolom.','. self::__jsonArray_toCreateColumn($data) .') ';
	}
	protected static function getColumnJson($str)
	{
		return is_string($str) ? ' COLUMN_JSON('. $str .') ' : '';
	}
	protected static function decodeJson($key='',&$data , $modeArray =true )
	{
		if(empty($data) || !is_array($data))return false;
		$modeArray = (bool)$modeArray ;
		foreach($data as $k => &$v){
			if(is_string($v) && $k == $key){
				$v=@json_decode(str_replace(array("\t","\r\n"),array("\\t","\\n"),$v ),$modeArray);
			}elseif(is_array($v) && isset($v[$key])){
				$v[$key]=@json_decode(str_replace(array("\t","\r\n"),array("\\t","\\n"),$v[$key]) ,$modeArray);
			}
		}
		return true;
	} 
}