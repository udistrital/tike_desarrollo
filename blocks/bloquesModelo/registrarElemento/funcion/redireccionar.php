<?

namespace inventarios\gestionElementos\registrarElemento\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class redireccion {
	public static function redireccionar($opcion, $valor = "", $valor1 = "") {
		
		$miConfigurador = \Configurador::singleton ();
		$miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		switch ($opcion) {
			case "inserto" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=cargarElemento";
				$variable .= "&mensaje=registro";
				$variable .= "&numero_orden=" . $valor [0];
				$variable .= "&fecha_orden=" . $valor [1];
				$variable .= "&numero_entrada=" . $valor [2];
				$variable .= "&datosGenerales=" . $valor1;
				
				break;
			
			case "inserto_M" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=confirmaMasivo";
				break;
			
			case "noExtension" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=noExtension";
				break;
			
			case "noInserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=error";
				
				break;
			
			case "noCargarElemento" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=noElemento";
				
				break;
			
			case "notextos" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=otros";
				$variable .= "&errores=notextos";
				
				break;
			
			case "Salir" :
				
				$variable = "pagina=indexAlmacen";
				
				break;
			
			case "SalidaElemento" :
				
				$variable = "pagina=registrarSalidas";
				$variable .= "&opcion=Salida";
				$variable .= "&numero_entrada=".$valor;
				$variable .= "&datosGenerales=".$valor1;
				break;
		}
		
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		$enlace = $miConfigurador->configuracion ['enlace'];
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		
		// $enlace =$miConfigurador->getVariableConfiguracion("enlace");
		// $variable = $miConfigurador->fabricaConexiones->crypto->codificar($variable);
		// // echo $enlace;
		// // // echo $variable;
		// // exit;
		// $_REQUEST[$enlace] = $variable;
		// $_REQUEST["recargar"] = true;
		// return true;
	}
}

?>