<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Manage</a></li>
					<li class="active"><span> User Profile </span></li>
				</ol>
			<h1>User Profile </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 "> 
				<div class="col-lg-4">
					<div id="user-profile" class="main-box clearfix">
						<div style="min-height:200px; margin: 100px 50%;"><img src="<?php echo $asset; ?>loading.gif" /></div>
					</div>
				</div>
				<div class="col-lg-8"> 
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-preview">Umum</a></li> 
					</ul>
					<div class="tab-content tab-content-body main-box clearfix" >
						<div id="tab-preview" class="tab-pane fade in active">
							<div style="min-height:200px; margin: 100px 50%;"><img src="<?php echo $asset; ?>loading.gif" /></div>
						</div>
					</div> 
				</div>
			</div>
		</div>
		
		
</div></div>
<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>'; 

loadCSS("<?php echo $__tema; ?>plugins/datatables/css/datatables.css");
//loadCSS("<?php echo $asset ?>plugins/datatables/css/dataTables.fixedHeader.css");
//loadCSS("<?php echo $asset ?>plugins/datatables/css/dataTables.tableTools.css");
loadJS([
	"<?php echo $__tema ?>plugins/datatables/js/jquery.dataTables.min.js"
	,"<?php echo $__tema ?>plugins/datatables/js/dataTables.bootstrap.min.js"
],'<?php echo $__tema ?>js/jadi/user-profile.js','content-wrapper');


</script>