<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
?>


<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 1600px; height: 500px; overflow: hidden;">
    <!-- Slides Container -->
    <div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 1600px; height: 530px; overflow: hidden;">
       
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_10.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_8.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_22.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_3.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_5.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_16.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_13.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_24.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_17.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_6.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_19.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_4.jpg" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_21.png" /></div>
        <div><img u="image" src="<?php echo $rutaBloque ?>/images/slide_23.jpg" /></div>
        
    </div>
</div>