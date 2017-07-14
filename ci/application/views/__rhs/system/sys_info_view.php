<div class="row">
	<div class="col-lg-12">
	<div class="main-box clearfix" style="min-height: 1100px;">
		<div class="tabs-wrapper tabs-no-header">
			<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-home" data-toggle="tab">General</a></li>
			<li><a href="#tab-accounts" data-toggle="tab">Log </a></li>
			</ul>
		<div class="tab-content">
		<div class="tab-pane fade in active" id="tab-home">
		<h3><span>General information</span></h3>
		<div class="panel-group accordion" id="accordion">
<?php
	$core='';
	try{
		$core = Saya\DB::table('z_info')->where('tipe','info')->limit(27)->get();
	}catch(PDOException $e){
		echo $sys_debug_db ? $e->getMessage() : '[DB] Error Reading Data';
	}
	
	/* $core =$this->db->query(
		"SELECT tipe,id,judul,keterangan FROM z_info WHERE tipe=? ORDER BY id DESC"
	,array('info') )->result_array(); */
	if(isset($core[0]) && is_array($core) ){ 
		$str =' '; 
		foreach($core as $val){
			$str .= '
		<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$val['tipe'].$val['id'].'">
			'.$val['judul'].'
			</a>
			</h4>
		</div>
		<div id="'.$val['tipe'].$val['id'].'" class="panel-collapse collapse">
			<div class="panel-body">'.$val['keterangan'].' </div>
			</div>
		</div>
			';
		}
		echo $str; 
	}
?>
		</div>
<?php
	$core='';
	try{
		$core = Saya\DB::table('z_info')->where('tipe','author')->limit(27)->get();
	}catch(PDOException $e){
		echo $sys_debug_db ? $e->getMessage() : '[DB] Error Reading Data';
	}
	
	if(isset($core[0]) && is_array($core) ){
		$str ='<h3><span>Author Information</span></h3>'; 
		$str =' '; 
		foreach($core as $val){
			$str .= '
		<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion4" href="#'.$val['tipe'].$val['id'].'">
			'.$val['judul'].'
			</a>
			</h4>
		</div>
		<div id="'.$val['tipe'].$val['id'].'" class="panel-collapse collapse">
			<div class="panel-body">'.$val['keterangan'].' </div>
			</div>
		</div>
			';
		}
		echo '<h3><span>Author Information</span></h3><div class="panel-group accordion" id="accordion4">'. $str.' </div>';
	}
	
?>

		</div>
<div class="tab-pane fade" id="tab-accounts">
		<h3><span>Log Prototype System Infromasi</span></h3>
		<div class="panel-group accordion" id="accordion2">
<?php
	$core='';
	try{
		$core = Saya\DB::table('z_info')->where('tipe','log')->limit(27)->get();
	}catch(PDOException $e){
		echo $sys_debug_db ? $e->getMessage() : '[DB] Error Reading Data';
	}
	
	if(isset($core[0]) && is_array($core) ){ 
		$str =' '; 
		foreach($core as $val){
			$str .= '
		<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#'.$val['tipe'].$val['id'].'">
			'.$val['judul'].'
			</a>
			</h4>
		</div>
		<div id="'.$val['tipe'].$val['id'].'" class="panel-collapse collapse">
			<div class="panel-body">'.$val['keterangan'].' </div>
			</div>
		</div>
			';
		}
		echo $str; 
	}
?>
		</div>
		</div>
		</div>
		</div>
	</div>
	</div>
</div>