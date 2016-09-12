<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">

	<title>Comarcas de Lujan</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico">
	<!--<link rel="apple-touch-icon" href="demos/images/apple-touch-icon.png">-->

	<!-- jQuery (required) -->

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"><\/script>')</script>

	<!-- Anything Slider optional plugins -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.easing.1.2.js"></script>
	<!-- http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js -->
	<script src="<?php echo base_url(); ?>assets/js/swfobject.js"></script>

	<!-- Demo stuff -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/page.css" media="screen">

	<!-- AnythingSlider -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/anythingslider.css">
	<script src="<?php echo base_url(); ?>assets/js/jquery.anythingslider.js"></script>

	<!-- AnythingSlider video extension; optional, but needed to control video pause/play -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.anythingslider.video.js"></script>

	<!-- Ideally, add the stylesheet(s) you are going to use here,
	 otherwise they are loaded and appended to the <head> automatically and will over-ride the IE stylesheet below -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/comarcas.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme-metallic.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme-minimalist-round.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme-minimalist-square.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme-construction.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme-cs-portfolio.css">

	<!-- Older IE stylesheet, to reposition navigation arrows, added AFTER the theme stylesheet above -->
	<!--[if lte IE 7]>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/anythingslider-ie.css" type="text/css" media="screen" />
	<![endif]-->

	<script>
		// Demo functions
		// **************
		$(function(){

			// External Link with callback function
			$("#slide-jump").click(function(){
				$('#slider2').anythingSlider(4, function(slider){ /* alert('Now on page ' + slider.currentPage); */ });
				return false;
			});

			// External Link
			$("a.muppet").click(function(){
				$('#slider1').anythingSlider(5);
				$(document).scrollTop(0); // make the page scroll to the top so you can watch the video
				return false;
			});

			// Report Events to console & features list
			$('#slider1, #slider2').bind('before_initialize initialized swf_completed slideshow_start slideshow_stop slideshow_paused slideshow_unpaused slide_init slide_begin slide_complete', function(e, slider){
				// show object ID + event (e.g. "slider1: slide_begin")
				var txt = slider.$el[0].id + ': ' + e.type + ', now on panel #' + slider.currentPage;
				$('#status').text(txt);
				if (window.console && window.console.firebug){ console.debug(txt); } // added window.console.firebug to make this work in Opera
			});

			// Theme Selector (This is really for demo purposes only)
			var themes = ['minimalist-round','minimalist-square','metallic','construction','cs-portfolio'];
			$('#currentTheme').change(function(){
				var theme = $(this).val();
				$('#slider1').closest('div.anythingSlider')
					.removeClass( $.map(themes, function(t){ return 'anythingSlider-' + t; }).join(' ') )
					.addClass('anythingSlider-' + theme);
				$('#slider1').anythingSlider(); // update slider - needed to fix navigation tabs
			});

			// Add a slide
			var imageNumber = 1;
			$('button.add').click(function(){
				$('#slider1')
					.append('<li><img src="<?php echo base_url(); ?>assets/imagenes/slide-tele-' + (++imageNumber%2 + 1)  + '.jpg" alt="" /></li>')
					.anythingSlider(); // update the slider
			});
			$('button.remove').click(function(){
				$('#slider1 > li:not(.cloned):last').remove();
				$('#slider1').anythingSlider(); // update the slider
			});

		});
	</script>

	<script>
		// Set up Sliders
		// **************
		$(function(){

			$('#slider1').anythingSlider({
				theme           : 'default',
				easing          : 'easeInOutBack',
				onSlideComplete : function(slider){
					// alert('Welcome to Slide #' + slider.currentPage);
				}
			});

			$('#slider2').anythingSlider({
				resizeContents      : false, // If true, solitary images/objects in the panel will expand to fit the viewport
				navigationSize      : 3,     // Set this to the maximum number of visible navigation tabs; false to disable
				navigationFormatter : function(index, panel){ // Format navigation labels with text
					return ['Recipe', 'Quote', 'Image', 'Quote #2', 'Image #2'][index - 1];
				},
				onSlideComplete: function(slider) {
					// keep the current navigation tab in view
					slider.navWindow( slider.currentPage );
				}
			});

		});
	</script>
</head>

<body id="main">
   <!-- <div style="position:relative; float:left;width:180px;padding:10px; height:600px;">
                <div style="position:relative; top:10px;"><img src="<?php echo base_url();?>assets/imagenes/logocomarcas.png" /></div>
                <div class="transparent"  style="position:relative; top:-150px;width:100%; height:100%; background-color: #000000;"></div>
    </div>-->
	<div id="page-wrap" style="position:relative; height:95%; width:95%;">

            
			<!-- AnythingSlider #1 -->
			<ul id="slider1" styles="position:relative; top:10px; width:100%;">

				<li><img src="<?php echo base_url(); ?>assets/imagenes/slide-civil-1.jpg" alt=""></li>

				<li><img src="<?php echo base_url(); ?>assets/imagenes/slide-env-1.jpg" alt=""></li>

				<li><img src="<?php echo base_url(); ?>assets/imagenes/slide-civil-2.jpg" alt=""></li>

				<li><object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/zSgiXGELjbc&amp;hl=en_US&amp;fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/zSgiXGELjbc&amp;hl=en_US&amp;fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object></li>

				<li class="panel5">
					<div>
						<div class="textSlide">
						<span class="rightside"><object width="500" height="325"><param name="movie" value="http://www.youtube.com/v/2Qj8PhxSnhg&amp;hl=en_US&amp;fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/2Qj8PhxSnhg&amp;hl=en_US&amp;fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="500" height="325"></embed></object></span>
							<h3>Other Information</h3>

							<br>
							<ul>
								<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla aliquet accumsan eros, et iaculis massa fringilla auctor.</li>
								<li>Proin a mi ante, ut lobortis risus. Sed fringilla augue sed enim faucibus eget aliquam tellus ultricies.</li>
								<li>Morbi a magna eu ligula scelerisque lobortis vel non nisi.</li>
								<li>Aliquam condimentum libero eget elit ultrices sit amet ullamcorper felis gravida.</li>
							</ul>

						</div>
					</div>
				</li>

				<li><img src="<?php echo base_url(); ?>assets/imagenes/slide-env-2.jpg" alt=""></li>

			</ul>  <!-- END AnythingSlider #1 -->

			<br><br>

			

		<br>
                
		

		

	</div>

</body>

</html>