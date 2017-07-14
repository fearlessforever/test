<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><span>Dashboard</span></li>
				</ol>
				<h1>Dashboard</h1>
			</div>
		</div>		
		<div class="row">
			<div class="col-lg-12">
				<div class="main-box">
					<header class="main-box-header clearfix"> <h2 class="pull-left">Selamat Datang <span class="label label-success"><?php echo Model\User::$data['nama']; ?></span></h2>  </header>
					<div class="main-box-body">
						<p>Ini adalah Halaman Dashboard <strong><?php echo $web_name; ?></strong></p>
						<p>Mohon lakukan pengisian data atau pun perubahan data dengan bijaksana di halaman Dashboard ini, karena segala perubahan atau penambahan data akan ditampilkan dihalaman Utama WEB <strong><?php echo $web_name; ?></strong></p>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
<script>
	helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';
	
	//loadCSS("<?php echo $asset ?>css/blablabla.css");
	
	loadJS([
		"<?php echo $__tema; ?>js/reset.js"
	],"",'content-wrapper');
	
</script>