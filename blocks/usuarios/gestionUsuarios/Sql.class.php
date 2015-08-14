<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlGestionUsuarios extends sql {


	var $miConfigurador;


	function __construct(){
		$this->miConfigurador=Configurador::singleton();
	}


	function cadena_sql($tipo,$variable="") {
			
		/**
		 * 1. Revisar las variables para evitar SQL Injection
		 *
		 */

		$prefijo=$this->miConfigurador->getVariableConfiguracion("prefijo");
		$idSesion=$this->miConfigurador->getVariableConfiguracion("id_sesion");
			
		switch($tipo) {

                    
                        case "idioma":

				$cadena_sql = "SET lc_time_names = 'es_ES' ";
			break;
                    
                        case "consultarUsuarios":
				$cadena_sql = "SELECT usu.id_usuario, ";
                            	$cadena_sql .= "usu.nombre, ";
                            	$cadena_sql .= "usu.apellido, ";
                                $cadena_sql .= " usu.correo, ";
                                $cadena_sql .= " usu.telefono, ";
                                $cadena_sql .= " usu.tipo ,";
                                $cadena_sql .= " (CASE WHEN usu.tipo='0' THEN 'Anonimo' ELSE 'Conocido' END) nivel, ";
                                $cadena_sql .= " est.estado_registro_alias estado  ";
                                $cadena_sql .= "FROM ".$prefijo."usuario usu ";
                                $cadena_sql .= "INNER JOIN ".$prefijo."estado_registro est ";
                                $cadena_sql .= "ON est.estado_registro_id=usu.estado ";
                                if(isset($variable['id_usuario']) && $variable['id_usuario']>0)
                                    { $cadena_sql .= " WHERE ";
                                      $cadena_sql .= " usu.id_usuario='".$variable['id_usuario']."'"; 
                                    }
                                $cadena_sql .= " ORDER BY id_usuario";
			break;
                        
                        case "consultarPerfilUsuario":

                            	$cadena_sql = "SELECT sist.id_usuario,  ";
                            	$cadena_sql .= "sist.id_subsistema, ";
                            	$cadena_sql .= "sist.rol_id, ";
                            	$cadena_sql .= "rol.rol_alias , ";
                            	$cadena_sql .= "sist.fecha_registro,  ";
                            	$cadena_sql .= "sist.fecha_caduca,  ";
                            	$cadena_sql .= "est.estado_registro_alias estado  ";
                            	$cadena_sql .= "FROM tike_usuario_subsistema sist ";
                            	$cadena_sql .= "INNER JOIN tike_rol rol ON rol.rol_id=sist.rol_id ";
                                $cadena_sql .= "INNER JOIN ".$prefijo."estado_registro est ";
                                $cadena_sql .= "ON est.estado_registro_id=sist.estado ";
                            	$cadena_sql .= "WHERE id_usuario='".$variable['id_usuario']."'";
                                $cadena_sql .= " ORDER BY rol_alias";
			break;
                    
                        case "consultarUsuariosEditar":
                            
				$cadena_sql = "SELECT id_usuario, nombre, apellido, correo, telefono, tipo ";
                                $cadena_sql .= "FROM ".$prefijo."usuario ";
                                $cadena_sql .= " WHERE  id_usuario = ".$variable;
                                
			break;
                    
                        case "tipoUsuario":
                            
				$cadena_sql = "SELECT  idtipo, descripcion ";
                                $cadena_sql .= "FROM ".$prefijo."tipousuario ";
                                $cadena_sql .= " WHERE  idtipo != 1";
                                
			break;
                    
                        case "insertarUsuario":
                            
				$cadena_sql = "INSERT INTO ".$prefijo."usuario(id_usuario, nombre, apellido, correo, telefono, clave, tipo, estilo, idioma, estado) ";
                                $cadena_sql .= " VALUES ( ";
                                $cadena_sql .= " ".$variable[0].", ";
                                $cadena_sql .= " '".$variable[1]."', ";
                                $cadena_sql .= " '".$variable[2]."', ";
                                $cadena_sql .= " '".$variable[3]."', ";
                                $cadena_sql .= " '".$variable[4]."', ";
                                $cadena_sql .= " '".$variable[6]."', ";
                                $cadena_sql .= " '".$variable[5]."', ";
                                $cadena_sql .= " 'basico', ";
                                $cadena_sql .= " 'es_es', ";
                                $cadena_sql .= " 2 ";
                                $cadena_sql .= " )";
                                
			break;
                    
                        case "actualizarUsuario":
                            
				$cadena_sql = "UPDATE ".$prefijo."usuario SET ";
                                $cadena_sql .= " nombre = '".$variable[1]."', ";
                                $cadena_sql .= " apellido = '".$variable[2]."', ";
                                $cadena_sql .= " correo = '".$variable[3]."', ";
                                $cadena_sql .= " telefono = '".$variable[4]."', ";
                                $cadena_sql .= " tipo = '".$variable[5]."' ";
                                $cadena_sql .= " WHERE id_usuario = ".$variable[0]." ";
			break;
                    
                        case "inhabilitarUsuario":
                            
				$cadena_sql = "UPDATE ".$prefijo."usuario SET ";
                                $cadena_sql .= " estado = 0 ";
                                $cadena_sql .= " WHERE id_usuario = ".$variable." ";
			break;
				/**
				 * Clausulas genéricas. se espera que estén en todos los formularios
				 * que utilicen esta plantilla
				 */

			case "iniciarTransaccion":
				$cadena_sql="START TRANSACTION";
				break;

			case "finalizarTransaccion":
				$cadena_sql="COMMIT";
				break;

			case "cancelarTransaccion":
				$cadena_sql="ROLLBACK";
				break;


			case "eliminarTemp":

				$cadena_sql="DELETE ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_sesion = '".$variable."' ";
				break;

			case "insertarTemp":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="( ";
				$cadena_sql.="id_sesion, ";
				$cadena_sql.="formulario, ";
				$cadena_sql.="campo, ";
				$cadena_sql.="valor, ";
				$cadena_sql.="fecha ";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";

				foreach($_REQUEST as $clave => $valor) {
					$cadena_sql.="( ";
					$cadena_sql.="'".$idSesion."', ";
					$cadena_sql.="'".$variable['formulario']."', ";
					$cadena_sql.="'".$clave."', ";
					$cadena_sql.="'".$valor."', ";
					$cadena_sql.="'".$variable['fecha']."' ";
					$cadena_sql.="),";
				}

				$cadena_sql=substr($cadena_sql,0,(strlen($cadena_sql)-1));
				break;

			case "rescatarTemp":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_sesion, ";
				$cadena_sql.="formulario, ";
				$cadena_sql.="campo, ";
				$cadena_sql.="valor, ";
				$cadena_sql.="fecha ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_sesion='".$idSesion."'";
				break;



		}
		return $cadena_sql;

	}
}
?>
