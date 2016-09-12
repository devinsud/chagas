<!DOCTYPE html>

<html>
    <head>
        <title>Comarcas de Luj&aacute;n | Pueblo de chacras </title>
        <meta charset="utf-8">
        <link href="<?php echo base_url(); ?>assets/css/reset.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.2.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bgfull.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.14.custom.min.js"></script>
        <!-- jQuery Color Plugin --> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.color.js"></script> 

        <!-- Import The jQuery Script --> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jMenu.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.address-1.4.min.js"></script>

    </head>

    <body>
        <div class="wrapper">

            <header class="head">
                <hgroup>
                    <h1>COMARCAS DE LUJAN</h1>
                    <h2>Pueblo de Chacras</h2>
                </hgroup>
                <nav>   
                    <div id="jQ-menu">
                        <ul>
                            <?php echo $menu; ?>
                        </ul>
                    </div>
                </nav>
            </header>

            <article>
                <div id="contenedor" style="position:absolute; width:40%; height:1500px; right: 0;top: 0px; overflow:hidden; ">
                    <div id="titulo"><h1><?php echo $seccion->titulo; ?></h1></div>
                    <div id="main">
                        <?php echo $seccion->texto; ?>
                    </div> 
                </div>

            </article>
            <aside>

                <div id="galeria">

                </div>

            </aside>
            <aside>
                <div id="slideshow">
                    <img src="<?php echo base_url(); ?>assets/imagenes/image1.jpg" alt="Slideshow Image 1" class="active" />
                    <img src="<?php echo base_url(); ?>assets/imagenes/image2.jpg" alt="Slideshow Image 2" />
                    <img src="<?php echo base_url(); ?>assets/imagenes/image3.jpg" alt="Slideshow Image 3" />
                    <img src="<?php echo base_url(); ?>assets/imagenes/image1.jpg" alt="Slideshow Image 4" />
                    <img src="<?php echo base_url(); ?>assets/imagenes/image2.jpg" alt="Slideshow Image 5" />
                </div>
            </aside>
        </div>
        <script type="text/javascript">
            function change(text,url){
                $("#titulo").animate({"right":"-500px"}, "slow",
                function(){
                    $("#titulo").html(text);
                
                    $("#titulo").animate({"right":"0px"},"slow");
                    $('#main').animate({"right":"-500px"}, "slow",
                    function(){
                        $.ajax({
                            url:"<?php echo base_url(); ?>secciones/get_seccion/"+url,
                            success: function(data){

                                $("#main").html(data);
                                $("#main").animate({"right":"0px"},"slow");
                            }
                        })   
                    })   
                    <?php if ($seccion->galerias != '') { ?>
                        $.ajax({
                            url:"<?php echo base_url(); ?>secciones/get_galeria/"+url,
                            success: function(data){
                                if(data!=''){
                                    $("#galeria").css("display","block");       

                                    $("#galeria").html(data);
                                    $("#galeria").animate({"bottom":"-79%"},"slow"); 

                        <?php
                        foreach ($galXsec as $gxs) {
                            if ($gxs > 0) {
                                ?>

                                 $("a[rel=example_group<?php echo $gxs; ?>]").fancybox({
                                     'transitionIn'		: 'none',
                                     'transitionOut'		: 'none',
                                     'titlePosition' 	: 'over',
                                     'type'                  : 'swf',
                                     'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
                                         return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                                     }
                                 })
                            <?php
                            }
                        }
                        ?>
                                 }else{
                                     $("#galeria").css("display","none");       
                                 }
                             }
                         })   

                    <?php } ?>
                            })
                        }
                        
                        
                        
 $(document).ready(function(){
 
  $(".menu").click(function() {
    $("#titulo").animate({"right":"-500px"}, "slow",
                function(){ 
                    var link = $(this).attr("href"); 
                    var sec = $(this).attr('alt');
                    var titulo = $(this).attr('rel');
                    $("#titulo").html(titulo);
                    $("#titulo").animate({"right":"0px"},"slow");
                    $('#main').animate({"right":"-500px"}, "slow", function(){
                    $.ajax({
                        url:"<?php echo base_url(); ?>secciones/get_seccion/"+sec,
                        success: function(data){
                            $("#main").html(data);
                            $("#main").animate({"right":"0px"},"slow");
                        }
                     })
                    }
                    )
             })
    
    
<?php if ($seccion->galerias != '') { ?>
    $.ajax({
        url:"<?php echo base_url(); ?>secciones/get_galeria/"+sec,
        success: function(data){
            if(data!=''){
                $("#galeria").css("display","block");       
                $("#galeria").html(data);
                $("#galeria").animate({"bottom":"-79%"},"slow"); 
                                        
    <?php
    foreach ($galXsec as $gxs) {
        if ($gxs > 0) {
            ?>    
             $("a[rel=example_group<?php echo $gxs; ?>]").fancybox({
                 'transitionIn'		: 'none',
                 'transitionOut'		: 'none',
                 'titlePosition' 	: 'over',
                 'type'                  : 'swf',
                 'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
                     return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                 }
             })
        <?php
        }
    }
    ?>
      }else{
        $("#galeria").css("display","none");       
      }
   }
   })   
                              
<?php } ?>     
    return false
                   
    
   
    
  });
 
});      
        </script>
    </body>
</html>