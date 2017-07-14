<?php
	use Model\User;
	$_icons =array(
		'fa fa-dashboard','fa fa-table','fa fa-envelope','fa fa-bar-chart-o','fa fa-th-large','fa fa-desktop','fa fa-edit','fa fa-map-marker','fa fa-file-text-o','fa fa-university'
	);
	$_sidebars=array();
	/* $_sidebars=array(
		array('url'=>'dashboard.html','ket'=>'Dashboard')
		,array('url'=>'#','ket'=>'App Web '.$web_name ,
			'sub'=>array(
				array('url'=>'data-news.html','ket'=>'<i class="fa fa-user"></i> Data News')
				,array('url'=>'data-pages.html','ket'=>'<i class="fa fa-check"></i> Data Halaman')
				,array('url'=>'data-comments.html','ket'=>'<i class="fa fa-comments"></i> Data Komentar ')
				,array('url'=>'data-galeri.html','ket'=>'<i class="fa fa-file"></i> Data Galeri ')
				,array('url'=>'data-galeri-album.html','ket'=>'<i class="fa fa-photo"></i> Data Galeri Album')
				,array('url'=>'jg-get-token.html','ket'=>'<i class="fa fa-photo"></i>Report Your Token')
			)
		)
		,array('url'=>'#','ket'=>'App Json '.$web_name ,
			'sub'=>array(
				array('url'=>'public-sambutan.html','ket'=>'<i class="fa fa-heart-o"></i> Kata Sambutan')
				,array('url'=>'public-slider.html','ket'=>'<i class="fa fa-image"></i> Gambar Slide Beranda')
				,array('url'=>'public-medsos.html','ket'=>'<i class="fa fa-users"></i> Data Medsos ')
				,array('url'=>'public-testimoni.html','ket'=>'<i class="fa fa-comments"></i> Data Testimoni ')
				,array('url'=>'public-navigasi-bar.html','ket'=>'<i class="fa fa-comments"></i> Data Navigasi Beranda')
				,array('url'=>'public-blog-widget.html','ket'=>'<i class="fa fa-comments"></i> Data Widget Blog')
			)
		)
		,array('url'=>'#','ket'=>'System','sub'=>array(array('url'=>'manage-user.html','ket'=>'<i class="fa fa-user"></i> User Management'),array('url'=>'manage-app.html','ket'=>'<i class="fa fa-recycle"></i> App Management') ))
		,array('url'=>'sys-info.html','ket'=>'Info : {memory_usage}')
	); */
	try{
		$_sidebars = Saya\DB::table('z_aplikasi_navbar')->select('ket','link as url','sub','icon')->limit(27)->get();
		krsort($_sidebars);
	}catch(PDOException $e){ }
	
?>
<div id="nav-col">
	<section id="col-left" class="col-left-nano">
		<div id="col-left-inner" class="col-left-nano-content">
			<div id="user-left-box" class="clearfix hidden-sm hidden-xs">
				<img alt="" src="<?php echo (isset(User::$data['extra']['folder']) && isset(User::$data['extra']['profile_pic']) )? $asset . User::$data['extra']['folder'] . User::$data['extra']['profile_pic'].'?_='.time() : $asset .'upload/no_image.jpg' ; ?>"/>
				<div class="user-box">
					<span class="name" style="max-width:90px!important; max-height:100px; overflow-x:hidden;"> Welcome<br/> <span ><?php echo User::$data['nama_d']; ?></span> </span>
					<span class="status"> <i class="fa fa-circle"></i> Online </span>
				</div>
			</div>
			<div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
				<ul class="nav nav-pills nav-stacked">
				<li><a href="#dashboard.html"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
<?php

	if(isset($_sidebars[0]) && is_array($_sidebars)){
		$_loc ='';
		foreach($_sidebars as $val){
			if(!empty($val['sub']) && is_string($val['sub'])){
				$val['sub'] = @json_decode($val['sub'] , TRUE);
			}
			
			if(!empty($val['sub']) && is_array($val['sub'])){
				$_loc2='';
				foreach($val['sub'] as $val2){
					$__check = str_replace('.html','',$val2['url']) ;
					if(!isset(User::$data['modul'][$__check  ]) && User::$data['level'] != 'admin')continue;
					$_loc2 .='<li><a href="#'.$val2['url'].'">'.( !empty($val2['icon'])?'<i class="'.$val2['icon'].'"></i> ':'' ).'<span>'.$val2['ket'].'</span></a></li> ';			
				}
				if($_loc2 =='')continue;
				$_loc .='<li><a href="#" class="dropdown-toggle" >'.( !empty($val['icon'])?'<i class="'.$val['icon'].'"></i>':'' ).'<span>'.$val['ket'].'</span><i class="fa fa-chevron-circle-right drop-icon"></i></a>'.( ($_loc2 =='' ? '' : '<ul class="submenu">'.$_loc2.'</ul>')).'</li>';
			}else{
				$_loc .='<li><a href="#'.$val['url'].'">'.( !empty($val['icon'])?'<i class="'.$val['icon'].'"></i>':'' ).'<span>'.$val['ket'].'</span></a></li> ';
	//<span class="label label-info label-circle pull-right">28</span>
			}
		}
		echo $_loc; $_loc=null;
	}
?>
				<li><a href="#sys-info.html"><i class="fa fa-eye"></i><span>Info : {memory_usage}</span></a></li>
				</ul>
			</div>
		</div>
	</section>
</div>