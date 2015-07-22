<?php

namespace arka\dependencia\agregarDependencia\dibujarCatalogo;

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
    var $conteoListas;

    function __construct($lenguaje, $formulario, $sql, $funcion) {

        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->sql = $sql;

        $this->funcion = $funcion;

        $this->conteoListas = 0;

        $conexion="inventarios";
        $this->esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        if (!$this->esteRecursoDB) {
            //Este se considera un error fatal
            exit;
        }
    }

    private function consultarElementos() {

        $cadena_sql = $this->sql->getCadenaSql("listarElementos", $_REQUEST['idCatalogo']);
        $registros = $this->esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");


        if (!$registros) {
            $this->miConfigurador->setVariableConfiguracion('mostrarMensaje', 'catalogoVacio');
            $this->mensaje();
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

    public function dibujarCatalogo() {

        //consultar elementos 


        $base = $this->consultarElementosNivel(0);

        $this->consultarDatosCatalogo();

        //Inicio Lista
        echo "<br>";
        echo '<div id = "arbol">';
        echo '<fieldset class="ui-corner-all ui-widget ui-widget-content ui-corner-all">';
        echo '<legend>' . $this->arrayDatos[0]['lista_nombre'] . '</legend>';

        if (!$base) {
            $this->miConfigurador->setVariableConfiguracion('mostrarMensaje', 'catalogoVacio');

            $this->mensaje();
        } else {
            $this->dibujarLista($base);
        }

        echo "</fieldset>";
        echo "</div>";
        echo "<br>";

        $textos[8] = $this->lenguaje->getCadena("listaCasa");

        echo '<div class="marcoBotones">';
        echo '<button id="volver"  class="botonMenu" value="' . $textos[8] . '" title="' . $textos[8] . '">' . $textos[8];
        echo '</button>';
        echo "</div>";
    }

    private function dibujarLista($base, $hijo = false) {

        if ($base) {

            echo '<ul class=tree ';
            //if($this->conteoListas==0&&!$hijo) echo 'class="tree" ' ;
            //else echo 'style="list-style: none; ';
            $this->conteoListas++;
            echo '">';
            foreach ($base as $b) {

                //var_dump($this->conteoListas);echo "<br>";
                $base2 = $this->consultarElementosNivel($b['elemento_id']);
                echo '<div ';
                if ($hijo)
                    echo 'style="display:none;" ';

                echo 'class="cont contenedor' . $b['elemento_padre'] . '" id="elemento' . $b['elemento_padre'] . '" ';
                echo ">";



                echo '<li id="el' . $b['elemento_id'] . '">';

                /////comienzo fila
                echo '<div class="fila">';
                echo '<div class="interno" >';
                //contraer - expandir
                if ($base2) {

                    echo '<button title="Click para expandir elementos" class="expandir" onclick="cambioHijos(\'contenedor' . $b['elemento_id'] . '\',this)">';
                    echo "</button>";
                }




                echo "</div>";

                echo '<div class="interno"   ';
                /* if(isset($_REQUEST['editar'])&&$_REQUEST['editar']==true){
                  echo 'title="click para seleccionar el padre"';
                  } */


                echo ' title="' . $b['elemento_fecha_creacion'] . '" onclick="accion(\'contenedor' . $b['elemento_id'] . '\',' . $b['elemento_codigo'] . ',' . $b['elemento_id'] . ')"';

                echo '>';
                echo $b['elemento_codigo'] . " " . $b['elemento_nombre'] . "  ";
                echo "</div>";


                if (isset($_REQUEST['editar']) && $_REQUEST['editar'] == true) {
                    //edicion

                    echo '<div class="interno">';
                    echo '<div class="posiscion">';

                    //eliminar
                    echo '<button title="Click para Eliminar" class="eliminar" onclick="eliminarElementoCatalogo(' . $b['elemento_id'] . ',' . $b['elemento_padre'] . ',' . $b['elemento_codigo'] . ',' . $b['elemento_catalogo'] . ')">';
                    echo "</button>";

                    //editar
                    echo '<button title="Click para Editar" class="editar" onclick="editarElementoCatalogo(' . $b['elemento_id'] . ',' . $b['elemento_padre'] . ',' . $b['elemento_codigo'] . ',\'' . $b['elemento_nombre'] . '\',' . $b['elemento_catalogo'] . ')">';
                    echo "</button>";


                    echo '</div>';
                    echo '</div>';
                }

                echo "</div>";
                ///fin fila
                if ($base2) {
                    $this->dibujarLista($base2, true);
                }

                echo "</li>";
                echo "</div>";
            }
            $this->conteoListas = 0;
            echo "</ul>";
        }
        return true;
    }

    private function consultarElementosNivel($nivel) {
        $cadena_sql = $this->sql->getCadenaSql("elementosNivel", array($_REQUEST['idCatalogo'], $nivel));
        $registros = $this->esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
        return $registros;
    }

    function mensaje() {

        // Si existe algun tipo de error en el login aparece el siguiente mensaje
        $mensaje = $this->miConfigurador->getVariableConfiguracion('mostrarMensaje');

        //$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );
        $atributos = array();
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
            if ($tipoMensaje)
                $atributos ["estilo"] = $tipoMensaje;
            else
                $atributos ["estilo"] = 'information';
            $atributos ["etiqueta"] = '';
            $atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario

            echo $this->miFormulario->campoMensaje($atributos);

            unset($atributos);
        }
        $this->miConfigurador->setVariableConfiguracion('mostrarMensaje', null);
        return true;
    }

}

$miFormulario = new Formulario($this->lenguaje, $this->miFormulario, $this->sql, $this);


$miFormulario->dibujarCatalogo();

//$miFormulario->mensaje ();
?>