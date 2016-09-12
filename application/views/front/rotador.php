<div id="slideshow">
    <?php
    $rot = 0;

    if(isset($imgs) && count($imgs)>0){
    foreach ($imgs as $img) {
        if ($rot == 0) {
            ?>
            <img src="<?php echo base_url(); ?>assets/imagenes/<?php echo $img['path']; ?>" alt="Slideshow Image " class="active" />
        <?php } else { ?>
            <img src="<?php echo base_url(); ?>assets/imagenes/<?php echo $img['path']; ?>" alt="Slideshow Image "  />
            <?php
        }
        $rot = 1;
    }
}else{

    echo "NO HAY IMAGEN";
}
    ?>

</div>
