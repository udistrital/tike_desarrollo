<?php 
include_once ("../../core/crypto/Encriptador.class.php");

$miCodificador = Encriptador::singleton ();

echo "clave: ".$miCodificador->codificarClave ( "51914734=" ) . "<br>";

echo $miCodificador->codificar ( "gearbox" ) . "<br>";
echo $miCodificador->decodificar ( "CErJNbK6-fxuVSLWe4wSdcY4MZTY-vVcDdEg8yO3EBE" ) . "<br>";

/*
 * $parametro=array("AwLSWHOR61DhZcTqkA==", "CwKk33OR61C9BaWCkKKdcbc=", "DwLlY3OR61B/gbFc", "EwLQVHOR61DfS8OI/96/gEL0l9XuWw==", "FwJ14HOR61DhdetkyM8whQ==", "GwKxk3OR61C90avH6Fq2nbol5g==", "HwI+DXOR61DMHj+OOwOsk7YAZg=="); foreach ($parametro as $valor){ echo $miCodificador->decodificar($valor)."<br>"; }
 */

?>
