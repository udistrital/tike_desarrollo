<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");
	switch($opcion)
	{
            
                case "inserto":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=confirma";
                        $variable.="&identificacion=".$valor[0];
                        $variable.="&nombres=".$valor[1];
                        $variable.="&apellidos=".$valor[2];
                        $variable.="&correo=".$valor[3];
                        $variable.="&telefono=".$valor[4];
                        $variable.="&password=".$valor[7];
			
			break;
                        
                case "noInserto":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=error";
			if($valor!=""){
				$variable.="&identificacion=".$valor[0];
                                $variable.="&nombres=".$valor[1];
                                $variable.="&apellidos=".$valor[2];
                                $variable.="&correo=".$valor[3];
                                $variable.="&telefono=".$valor[4];
                                $variable.="&password=".$valor[7];
			}
			break;
                        
                case "actualizo":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=actualizo";
                        $variable.="&identificacion=".$valor[0];
                        $variable.="&nombres=".$valor[1];
                        $variable.="&apellidos=".$valor[2];
                        $variable.="&correo=".$valor[3];
                        $variable.="&telefono=".$valor[4];
			
			break;
                        
                case "noActualizo":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=errorActualizo";
			if($valor!=""){
				$variable.="&identificacion=".$valor[0];
                                $variable.="&nombres=".$valor[1];
                                $variable.="&apellidos=".$valor[2];
                                $variable.="&correo=".$valor[3];
                                $variable.="&telefono=".$valor[4];
			}
			break;        
                        
                case "inhabilito":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=inhabilito";
                        $variable.="&id_usuario=".$valor;
			
			break;
                        
                case "noInhabilito":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=noInhabilito";
			if($valor!=""){
				$variable.="&id_usuario=".$valor;
			}
			break;        
            
		case "confirmarNuevo":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=confirmar";
			if($valor!=""){
				$variable.="&id_sesion=".$valor;
			}
			break;

		case "confirmacionEditar":
			$variable="pagina=conductorAdministrador";
			$variable.="&opcion=confirmarEditar";
			if($valor!=""){
				$variable.="&registro=".$valor;
			}
			break;

		case "exitoRegistro":
			$variable="pagina=inscripcionConferencia";
			$variable.="&opcion=mostrar";
			$variable.="&mensaje=exitoRegistro";
			$variable.="&registro=".$configuracion["idRegistrado"];

			break;

		case "falloRegistro":
			$variable="pagina=adminParticipante";
			$variable.="&opcion=mostrar";
			$variable.="&mensaje=falloRegistro";
			break;

		case "exitoEdicion":
			$variable="pagina=adminParticipante";
			$variable.="&opcion=mostrar";
			$variable.="&mensaje=exitoEdicion";
			break;

		case "falloEdicion":
			$variable="pagina=adminParticipante";
			$variable.="&opcion=mostrar";
			$variable.="&mensaje=falloRegistro";
			break;

		case "paginaPrincipal":
			$variable="pagina=index";
			break;


	}

	foreach($_REQUEST as $clave=>$valor)
	{
		unset($_REQUEST[$clave]);

	}

	$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
	$variable=$this->miConfigurador->fabricaConexiones->crypto->codificar($variable);

	$_REQUEST[$enlace]=$variable;
	$_REQUEST["recargar"]=true;

}

?>