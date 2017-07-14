<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">System</a></li>
					<li class="active"><span> Manage User</span></li>
				</ol>
			<h1>User Management </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 "> 
				<div class="main-box clearfix">
					<header class="main-box-header clearfix"> <h2 class="pull-left">List</h2>  </header>
				<div class="main-box-body">
				<ul class="nav nav-tabs"> 
					<li class="active"><a href="#tab1" data-toggle="tab">List Level</a></li>
					<li class=""><a href="#tab2" data-toggle="tab">List User </a></li>
					<li class=""><a href="#tab3" data-toggle="tab">List Application Permission </a></li>
				</ul>
				<p>
					<div class="tab-content" >
						<div class="tab-pane active" id="tab1">
							
							<p>
								<button class="btn btn-info" data-tombol="tambah-lvl"><i class="fa fa-plus-circle"></i> Add LeveL Login</button>
							</p>
							<p> Level Login Ke dalam System ini</p>
							<div class="table-responsive">
							<table class="table " id="hahaha">
								<thead style="background-color:rgb(116, 20, 152);color:white; "><tr><th >Level</th><th >Keterangan</th><th >Rate (1- 5)</th><th >Action</th></tr></thead> 
								<tbody > </tbody>
							</table>
							</div>
						</div>
						<div class="tab-pane " id="tab2">
							
							<p><button class="btn btn-info" data-tombol="tambah-user"><i class="fa fa-plus-circle"></i> Add User</button></p>
							<p> User dalam System ini</p>
							<div class="table-responsive">
							<table class="table " style="min-width:900px;">
								<thead style="background-color:#18d234;color:white;"><tr><th >ID</th><th >Username</th><th>Email</th><th >LeveL</th><th >Nama</th><th >Buat</th><th >Status</th><th >Action</th></tr></thead>
								<tbody> </tbody>
							</table>
							</div>
						</div>
						<div class="tab-pane " id="tab3">
							<p><button class="btn btn-info" data-tombol="tambah-izin"><i class="fa fa-plus-circle"></i> Add Application For Level Login</button></p>
							<p> Level admin Tidak memerlukan Application permission , semua aplikasi bisa di akses admin</p>
							<div class="table-responsive">
							<table class="table ">
								<thead style="background-color:rgb(43, 138, 198);color:white;"><tr><th >Level</th><th>Ket. LvL </th><th>Application </th><th>App. Status </th><th>Ket. Application </th> <th >Action</th></tr></thead>
								<tbody> </tbody>
							</table>
							</div>
						</div>
					</div>
				</p>
				</div>
					
				</div>
			</div>
		</div>
		
		
</div></div>

<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';

loadCSS("<?php echo $__tema ?>plugins/bootstrap-ext/bootstrap-select/bootstrap-select.css");
loadCSS("<?php echo $__tema ?>plugins/easytable/easyTable.css");

//loadJS([],"<?php echo $asset ?>js/reset.js" );
/* requireJS.push( "<?php echo $asset ?>plugins/easytable/easyTable.js" );
requireJS.push( "<?php echo $asset ?>plugins/a/bootstrap-ext/bootstrap-select/bootstrap-select.js" );
requireJS.push( "<?php echo $asset ?>js/reset.js" );
requireJS.push( "<?php echo $asset ?>js/manage-user.js" ); */

loadJS([
	/* "<?php echo $asset ?>plugins/datatables/js/jquery.dataTables.min.js"
	,"<?php echo $asset ?>plugins/datatables/js/dataTables.bootstrap.min.js" */
	"<?php echo $__tema; ?>plugins/easytable/easyTable.js"
	,"<?php echo $__tema; ?>plugins/bootstrap-ext/bootstrap-select/bootstrap-select.js"
	,"<?php echo $__tema; ?>js/reset.js"
],'<?php echo $__tema; ?>js/jadi/manage-user.js','content-wrapper');

</script>