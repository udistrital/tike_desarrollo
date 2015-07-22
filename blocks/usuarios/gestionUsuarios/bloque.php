<?php

namespace bloquesModelo\bloqueModelo1;

// Evitar un acceso directo a este archivo
if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("../index.php");
    exit ();
}

// Todo bloque debe implementar la interfaz Bloque
include_once ("core/builder/Bloque.interface.php");
include_once ("core/manager/Configurador.class.php");
include_once ("core/builder/FormularioHtml.class.php");
include_once ("core/connection/DAL.class.php");

// Elementos que constituyen un bloque típico CRUD.

// Interfaz gráfica
include_once ("Frontera.class.php");

// Funciones de procesamiento de datos
include_once ("Funcion.class.php");

// Compilación de clausulas SQL utilizadas por el bloque
include_once ("Sql.class.php");

// Mensajes
include_once ("Lenguaje.class.php");


include_once 'component/GestorHTMLCRUD/Componente.php';
use component\GestoHTMLCRUD\Componente as GestorHTMLCRUD;
// Esta clase actua como control del bloque en un patron FCE

if (! class_exists ( '\\bloquesModelo\\bloqueModelo1\\Bloque' )) {
    
    class Bloque implements \Bloque {
        var $nombreBloque;
        var $miFuncion;
        var $miSql;
        var $miConfigurador;
        var $miFormulario;
		
		private $gestorHTMLCRUD;
		private $bloqueNombre;
		private $bloqueGrupo;
        
        var $ruta;
        
        public function __construct($esteBloque, $lenguaje = "") {
            
            // El objeto de la clase Configurador debe ser único en toda la aplicación
            $this->miConfigurador = \Configurador::singleton ();
            
            $ruta = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" );
            $rutaURL = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" );
            
            if (! isset ( $esteBloque ["grupo"] ) || $esteBloque ["grupo"] == "") {
                $ruta .= "/blocks/" . $esteBloque ["nombre"] . "/";
                $rutaURL .= "/blocks/" . $esteBloque ["nombre"] . "/";
            } else {
                $ruta .= "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"] . "/";
                $rutaURL .= "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"] . "/";
            }
            
			$this->ruta =  $ruta;
            $this->miConfigurador->setVariableConfiguracion ( "rutaBloque", $ruta );
            $this->miConfigurador->setVariableConfiguracion ( "rutaUrlBloque", $rutaURL );
            
			$this->bloqueNombre =  $esteBloque['nombre'];
			$this->bloqueGrupo =  $esteBloque['grupo'];
			
            $this->miFuncion = new Funcion ();
            $this->miSql = new Sql ();
            $this->miFrontera = new Frontera ();
            $this->miLenguaje = new Lenguaje ();
			$this->miFuncion->setLenguaje($this->miLenguaje);
            $this->miFormulario = new \FormularioHtml ();
        
        }
        public function bloque() {
            
			
			
            if (isset ( $_REQUEST ['botonCancelar'] ) && $_REQUEST ['botonCancelar'] == "true") {
                $this->miFuncion->redireccionar ( "paginaPrincipal" );
            } else {
                
                /**
                 * Injección de dependencias
                 */
                
                // Para la frontera
                $this->miFrontera->setSql ( $this->miSql );
                $this->miFrontera->setFuncion ( $this->miFuncion );
                $this->miFrontera->setFormulario ( $this->miFormulario );
                $this->miFrontera->setLenguaje ( $this->miLenguaje );
                
                // Para la entidad
                $this->miFuncion->setSql ( $this->miSql );
                $this->miFuncion->setFuncion ( $this->miFuncion );
                $this->miFuncion->setLenguaje ( $this->miLenguaje );
                
                if (! isset ( $_REQUEST ['action'] )) {
                    
                                $gh =  new GestorHTMLCRUD($this->miLenguaje);
                    			$gh->setOperaciones($this->operaciones());
                    			$gh->setObjetos('17,18');
								$gh->setFuncionInicio('if($(\'#objetoId\').val()!=0) 	getFormularioConsulta(true);');
								$gh->setBloque($this->bloqueNombre,$this->bloqueGrupo);
								$gh->iniciarPrincipal();
								unset($gh);
								return true;
					                    
                } else {
                    
                    $respuesta = $this->miFuncion->action ();
                    
                    // Si $respuesta==false, entonces se debe recargar el formulario y mostrar un mensaje de error.
                    if (! $respuesta) {
                        
                        $miBloque = $this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );
                        $this->miConfigurador->setVariableConfiguracion ( 'errorFormulario', $miBloque ['nombre'] );
                    
                    }
                    
                
                }
            }
        }
        
        private function setBool($valor = ''){
        	if($valor=='t') return 'true';
        	return 'false';
        }
        
		public function operaciones(){
				$operaciones =  array();
			
			$operacionesPermitidas =  array(
				'consultar',
				'crear', 
				'actualizar', 
				'ver',
				'activarInactivar',
				'duplicar',
				'eliminar',
				//'ejecutar',
				//'validar',
				'autocompletar'
			);

			$datos =  new \DAL();
			
			$listaOperaciones =  $datos->getListaOperacion();
			

			$operaciones= array();
			foreach ($operacionesPermitidas as $a=>$b){
				
				foreach ($listaOperaciones as $elemento){
					
					if($b==$elemento['nombre']){
						$elemento['text'] =  $this->setBool($elemento['text']);
						$operaciones[$a] = $elemento;
					}
					
				}
			
			}
			
			return $operaciones;
		}    
}
}
// @ Crear un objeto bloque especifico
// El arreglo $unBloque está definido en el objeto de la clase ArmadorPagina o en la clase ProcesadorPagina

if (isset ( $_REQUEST ["procesarAjax"] )) {
    $unBloque ["nombre"] = $_REQUEST ["bloqueNombre"];
    $unBloque ["grupo"] = $_REQUEST ["bloqueGrupo"];
}

$this->miConfigurador->setVariableConfiguracion ( "esteBloque", $unBloque );

if (isset ( $lenguaje )) {
    $esteBloque = new Bloque ( $unBloque, $lenguaje );
} else {
    $esteBloque = new Bloque ( $unBloque );
}

$esteBloque->bloque ();

?>
