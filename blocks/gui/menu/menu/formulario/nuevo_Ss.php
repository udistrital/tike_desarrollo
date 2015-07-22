<?php

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
                    <a href="<?php echo $enlaceRegistroOrdenCompra['urlCodificada'] ?>"><?php echo $enlaceRegistroOrdenCompra['nombre'] ?></a>
                    <a href="<?php echo $enlaceConsultaOrdenCompra['urlCodificada'] ?>"><?php echo $enlaceConsultaOrdenCompra['nombre'] ?></a>
                    <a href="<?php echo $enlaceRegistroOrdenServicios['urlCodificada'] ?>"><?php echo $enlaceRegistroOrdenServicios['nombre'] ?></a>
                    <a href="<?php echo $enlaceConsultaOrdenServicios['urlCodificada'] ?>"><?php echo $enlaceConsultaOrdenServicios['nombre'] ?></a>
                    <a href="<?php echo $enlacegestionContrato['urlCodificada'] ?>"><?php echo $enlacegestionContrato['nombre'] ?></a>
                    <a href="<?php echo $enlacegestionActa['urlCodificada'] ?>"><?php echo $enlacegestionActa['nombre'] ?></a>
                    <a href="<?php echo$enlaceconsultaActa['urlCodificada'] ?>"><?php echo $enlaceconsultaActa['nombre'] ?></a>
                    <a href="#">--------</a>

                </div>
            </li>
            
             <li><a href="#"> <img src="<?php echo $rutaBloque ?>/css/images/Entrada.png" alt="" /> 
                    <span class="sdt_active">
                    </span> <span class="sdt_wrap"> 
                        <span class="sdt_link"><center>ENTRADAS</center></span> 
                </a>
                <div class="sdt_box">
                  
	
                </div>
            </li>


		<li><a href="#"> <img src="<?php echo $rutaBloque ?>/css/images/Entrada.png" alt="" /> 
		            <span class="sdt_active">
		            </span> <span class="sdt_wrap"> 
		                <span class="sdt_link"><center>CATALOGO</center></span> 
		        </a>
		        <div class="sdt_box">
		            
		           
	
		        </div>
            </li>


        </ul>
    </div>
</div>


