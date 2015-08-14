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
        
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; 
        $numerodeletras=8; 
        $pass = "";
        for($i=0;$i<$numerodeletras;$i++)
        {
            $pass .= substr($caracteres,rand(0,strlen($caracteres)),1);  
       
        }
        
        $password = $this->miConfigurador->fabricaConexiones->crypto->codificarClave ( $pass );
        
	$arregloDatos = array($_REQUEST['identificacion'],
                              $_REQUEST['nombres'],
                              $_REQUEST['apellidos'],
                              $_REQUEST['correo'],
                              $_REQUEST['telefono'],
                              $_REQUEST['tipousuario'],
                              $password,$pass);
	
	$this->cadena_sql = $this->sql->cadena_sql("insertarUsuario", $arregloDatos);
	$resultadoEstado = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
	
        if($resultadoEstado)
	{	
            $this->funcion->redireccionar('inserto',$arregloDatos);
	}else
	{
		$this->funcion->redireccionar('noInserto',$arregloDatos);
	}



}
?>