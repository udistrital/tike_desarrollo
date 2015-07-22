<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class pie {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;

    function __construct($lenguaje, $formulario) {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;
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
        $tiempo = $_REQUEST ['tiempo'];

        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = 'pie';

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
        

            //-------------------------------------------------------------------//
            $esteCampo = "marcoDatosBasicosPie";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "";
            $atributos ['tipoEtiqueta'] = 'inicio';
            $atributos ['marco'] = false;
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
            unset($atributos); {

                $tab = 1;
                // ------------------Division-------------------------

                $atributos ["id"] = "colm1";
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos); {

                    $esteCampo = 'enlaceDistrital';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['enlace'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['tabIndex'] = 1;
                    // $atributos ['estilo'] = 'jquery';
                    $atributos ['enlaceImagen'] = $this->miConfigurador->getVariableConfiguracion('rutaUrlBloque') . 'imagen/escudo.png';
                    $atributos ['ancho'] = '60px';
                    $atributos ['alto'] = '80px';
                    echo $this->miFormulario->enlace($atributos);
                    unset($atributos);
                }

                echo $this->miFormulario->division("fin");

                $atributos ["id"] = "colm2";
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos); {

                    $esteCampo = 'mensajePie';
                    $atributos ["id"] = $esteCampo;
                    $atributos ["estilo"] = $esteCampo;
                    $atributos ['columnas'] = 1;
                    $atributos ["estilo"] = "textoSubtituloCursiva";
                    $atributos ['texto'] = $this->lenguaje->getCadena($esteCampo);
                    $tab ++;
                    echo $this->miFormulario->campoTexto($atributos);
                    unset($atributos);
                }

                echo $this->miFormulario->division("fin");

                $atributos ["id"] = "colm3";
                $atributos ["estilo"] = "textoDerecha";
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos); {

                    // $atributos ["id"] = "clockdigital";
                    // echo $this->miFormulario->division ( "inicio", $atributos );
                    // unset ( $atributos );
                    // {

                    /*
                     * <img id="digitalhour" alt="Clocks hours" src="<?php echo $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' ) . 'imagen/digitalhours.gif';?>">
                     * <img id="digitalminute" alt="Clocks minutes" src="<?php echo$this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' ) . 'imagen/digitalminutes.gif'; ?>">
                     * <img id="digitalsecond" alt="Clocks seconds" src="<?php echo $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' ) . 'imagen/digitalseconds.gif';?>">
                     * <div></div>
                     * <div></div>
                     */
                    // $atributos ["id"] = "ventana1";
                    // echo $this->miFormulario->division ( "inicio", $atributos );
                    // unset ( $atributos );
                    // {
                    // }
                    // $esteCampo = 'digitalsecond';
                    // $atributos ['id'] = $esteCampo;
                    // $atributos ['imagen'] = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' ) . 'imagen/digitalseconds.gif';
                    // // $atributos ['ancho'] = '60px';
                    // // $atributos ['alto'] = '80px';
                    // // $atributos ['etiqueta'] = 'Clocks seconds';
                    // $atributos ['saltoLinea'] = true;
                    // echo $this->miFormulario->grafico ( $atributos );
                    // unset ( $atributos );
                    // $esteCampo = 'digitalminute';
                    // $atributos ['id'] = $esteCampo;
                    // $atributos ['imagen'] = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' ) . 'imagen/digitalminutes.gif';
                    // // $atributos ['ancho'] = '60px';
                    // // $atributos ['alto'] = '80px';
                    // // $atributos ['etiqueta'] = 'Clocks minutes';
                    // $atributos ['saltoLinea'] = true;
                    // echo $this->miFormulario->grafico ( $atributos );
                    // unset ( $atributos );
                    // $esteCampo = 'digitalhour';
                    // $atributos ['id'] = $esteCampo;
                    // $atributos ['imagen'] = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' ) . 'imagen/digitalhours.gif';
                    // // $atributos ['etiqueta'] = 'Clocks hours';
                    // $atributos ['saltoLinea'] = true;
                    // echo $this->miFormulario->grafico ( $atributos );
                    // unset ( $atributos );
                    // echo $this->miFormulario->division ( "fin" );
                    // $atributos ["id"] = "ventana2";
                    // echo $this->miFormulario->division ( "inicio", $atributos );
                    // unset ( $atributos );
                    // {
                    // }
                    // echo $this->miFormulario->division ( "fin" );
                    // }
                    // echo $this->miFormulario->division ( "fin" );

                    setlocale(LC_ALL, "es_ES");
                    $fecha = strftime("%A %d de %B del %Y");

                    $esteCampo = 'fecha';
                    $atributos ["id"] = $esteCampo;
                    $atributos ["estilo"] = $esteCampo;
                    $atributos ['columnas'] = 1;
                    $atributos ["estilo"] = $esteCampo;
                    $atributos ['texto'] = strtoupper($fecha);
                    $tab ++;
                    echo $this->miFormulario->campoTexto($atributos);
                    unset($atributos);

                    // $esteCampo = 'otrasRedes ';
                    // $atributos ["id"] = $esteCampo;
                    // $atributos ["estilo"] = $esteCampo;
                    // $atributos ['columnas'] = 1;
                    // $atributos ["estilo"] = "textoSubtituloCursiva";
                    // $atributos ['texto'] = $this->lenguaje->getCadena ( $esteCampo );
                    // $tab ++;
                    // echo $this->miFormulario->campoTexto ( $atributos );
                    // unset ( $atributos );
                    // $esteCampo = 'enlaceCondor';
                    // $atributos ['id'] = $esteCampo;
                    // $atributos ['enlace'] = $this->lenguaje->getCadena ( $esteCampo );
                    // $atributos ['tabIndex'] = 1;
                    // // $atributos ['estilo'] = 'jquery';
                    // $atributos ['enlaceImagen'] = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' ) . 'imagen/condor.png';
                    // $atributos ['ancho'] = '40px';
                    // $atributos ['alto'] = '30px';
                    // echo $this->miFormulario->enlace ( $atributos );
                    // unset ( $atributos );
                    // $esteCampo = 'enlaceProveedores';
                    // $atributos ['id'] = $esteCampo;
                    // $atributos ['enlace'] = $this->lenguaje->getCadena ( $esteCampo );
                    // $atributos ['tabIndex'] = 1;
                    // // $atributos ['estilo'] = 'jquery';
                    // $atributos ['enlaceImagen'] = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' ) . 'imagen/provee.png';
                    // $atributos ['ancho'] = '30px';
                    // $atributos ['alto'] = '30px';
                    // $atributos ['saltoLinea'] = true;
                    // echo $this->miFormulario->enlace ( $atributos );
                    // unset ( $atributos );
                    // $esteCampo = 'redesSociales ';
                    // $atributos ["id"] = $esteCampo;
                    // $atributos ["estilo"] = $esteCampo;
                    // $atributos ['columnas'] = 1;
                    // $atributos ["estilo"] = "textoSubtituloCursiva";
                    // $atributos ['texto'] = $this->lenguaje->getCadena ( $esteCampo );
                    // $tab ++;
                    // echo $this->miFormulario->campoTexto ( $atributos );
                    // unset ( $atributos );

                    $esteCampo = 'enlacegoogle';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['enlace'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['tabIndex'] = 1;
                    // $atributos ['estilo'] = 'jquery';
                    $atributos ['enlaceImagen'] = $this->miConfigurador->getVariableConfiguracion('rutaUrlBloque') . 'imagen/google+.png';
                    $atributos ['ancho'] = '30px';
                    $atributos ['alto'] = '30px';
                    echo $this->miFormulario->enlace($atributos);
                    unset($atributos);

                    $esteCampo = 'enlacefacebook';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['enlace'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['tabIndex'] = 1;
                    // $atributos ['estilo'] = 'jquery';
                    $atributos ['enlaceImagen'] = $this->miConfigurador->getVariableConfiguracion('rutaUrlBloque') . 'imagen/facebook.png';
                    $atributos ['ancho'] = '30px';
                    $atributos ['alto'] = '30px';
                    echo $this->miFormulario->enlace($atributos);
                    unset($atributos);

                    $esteCampo = 'enlacetwitter';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['enlace'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['tabIndex'] = 1;
                    // $atributos ['estilo'] = 'jquery';
                    $atributos ['enlaceImagen'] = $this->miConfigurador->getVariableConfiguracion('rutaUrlBloque') . 'imagen/twitter.png';
                    $atributos ['ancho'] = '30px';
                    $atributos ['alto'] = '30px';
                    echo $this->miFormulario->enlace($atributos);
                    unset($atributos);

                    // $atributos ["id"] = "cssclock";
                    // echo $this->miFormulario->division ( "inicio", $atributos );
                    // unset ( $atributos );
                    // {
                    // }
                    // echo $this->miFormulario->division ( "fin" );
                }

                echo $this->miFormulario->division("fin");
            }

            echo $this->miFormulario->agrupacion('fin');
        }

        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);

        return true;
    }

}

$miSeleccionador = new pie($this->lenguaje, $this->miFormulario);

$miSeleccionador->miForm();
?>



