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
	
	$this->cadena_sql = $this->sql->cadena_sql("inhabilitarUsuario", $_REQUEST['id_usuario']);
	$resultadoEstado = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
	
        if($resultadoEstado)
	{	
            $this->funcion->redireccionar('inhabilito',$_REQUEST['id_usuario']);
	}else
	{
		$this->funcion->redireccionar('noInhabilito',$_REQUEST['id_usuario']);
	}



}
?>