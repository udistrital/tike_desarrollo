<?php

namespace arka\dependencia\agregarDependencia\editarCatalogo;

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

class Formulario {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $sql;
    var $esteRecursoDB;
    var $arrayElementos;
    var $arrayDatos;
    var $funcion;

    function __construct($lenguaje, $formulario, $sql, $funcion) {

        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->sql = $sql;

        $this->funcion = $funcion;

        $conexion = "inventarios";
        $this->esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        if (!$this->esteRecursoDB) {
            //Este se considera un error fatal
            exit;
        }
    }

    function formulario() {

        //validar request idCatalogo
        if (!isset($_REQUEST['idCatalogo'])) {
            $this->miConfigurador->setVariableConfiguracion('mostrarMensaje', 'errorId');
            $this->mensaje();
            exit;
        }



        $this->consultarDatosCatalogo();
        $this->principal();
        //$this->consultarElementos();
        //echo '<div id="arbol">';
        $this->funcion->dibujarCatalogo();
        //echo '</div>';
        exit;
    }

    private function consultarElementos() {

        $cadena_sql = $this->sql->getCadenaSql("listarElementos", $_REQUEST['idCatalogo']);
        $registros = $this->esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");


        if (!$registros) {
            $this->miConfigurador->setVariableConfiguracion('mostrarMensaje', 'catalogoVacio');
            $this->mensaje();
            exit;
        }

        $this->arrayElementos = $registros;
    }

    private function consultarDatosCatalogo() {

        $cadena_sql = $this->sql->getCadenaSql("buscarCatalogoId", $_REQUEST['idCatalogo']);
        $registros = $this->esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");


        if (!$registros) {
            $this->miConfigurador->setVariableConfiguracion('mostrarMensaje', 'catalogoVacio');
            $this->mensaje();
            exit;
        }

        $this->arrayDatos = $registros;
    }

    private function edicionNombreCatalogo() {

        $nombre = $this->lenguaje->getCadena('nombreCatalogo');
        $nombreTitulo = $this->lenguaje->getCadena('nombreTitulo');

        $crearTitulo = $this->lenguaje->getCadena('cambiarNombreTitulo');
        echo '<form id="catalogo_1" name="catalogo" action="index.php" method="post">';
        //echo '<div id="agregar" class="marcoBotones">';
        echo '<fieldset class="ui-corner-all ui-widget ui-widget-content ui-corner-all">';
        echo '<legend>' . $this->lenguaje->getCadena('catalogo') . '</legend>';
        echo '<div style="float:left; width:200px"><label for="nombre">' . $nombre . '</label><span style="white-space:pre;"> </span></div>';
        echo '<input type="text" maxlength="" size="50" value="' . $this->arrayDatos[0][1] . '" class="ui-widget ui-widget-content ui-corner-all  validate[required] " tabindex="1" name="nombreCatalogo" id="nombreCatalogo" title="' . $nombreTitulo . '">';
        echo '</fieldset>';
        echo '</form>';
    }

    private function edicionBotones() {

        $crear = $this->lenguaje->getCadena('cambiarNombre');
        echo '<div id="botones"  class="marcoBotones">';

        echo '<div class="campoBoton">';
        echo '<button  onclick="cambiarNombreCatalogo()" type="button" tabindex="2" id="crearA" value="' . $crear . '" class="ui-button-text ui-state-default ui-corner-all ui-button-text-only">' . $crear . '</button>';

        echo '</div>';

        echo '<div class="campoBoton">';
        echo '<button "="" onclick=" agregarElementoCatalogo()" type="button" tabindex="2" id="agregarA"';
        echo 'value="Agregar Elemento" class="ui-button-text ui-state-default ui-corner-all ui-button-text-only">Agregar Elemento</button>';
        echo '</div><div class="campoBoton">';
        echo '<button "="" onclick=" reiniciarEdicion(' . $_REQUEST['idCatalogo'] . ')" type="button" tabindex="3" id="reiniciarA"';
        echo 'value="Reiniciar" class="ui-button-text ui-state-default ui-corner-all ui-button-text-only">Reiniciar</button>';
        echo '</div>';
        echo '</div>';
    }

    private function campoId() {

        echo '<div class= "jqueryui  anchoColumna1">';
        echo '<div style="float:left; width:200px"><label for="id">ID Dependencia Hijo</label><span style="white-space:pre;"> </span></div>';
        echo '<input type="text" maxlength="" size="50" value="" class="ui-widget ui-widget-content ui-corner-all';
        echo ' validate[required,number] " tabindex="2" name="id" id="id" title="Ingrese ID Dependencia Hijo">';
        echo '</div>';
    }

