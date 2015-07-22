<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class registrarForm {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;

    function __construct($lenguaje, $formulario, $sql) {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->miSql = $sql;
    }

    function miForm() {
        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

        // ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
        /**
         * Atributos que deben ser aplicados a todos los controles de este formulario.
         * Se utiliza un arreglo
         * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
         *
         * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
         * $atributos= array_merge($atributos,$atributosGlobales);
         */
        $atributosGlobales ['campoSeguro'] = 'true';


        $_REQUEST ['tiempo'] = time();
        $tiempo = $_REQUEST['tiempo'];
   

        // lineas para conectar base de d atos-------------------------------------------------------------------------------------------------
        $conexion = "inventarios";

        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        // Limpia Items Tabla temporal
        $cadenaSql = $this->miSql->getCadenaSql('limpiar_tabla_items');
        $resultado_secuencia = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");


        // Consultar Orden Compra--------------------------------------------------------------------------------------------
        $cadenaSql = $this->miSql->getCadenaSql('consultarActaM', $_REQUEST ['numero_acta']);
        $Acta = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

        $cadenaSql = $this->miSql->getCadenaSql('consultarItems', $_REQUEST ['numero_acta']);
        $items = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $seccion['tiempo'] = $tiempo;

        foreach ($items as $valor => $key) {
            $key = array_merge($key, $seccion);
            $cadenaSql = $this->miSql->getCadenaSql('insertarItemTemporal', $key);
            $insertados = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");
        }

   
        $conexion = "inventarios";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $cadenaSql = $this->miSql->getCadenaSql('tipoBien');
        $tipoBien = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

        $cadenaSql1 = $this->miSql->getCadenaSql('tipoComprador');
        $tipoComprador = $esteRecursoDB->ejecutarAcceso($cadenaSql1, "busqueda");

        $cadenaSql2 = $this->miSql->getCadenaSql('tipoAccion');
        $tipoAccion = $esteRecursoDB->ejecutarAcceso($cadenaSql2, "busqueda");


        // ___________________________________________________________________________________
        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque ['nombre'];
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = 'multipart/form-data';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        // $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = false;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos); {
            // ---------------- SECCION: Controles del Formulario -----------------------------------------------

            $esteCampo = "marcoDatosBasicos";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            $atributos ["leyenda"] = "Modificar Acta Recibido";
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
            unset($atributos); {


                $esteCampo = "AgrupacionActa";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Datos Iniciales";
                echo $this->miFormulario->agrupacion('inicio', $atributos); {

// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'dependencia';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 1;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1],maxSize[15]';

                    if (isset($Acta[0][$esteCampo])) {
                        $atributos ['valor'] = $Acta[0][$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 220;
                    $tab ++;

// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'fecha_recibido';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 1;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1],maxSize[200]';

                    if (isset($Acta[0][$esteCampo])) {
                        $atributos ['valor'] = $Acta[0][$esteCampo];
                    } else {
                        $atributos ['valor'] = date('d/m/Y');
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 220;
                    $tab ++;

// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
///------------------CONTROL: Lista desplegable -----------------------------------------------------

                    $matrizItems = $tipoBien;

                    $esteCampo = "tipo_bien";
                    $atributos['nombre'] = $esteCampo;
                    $atributos['id'] = $esteCampo;
                    $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos['tab'] = $tab ++;
                    $atributos['seleccion'] = $Acta[0][$esteCampo];
                    $atributos['evento'] = 2;
                    if (isset($Acta[0][$esteCampo])) {
                        $atributos ['valor'] = $Acta[0][$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos['deshabilitado'] = false;
                    $atributos['columnas'] = "1";
                    $atributos['tamanno'] = 1;
                    $atributos['ajax_function'] = "";
                    $atributos['ajax_control'] = $esteCampo;
                    $atributos['estilo'] = "jqueryui";
                    $atributos['validar'] = "required";
                    $atributos['limitar'] = false;
                    $atributos['matrizItems'] = $matrizItems;
//$atributos['miniRegistro']=;
                    $atributos['baseDatos'] = "inventarios";
                    $atributos['cadena_sql'] = $this->miSql->getCadenaSql("tipoOrden");

// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);

// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'nitproveedor';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 1;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1],maxSize[15],custom[onlyNumberSp]';

                    if (isset($Acta[0][$esteCampo])) {
                        $atributos ['valor'] = $Acta[0][$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 220;
                    $tab ++;

// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'proveedor';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 1;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1],maxSize[200]';

                    if (isset($Acta[0][$esteCampo])) {
                        $atributos ['valor'] = $Acta[0][$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 220;
                    $tab ++;

// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto -------------------------------------------------- 
// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'numfactura';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 1;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1],maxSize[15],custom[onlyNumberSp]';

                    if (isset($Acta[0][$esteCampo])) {
                        $atributos ['valor'] = $Acta[0][$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 220;
                    $tab ++;

// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'fecha_factura';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 1;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1],maxSize[200]';

                    if (isset($Acta[0][$esteCampo])) {
                        $atributos ['valor'] = $Acta[0][$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 220;
                    $tab ++;

// Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------

                    echo $this->miFormulario->agrupacion('fin');

                    //----------------------------------------------- Items ------------------------------------//

                    $esteCampo = "descripcionFactura";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = $this->lenguaje->getCadena($esteCampo);
                    echo $this->miFormulario->agrupacion('inicio', $atributos); {
                        ?>
                        <center>
                            <table id="tablaContenido">
                                <tr>
                                    <td>&nbsp</td>
                                </tr>
                            </table>
                            <div id="barraNavegacion"></div>
                        </center>
                        <?php

                    }
                    echo $this->miFormulario->agrupacion('fin');
                    unset($atributos);


//------ -----//
//------------------------------ Nueva Agrupación -------------------------------------------------//
                    $esteCampo = "AgrupacionActa";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Información General";
                    echo $this->miFormulario->agrupacion('inicio', $atributos);
                    {
///------------------CONTROL: Lista desplegable -----------------------------------------------------

                        $matrizItems = $tipoComprador;

                        $esteCampo = "tipocomprador";
                        $atributos['nombre'] = $esteCampo;
                        $atributos['id'] = $esteCampo;
                        $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos['tab'] = $tab ++;
                        $atributos['seleccion'] = $Acta[0][$esteCampo];
                        $atributos['evento'] = 2;
                        if (isset($Acta[0][$esteCampo])) {
                            $atributos ['valor'] = $Acta[0][$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos['deshabilitado'] = false;
                        $atributos['columnas'] = "1";
                        $atributos['tamanno'] = 1;
                        $atributos['ajax_function'] = "";
                        $atributos['ajax_control'] = $esteCampo;
                        $atributos['estilo'] = "jqueryui";
                        $atributos['validar'] = 'required';
                        $atributos['limitar'] = false;
                        $atributos['matrizItems'] = $matrizItems;
//$atributos['miniRegistro']=;
                        $atributos['baseDatos'] = "inventarios";
                        $atributos['cadena_sql'] = $this->miSql->getCadenaSql("tipoOrden");

// Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
// -------------------- FIN CONTROL Lista Desplegable ---------------------------------------------//
///------------------CONTROL: Lista desplegable -----------------------------------------------------

                        $matrizItems = $tipoAccion;

                        $esteCampo = "tipoaccion";
                        $atributos['nombre'] = $esteCampo;
                        $atributos['id'] = $esteCampo;
                        $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos['tab'] = $tab ++;
                        $atributos['seleccion'] = $Acta[0][$esteCampo];
                        $atributos['evento'] = 2;
                        if (isset($Acta[0][$esteCampo])) {
                            $atributos ['valor'] = $Acta[0][$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos['deshabilitado'] = false;
                        $atributos['columnas'] = "1";
                        $atributos['tamanno'] = 1;
                        $atributos['ajax_function'] = "";
                        $atributos['ajax_control'] = $esteCampo;
                        $atributos['estilo'] = "jqueryui";
                        $atributos['validar'] = "required";
                        $atributos['limitar'] = false;
                        $atributos['matrizItems'] = $matrizItems;
//$atributos['miniRegistro']=;
                        $atributos['baseDatos'] = "inventarios";
                        $atributos['cadena_sql'] = $this->miSql->getCadenaSql("tipoOrden");

// Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
// -------------------- FIN CONTROL Lista Desplegable ---------------------------------------------//


                        echo $this->miFormulario->agrupacion('fin');
                    }

// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
//------------------------------ Nueva Agrupación -------------------------------------------------//
                    $esteCampo = "AgrupacionActa";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Validación de la Información";
                    echo $this->miFormulario->agrupacion('inicio', $atributos);
                    {
///------------------CONTROL: Lista desplegable -----------------------------------------------------
// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'fecha_revision';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 1;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required, minSize[1],maxSize[200]';

                        if (isset($Acta[0][$esteCampo])) {
                            $atributos ['valor'] = $Acta[0][$esteCampo];
                        } else {
                            $atributos ['valor'] = date('d/m/Y');
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;
                        $tab ++;

// Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'revisor';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 1;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required, minSize[1],maxSize[15]';

                        if (isset($Acta[0][$esteCampo])) {
                            $atributos ['valor'] = $Acta[0][$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;
                        $tab ++;

// Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);
// --------------- FIN CONTROL : Cuadro de Texto ---------------------------------------------------//

                        $esteCampo = 'aprobacionCheck';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['estilo'] = 'campoCuadroSeleccionCorta';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 1;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroSeleccion($atributos);
                        unset($atributos);
                        //----------------------- FIN CONTROL CHECKBOX--------------------//
                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'observacionesacta';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 105;
                        $atributos ['filas'] = 5;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'minSize[1],maxSize[2000]';
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;
                        if (isset($Acta[0][$esteCampo])) {
                            $atributos ['valor'] = $Acta[0][$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoTextArea($atributos);
                        unset($atributos);

                        //----------------------- FIN CONTROL AREA TEXTOO---------------//

                        echo $this->miFormulario->agrupacion('fin');

//---- FIN DE LA AGRUPACIÓN-----
                    }
                    // ------------------Division para los botones-------------------------
                    $atributos ["id"] = "botones";
                    $atributos ["estilo"] = "marcoBotones";
                    echo $this->miFormulario->division("inicio", $atributos);

                    // -----------------CONTROL: Botón ----------------------------------------------------------------
                    $esteCampo = 'botonAceptar';
                    $atributos ["id"] = $esteCampo;
                    $atributos ["tabIndex"] = $tab;
                    $atributos ["tipo"] = '';
                    // submit: no se coloca si se desea un tipo button genérico
                    $atributos ['submit'] = 'true';
                    $atributos ["estiloMarco"] = '';
                    $atributos ["estiloBoton"] = 'jqueryui';
                    // verificar: true para verificar el formulario antes de pasarlo al servidor.
                    $atributos ["verificar"] = '';
                    $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                    $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoBoton($atributos);
                    // -----------------FIN CONTROL: Botón -----------------------------------------------------------
                    // // -----------------CONTROL: Botón ----------------------------------------------------------------
                    // $esteCampo = 'botonCancelar';
                    // $atributos ["id"] = $esteCampo;
                    // $atributos ["tabIndex"] = $tab;
                    // $atributos ["tipo"] = 'boton';
                    // // submit: no se coloca si se desea un tipo button genérico
                    // $atributos ['submit'] = true;
                    // $atributos ["estiloMarco"] = '';
                    // $atributos ["estiloBoton"] = 'jqueryui';
                    // // verificar: true para verificar el formulario antes de pasarlo al servidor.
                    // $atributos ["verificar"] = '';
                    // $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                    // $atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
                    // $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
                    // $tab ++;
                    // // Aplica atributos globales al control
                    // $atributos = array_merge ( $atributos, $atributosGlobales );
                    // echo $this->miFormulario->campoBoton ( $atributos );

                    echo $this->miFormulario->marcoAgrupacion('fin');

                    // ---------------- SECCION: División ----------------------------------------------------------
                    $esteCampo = 'division1';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['estilo'] = 'general';
                    echo $this->miFormulario->division("inicio", $atributos);

                    // ---------------- FIN SECCION: División ----------------------------------------------------------
                    echo $this->miFormulario->division('fin');

                    // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
                    // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
                    // Se debe declarar el mismo atributo de marco con que se inició el formulario.
                }

                // -----------------FIN CONTROL: Botón -----------------------------------------------------------
                // ------------------Fin Division para los botones-------------------------
                echo $this->miFormulario->division("fin");

                // ------------------- SECCION: Paso de variables ------------------------------------------------

                /**
                 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
                 * SARA permite realizar esto a través de tres
                 * mecanismos:
                 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
                 * la base de datos.
                 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
                 * formsara, cuyo valor será una cadena codificada que contiene las variables.
                 * (c) a través de campos ocultos en los formularios. (deprecated)
                 */
                // En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
                // Paso 1: crear el listado de variables



                $valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
                $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
                $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
                $valorCodificado .= "&opcion=modificarActa";
                $valorCodificado .= "&seccion=".$tiempo;
                $valorCodificado .= "&id_acta=".$_REQUEST ['numero_acta'];

                /**
                 * SARA permite que los nombres de los campos sean dinámicos.
                 * Para ello utiliza la hora en que es creado el formulario para
                 * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
                 * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
                 * (b) asociando el tiempo en que se está creando el formulario
                 */
                $valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
                $valorCodificado .= "&tiempo=" . time();
                // Paso 2: codificar la cadena resultante
                $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

                $atributos ["id"] = "formSaraData"; // No cambiar este nombre
                $atributos ["tipo"] = "hidden";
                $atributos ['estilo'] = '';
                $atributos ["obligatorio"] = false;
                $atributos ['marco'] = true;
                $atributos ["etiqueta"] = "";
                $atributos ["valor"] = $valorCodificado;
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);

                $atributos ['marco'] = true;
                $atributos ['tipoEtiqueta'] = 'fin';
                echo $this->miFormulario->formulario($atributos);

                return true;
            }
        }
    }

}

$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>
