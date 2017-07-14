<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Soding Test</a></li>
					<li class="active"><span>Task </span></li>
				</ol>
				<h1>Task List</h1>
			</div>
		</div>		
		<div class="row">
			<div class="col-lg-12">
				<div class="main-box">
					<header class="main-box-header clearfix"> <h2 class="pull-left">Task</h2>  </header>
					<div class="main-box-body">
					<p> </p>
					<p><button class="btn btn-success" data-tombol="tambah-scanid"> <i class="fa fa-plus"></i> Add Task </button></p>
						<div class="table-responsive" data-tombol="tampil-table-1">
						<table class="table table-bordered">
						<thead><tr><th> Id</th><th>Task's Name</th><th>Create Date</th><th>Action</th> </tr></thead>
						<tbody><tr><td colspan="4"> <h4>NO DATA YET</h4></td></tr></tbody>
						</table>
						<div class="col-lg-3 pull-right" data-tombol="paginationnya"> </div>
						</div>
					<div class="text-center" data-tombol="gambar-loading" ><img src="<?php echo $asset; ?>loading.gif" /></div>
					</div>
					
						<div style="display:none;">
							<div data-tombol="form-1">
								<div class="input-group">
									<label class="input-group-addon"> Task's Name : </label><input class="form-control" name="task_name"  />
								</div>
								<div class="form-group">
									<label style=" font-weight:bold;" > Description : </label>
									<textarea class="form-control" name="task_desc" style="resize:none;" ></textarea>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
<style>
#modalnya-bro .modal-body .listTombol button{
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
	],"<?php echo $__tema; ?>js/soding/task-list.js",'content-wrapper');
	
</script>