<?php
require_once ("core/builder/HtmlBase.class.php");
/**
 *
 * @author paulo
 *        
 *         $atributos['estilo']
 *         $atributos['filas']
 *         $atributos['columnas']
 *        
 */
class TextArea extends HtmlBase {
	function campoTextArea($atributos) {
		$this->setAtributos ( $atributos );
		$this->campoSeguro ();
		
		$final = '';
		
		$this->definirEstilo ( 'campoAreaTexto' );
		
		if (isset ( $this->atributos [self::MARCO] ) && ! isset ( $this->atributos [self::ESTILOMARCO] )) {
			$this->cadenaHTML = "<div>\n";
			$final = '</div>';
		} elseif (isset ( $this->atributos [self::MARCO] ) && isset ( $this->atributos [self::ESTILOMARCO] ) && $this->atributos [self::ESTILOMARCO] != '') {
			$this->cadenaHTML = "<div class=" . $this->atributos [self::ESTILOMARCO] . ">\n";
			$final = '</div>';
		} elseif (isset ( $this->atributos [self::MARCO] ) && isset ( $this->atributos [self::ESTILOMARCO] ) && $this->atributos [self::ESTILOMARCO] == '') {
			$this->cadenaHTML = "<div>\n";
			$this->cadenaHTML .= "<fieldset class='" . $this->atributos [self::ESTILO] . "'>\n";
			$this->cadenaHTML .= "<legend class='" . $this->atributos [self::ESTILO] . "'>\n" . $this->atributos [self::ETIQUETA] . "</legend>\n";
			$final = '</fieldset></div>';
		}
		
		$this->cadenaHTML .= $this->area_texto ( $this->configuracion );
		$this->cadenaHTML .= $final;
		return $this->cadenaHTML;
	}
	function area_texto($datosConfiguracion) {
		$this->mi_cuadro = "<textarea ";
		
		$this->mi_cuadro .= "id='" . $this->atributos [self::ID] . "' ";
		$this->mi_cuadro .= $this->atributosGeneralesAreaTexto ();
		
		if (isset ( $this->atributos [self::ESTILOAREA] ) && $this->atributos [self::ESTILOAREA] != "") {
			$this->mi_cuadro .= self::HTMLCLASS . "'" . $this->atributos [self::ESTILOAREA] . "' ";
		} else {
			
			if (isset ( $this->atributos [self::VALIDAR] ) && $this->atributos [self::VALIDAR] != "") {
				
				$this->mi_cuadro .= "class='areaTexto ui-widget ui-widget-content ui-corner-all validate[" . $this->atributos [self::VALIDAR] . "]";
			} else {
				
				$this->mi_cuadro .= "class='areaTexto ui-widget ui-widget-content ui-corner-all ";
			}
		}
		
		$this->mi_cuadro .= self::HTMLTABINDEX . "'" . $this->atributos [self::TABINDEX] . "' ";
		$this->mi_cuadro .= ">\n";
		if (isset ( $this->atributos [self::VALOR] )) {
			$this->mi_cuadro .= $this->atributos [self::VALOR];
		} else {
			$this->mi_cuadro .= "";
		}
		$this->mi_cuadro .= "</textarea>\n";
		
		if (isset ( $this->atributos [self::TEXTOENRIQUECIDO] ) && $this->atributos [self::TEXTOENRIQUECIDO]) {
			$this->mi_cuadro .= "<script type=\"text/javascript\">\n";
			$this->mi_cuadro .= "mis_botones='" . $datosConfiguracion ["host"] . $datosConfiguracion ["site"] . $datosConfiguracion ["grafico"] . "/textarea/';\n";
			$this->mi_cuadro .= "archivo_css='" . $datosConfiguracion ["host"] . $datosConfiguracion ["site"] . $datosConfiguracion ["estilo"] . "/basico/estilo.php';\n";
			$this->mi_cuadro .= "editor_html('" . $this->atributos [self::ID] . "', 'bold italic underline | left center right | number bullet | wikilink');";
			$this->mi_cuadro .= "\n</script>";
		}
		
		return $this->mi_cuadro;
	}
	function atributosGeneralesAreaTexto() {
		$cadena = '';
		
		if (isset ( $this->atributos [self::DESHABILITADO] ) && $this->atributos [self::DESHABILITADO]) {
			$cadena .= "readonly='1' ";
		}
		
		if (isset ( $this->atributos [self::NOMBRE] ) && $this->atributos [self::NOMBRE] != "") {
			$cadena .= self::HTMLNAME . "'" . $this->atributos [self::NOMBRE] . "' ";
		} else {
			$cadena .= self::HTMLNAME . "'" . $this->atributos [self::ID] . "' ";
		}
		
		if (isset ( $this->atributos ["columnas"] )) {
			$cadena .= "cols='" . $this->atributos ["columnas"] . "' ";
		} else {
			$cadena .= "cols='50' ";
		}
		
		if (isset ( $this->atributos ["filas"] )) {
			$cadena .= "rows='" . $this->atributos ["filas"] . "' ";
		} else {
			$cadena .= "rows='2' ";
		}
		
		return $cadena;
	}
}