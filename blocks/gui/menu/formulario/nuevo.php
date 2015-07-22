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

$nivel = $miSesion->nivelSesion();
+
// Consulta General
$enlaceConsultaGeneral ['enlace'] = "pagina=consultaGeneral";
$enlaceConsultaGeneral ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceConsultaGeneral ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceConsultaGeneral ['enlace'], $directorio);
$enlaceConsultaGeneral ['nombre'] = "Consultas Generales";

// Reportico
$enlaceReportico ['enlace'] = "pagina=reportico";
$enlaceReportico ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

if($nivel==0)
    {    $enlaceReporticoAdmin ['enlace']=$enlaceReportico ['enlace'];
         $enlaceReporticoAdmin ['enlace'] .= "&informes=admin";
         $enlaceReporticoAdmin ['enlace'] .= "&acceso=sistemasoas";
         $enlaceReporticoAdmin ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceReporticoAdmin ['enlace'], $directorio);
         $enlaceReporticoAdmin ['nombre'] = "Administrar Reportes";
    }

         
if($nivel==0 || $nivel==1)
    {    $enlaceReporticoTes ['enlace']=$enlaceReportico ['enlace'];
         $enlaceReporticoTes ['enlace'] .= "&informes=Tesoreria";
         $enlaceReporticoTes ['enlace'] .= "&acceso=tesoreriaTike";
         $enlaceReporticoTes ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceReporticoTes ['enlace'], $directorio);
         $enlaceReporticoTes ['nombre'] = "Reportes Tesoreria";

    }



