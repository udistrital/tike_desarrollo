<?php

//if(isset($_REQUEST)) {unset ($_REQUEST);}
set_include_path('blocks/reportes/reportico/script/reportico');
require_once('blocks/reportes/reportico/script/reportico/reportico.php');

// Set the timezone according to system defaults
date_default_timezone_set(@date_default_timezone_get());

// Reserver 100Mb for running
ini_set("memory_limit", "512M");

// Allow a good time for long reports to run. Set to 0 to allow unlimited time
ini_set("max_execution_time", "180");
//Incluye archivo que direcciona al proyecto indicado
//include_once('blocks/reportes/reportico/script/reportico/login_reporte_especifico.php');

$reporte = new reportico();
//$reporte->embedded_report = true;

$reporte->execute();

ob_end_flush();
?>
