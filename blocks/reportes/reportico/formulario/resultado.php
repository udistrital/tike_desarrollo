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

// 		var_dump ( $_REQUEST );
// 		exit ();
        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');


        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");


        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
        $rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
        $rutaBloque .= $esteBloque ['grupo'] . $esteBloque ['nombre'];

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

        // -------------------------------------------------------------------------------------------------
        $conexion = "inventarios";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        if (isset($_REQUEST ['fecha_recibido']) && $_REQUEST ['fecha_recibido'] != '') {
            $fechaRecibido = $_REQUEST ['fecha_recibido'];
        } else {
            $fechaRecibido = '';
        }

        if (isset($_REQUEST ['numero_acta']) && $_REQUEST ['numero_acta'] != '') {
            $numeroActa = $_REQUEST ['numero_acta'];
        } else {
            $numeroActa = '';
        }

        if (isset($_REQUEST ['nitProveedor']) && $_REQUEST ['nitProveedor'] != '') {
            $nit = $_REQUEST ['nitProveedor'];
        } else {
            $nit = '';
        }

        if (isset($_REQUEST ['numFactura']) && $_REQUEST ['numFactura'] != '') {
            $factura = $_REQUEST ['numFactura'];
        } else {
            $factura = '';
        }

        $arreglo = array(
            $numeroActa,
            $fechaRecibido,
            $nit,
            $factura
        );


        $cadenaSql = $this->miSql->getCadenaSql('consultarActa', $arreglo);
        $Acta = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

       
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
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Consultar y Modificar Acta Recibido";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);


        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        echo $this->miFormulario->division("inicio", $atributos);

        // -----------------CONTROL: Botón ----------------------------------------------------------------
        $esteCampo = 'botonRegresar';
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab;
        $atributos ["tipo"] = 'boton';
        // submit: no se coloca si se desea un tipo button genérico
        $atributos ['submit'] = true;
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
        // ---------------------------------------------------------
        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");



        if ($Acta) {

            echo "<table id='tablaTitulos'>";

            echo "<thead>
                             <tr>
                                <th>Número Acta Recibido</th>
                                <th>Dependencia</th>
                                <th>Fecha Recibido</th>
                                <th>Tipo de Bien</th>
                                <th>Nit Proveedor</th>
                                <th>Proveedor</th>
				<th>Número Factura</th>
                                <th>Fecha Factura</th>
                                <th>Comprador</th>
                                <th>Acción</th>
                                <th>Fecha Revisión</th>
                                <th>Revisor</th>
                                <th>Observaciones</th>
			        <th>Modificar</th>
                                <th>Eliminar</th>
                             </tr>
            </thead>
            <tbody>";

            for ($i = 0; $i < count($Acta); $i ++) {
                $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable .= "&opcion=modificar";
                $variable .= "&numero_acta=" . $Acta [$i] [0];
                $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
                
                
                $variable1= "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable1.= "&opcion=eliminarActa";
                $variable1.= "&numero_acta=" . $Acta [$i] [0];
                $variable1= $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable1, $directorio);

                $mostrarHtml = "<tr>
                    <td><center>" . $Acta [$i] [0] . "</center></td>
                    <td><center>" . $Acta [$i] [1] . "</center></td>
                    <td><center>" . $Acta [$i] [2] . "</center></td>
                    <td><center>" . $Acta [$i] [3] . "</center></td>
                    <td><center>" . $Acta [$i] [4] . "</center></td>
                    <td><center>" . $Acta [$i] [5] . "</center></td>
                    <td><center>" . $Acta [$i] [6] . "</center></td>
                    <td><center>" . $Acta [$i] [7] . "</center></td>
                    <td><center>" . $Acta [$i] [8] . "</center></td>
                    <td><center>" . $Acta [$i] [9] . "</center></td>
                    <td><center>" . $Acta [$i] [10] . "</center></td>
                    <td><center>" . $Acta [$i] [11] . "</center></td>
                    <td><center>" . $Acta [$i] [12] . "</center></td>
                    <td><center>
                    	<a href='" . $variable . "'>
                            <img src='" . $rutaBloque . "/css/images/edit.png' width='15px'>
                        </a>
                  	</center> </td>
                    <td><center>
                    
                    	<a href='" . $variable1 . "'>
                            <img src='" . $rutaBloque . "/css/images/delete.png' width='15px'>
                        </a>
                  	</center> </td>
           
                </tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($variable);
            }

            echo "</tbody>";

            echo "</table>";

            // Fin de Conjunto de Controles
            // echo $this->miFormulario->marcoAgrupacion("fin");
        } else {

            $mensaje = "No Se Encontraron<br>Actas de Recibido";

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'mensajeRegistro';
            $atributos ['id'] = $esteCampo;
            $atributos ['tipo'] = 'error';
            $atributos ['estilo'] = 'textoCentrar';
            $atributos ['mensaje'] = $mensaje;

            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->cuadroMensaje($atributos);
            // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        }



        echo $this->miFormulario->marcoAgrupacion('fin');

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
        $valorCodificado .= "&opcion=regresar";
        $valorCodificado .= "&redireccionar=regresar";
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
         * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
         * (b) asociando el tiempo en que se está creando el formulario
         */
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
    }

}

$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>
