<div class="table">
<?php $base = base_url();?>
        <ul class="select"><li><a id="barrios" href="<?php echo $base; ?>admin/barrios/index" ><b>Barrios</b></a></li></ul>
        <!--<div class="nav-divider">&nbsp;</div>-->
        <ul class="select"><li><a id="viviendas" href="<?php echo $base; ?>admin/viviendas/index" ><b>Viviendas</b></a></li></ul>
                <ul class="select"><li><a id="rociadas" href="<?php echo $base; ?>admin/viviendas/rociadas" ><b>Rociadas</b></a></li></ul>

        <ul class="select"><li><a id="ordenes" href="<?php echo $base; ?>admin/ordenes/index" ><b>Ordenes</b></a></li></ul>
        
        <ul class="select"><li><a id="lugares" href="<?php echo $base; ?>admin/lugares/index" ><b>Lugares</b></a></li></ul>
        
        <ul class="select"><li><a id="ciclos" href="<?php echo $base; ?>admin/ciclos/index" ><b>Ciclos</b></a></li></ul>
        
        <ul class="select"><li><a id="relaciones" href="<?php echo $base; ?>admin/relaciones/index" ><b>Relaciones</b></a></li></ul>
        
        
        <div class="clear"></div>
</div>
<script>
function borrarItem(url){
    var txt;
    if (confirm("¿Querés borrar este item?") == true) {
        window.location=url;
    }  
}
</script>