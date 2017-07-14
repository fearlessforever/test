<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">System</a></li>
					<li class="active"><span> Pengaturan</span></li>
				</ol>
			<h1>Pengaturan System </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 "> 
				<div class="main-box clearfix">
					<header class="main-box-header clearfix">
						<h2 class="pull-left">Settingan Systems</h2> 
					</header>
				<div class="main-box-body">
					<form id="settingan-system">
						<div class="form-group"><label> Alamat : </label><input class="form-control" type="text" name="alamat" value="<?php echo isset($alamat['isi1'])?$alamat['isi1']:''; ?>" /></div>	
						<div class="form-group"><label> Nama System : </label><input class="form-control" type="text" name="title" value="<?php echo isset($title['isi1'])?$title['isi1']:''; ?>" /></div>	
						<div class="form-group"><div class="input-group"><span class="input-group-addon"> <input type="checkbox" name="hapus_boleh" <?php echo (isset($sys_hapus) && $sys_hapus ) ? 'checked' : '' ; ?> /> </span> <input class="form-control" value="Izinkan untuk Hapus Data  " disabled /> </div></div>
						<div class="form-group"><div class="input-group"><span class="input-group-addon"> <input type="checkbox" name="debug_db" <?php echo ($sys_debug_db == 1) ? 'checked' : '' ; ?> /> </span> <input class="form-control" value="Debug DB Error " disabled /> </div></div>
						<div class="form-group"><div class="input-group"><span class="input-group-addon"> <input type="checkbox" name="sys_notif" <?php echo ($sys_notif == 1) ? 'checked' : '' ; ?> /> </span> <input class="form-control" value="System Notification" disabled /> </div></div>
						<input type="hidden" name="controller" value="<?php echo isset($__controller)?$__controller:''; ?>" />
						<input type="hidden" name="mode" value="simpan" />
					</form>
						<button class="btn btn-info" data-tombol="simpan">SIMPAN</button>
						<button class="btn btn-danger" data-tombol="hapus-notif">Clear System Notification</button>
						<button class="btn btn-danger" data-tombol="set-photo-profile">Set Background Image</button>
						<?php if(isset($sys_bg['isi1']) && isset($sys_bg['isi2'])) :?><button class="btn btn-warning" data-tombol="hapus-photo" data-gambar="<?php echo $sys_bg['isi2'].$sys_bg['isi1']; ?>" >Delete Background Image</button> <?php endif; ?>
						<p></p>
				</div>
					
				</div>
			</div>
		</div>
		
		
</div></div>

<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';

loadJS([
	"<?php echo $__tema ?>js/reset.js"
],'<?php echo $__tema ?>js/jadi/systems.js','content-wrapper');

</script>