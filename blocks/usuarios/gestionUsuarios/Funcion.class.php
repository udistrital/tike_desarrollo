<?php
namespace bloquesModelo\bloqueModelo1;

if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("../index.php");
    exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/builder/InspectorHTML.class.php");
include_once ("core/builder/Mensaje.class.php");
include_once ("core/crypto/Encriptador.class.php");

include_once 'component/GestorHTMLCRUD/Componente.php';
use component\GestoHTMLCRUD\Componente as GestorHTMLCRUD;

// Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
// metodos mas utilizados en la aplicacion

// Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
// en camel case precedido por la palabra Funcion

class Funcion {
    
    var $sql;
    var $funcion;
    var $lenguaje;
    var $ruta;
    var $miConfigurador;
    var $error;
    var $miRecursoDB;
    var $crypto;
	
	private $gestorHTMLCRUD;
    
    
    function cambiarEstado($objetoId) {
    	 
    	$this->gestorHTMLCRUD->setObjetoIdCambiarEstado($objetoId);
    	$this->gestorHTMLCRUD->setLenguajeCambiarEstado($this->lenguaje);
    	return $this->gestorHTMLCRUD->cambiarEstado($objetoId);
    
    
    }
    
    
    function evaluar($objetoId,$texto =  false) {
    
    }
    
    
    function duplicar($objetoId) {
    
    	$this->gestorHTMLCRUD->setObjetoIdDuplicar($objetoId);
    	$this->gestorHTMLCRUD->setLenguajeDuplicar($this->lenguaje);
    	return $this->gestorHTMLCRUD->duplicar($objetoId);
       
    }
    
    function editar($objetoId) {
    
    	$this->gestorHTMLCRUD->setObjetoIdEditar($objetoId);
    	$this->gestorHTMLCRUD->setLenguajeEditar($this->lenguaje);
    	
    	//$this->gestorHTMLCRUD->addTablasPasoEditar(array('usuario','telefono'));
    	//$this->gestorHTMLCRUD->addTablasPasoEditar(array('usuario','correo'));
    	//$this->gestorHTMLCRUD->addTablasPasoEditar(array('usuario','usuario_rol'));
    	
    	//$this->gestorHTMLCRUD->addTablasPasoEditar(array('rol','rol_pagina'));
    	//$this->gestorHTMLCRUD->addTablasPasoEditar(array('rol','rol_usuario'));
    	
    	return $this->gestorHTMLCRUD->editar($objetoId);
    }
    
    function consultar($objetoId) {
        $this->gestorHTMLCRUD->setObjetoIdConsultar($objetoId);
		$this->gestorHTMLCRUD->setLenguajeConsultar($this->lenguaje);
    	return $this->gestorHTMLCRUD->consultar($objetoId);
    }
    
    function ver($objetoId) {
    	
    	$this->gestorHTMLCRUD->setObjetoIdVer($objetoId);
    	$this->gestorHTMLCRUD->setLenguajeVer($this->lenguaje);
    	//$this->gestorHTMLCRUD->addTablasPasoVer(array('usuario','telefono'));
    	//$this->gestorHTMLCRUD->addTablasPasoVer(array('usuario','correo'));
    	return $this->gestorHTMLCRUD->ver($objetoId);
    }
    
    function eliminar($objetoId){
    	$this->gestorHTMLCRUD->setObjetoIdEliminar($objetoId);
    	$this->gestorHTMLCRUD->setLenguajeEliminar($this->lenguaje);
    	return $this->gestorHTMLCRUD->eliminar($objetoId);
    }
    
    function guardarDatos($objetoId) {	 
    	$this->gestorHTMLCRUD->setObjetoIdGuardarDatos($objetoId);
    	$this->gestorHTMLCRUD->setLenguajeGuardarDatos($this->lenguaje);
    	
    	//$this->gestorHTMLCRUD->addTablasPasoGuardarDatos(array('usuario','telefono'));
    	//$this->gestorHTMLCRUD->addTablasPasoGuardarDatos(array('usuario','correo'));
    	//$this->gestorHTMLCRUD->addTablasPasoGuardarDatos(array('usuario','usuario_rol'));
    	 
    	//$this->gestorHTMLCRUD->addTablasPasoGuardarDatos(array('rol','rol_pagina'));
    	//$this->gestorHTMLCRUD->addTablasPasoGuardarDatos(array('rol','rol_usuario'));
    	
    	return $this->gestorHTMLCRUD->guardarDatos($objetoId);
    }
    
