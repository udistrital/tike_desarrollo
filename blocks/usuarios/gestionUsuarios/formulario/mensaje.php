<?php
if(!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}else
{

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directoriourl = $this->miConfigurador->getVariableConfiguracion("host");
$directoriourl.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directoriourl.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$nombreFormulario=$esteBloque["nombre"];

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$directorioIndex = $this->miConfigurador->getVariableConfiguracion("host");
$directorioIndex.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorioIndex.=$this->miConfigurador->getVariableConfiguracion("enlace");

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
	
	if($_REQUEST['mensaje'] == 'confirma')
	{
            $tipo = 'success';
            $mensaje = "El usuario ".$_REQUEST['nombres']." ".$_REQUEST['apellidos']." ha sido creado exitosamente. Puede descargar el siguiente PDF con la información del usuario.";
            $boton = "continuar";
            
            $valorCodificado="pagina=gestionUsuarios";
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
            
            $variableResumen = "pagina=gestionUsuarios"; //pendiente la pagina para modificar parametro                                                        
            $variableResumen.= "&action=".$esteBloque["nombre"];
            $variableResumen.= "&bloque=" . $esteBloque["id_bloque"];
            $variableResumen.= "&bloqueGrupo=" . $esteBloque["grupo"];
            $variableResumen.= "&opcion=resumen";
            $variableResumen.= "&identificacion=" . $_REQUEST['identificacion'];
            $variableResumen.= "&nombres=" .$_REQUEST['nombres'];
            $variableResumen.= "&apellidos=" .$_REQUEST['apellidos'];
            $variableResumen.= "&correo=" .$_REQUEST['correo'];
            $variableResumen.= "&telefono=" .$_REQUEST['telefono'];
            $variableResumen.= "&password=" .$_REQUEST['password'];
            $variableResumen = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableResumen, $directorioIndex);
            
            //------------------Division para los botones-------------------------
            $atributos["id"]="botones";
            $atributos["estilo"]="marcoBotones";
            echo $this->miFormulario->division("inicio",$atributos);
            
            $enlace = "<a href='".$variableResumen."'>";
            $enlace.="<img src='".$rutaBloque."/images/acroread.png' width='25px'><br>Descargar Resumen ";
            $enlace.="</a><br><br>";       
            echo $enlace;
            //------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");        
                
	}else if($_REQUEST['mensaje'] == 'error')
	{
            $tipo = 'error';
            $mensaje = "El usuario ".$_REQUEST['nombres']." ".$_REQUEST['apellidos']." no ha sido creado. Por favor intente mas tarde.";
            $boton = "regresar";
                        
            $valorCodificado="pagina=gestionUsuarios";
            $valorCodificado.="&opcion=nuevo"; 
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	}else if($_REQUEST['mensaje'] == 'actualizo')
	{
            $tipo = 'success';
            $mensaje = "El usuario ".$_REQUEST['nombres']." ".$_REQUEST['apellidos']."  se ha actualizado exitosamente. Presione el botón Continuar para regresar.";
            $boton = "continuar";
                        
            $valorCodificado="pagina=gestionUsuarios";
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	}else if($_REQUEST['mensaje'] == 'errorActualizo')
	{
            $tipo = 'error';
            $mensaje = "El usuario ".$_REQUEST['nombres']." ".$_REQUEST['apellidos']." no se ha actualizado. Por favor intente mas tarde.";
            $boton = "regresar";
                        
            $valorCodificado="pagina=gestionUsuarios";
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	}else if($_REQUEST['mensaje'] == 'inhabilito')
	{
            $tipo = 'success';
            $mensaje = "El usuario se inhabilito con exito.";
            $boton = "continuar";
                        
            $valorCodificado="pagina=gestionUsuarios";
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	}else if($_REQUEST['mensaje'] == 'noInhabilito')
	{
            $tipo = 'error';
            $mensaje = "El usuario no se pudo inhabilitar. Por favor intente mas tarde.";
            $boton = "regresar";
                        
            $valorCodificado="pagina=gestionUsuarios";
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	}
	
	$esteCampo = 'mensaje';
        $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
        $atributos["etiqueta"] = "";
        $atributos["estilo"] = "centrar";
        $atributos["tipo"] = $tipo;
        $atributos["mensaje"] = $mensaje;
        echo $this->miFormulario->cuadroMensaje($atributos);
        unset($atributos); 
        
        //------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
        
        //------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = $boton;
	$atributos["id"]=$esteCampo;
	$atributos["tabIndex"]=$tab++;
	$atributos["tipo"]="boton";
	$atributos["estilo"]="jquery";
	$atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
	$atributos["onclick"]="location.replace('".$valorCodificado."');"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
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