// gestion usuarios
$enlaceUsuarios ['enlace'] = "pagina=gestionUsuarios";
$enlaceUsuarios ['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceUsuarios ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceUsuarios ['enlace'], $directorio);
$enlaceUsuarios ['nombre'] = "Gestión Usuarios";

//Administración Dependencias
$enlaceregistrarDependencia ['enlace'] = "pagina=agregarDependencia";
$enlaceregistrarDependencia['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceregistrarDependencia['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceregistrarDependencia['enlace'], $directorio);
$enlaceregistrarDependencia['nombre'] = "Dependencias";

// Fin de la sesión
$enlaceFinSesion['enlace'] = "pagina=index";
$enlaceFinSesion['enlace'] .= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceFinSesion['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceFinSesion['enlace'], $directorio);
$enlaceFinSesion['nombre'] = "Cerrar Sesión";

//------------------------------- Inicio del Menú-------------------------- //

    ?>
    <nav id="cbp-hrmenu" class="cbp-hrmenu">
        <ul>

<?php if ($nivel == 'muestra') {
    ?>
            <li>
                <a href="#">Gestión de Elementos</a>
                <div class="cbp-hrsub">
                    <div class="cbp-hrsub-inner">
                        <div>
                            <h4>Cargue de Elementos</h4>
                            <ul>
                                <li><a href="<?php echo $enlaceRegistroElementos['urlCodificada'] ?>"><?php echo $enlaceRegistroElementos['nombre'] ?></a></li>
                                <li><a href="<?php echo $enlaceModificarElementos['urlCodificada'] ?>"><?php echo $enlaceModificarElementos['nombre'] ?></a></li>
                                <li><a href="<?php echo $enlaceImpresionPlacas['urlCodificada'] ?>"><?php echo $enlaceImpresionPlacas['nombre'] ?></a></li> 
                            </ul>
                        </div>
                        <div>
                            <h4>Movimientos</h4>
                            <ul>
                                <li><a href="<?php echo $enlaceTrasladosElementos['urlCodificada'] ?>"><?php echo $enlaceTrasladosElementos['nombre'] ?></a></li>
                                <li><a href="<?php echo $enlaceSobranteFlatanteElementos['urlCodificada'] ?>"><?php echo $enlaceSobranteFlatanteElementos['nombre'] ?></a></li>
                                <li><a href="<?php echo $enlaceBajasElementos['urlCodificada'] ?>"><?php echo $enlaceBajasElementos['nombre'] ?></a></li>
                                <li><a href="<?php echo $enlaceAprobarBajas['urlCodificada'] ?>"><?php echo $enlaceAprobarBajas['nombre'] ?></a></li>
                            </ul>
                        </div>

                        <div>
                            <h4>Asignación de Elementos Contratistas</h4>
                            <ul>
                                <li><a href="<?php echo $enlaceasignarInventarioC['urlCodificada'] ?>"><?php echo $enlaceasignarInventarioC['nombre'] ?></a></li>
                                <li><a href="<?php echo $enlaceconsultarAsignacion['urlCodificada'] ?>"><?php echo $enlaceconsultarAsignacion['nombre'] ?></a></li>
                                <li><a href="<?php echo $enlacedescargarInventario['urlCodificada'] ?>"><?php echo $enlacedescargarInventario['nombre'] ?></a></li>
                                <li><a href="<?php echo $enlacegenerarPazSalvo['urlCodificada'] ?>"><?php echo $enlacegenerarPazSalvo['nombre'] ?></a></li>
                            </ul>
                        </div>
                    </div><!-- /cbp-hrsub-inner -->
                </div><!-- /cbp-hrsub -->
            </li>
 <?php }  ?>

<?php if ($nivel == '0') {
    ?>
            <li>
                <a href="#">Administración</a>
                <div class="cbp-hrsub">
                    <div class="cbp-hrsub-inner"> 
                        <div>
                            <h4>Usuarios</h4>
                            <ul>
                                <li><a href="<?php echo $enlaceUsuarios['urlCodificada'] ?>"><?php echo $enlaceUsuarios['nombre'] ?></a></li>
                                <!--li><a href="<?php echo $enlaceregistrarDependencia['urlCodificada'] ?>"><?php echo $enlaceregistrarDependencia['nombre'] ?></a></li-->
                                <!--li><a href="<?php echo $enlaceGestionarGrupoC['urlCodificada'] ?>"><?php echo $enlaceGestionarGrupoC['nombre'] ?></a></li-->
                            </ul>
                        </div>
                        <div>
                            <h4>Reportes</h4>
                            <ul>
                                <li><a href="<?php echo $enlaceReporticoAdmin['urlCodificada'] ?>"><?php echo $enlaceReporticoAdmin['nombre'] ?></a></li>
                            </ul>
                        </div>                        
                    </div><!-- /cbp-hrsub-inner -->
                </div><!-- /cbp-hrsub -->
            </li>
<?php }  ?>
            <li>
                <a href="#">Gestor Reportes</a>
                <div class="cbp-hrsub">
                    <div class="cbp-hrsub-inner"> 
                    <?php if ($nivel == '0' || $nivel == '1') { ?>                        
                        <div>
                            <h4>Gestor Reportes</h4>
                            <ul>
                                <li><a href="<?php echo $enlaceReporticoTes['urlCodificada'] ?>"><?php echo $enlaceReporticoTes['nombre'] ?></a></li>
                            </ul>
                        </div>
                    <?php } ?>    
                         <?php /*?>
                        <div>
                            <h4>Reportes Depreciación</h4>
                            <ul><li><a href="<?php echo $enlaceConsultaGeneral['urlCodificada'] ?>"><?php echo $enlaceConsultaGeneral['nombre'] ?></a></li>
                                <li><a href="<?php echo$enlaceregistrarDepreciacion['urlCodificada'] ?>"><?php echo$enlaceregistrarDepreciacion['nombre'] ?></a></li>
                                <li><a href="<?php echo$enlacedepreciacionGeneral['urlCodificada'] ?>"><?php echo$enlacedepreciacionGeneral['nombre'] ?></a></li>
                            </ul>
                        </div>
                        <?php */?>
                    </div><!-- /cbp-hrsub-inner -->
                </div><!-- /cbp-hrsub -->
            </li>
  
            <li>
                <a href="#">Mi Sesión</a>
                <div class="cbp-hrsub">
                    <div class="cbp-hrsub-inner"> 
                        <div>
                            <h4>Usuarios</h4>
                            <ul>
                                <!--li><a href="<?php echo $enlaceUsuarios['urlCodificada'] ?>"><?php echo ($enlaceUsuarios['nombre']) ?></a></li-->
                                <li><a href="<?php echo$enlaceFinSesion['urlCodificada'] ?>">Cerrar Sesión </a></li>
                            </ul>
                        </div>
                    </div><!-- /cbp-hrsub-inner -->
                </div><!-- /cbp-hrsub -->
            </li>
        </ul>
    </nav>
    
