<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
	 
	$miSesion = Sesion::singleton();
	
	$usuarioSoporte = $miSesion->getSesionUsuarioId(); 
	 
	$conexion="estructura";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $arregloDatos = array($_REQUEST['identificacion'],
                              $_REQUEST['nombres'],
                              $_REQUEST['apellidos'],
                              $_REQUEST['correo'],
                              $_REQUEST['telefono'],
                              $_REQUEST['tipousuario']);
	
	$this->cadena_sql = $this->sql->cadena_sql("actualizarUsuario", $arregloDatos);
	$resultadoEstado = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
	
        if($resultadoEstado)
	{	
            $this->funcion->redireccionar('actualizo',$arregloDatos);
	}else
	{
		$this->funcion->redireccionar('noActualizo',$arregloDatos);
	}



}
?>