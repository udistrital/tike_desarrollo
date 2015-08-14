<?php
/**
 * Este archivo se utiliza para registrar las funciones javascript que sirven para peticiones AJAX. 
 * Se implementa antes de procesar cualquier bloque al momento de armar la página.
 * 
 * Importante: Si se desean los datos del bloque estos se encuentran en el arreglo $esteBloque
 *
 * El archivo procesarAjax.php (carpeta funcion) tiene la tarea de procesar la peticiones ajax conforme a la variable
 * funcion que se registra en la URL.
 *
 */
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url.=$this->miConfigurador->getVariableConfiguracion("site");
$url.="/index.php?";

$ruta = $this->miConfigurador->getVariableConfiguracion("raizDocumento");
$ruta.="/blocks/" . $esteBloque["grupo"] . "/" . $esteBloque["nombre"] . "/";
$directorioImagenes = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/images";

$urlImagenes = $this->miConfigurador->getVariableConfiguracion("host");
$urlImagenes.=$this->miConfigurador->getVariableConfiguracion("site");
$urlImagenes.="/blocks/" . $esteBloque["grupo"] . "/" . $esteBloque["nombre"] . "/images";;


//Incluir el archivo de idioma
/**
 * @todo Rescatar el valor del idioma desde la sesión. En la actualidad de forma predeterminada se utiliza es_es
 */
include_once($ruta . "/locale/es_es/Mensaje.php");


$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");

//Se debe tener una variable llamada procesarAjax
$cadenaACodificar.="&procesarAjax=true";
$cadenaACodificar.="&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar.="&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar.="&action=index.php";

?>
<script type='text/javascript'>

<?php
$valor = "#cuerpoNotas";
$cadenaFinal = $cadenaACodificar . "&funcion=" . $valor;
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$estaUrl = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal, $enlace);
?>    
    function guardarNota(usuario)
    {
    		var divInfo = $("#notasTodos"); 
            var respuesta = $.ajax({
            url: "<?php echo $estaUrl ?>",
            dataType: "html",
            data: {
                featureClass: "P",
                style: "full",
                maxRows: 12,
                texto: $("#textoBitacora").val(),
                idUsuario: usuario
                }
            })
                    .done(function(data) {
                $(divInfo).html(data);

            })
                    .fail(function() {
                alert("error");
            });
            
    }
    


    
</script>