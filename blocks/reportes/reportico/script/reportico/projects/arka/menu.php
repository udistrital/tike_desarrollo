<?php

$menu_title = 'Gestor Reportes';
$menu = array();

$dropdown_menu = array(
    array(
        "project" => "arka",
        "title" => "Reportes Generales",
        "items" => array(
            array("reportfile" => "ordenCompra.xml", "title" => "Orden de Compra"),
	    array("reportfile" => "ordenServicio.xml", "title" => "Orden de Servicio"),
            array("reportfile" => "actaRecibido.xml", "title" => "Acta Recibido del Bien"),
            array("reportfile" => "consultarElemento.xml", "title" => "Consulte Elementos"),
          
        )
    ),
 array(
        "project" => "arka",
        "title" => "Entradas y Salidas",
        "items" => array(
            array("reportfile" => "consultarEntrada.xml", "title" => "Reporte Entrada de Almacén"),
            array("reportfile" => "reporteSalidaAlmacen.xml", "title" => "Reporte Salida de Almacén"),
  array("reportfile" => "contabilidadEntradas.xml", "title" => "Informe Contabilidad Entradas"),
            array("reportfile" => "contabilidadSalidas.xml", "title" => "Informe Contabilidad Salidas"),
        )
    ),
    array(
        "project" => "arka",
        "title" => "Asignación de Inventarios",
        "items" => array(
            array("reportfile" => "consultarInventariosContratistas.xml", "title" => "Consultar Inventarios de Contratistas"),
	    array("reportfile" => "consultarInventariosFuncionarios.xml", "title" => "Consultar Inventarios Funcionarios en Salida"),
            //array("reportfile" => "pazysalvo.xml", "title" => "Generar Paz y Salvo Contratistas"),
        )
    ),
   /* array(
        "project" => "arka",
        "title" => "Radicación de Documentos",
        "items" => array(
            array("reportfile" => "consultarRadicacion_avance.xml", "title" => "Consulta de Radicación por Avance"),
            array("reportfile" => "consultarRadicacion_compra.xml", "title" => "Consulta de Radicación por Compra"),
            array("reportfile" => "consultarRadicacion_contrato.xml", "title" => "Consulta de Radicación por Contrato"),
        )
    ),
      array(
        "project" => "arka",
        "title" => "Depreciación",
        "items" => array(
            array("reportfile" => "consultarDepreciacion_general.xml", "title" => "Consulta Depreciación General"),
            array("reportfile" => "consultarDepreciacion_grupo.xml", "title" => "Consulta Depreciación por Grupo Contable"),
            array("reportfile" => "consultarDepreciacion_elemento.xml", "title" => "Consulta Depreciación por Elemento"),
        )
    ),*/
        array(
        "project" => "arka",
        "title" => "Movimientos",
        "items" => array(
            array("reportfile" => "consultar_hurtos.xml", "title" => "Consulta Faltantes por Hurto"),
            array("reportfile" => "consultar_faltante.xml", "title" => "Consulta Faltantes Dependencia"),
            array("reportfile" => "consultar_sobrante.xml", "title" => "Consulta Sobrantes"),
            array("reportfile" => "consultar_baja.xml", "title" => "Consulta Bajas por Aprobar"),
            array("reportfile" => "consultar_bajaAprobada.xml", "title" => "Consulta Bajas Aprobadas"),
	    array("reportfile" => "consultarTraslado.xml", "title" => "Consulta Traslados"),
        )
    ),
);
?>
