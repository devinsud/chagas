<?php $this->load->view('front/header');

?>
    <article>
        <div id="listado"><dl class="nls"></dl></div>
    </article>
    <article>
            <div id="contenedor">
                <div id="titulo"><h1><?php echo $seccion->titulo; ?></h1></div>
                <div id="main" class="main">
                    <?php echo $seccion->texto; ?>
                </div>
            </div>
    </article>
    <article>
       <?php $this->load->view('front/mapa'); ?>
    </article>
    <article>
        <?php $this->load->view('front/contacto') ?>
    </article>
    <aside>
        <div id="titulo_galeria">Galer&iacute;a</div>
        <div id="galeria"></div>
    </aside>
    <aside>
        <?php $this->load->view('front/rotador'); ?>
    </aside>
    </div>
<script type="text/javascript">
    (function(){
    var $this = this;
    var galerias = "<?php echo $seccion->galerias;?>"

    function change(text,url){

        var main = $('#main'),
                map1 = $('.map'),
                listado = $('#listado'),
                contacto = $('#contacto'),
                main_animate = (url == 'comollegar') ? "-100px" : "0px",
                main_animate = (url == 'noticomarcas' || url=='noticias' ) ? "-200px" : main_animate,
                main_animate = (url == 'documentacion'  ) ? "-200px" : main_animate;


        $("#titulo").animate({"right":"-300px"}, "slow",
            function(){
                        $("#titulo").html(text);
                        $("#titulo").animate({"right":main_animate},"slow");
                        _this = this;
                        main.animate({"right":"-500px"}, "slow",
                                function(){

                                        $.ajax({
                                                url:"<?php echo base_url(); ?>secciones/get_seccion/"+url,
                                                dataType: 'json',
                                                success: function(data){

                                                        $this.galerias = data.galerias;
                                                        _this.sec = data;

                                                        switch(data.tipo){
                                                            case 'mapa':
                                                                map1.show();
                                                                initialize(-34.56969861322237, -59.03709981213376);
                                                                listado.slideUp();
                                                                contacto.slideUp();
                                                                break;
                                                            case 'listado':
                                                                if(data.seccion=='documentacion'){
                                                                    var pepe = $this.lista.init({
                                                                        template: $('#listado-documentos-template').html(),
                                                                        url:"<?php echo base_url(); ?>secciones/get_listado/"+data.seccion

                                                                    });
                                                                }else{
                                                                    var pepe = $this.lista.init({
                                                                        template: $('#listado-template').html(),
                                                                        url:"<?php echo base_url(); ?>secciones/get_listado/"+data.seccion

                                                                    });
                                                                }
                                                                contacto.slideUp();
                                                                listado.slideDown();
                                                                map1.hide();
                                                                break;
                                                            case 'comun':

                                                                main.html(data.texto);
                                                                main.animate({"right":main_animate},"slow");
                                                                map1.slideUp();
                                                                contacto.slideUp();
                                                                listado.slideUp();
                                                                break;
                                                            case 'contacto':
                                                                contacto.slideDown();
                                                                map1.slideUp();
                                                                listado.slideUp();
                                                                break;

                                                            case 'galeria':
                                                                break;



                                                            }



                                 if(_this.sec['galerias']!=''){ //si tiene galerias
                                    $.ajax({
                                        url: base+"secciones/get_galeria/"+url,
                                        success: function(data1){
                                            pp = _this.sec['galerias'].split(',');

                                            if(data1!=''){

                                               $("#galeria").css("display","block");
                                                $("#galeria").html(data1);
                                                $("#galeria").animate({"right":"40%"},"slow");
                                                $("#titulo_galeria").css('display','block');
                                                $("#titulo_galeria").animate({"right":"40%"},"slow");

                                                for(gsx in pp){

                                                    if(pp[gsx]!==""){
                                                     $("a[rel=images_group"+pp[gsx]+"]").fancybox({
                                                                        'transitionIn'      : 'none',
                                                                        'transitionOut'     : 'none',
                                                                        'titlePosition'     : 'over',
                                                                        'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
                                                                            return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                                                                        }
                                                                    })
                                                        }
                                                    }


                                            }else{
                                                $("#galeria").animate({"right":"-40%"}, "slow",
                                                    function(){
                                                        $("#galeria").css("display","none");
                                                        $("#titulo_galeria").animate({"right":"-40%"},"slow",
                                                                function(){
                                                                    $("#titulo_galeria").css("display","none");
                                                                });
                                                    })
                                            }
                                        }
                                    })


                                } else{
                                    $("#galeria").animate({"right":"-40%"}, "slow",
                                                    function(){
                                                        $("#galeria").css("display","none");
                                                        $("#titulo_galeria").animate({"right":"-40%"},"slow",
                                                                function(){
                                                                    $("#titulo_galeria").css("display","none");
                                                                });
                                                    })

                                }//fin if tiene o no
                                                            //console.log($this.galerias);

                                                }
                                        })
                                })




         /*                       if(this.galerias!=''){ //si tiene galerias
                                    $.ajax({
                                        url: base+"secciones/get_galeria/"+url,
                                        success: function(data){
                                            pp = _this.sec.galerias.split(',');
                                            console.log(pp);
                                            if(data!=''){

                                               $("#galeria").css("display","block");
                                                $("#galeria").html(data);
                                                $("#galeria").animate({"right":"40%"},"slow");
                                                $("#titulo_galeria").css('display','block');
                                                $("#titulo_galeria").animate({"right":"40%"},"slow");


                                                    <?php
                                                    //var_dump("galxsec: ".$galXsec);
                                                    foreach ($galXsec as $gxs):
                                                        if ($gxs > 0):
                                                            $tipoGal = $this->varios->getGaleryType($gxs);

                                                            if ($tipoGal == 'foto'):
                                                                ?>
                                                                    alert('llego');
                                                                    $("a[rel=images_group<?php echo $gxs; ?>]").fancybox({
                                                                        'transitionIn'      : 'none',
                                                                        'transitionOut'     : 'none',
                                                                        'titlePosition'     : 'over',
                                                                        'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
                                                                            return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                                                                        }
                                                                    })
                                                            <?php else: ?>
                                                                    $("a[rel=video_group<?php echo $gxs; ?>]").fancybox({
                                                                        'transitionIn'      : 'none',
                                                                        'transitionOut'     : 'none',
                                                                        'titlePosition'     : 'over',
                                                                        'type'                  : 'swf',
                                                                        'swf' :{wmode: 'transparent'},
                                                                        'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
                                                                           // return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                                                                           return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                                                                        }
                                                                    })

                                                                <?php
                                                            endif;
                                                        endif;
                                                    endforeach;
                                                    ?>

                                            }else{
                                                $("#galeria").animate({"right":"-40%"}, "slow",
                                                    function(){
                                                        $("#galeria").css("display","none");
                                                        $("#titulo_galeria").animate({"right":"-40%"},"slow",
                                                                function(){
                                                                    $("#titulo_galeria").css("display","none");
                                                                });
                                                    })
                                            }
                                        }
                                    })


                                } //fin if tiene o no tiene gals
*/
                                 })
            }


//

            $('ul li a').click(function(e){
                e.preventDefault();
                sec=$(this).attr('rel');
                tit=$(this).attr('alt');
                change(tit, sec);


            } );


            change('<?php echo $seccion->titulo; ?>' ,'<?php echo $seccion->seccion; ?>');
        })()

</script>

        </body>

    </html>
