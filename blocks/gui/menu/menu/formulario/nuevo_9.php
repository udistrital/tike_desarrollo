<?php
// var_dump($this->miConfigurador);
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

// Registro Orden Compra
$enlaceRegistroOrdenCompra ['enlace'] = "pagina=registrarOrdenCompra";
$enlaceRegistroOrdenCompra ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceRegistroOrdenCompra ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceRegistroOrdenCompra ['enlace'], $directorio);
$enlaceRegistroOrdenCompra ['nombre'] = "Registrar Orden de Compra";

// consultar y modificar Orden Compra
$enlaceConsultaOrdenCompra ['enlace'] = "pagina=consultaOrdenCompra";
$enlaceRegistroOrdenCompra ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceConsultaOrdenCompra ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceConsultaOrdenCompra ['enlace'], $directorio);
$enlaceConsultaOrdenCompra ['nombre'] = "Consultar y Modificar Orden de Compra";

// Registro de Contrato

$enlacegestionContrato['enlace'] = "pagina=gestionContrato";
$enlacegestionContrato['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlacegestionContrato['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlacegestionContrato ['enlace'], $directorio);
$enlacegestionContrato['nombre'] = "Gestión Contrato";

// Gestionar Acta de Recibido

$enlacegestionActa['enlace'] = "pagina=gestionActa";
$enlacegestionActa['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlacegestionActa['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlacegestionActa ['enlace'], $directorio);
$enlacegestionActa['nombre'] = "Gestión Acta de Recibido";

// Gestionar Acta de Recibido

$enlaceconsultaActa['enlace'] = "pagina=consultarActa";
$enlaceconsultaActa['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceconsultaActa['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceconsultaActa['enlace'], $directorio);
$enlaceconsultaActa['nombre'] = "Consultar y Modificar Acta de Recibido";

// Fin de la sesión

$enlaceFinSesion['enlace'] = "pagina=index";
$enlaceFinSesion['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceFinSesion['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceFinSesion['enlace'], $directorio);
$enlaceFinSesion['nombre'] = "Cerrar Sesión";


// var_dump($enlaceRegistroOrdenCompra);exit;
?>
<!--  <div class="wrap">

        <div class="demo-container">
                <div class="black">
                        <ul id="mega-menu-1" class="mega-menu">
                                <li><a href="#">Inicio</a></li>
                                <li><a href="#">Gestión de Compras</a>
                                        <ul>

                                                <li><a href="<?php echo $enlaceRegistroOrdenCompra['urlCodificada'] ?>"><?php echo $enlaceRegistroOrdenCompra['nombre'] ?></a></li>

                                        </ul>
                                </li>
                                <li><a href="#">Gestión de Catalogo</a>
                                        <ul>
                                                
                                        </ul>
                                        
                                        </li>

                                

<?php $pagina = $this->miConfigurador->getVariableConfiguracion("site") ?>
      <li><a href="<?php echo $pagina ?>">Cerrar Sesi&oacute;n</a></li>
                        </ul>
                </div>
        </div>

</div>   -->

<div class="wrap">

    <div class="content">

        <ul id="sdt_menu" class="sdt_menu">
            <li><a href="#"> <img src="<?php echo $rutaBloque ?>/css/images/arka.png" alt="" /> 
                    <span class="sdt_active">
                    </span> <span class="sdt_wrap"> 
                        <span class="sdt_link"><center>ARKA</center></span> 
                </a>
                <div class="sdt_box">
                    <a href="<?php echo$enlaceFinSesion['urlCodificada'] ?>"><?php echo $enlaceFinSesion['nombre'] ?></a>
                </div>
            </li>

            <li><a href="#"> <img src="<?php echo $rutaBloque ?>/css/images/buy.png" alt="" /> 
                    <span class="sdt_active">
                    </span> <span class="sdt_wrap"> 
                        <span class="sdt_link"><center>COMPRAS</center></span> 
                </a>
                <div class="sdt_box">
                    <a href="<?php echo$enlaceRegistroOrdenCompra['urlCodificada'] ?>"><?php echo $enlaceRegistroOrdenCompra['nombre'] ?></a>
                    <a href="<?php echo$enlaceConsultaOrdenCompra['urlCodificada'] ?>"><?php echo $enlaceConsultaOrdenCompra['nombre'] ?></a>
                    <a href="<?php echo$enlacegestionContrato['urlCodificada'] ?>"><?php echo $enlacegestionContrato['nombre'] ?></a>
                    <a href="<?php echo$enlacegestionActa['urlCodificada'] ?>"><?php echo $enlacegestionActa['nombre'] ?></a>
                    <a href="<?php echo$enlaceconsultaActa['urlCodificada'] ?>"><?php echo $enlaceconsultaActa['nombre'] ?></a>
                    <a href="#">--------</a>

                </div>
            </li>


        </ul>
    </div>
</div>


