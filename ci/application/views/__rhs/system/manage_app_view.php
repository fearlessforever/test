<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">System</a></li>
					<li class="active"><span> Manage Aplikasi</span></li>
				</ol>
			<h1>Application Management </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 "> 
				<div class="main-box clearfix">
					<header class="main-box-header clearfix"> <h2 class="pull-left">List</h2>  </header>
				<div class="main-box-body">
				<p>
					Untuk Security , di halaman ini hanya untuk pendaftaran Modul Aplikasi kedalam Database , tidak di sedia kan option upload file PHP .
					<br>Hal ini dilakukan untuk mengurangi celah keamanan , Seandainya ada kesalahan dalam System LeveL login Atau User dengan Level Admin melakukan yg seharus ny tidak dibuat .
					<br>Jadi Hanya yang punya akses ke system internal secara langsung yang bisa menambah / merubah File Aplikasi
					<br>P.S :
					<ul>
						<li>Tidak dizinkan menghapus Aplikasi System</li>
						<li>Tidak dizinkan merubah Status App management <span class="label label-warning">[manage-app] </span></li>
					</ul>
				</p>
				<p> <button class="btn btn-info" data-tombol="tambah-app"><i class="fa fa-plus-circle"></i> App Registration to DB</button> </p>
				<div class="table-responsive" id="app">
					<table class="table " >
					<thead style="background-color:rgb(116, 20, 152);color:white; "><tr><th >Application ID</th><th >Ket</th><th >Folder</th><th >File View</th><th >File Model</th><th >Status</th><th >Action</th> </tr></thead> 
					<tbody > </tbody>
					</table>
				</div>
				
				</div>
					
				</div>
			</div>
		</div>
		
		
</div></div>
<style> .ttt{cursor:pointer;} </style>
<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';

loadCSS("<?php echo $__tema; ?>plugins/bootstrap-ext/bootstrap-select/bootstrap-select.css");
loadCSS("<?php echo $__tema; ?>plugins/easytable/easyTable.css");

//loadJS([],"<?php echo $asset ?>js/reset.js" );
loadJS([
	"<?php echo $__tema; ?>plugins/easytable/easyTable.js"
	,"<?php echo $__tema; ?>plugins/bootstrap-ext/bootstrap-select/bootstrap-select.js"
	,"<?php echo $__tema; ?>js/reset.js"
],'<?php echo $__tema; ?>js/jadi/manage-app.js','content-wrapper');

</script>