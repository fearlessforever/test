		<!--[if !IE]>-->

				<script src="<?php echo $asset; ?>plugins/a/jquery-2.1.1.min.js"></script>

		<!--<![endif]-->

		<!--[if IE]>

			<script src="<?php echo $asset; ?>plugins/a/jquery-2.1.1.min.js"></script>

		<![endif]-->
		
		<script src="<?php echo $asset; ?>plugins/a/bootstrap.min.js"></script>
		<script>
		if(typeof requireJS !== 'undefined'){
			loadJS(requireJS);
		}
		</script>