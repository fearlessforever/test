<!DOCTYPE html>
<html lang="en">
<?php
	$this->load->view('tema/'.$theme.'/header');
	
	/*
	<!-- BODY options, add following classes to body to change options

		1. 'sidebar-minified'     - Switch sidebar to minified version (width 50px)
		2. 'sidebar-hidden'		  - Hide sidebar
		3. 'rtl'				  - Switch to Right to Left Mode
		4. 'container'			  - Boxed layout
		5. 'static-sidebar'		  - Static Sidebar
		6. 'static-header'		  - Static Header
	-->
	*/
	echo '<body class="theme-whbl">';
	
		if(!isset($konten) && isset($logged_in) ){
			/* <!-- start: Header --> */
			//include 'body.1.theme.wrapper.header.php';
			$this->load->view('tema/'.$theme.'/body1_header');
			/*	<!-- end: Header -->*/
			
			
			/* <!-- start: theme wrapper --> */				
			echo '<div id="theme-wrapper">';
			
			echo '<div id="page-wrapper" class="container "><div class="row">';
			//navigation sidebar
			//include 'body.2.theme.wrapper.sidebar.menu.php';
			$this->load->view('tema/'.$theme.'/body2_sidebar');
			/*  <!-- start: Content --> */
			echo '<div id="content-wrapper" class="main"></div>';
			/*	<!-- end: Content --> */
			echo '</div></div>';
			echo '</div>';
			$this->load->view('tema/'.$theme.'/body4_footer');
		}elseif( isset($konten) ){
			echo $konten;
		}
	/* <!-- end: theme wrapper -->  */
	
	/*  <!-- start: Main Menu -->  */
		//include 'body.3.config.php';
		if($sys_demo)$this->load->view('tema/'.$theme.'/body3_config');
	/*	<!-- end: Main Menu --> */
	
	/*  <!-- start: JavaScript-->  */
	
	
	if(isset($halaman_js))
		echo $halaman_js;
	else{
		if(isset($logged_in))$this->load->view('tema/'.$theme.'/body5_js');
		else $this->load->view('tema/'.$theme.'/body5_jss');
	}
		
	
	
	/*  <!-- end: JavaScript-->  */
	echo '</body>';
?>
</html>