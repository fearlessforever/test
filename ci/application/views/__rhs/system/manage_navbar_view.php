<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">System</a></li>
					<li class="active"><span> Manage NavBar</span></li>
				</ol>
				<h1> Manage Navigation Bar </h1>
			</div>
		</div>		
		<div class="row">
			<div class="col-lg-12">
				<div class="main-box">
					<header class="main-box-header clearfix"> <h2 class="pull-left">Data Navigation Bar</h2> </header>
					<div class="main-box-body" >
						<ul class="nav nav-tabs"> 
							<li class="active"><a href="#tab1" data-toggle="tab">Navbar List</a></li>
							<li ><a href="#tab2" data-toggle="tab">Navbar Sub</a></li>
						</ul>
						<div class="tab-content" >
						<div class="tab-pane active" id="tab1" data-tombol="tampil-table-1"> 
							<p style="margin-top:27px;margin-bottom:27px;"> List Bar Navigasi di Dashboard
							<button class="btn btn-sm btn-success pull-right" data-tombol="tambah"><i class="fa fa-plus-circle"></i> Tambah </button>
							</p>
							<div class="clearfix"></div>
						 <div class="table-responsive">
							<table class="table table-hover ">
								<thead style="color: rgb(255, 255, 255); background-color: rgb(144, 15, 138); font-weight: bold;"><tr><th>Id</th><th> Keterangan </th><th> Icon </th><th>Link </th><th>Action </th> </tr></thead>
								<tbody ><tr><td colspan="5" ><h2>Tidak Ada Data</h2></td></tr></tbody>
							</table>
						 </div>
						 
						</div>
						
						<div class="tab-pane" id="tab2" data-tombol="tampil-table-2">
							<p></p>
							<h2>Silahkan Pilih Terlebih Dahulu Salah Satu dari Navbar di Tab Pertama</h2>
							<p><button class="btn btn-success " data-tombol="tambah-sub"><i class="fa fa-plus-circle"></i> Tambah Sub</button></p>
							
							<div class="table-responsive">
								<table class="table table-hover ">
									<thead style="background-color: rgb(29, 136, 204); color: #fff;"><tr><th>Link</th><th> Keterangan </th><th> Icon </th><th> Id </th><th>Action </th> </tr></thead>
									<tbody ><tr><td colspan="4" ><h2>Tidak Ada Data</h2></td></tr></tbody>
								</table>
							 </div>
						</div>
						</div>
						<div class="text-center" data-tombol="gambar-loading" ><img src="<?php echo $asset; ?>loading.gif" /></div>
						<button style="display:none;" data-tombol="edit-komentar"> </button>
						<button style="display:none;" data-tombol="edit-komentar-i"> </button>
						<div style="display:none;">
							<div data-tombol="form-1">
								<div class="input-group"><label class="input-group-addon">Keterangan : </label><input class="form-control" name="ket" placeholder="Keterangan" /></div>
								<div class="input-group"><label class="input-group-addon">Class Icon : </label><input class="form-control" name="icon" placeholder="Misal : fa fa-gear" /></div>
								<div class="input-group"><label class="input-group-addon">Link : </label><input class="form-control" name="url" placeholder="Misal : tes.html" /></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
<style>
#modalnya-bro .modal-body .listTombol button,#modalnya-bro .modal-body .input-group{
	margin: 7px 0;
}
</style>
<script>
	helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';
	
	//loadCSS("<?php echo $asset ?>css/blablabla.css");
	loadCSS("<?php echo $__tema; ?>plugins/bootstrap-ext/bootstrap-select/bootstrap-select.css");
	loadJS('',"<?php echo $__tema; ?>js/reset.js",'content-wrapper');
	
	loadJS([
		"<?php echo $__tema; ?>plugins/bootstrap-ext/bootstrap-select/bootstrap-select.js"
	],"<?php echo $__tema; ?>js/system/manage-app-navbar.js",'content-wrapper');
	
</script>