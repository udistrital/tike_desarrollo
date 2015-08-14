<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$nombreFormulario=$esteBloque["nombre"];

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("idioma", "");
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");    
   
$cadena_sql = $this->sql->cadena_sql("consultarUsuarios", "");
$resultadoUsuarios = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$variableNuevo = "pagina=gestionUsuarios"; //pendiente la pagina para modificar parametro                                                        
$variableNuevo.= "&opcion=nuevo";
$variableNuevo.= "&usuario=" . $miSesion->getSesionUsuarioId();
$variableNuevo = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableNuevo, $directorio);
		

echo "<div class='datagrid'><table width='100%' align='center'>
        <caption>GESTIÓN DE USUARIOS</caption>
        <tr align='center'>
            <td align='center'>
                <a href='".$variableNuevo."'>                        
                    <img src='".$rutaBloque."/images/add_user.png' width='45px'> <br> <b>Crear Nuevo <br>Usuario</b>
                </a>
            </td>
        </tr>
      </table></div> ";

if($resultadoUsuarios)
{	
    //-----------------Inicio de Conjunto de Controles----------------------------------------
        $esteCampo = "marcoDatosResultadoParametrizar";
        $atributos["estilo"] = "jqueryui";
        $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        //echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
        unset($atributos);
        
        echo "<div class='datagrid'><table id='tablaProcesos'>";
        
        echo "<thead>
                <tr align='center'>
                    <th>ID Usuario</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>                    
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Perfil</th>
                    <th>Estado</th>
                    <th>Tipo Usuario</th>
                    <th>Editar</th>
                    <th>Inhabilitar</th>
                </tr>
            </thead>
            <tbody>";
        
        foreach($resultadoUsuarios as $key=>$value )
            { 
                $parametro['id_usuario']=$resultadoUsuarios[$key]['id_usuario'];
                $cadena_sql = $this->sql->cadena_sql("consultarPerfilUsuario", $parametro);
                $resultadoPerfil = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                //var_dump($resultadoPerfil);
                $perfil[$key]['perfil']='';
                if($resultadoPerfil)
                    {
                        foreach ($resultadoPerfil as $Pkey => $value) {
                           $perfil[$key]['perfil'].=$resultadoPerfil[$Pkey]['rol_alias']."<br>";
                        }
                    
                    
                    }
                else{$perfil[$key]['perfil']='N/A';}
                $variableEditar = "pagina=gestionUsuarios"; //pendiente la pagina para modificar parametro                                                        
                $variableEditar.= "&opcion=editar";
                $variableEditar.= "&usuario=" . $miSesion->getSesionUsuarioId();
                $variableEditar.= "&id_usuario=" .$resultadoUsuarios[$key]['id_usuario'];
                $variableEditar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableEditar, $directorio);

                $variableInhabilitar = "pagina=gestionUsuarios"; //pendiente la pagina para modificar parametro                                                        
                $variableInhabilitar.= "&opcion=inhabilitar";
                $variableInhabilitar.= "&usuario=" . $miSesion->getSesionUsuarioId();
                $variableInhabilitar.= "&id_usuario=" .$resultadoUsuarios[$key]['id_usuario'];
                $variableInhabilitar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableInhabilitar, $directorio);

                $mostrarHtml = "<tr align='center'>
                        <td>".$resultadoUsuarios[$key]['id_usuario']."</td>
                        <td>".$resultadoUsuarios[$key]['nombre']."</td>
                        <td>".$resultadoUsuarios[$key]['apellido']."</td>
                        <td>".$resultadoUsuarios[$key]['correo']."</td>
                        <td>".$resultadoUsuarios[$key]['telefono']."</td>
                        <td>".$perfil[$key]['perfil']."</td>
                        <td>".$resultadoUsuarios[$key]['estado']."</td>    
                        <td>".$resultadoUsuarios[$key]['nivel']."</td>
                            
                        <td>";

                        $mostrarHtml .= "<a href='".$variableEditar."'>                        
                                            <img src='".$rutaBloque."/images/edit.png' width='25px'> 
                                        </a>";
                        $mostrarHtml .= "<td>";
                        $mostrarHtml .= "<a href='".$variableInhabilitar."'>                        
                                            <img src='".$rutaBloque."/images/cancel.png' width='25px'> 
                                        </a>";
                        $mostrarHtml .= "</td>";


                    $mostrarHtml .= "</tr>";
                    echo $mostrarHtml;
                    unset($mostrarHtml);
                    unset($variable);
            }
               
        echo "</tbody>";
        
        echo "</table></div>";
        
        //Fin de Conjunto de Controles
        //echo $this->miFormulario->marcoAgrupacion("fin");
   
}else
{
        $nombreFormulario=$esteBloque["nombre"];
        include_once("core/crypto/Encriptador.class.php");
        $cripto=Encriptador::singleton();
        $directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

        $miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");

        $tab=1;
        //---------------Inicio Formulario (<form>)--------------------------------
        $atributos["id"]=$nombreFormulario;
        $atributos["tipoFormulario"]="multipart/form-data";
        $atributos["metodo"]="POST";
        $atributos["nombreFormulario"]=$nombreFormulario;
        $verificarFormulario="1";
        echo $this->miFormulario->formulario("inicio",$atributos);
        
	$atributos["id"]="divNoEncontroEgresado";
	$atributos["estilo"]="marcoBotones";
   //$atributos["estiloEnLinea"]="display:none"; 
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = "noEncontroProcesos";
	$atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos["etiqueta"] = "";
	$atributos["estilo"] = "centrar";
	$atributos["tipo"] = 'error';
	$atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);;
	echo $this->miFormulario->cuadroMensaje($atributos);
    unset($atributos); 
    
        $valorCodificado="pagina=".$miPaginaActual;
        $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
        $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
        $valorCodificado=$cripto->codificar($valorCodificado);
	//-------------Fin Control Boton----------------------
	
	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
        //------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = "regresar";
	$atributos["id"]=$esteCampo;
	$atributos["tabIndex"]=$tab++;
	$atributos["tipo"]="boton";
	$atributos["estilo"]="jquery";
	$atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
	$atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
	$atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["nombreFormulario"]=$nombreFormulario;
	echo $this->miFormulario->campoBoton($atributos);
	unset($atributos);
	//-------------Fin Control Boton----------------------
	
	
	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
    
	//-------------Control cuadroTexto con campos ocultos-----------------------
	//Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos["id"]="formSaraData"; //No cambiar este nombre
	$atributos["tipo"]="hidden";
	$atributos["obligatorio"]=false;
	$atributos["etiqueta"]="";
	$atributos["valor"]=$valorCodificado;
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
	
        //Fin del Formulario
        echo $this->miFormulario->formulario("fin");
}
    

?>