    function autocompletar($objetoId) {
    
       	return $this->gestorHTMLCRUD->autocompletar($objetoId);
    
    }
    
    function crear($objetoId) {
    	 
    	$this->gestorHTMLCRUD->setObjetoIdCrear($objetoId);
    	$this->gestorHTMLCRUD->setLenguajeCrear($this->lenguaje);
    	
    	//$this->gestorHTMLCRUD->addTablasPasoCrear(array('usuario','telefono'));
    	//$this->gestorHTMLCRUD->addTablasPasoCrear(array('usuario','correo'));
    	//$this->gestorHTMLCRUD->addTablasPasoCrear(array('usuario','usuario_rol'));
    	
    	//$this->gestorHTMLCRUD->addTablasPasoCrear(array('rol','rol_pagina'));
    	//$this->gestorHTMLCRUD->addTablasPasoCrear(array('rol','rol_usuario'));
    	 
    	return $this->gestorHTMLCRUD->crear($objetoId);
    }
    
    
    private function limpiarRequest(){
    	
    	foreach ($_REQUEST as $a => $b){
    		if($b==''||is_null($b))unset($_REQUEST[$a]);
    	}
    }
    
    function action() {
        
        $resultado = true;
        
        // Aquí se coloca el código que procesará los diferentes formularios que pertenecen al bloque
        // aunque el código fuente puede ir directamente en este script, para facilitar el mantenimiento
        // se recomienda que aqui solo sea el punto de entrada para incluir otros scripts que estarán
        // en la carpeta funcion
        
        // Importante: Es adecuado que sea una variable llamada opcion o action la que guie el procesamiento:
        
        $resultado = true;
        $this->limpiarRequest();
        // Aquí se coloca el código que procesará los diferentes formularios que pertenecen al bloque
        // aunque el código fuente puede ir directamente en este script, para facilitar el mantenimiento
        // se recomienda que aqui solo sea el punto de entrada para incluir otros scripts que estarán
        // en la carpeta funcion
        
        // Importante: Es adecuado que sea una variable llamada opcion o action la que guie el procesamiento:
        if(isset($_REQUEST['funcion'])&&isset($_REQUEST['objetoId'])){
        	
	        switch($_REQUEST['funcion']){
	        	case 'consultar':
	        		$this->consultar($_REQUEST['objetoId']);
	        		break;
	        	case 'ver':
	        		$this->ver($_REQUEST['objetoId']);
	        		break;
	            case 'crear':
	        		$this->crear($_REQUEST['objetoId']);
	        		break;
	        	case 'editar':
	        		$this->editar($_REQUEST['objetoId']);
	        		break;
	        	case 'guardarDatos':
	        		$this->guardarDatos($_REQUEST['objetoId']);
	        		break;
	        	case 'duplicar':
	        		$this->duplicar($_REQUEST['objetoId']);
	        		break;
	        	case 'cambiarEstado':
	        		
	        		$this->cambiarEstado($_REQUEST['objetoId']);
	        		break;
	        	case 'evaluar':
	        		 $this->evaluar($_REQUEST['objetoId']);
	        		break;
	        	case 'autocompletar':
	        		$this->autocompletar($_REQUEST['objetoId']);
	        		break;
	        	case 'eliminar':
	        		$this->eliminar($_REQUEST['objetoId']);
	        	default:
	        		default;
	        	
	        }
        }
    
        
        return $resultado;
    
    
    }
    
    function __construct() {
        
        $this->miConfigurador = \Configurador::singleton ();
        
        $this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
        
        $this->miMensaje = \Mensaje::singleton ();
        
        $conexion = "aplicativo";
        $this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
        
        if (! $this->miRecursoDB) {
            
            $this->miConfigurador->fabricaConexiones->setRecursoDB ( $conexion, "tabla" );
            $this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
        }
		$lenguaje = &$this->lenguaje;
		$this->gestorHTMLCRUD =  new GestorHTMLCRUD($lenguaje);
    
    }
    
    public function setRuta($unaRuta) {
        $this->ruta = $unaRuta;
    }
    
    function setSql($a) {
        $this->sql = $a;
    }
    
    function setFuncion($funcion) {
        $this->funcion = $funcion;
    }
    
    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
		$this->gestorHTMLCRUD->setLenguajeConsultar($lenguaje);
    }
    
    public function setFormulario($formulario) {
        $this->formulario = $formulario;
    }

}

?>
