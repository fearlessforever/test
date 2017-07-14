<head>
    	<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
		<meta name="author" content="Helmi">
		
	    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $asset; ?>/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $asset; ?>/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $asset; ?>/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $asset; ?>/ico/apple-touch-icon-57-precomposed.png">
		<link rel="shortcut icon" href="<?php echo $asset; ?>/favicon.ico"  type="image/x-icon" >

	    <title><?php echo isset($title['isi1']) ? 'Dashboard : '.$title['isi1'] : 'No Title'; ?></title>

	    <!-- Bootstrap core CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo $__tema; ?>css/bootstrap/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $__tema; ?>css/libs/font-awesome.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $__tema; ?>css/libs/nanoscroller.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $__tema; ?>css/compiled/theme_styles.css"/>
		
		<script>
		var requireJS=[
			"<?php echo $__tema; ?>js/bootstrap.min.js"
			,"<?php echo $__tema; ?>plugins/pace/pace.min.js"
			,"<?php echo $__tema; ?>plugins/jquery-cookie/jquery.cookie.min.js"
			,"<?php echo $__tema; ?>plugins/gritter/js/jquery.gritter.min.js"
			//,"<?php echo $__tema; ?>plugins/autosize/jquery.autosize.min.js"
			,"<?php echo $__tema; ?>js/jquery.nanoscroller.min.js"
			,"<?php echo $__tema; ?>js/scripts.js"
			,"<?php echo $__tema; ?>js/demo.js"
			,"<?php echo $__tema; ?>js/jadi/intinya.js"
		];
		var cssArray={},helmi={}; helmi.quot=function(a){ var b=[]; if(a instanceof Array || a instanceof Object ){ $.each(a,function(k,val){ b[k]=val.replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }); return b; } return a; }; helmi.amankan=function(a){return a.replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/'/g,'&#039;');};
		helmi.form_e =function(a,b){
			if(a instanceof Object){
				a.parents('div.form-group').find('input').focus();
				var c = a.parents('div.form-group').find('span.help-block') ; b = (typeof b !== 'undefined')?b:'Ada Kesalahan Disini';
				if( c.length > 0 ){
					c.html(b);
				}else{ a.parents('div.form-group').addClass('has-error').append('<span class="help-block">'+b+'</span>'); }
			}
		};
		helmi.notif = <?php echo empty($sys_notif) ? 'false' : 'true'; ?>;
		helmi.form_o =function(a){
			if(a instanceof Object){
				a.parents('div.form-group').removeClass('has-error').addClass('has-success').find('span.help-block').remove();
			}
		};
		helmi.home="<?php echo $home; ?>",helmi.asset="<?php echo $asset; ?>",helmi.current="<?php echo $__current; ?>",helmi.controller='',helmi.tema="<?php echo $__tema; ?>";
		
		function loadJS(e,t,target){ for(i=0;i<e.length;i++){ var n= (typeof target !== 'undefined') ? document.getElementById(target) : document.getElementsByTagName("body")[0],r=document.createElement("script"); r.type="text/javascript";r.async=!1;r.src=e[i];n.appendChild(r) } if(t){ var n=(typeof target !== 'undefined') ? document.getElementById(target) : document.getElementsByTagName("body")[0],r=document.createElement("script"); r.type="text/javascript";r.async=!1;r.src=(typeof target !== 'undefined')?t +'?_='+Math.random() : t;n.appendChild(r) }if(typeof init === 'function')init() }function loadCSS(e,t,n){if(!cssArray[e]){cssArray[e]=!0;if(t==1){var r=document.getElementsByTagName("head")[0],i=document.createElement("link");i.setAttribute("rel","stylesheet");i.setAttribute("type","text/css");i.setAttribute("href",e);i.onload=n;r.appendChild(i)}else{var r=document.getElementsByTagName("head")[0],s=document.getElementById("main-style"),i=document.createElement("link");i.setAttribute("rel","stylesheet");i.setAttribute("type","text/css");i.setAttribute("href",e);i.onload=n;r.insertBefore(i,s)}}else n&&n()}
		</script>
</head>
<?php
/*
// INI javascript function untuk loadJS ny no cache
function loadJS(e,t,target){ for(i=0;i<e.length;i++){ var n= (typeof target !== 'undefined') ? document.getElementById(target) : document.getElementsByTagName("body")[0],r=document.createElement("script"); r.type="text/javascript";r.async=!1;r.src=e[i];n.appendChild(r) } if(t){ var n=(typeof target !== 'undefined') ? document.getElementById(target) : document.getElementsByTagName("body")[0],r=document.createElement("script"); r.type="text/javascript";r.async=!1;r.src=(typeof target !== 'undefined')?t+'?t='+Math.random():t;n.appendChild(r) }init() }


		<link rel="stylesheet" href="<?php echo $__tema; ?>css/libs/fullcalendar.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo $__tema; ?>css/libs/fullcalendar.print.css" type="text/css" media="print"/>
		<link rel="stylesheet" href="<?php echo $__tema; ?>css/compiled/calendar.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="<?php echo $__tema; ?>css/libs/morris.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo $__tema; ?>css/libs/daterangepicker.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo $__tema; ?>css/libs/jquery-jvectormap-1.2.2.css" type="text/css"/>
*/