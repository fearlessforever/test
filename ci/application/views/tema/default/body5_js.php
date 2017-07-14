		<!--[if !IE]>-->
				<script src="<?php echo $__tema; ?>js/jquery-2.1.1.min.js"></script>
		<!--<![endif]-->
		<!--[if IE]>
			<script src="<?php echo $__tema; ?>js/jquery-2.1.1.min.js"></script>
		<![endif]-->
		
		
<script>
	/* requireJS.push ( "<?php echo $__tema; ?>js/bootstrap.min.js" );
	requireJS.push ( "<?php echo $__tema; ?>plugins/pace/pace.min.js" );
	requireJS.push ( "<?php echo $__tema; ?>plugins/jquery-cookie/jquery.cookie.min.js" );
	requireJS.push ( "<?php echo $__tema; ?>plugins/gritter/js/jquery.gritter.min.js" );
	
	requireJS.push ( "<?php echo $__tema; ?>js/demo.js" );
	requireJS.push ( "<?php echo $__tema; ?>js/jquery.nanoscroller.min.js" );
	requireJS.push ( "<?php echo $__tema; ?>js/scripts.js" );	
	requireJS.push ( "<?php echo $__tema; ?>js/jadi/intinya.js" ); */
		
	if(typeof requireJS !== 'undefined' ){
		loadJS(requireJS);
	}
</script>
