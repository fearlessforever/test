<?php use Saya\Lang ; Lang::load( array('form') ); ?>

<style>
<?php 
echo (!empty($sys_bg['isi1']) && !empty($sys_bg['isi2'])) ?  'body{background:url('.$asset.$sys_bg['isi2'].$sys_bg['isi1'].') ; background-position: right top; background-attachment: fixed;}' : '';
?>
/* @media screen and (min-width: 1000px) {
	.tambahan{
		margin: 5px!important;
	}
} */
ul#myCarousel{
	list-style: none;
	margin: 0;
	padding: 0;
	height: 0;
	padding-bottom: 75%;
	/* background-color: #333; */
	position: relative;
	overflow: hidden;
}
/* ul#myCarousel li:nth-child(n){
	 display:none;
}
ul#myCarousel li:first-child{
	 display:block!important;
} */
.slider-wrapper{
	margin:70px auto 5px; text-align:center;
	max-width:600px ; 
}
.slider-wrapper li img{
	border-radius:17px; width:100%; height:00%;
}
</style>
<?php 
	/*
	<div class="col-md-8 hidden-sm hidden-xs">
				<!-- <div class="slider-wrapper">
				<ul id="sliderz" >
					<li><img src="<?php echo $asset; ?>upload/1.jpg" /></li>
					<li><img src="<?php echo $asset; ?>upload/2.jpg" /></li> 
					<li><img src="<?php echo $asset; ?>upload/3.jpg" /></li> 
					<li><img src="<?php echo $asset; ?>upload/4.jpg" /></li> 
				</ul> 
				</div> -->
				<div id="myCarousel" class="slider-wrapper carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2" class="active"></li>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
					<div class="item">
					  <img src="<?php echo $asset; ?>upload/1.jpg" alt="Chania">
					  <div class="carousel-caption">
						<h3>Chania</h3>
						<p>The atmosphere in Chania has a touch of Florence and Venice.</p>
					  </div>
					</div>

					<div class="item">
					  <img src="<?php echo $asset; ?>upload/2.jpg" alt="Chania">
					  <div class="carousel-caption">
						<h3>Chania</h3>
						<p>The atmosphere in Chania has a touch of Florence and Venice.</p>
					  </div>
					</div>

					<div class="item active">
					  <img src="<?php echo $asset; ?>upload/3.jpg" alt="Flower">
					  <div class="carousel-caption">
						<h3>Flowers</h3>
						<p>Beatiful flowers in Kolymbari, Crete.</p>
					  </div>
					</div>
					
				  </div>

				  <!-- Left and right controls -->
				  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div>
			</div>
	*/
?>
<div id="login-full-wrapperz">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div id="login-box" class="tambahan">
					<div id="login-box-holder">
						<div class="row">
						<div class="col-xs-12">
						<header id="login-header">
						<div id="login-logo">
						<img alt="" src="<?php echo $__tema; ?>img/logo.png">
						</div>
						</header>
						<div id="login-box-inner">
						<form action="" role="form">
						<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user" style="color:black;"></i></span>
						<input id="loginmail" name="username" type="text" placeholder="<?php echo Lang::get('form_holder_user|email'); ?>" class="form-control">
						</div>
						<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key" style="color:black;"></i></span>
						<input id="loginpass" name="password" type="password" placeholder="<?php echo Lang::get('form_holder_password'); ?>" class="form-control">
						</div>
						<div class="input-group">
						<span class="input-group-addon" style="padding:7px;"> <img src="<?php echo $home; ?>misc/captcha/login" /> </span> 
						<input name="captcha" type="text" placeholder="Type The Captcha" class="form-control">
						</div>
						<div id="remember-me-wrapper">
						<div class="row">
						<div class="col-xs-6">
							<div class="checkbox-nice">
								<input type="checkbox" id="remember-me" name="remember" > <label for="remember-me"> <?php echo Lang::get('form_text_remember'); ?> </label>
							</div>
						</div>
						<a class="col-xs-6" id="login-forget-link" > <?php echo Lang::get('form_text_forgot_pass'); ?> </a>
						</div>
						</div>
						</form>
						<div class="row">
						   <div class="col-xs-12">
							<button class="btn btn-success col-xs-12" type="submit"> <?php echo Lang::get('form_text_login'); ?> </button>
						   </div>
						</div> 
						<div class="row">
						   <div class="col-xs-12">
						   	<div id="gambar-loading" style="text-align:center; display:none;"><img src="<?php echo $asset; ?>loading.gif" style="max-height:90px;" /></div>
							<p class="social-text" ><?php echo (!empty($__error_login) ? '<div class="alert alert-danger"><strong> ERROR : </strong> '.$__error_login.'<button class="close" data-dismiss="alert">&times;</button></div>' : '' );?></p>
						   </div>
						</div>
						<div class="row">
						 
						<div class="col-xs-12 col-sm-6">
						<a class="btn btn-primary col-xs-12 btn-facebook" href="<?php echo $home; ?>login-by-facebook">
						<i class="fa fa-facebook"></i> Facebook
						</a>
						</div>
						<div class="col-xs-12 col-sm-6">
							<a class="btn btn-primary col-xs-12 btn-twitter" onClick="alert('Login By using Twitter Not Supported ... yet ');"> <i class="fa fa-twitter"></i> Twitter </a>
						</div> 
						</div>
						
						</div>
						</div>
						</div>
					</div>
					
				</div>
			</div>
			<img src="<?php echo $asset; ?>loading.gif" style="display:none;" />
		</div>
	</div>
</div>