    private function campoPadre() {
        $idPadreTitulo = $this->lenguaje->getCadena('idPadreTitulo');
        $idPadre = $this->lenguaje->getCadena('idPadre');
        echo '<div class="jqueryui  anchoColumna1">';
        echo '<div style="float:left;display:inline; width:200px"><label for="idPadre">' . $idPadre . '</label></div>';
        echo '<input type="text" onchange="cambiarPadre()" onkeyup="autocompletar()" class="ui-widget ui-widget-content ui-corner-all validate[required,custom[valorLista]]"  tabindex="3" size="50" value="0" name="lidPadre" id="lidPadre" title="' . $idPadreTitulo . '" class="ui-widget ui-widget-content ui-corner-all"></input>';
        echo '</div>';
    }

    private function direccion() {
        $direccionTitulo = $this->lenguaje->getCadena('direccionTitulo');
        $direccion = $this->lenguaje->getCadena('direccion');
        echo '<div class="jqueryui  anchoColumna1">';
        echo '<div style="float:left;display:inline; width:200px"><label for="direccion">' . $direccion . '</label></div>';
        echo '<input type="text" class="ui-widget ui-widget-content ui-corner-all validate[required]"  tabindex="3" size="50" value="" name="ldireccion" id="ldireccion" title="' . $direccionTitulo . '" class="ui-widget ui-widget-content ui-corner-all"></input>';
        echo '</div>';
    }

    private function telefono() {
        $telefonoTitulo = $this->lenguaje->getCadena('telefonoTitulo');
        $telefono = $this->lenguaje->getCadena('telefono');
        echo '<div class="jqueryui  anchoColumna1">';
        echo '<div style="float:left;display:inline; width:200px"><label for="telefono">' . $telefono . '</label></div>';
        echo '<input type="text" class="ui-widget ui-widget-content ui-corner-all validate[required]"  tabindex="3" size="25" value="" name="ltelefono" id="ltelefono" title="' . $telefonoTitulo . '" class="ui-widget ui-widget-content ui-corner-all"></input>';
        echo '</div>';
    }

    private function campoNombre() {

        $nombreTitulo = $this->lenguaje->getCadena('nombreElementoTitulo');
        $nombre = $this->lenguaje->getCadena('nombreElemento');
        echo ' <div class="jqueryui  anchoColumna1">';
        echo ' <div style="float:left; width:200px"><label for="nombreElemento">'.$nombre.'</label><span style="white-space:pre;"> </span></div>';
        echo ' <input type="text" maxlength="" size="50" value="" class="ui-widget ui-widget-content';
        echo ' ui-corner-all  validate[required,onlyLetterNumber] " tabindex="4" name="nombreElemento" id="nombreElemento" title=" '.$nombreTitulo.'">';
        echo ' </div>';
    }

    private function notaUso() {
        echo ' <div class="jqueryui  anchoColumna1">';
        echo "<p>";
        echo "<b>Nota de Uso</b>: Para recuperar un identificador padre ya creado y asignarlo a un nuevo elemento, seleccione un elemento del listado. Click en Reiniciar para dar valor inicial al Identificador Padre.";
        echo "</p>";
        echo ' </div><br>';
    }

    private function principal() {
        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

        $tab = 0;
        $this->notaUso();
        $this->edicionNombreCatalogo();

        echo '<form id="catalogo" name="catalogo" action="index.php" method="post">';
        echo '<fieldset class="ui-corner-all ui-widget ui-widget-content ui-corner-all">';
        echo '<legend>' . $this->lenguaje->getCadena('elementos') . '</legend>';

        $this->campoPadre();
        $this->campoId();
        $this->campoNombre();
        $this->direccion();
        $this->telefono();

        echo '<input id="idCatalogo" type="hidden" value="' . $_REQUEST['idCatalogo'] . '" name="idCatalogo">';
        echo '<input id="idReg" type="hidden" value="0" name="idReg">';
        echo '<input id="idPadre" type="hidden" value="0" name="idPadre">';
        echo '</fieldset>';
        $this->edicionBotones();
        echo "</form>";
    }

    function mensaje() {

        // Si existe algun tipo de error en el login aparece el siguiente mensaje
        $mensaje = $this->miConfigurador->getVariableConfiguracion('mostrarMensaje');
        //$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );

        if ($mensaje) {

            $tipoMensaje = $this->miConfigurador->getVariableConfiguracion('tipoMensaje');

            if ($tipoMensaje == 'json') {

                $atributos ['mensaje'] = $mensaje;
                $atributos ['json'] = true;
            } else {
                $atributos ['mensaje'] = $this->lenguaje->getCadena($mensaje);
            }
            // -------------Control texto-----------------------
            $esteCampo = 'divMensaje';
            $atributos ['id'] = $esteCampo;
            $atributos ["tamanno"] = '';
            $atributos ["estilo"] = 'information';
            $atributos ["etiqueta"] = '';
            $atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
            echo $this->miFormulario->campoMensaje($atributos);
            unset($atributos);
        }

        return true;
    }

}

$miFormulario = new Formulario($this->lenguaje, $this->miFormulario, $this->sql, $this);


$miFormulario->formulario();
$miFormulario->mensaje();
?>