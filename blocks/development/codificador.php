<?php
include_once ("../../core/crypto/Encriptador.class.php");

$miCodificador = Encriptador::singleton ();
echo "clave: ".$miCodificador->codificarClave ( "sistemasoas" ) . "<br>";
echo $miCodificador->codificar ( "Aristoteles$2434hhzkpru" ) . "<br>";
echo $miCodificador->codificar ( "s1cg3f@d2014=EVA" ) . "<br>";


echo $miCodificador->decodificar ( "2MbMftocNNQSXwZ39ubYAuNbvmB8BDUf99HuigWCoCw" ) . "<br>";

/*
 * $parametro=array("AwLSWHOR61DhZcTqkA==", "CwKk33OR61C9BaWCkKKdcbc=", "DwLlY3OR61B/gbFc", "EwLQVHOR61DfS8OI/96/gEL0l9XuWw==", "FwJ14HOR61DhdetkyM8whQ==", "GwKxk3OR61C90avH6Fq2nbol5g==", "HwI+DXOR61DMHj+OOwOsk7YAZg=="); foreach ($parametro as $valor){ echo $miCodificador->decodificar($valor)."<br>"; }
 */

?>
