<!DOCTYPE html>

<html>
    <head>
        <?php $base = base_url(); ?>
        <title>Altos de San Jos&eacute; | Barrio Privado </title>
        <meta charset="utf-8">

        <link href="<?php echo $base; ?>assets/css/reset.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $base; ?>assets/css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo $base; ?>assets/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script type="text/javascript" src="<?php echo $base; ?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>assets/js/bgfull.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>assets/js/jquery-ui-1.8.14.custom.min.js"></script>
        <!-- jQuery Color Plugin -->
        <script type="text/javascript" src="<?php echo $base; ?>assets/js/jquery.color.js"></script>
        <!-- Import The jQuery Script -->
        <script type="text/javascript" src="<?php echo $base; ?>assets/js/jMenu.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>assets/js/handlebars-1.0.0.beta.6.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>assets/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v3.exp&sensor=false&libraries=places"></script>
        <script type="text/javascript" src="<?php echo $base; ?>assets/js/main.js"></script>
        <script type="text/javascript">
            var base = '<?php echo $base; ?>';

        </script>

    </head>
     <body>

        <div class="wrapper">
            <script id="listado-template" type="text/x-handlebars-template">
                {{#each this}}
                <dt><h2><span> {{fecha}}</span> {{titulo}} </h2> </dt>
                <dd>{{{texto}}}</dd>
                {{/each}}
            </script>
            <script id="listado-documentos-template" type="text/x-handlebars-template">
                {{#each this}}
                <dt> <a class="documento" href="<?php echo site_url('assets/imagenes/{{texto}}'); ?>" target="_blank"> <span class="rojo">+ &nbsp;&nbsp;&nbsp;&nbsp;</span> {{titulo}}</a>  </dt>

                {{/each}}
            </script>
            <script id="listado-eventos-template" type="text/x-handlebars-template">
                {{#each this}}
                <dt> <span>{{fecha_inicio}}</span><a class="evento" href="<?php echo site_url('assets/imagenes/{{texto}}'); ?>" target="_blank"> <span class="rojo">+ &nbsp;&nbsp;&nbsp;&nbsp;</span> {{titulo}}</a>  </dt>

                {{/each}}
            </script>
            <header class="head">
                <hgroup>
                    <h1>Altos de San Jos&eacute;</h1>
                    <h2>Barrio Privado</h2>
                </hgroup>
                <nav>
                    <div id="jQ-menu">
                        <ul>
                            <?php echo $menu; ?>
                        </ul>
                    </div>
                </nav>
            </header>
