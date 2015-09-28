<?php
//include_once("../Sql.class.php");
$miSql=new Sqlmenu();
// var_dump($this->miConfigurador);
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

$conexion="estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$miSesion = Sesion::singleton();
//verifica los roles del usuario en el sistema
$roles=$miSesion->RolesSesion();
//consulta datos del usuario
$id_usuario=$miSesion->getSesionUsuarioId();
$cadena_sql = $miSql->getCadenaSql("datosUsuario", $id_usuario);
$regUser = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if($regUser[0]['estado']!=1)
    {
    $parametro['cod_app']='';
    $parametro['cod_rol']='';
    }
else
    {$tam=(count($roles)-1);
    $cod_rol='';
    $cod_app='';
    foreach ($roles as $key => $value) 
            { if($key<$tam){$cod_rol.=$roles[$key]['cod_rol'].",";}
              else {$cod_rol.=$roles[$key]['cod_rol'];}

              if( $key<$tam){$cod_app.=$roles[$key]['cod_app'].",";}
              else {$cod_app.=$roles[$key]['cod_app'];}
            }
    $parametro['cod_app']=$cod_app;
    $parametro['cod_rol']=$cod_rol;
    }

//busca los datos de los servicios y los menus según los roles del usuario
$cadena_sql = $miSql->getCadenaSql("datosMenus", $parametro);
$reg_menu = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
if($reg_menu)
    {
    //Arma la matriz de menus con sus repectivos grupos y servicios
    $mMenu=array( );
    foreach ($reg_menu as $key => $value) 
        {
         if(isset($reg_menu[$key]['url_host_enlace']) && $reg_menu[$key]['url_host_enlace']!='')
               { $host=$reg_menu[$key]['url_host_enlace'];}
         else  { $host=$directorio;}      

         if(isset($reg_menu[$key]['pagina_enlace']) && $reg_menu[$key]['pagina_enlace']!='')
               {  $enlaceServ['URL']="pagina=" .$reg_menu[$key]['pagina_enlace'];
                  $enlaceServ['URL'].= "&usuario=" . $id_usuario;      
                  $enlaceServ['URL'].=$reg_menu[$key]['parametros'];
                  $enlaceServ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceServ['URL'], $host);   
                  $enlaceServ['tab']='';
               }
         else  { 
                  $enlaceServ['urlCodificada'] = $host.$reg_menu[$key]['parametros']; 
                  $enlaceServ['tab']=$reg_menu[$key]['enlace'];
               }      
         
         $mMenu[$reg_menu[$key]['menu']][$reg_menu[$key]['grupo']][$reg_menu[$key]['enlace']]=array('urlCodificada'=>$enlaceServ['urlCodificada'],'tab'=>$enlaceServ['tab']);    
         unset($enlaceServ);

        }
    }
$parametros['id_usuario']=$id_usuario;    
$parametros['tipo']='activo';    
$cadena_act = $miSql->getCadenaSql("RolesInactivos", $parametros);
$rolAct = $esteRecursoDB->ejecutarAcceso($cadena_act, "busqueda");
unset($parametros['tipo']);

$parametros['tipo']='inactivo';    
$cadena_sql = $miSql->getCadenaSql("RolesInactivos", $parametros);
//$rolOut = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
unset($parametros['tipo']);
$parametros['tipo']='caduco';    
$cadena_cad = $miSql->getCadenaSql("RolesInactivos", $parametros);
$rolCad = $esteRecursoDB->ejecutarAcceso($cadena_cad, "busqueda");
// CambiarContraseña
    
$enlaceCambiarClave['enlace']= "pagina=cambiarClave";
$enlaceCambiarClave['enlace'].= "&opcion=cambiarClave";
$enlaceCambiarClave['enlace'].= "&campoSeguro=" . $_REQUEST ['tiempo'];
$enlaceCambiarClave['enlace'].= "&usuario=" . $id_usuario;
$enlaceCambiarClave['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceCambiarClave['enlace'], $directorio);
$enlaceCambiarClave['nombre'] = "Cambiar Contraseña"; 

// Fin de la sesión
    
$enlaceFinSesion['enlace'] = "action=logintike";
$enlaceFinSesion['enlace'].= "&pagina=index";
$enlaceFinSesion['enlace'].= "&bloque=logintike";
$enlaceFinSesion['enlace'].= "&bloqueGrupo=registro";
$enlaceFinSesion['enlace'].= "&opcion=finSesion";
$enlaceFinSesion['enlace'].= "&campoSeguro=" . $_REQUEST ['tiempo'];
$enlaceFinSesion['enlace'].= "&sesion=" . $miSesion->getSesionId();
$enlaceFinSesion['enlace'].= "&usuario=" . $id_usuario;
$enlaceFinSesion['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceFinSesion['enlace'], $directorio);
$enlaceFinSesion['nombre'] = "Cerrar Sesión";    
    

//------------------------------- Inicio del Menú-------------------------- //

    ?>
    <nav id="cbp-hrmenu" class="cbp-hrmenu">
      <ul>

<?php 
    if(isset($mMenu))
    {
//cada foreach arma encabezado del menu, grupo y servicio en su orden.
        foreach ($mMenu as $mkey => $menus) 
        {
        ?> <li>
                <a href="#"><?php echo $mkey;?> </a>
                <div class="cbp-hrsub">
                    <div class="cbp-hrsub-inner"> 
              <?php foreach ($menus as $gkey => $grupos) 
                        {?>  <div>
                              <h4><?php echo $gkey;?></h4>
                                <ul>
                            <?php foreach ($grupos as $skey => $service) 
                                    { if(isset($grupos[$skey]['tab']) && $grupos[$skey]['tab']!='')
                                          {?>
                                           <li><a href="#" onclick=javascript:window.open('<?php echo $grupos[$skey]['urlCodificada'] ?>','<?php echo $grupos[$skey]['tab'] ?>','resizable','status','menubar','width=850','height=400','scrollbars') ><?php echo $skey; ?></a></li>
                            <?php         }
                                      else{?>
                                          <li><a href="<?php echo $grupos[$skey]['urlCodificada'] ?>"><?php echo $skey; ?></a></li>
                            <?php         }
                                    } ?>                                 
                                </ul>
                            </div>
                  <?php } ?>
                    </div><!-- /cbp-hrsub-inner -->
                </div><!-- /cbp-hrsub --> 
            </li>
  <?php } 
    } ?>            
            <li>
                <a href="#">Mi Sesión</a>
                <div class="cbp-hrsub">
                    <div class="cbp-hrsub-inner"> 
                        <div>
                            <h4>Usuario: <?php echo $regUser[0]['nombre']." ".$regUser[0]['apellido'] ?></h4>
                            <ul>
                                <li><a href="<?php echo $enlaceCambiarClave['urlCodificada'] ?>"><?php echo ($enlaceCambiarClave['nombre']) ?></a></li>
                                <li><a href="<?php echo $enlaceFinSesion['urlCodificada'] ?>"><?php echo ($enlaceFinSesion['nombre']) ?></a></li>
                            </ul>
                        </div>
                <?php                  
                    if(isset($rolAct) && is_array($rolAct) )
                       {?>                        
                        <div>
                            <h4>Perfiles Activos</h4>
                            <ul><?php
                                    foreach ($rolAct as $valueAct) {
                                        ?>
                                        <li><a href="#"><?php echo $valueAct['rol'] ?></a></li>    
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                 <?php }  
                 
                    if(isset($rolOut) && is_array($rolOut) )
                       {?>                        
                        <div>
                            <h4>Perfiles Inactivos</h4>
                            <ul><?php
                                    foreach ($rolOut as $valueOut) {
                                        ?>
                                        <li><a href="#"><?php echo $valueOut['rol'] ?></a></li>    
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                 <?php }  
                 
                    if(isset($rolCad) && is_array($rolCad) )
                       {?>                        
                        <div>
                            <h4>Perfiles Caducados</h4>
                            <ul><?php
                                    foreach ($rolCad as $valueCad) {
                                        ?>
                                        <li><a href="#"><?php echo $valueCad['rol']." (".$valueCad['app'].") ".$valueCad['fecha_caduca'] ?></a></li>    
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                 <?php }  ?>
 
                    </div><!-- /cbp-hrsub-inner -->
                </div><!-- /cbp-hrsub -->
            </li>
        </ul>
    </nav>
    
