<?php
	/**
	 * Class Notification_model model
	 * @property Notification_model $nt Notification module
	 */
	
	class Notification_model extends CI_Model {
		private string $environment = '';
		private string $dbsandbox = '';
//	private string $dbprod = 'compensapay';
		private string $dbprod = '';
		public string $base = '';
		public function __construct () {
			parent::__construct ();
			$this->load->database ();
			require 'conf.php';
			$this->base = $this->environment === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		}
		/**
		 * Inserta las notificaciones en la base de datos para que pueda visualizarse en el apartado de notificaciones.
		 *
		 * @param array       $args Arreglo con ID de usuario, título y cuerpo de la notificación.
		 * @param string|null $env  Ambiente en el que se va a trabajar
		 *
		 * @return array
		 */
		public function insertNotification ( array $args, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//Crear el query para insertar las notificaciones en la Base de Datos
//			var_dump ($args);
			$query = "INSERT INTO $this->base.notifications (user_id, title, body, readed)
VALUES ('{$args['id']}', '{$args['title']}',  \"" . $args[ 'body' ] . "\", 0)";
			//Revisa que sea correcta la conexión y ejecución con la BD
			$this->db->db_debug = FALSE;
			if ( !@$this->db->query ( $query ) ) {
				return [ "code" => 500, "message" => "Error al extraer la información", "reason" => $this->db->error ()[ 'message' ] ];
			}
			return [ "code" => 200, "message" => "Notificación insertada correctamente",
				"id" => $this->db->insert_id () ];
		}
		public function verNotificaciones () {
			$iduser = $this->session->userdata ( 'datosUsuario' )[ "id" ];
			$querynot = "SELECT * FROM notifications WHERE user_id='" . $iduser . "' ORDER BY create_at DESC";
			if ( $result = $this->db->query ( $querynot ) ) {
				if ( $result->num_rows () > 0 ) {
					$rresult = $result->result_array ();
				} else {
					$rresult = NULL;
				}
			}
			return $rresult;
		}
		public function updateNoti ( $idnoti ) {
			$q_update = "UPDATE notifications SET readed='1' WHERE id='" . $idnoti . "'";
			if ( $result = $this->db->query ( $q_update ) ) {
				
				$querynot = "SELECT * FROM notifications WHERE id='" . $idnoti . "' LIMIT 1";
				if ( $result2 = $this->db->query ( $querynot ) ) {
					if ( $result2->num_rows () > 0 ) {
						$rresult = $result2->result_array ();
					} else {
						$rresult = NULL;
					}
				}
			}
			return $rresult;
		}
		/**
		 * Inserta las Alertas en la base de datos para que pueda visualizarse en el apartado de notificaciones.
		 *
		 * @param array       $args Arreglo con ID de usuario, título y cuerpo de la notificación.
		 * @param string|null $env  Ambiente en el que se va a trabajar
		 *
		 * @return array
		 */
		public function insertAlert ( array $args, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//Crear el query para insertar las notificaciones en la Base de Datos
			$query = "INSERT INTO $this->base.alerts (user_id, title, body, readed)
VALUES ('{$args['id']}', '{$args['title']}',  \"" . $args[ 'body' ] . "\", 0)";
			//Revisa que sea correcta la conexión y ejecución con la BD
			$this->db->db_debug = FALSE;
			if ( !@$this->db->query ( $query ) ) {
				return [ "code" => 500, "message" => "Error al insertar alerta", "reason" => $this->db->error ()[ 'message' ] ];
			}
			return [ "code" => 200, "message" => "Alerta insertada correctamente.",
				"id" => $this->db->insert_id () ];
		}
		/**
		 * Inserta las Alertas en la base de datos para que pueda visualizarse en el apartado de notificaciones.
		 *
		 * @param array       $args Arreglo con los la información necesaria para generar el log y tener registro
		 *                          de los movimientos que se hayan realizado en la plataforma
		 * @param string|null $env  Ambiente en el que se va a trabajar
		 *
		 * @return array
		 * @author drakoz
		 *
		 */
		public function insertLogs ( array $args, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//Crear el query para insertar las notificaciones en la Base de Datos
			$query = "INSERT INTO $this->base.logs (id_company, id_user, module, code, data_in, result)
VALUES ('{$args['id_c']}', '{$args['id']}', '{$args['module']}', '{$args['code']}',
        '{$args[ 'in' ] }', '{$args[ 'out' ]}')";
			//Revisa que sea correcta la conexión y ejecución con la BD
			$this->db->db_debug = FALSE;
			if ( !@$res = $this->db->query ( $query ) ) {
				return [ "code" => 500, "message" => "Error al insertar logs", "reason" => $this->db->error ()[ 'message' ] ];
			}
			return [ "code" => 200, "message" => "logs registrado.",
				"id" => $this->db->insert_id () ];
		}
		/**
		 * Función para insertar logs, notificaciones y alertas según sean requeridos
		 *
		 * @param array       $args arreglo con los datos que se insertaran
		 * @param array       $ins  arreglo para determinar donde insertar la información
		 * @param string|NULL $env  ambiente en el que se estara trabajando
		 *
		 * @return array Arreglo con el resultado de la ejecución de los query
		 */
		public function saveBinnacle ( array $args, array $ins, string $env = NULL ): array {
			$res = [];
			foreach ( $ins as $binnacle ) {
				switch ( $binnacle ) {
					case 1:
						$subRes = $this->insertNotification ( $args[ 'N' ], $env );
						if ( $subRes[ 'code' ] != 200 ) {
							$res[ 'notification' ] = $subRes;
						}
						break;
					case 2:
						$subRes = $this->insertAlert ( $args[ 'A' ], $env );
						if ( $subRes[ 'code' ] != 200 ) {
							$res[ 'alert' ] = $subRes;
						}
						break;
					case 3:
						$subRes = $this->insertLogs ( $args[ 'L' ], $env );
						if ( $subRes[ 'code' ] != 200 ) {
							$res[ 'log' ] = $subRes;
						}
						break;
				}
			}
			return empty( $res ) ? [ "code" => 200, "message" => "logs registrado.",
				"id" => $this->db->insert_id () ] : $res;
		}
		public function getModuleByArgs ( string $arg, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//Crear el query para insertar las notificaciones en la Base de Datos
			$query = "SELECT * FROM compensatest_base.cat_module
         WHERE id = '$arg' OR module = '$arg'";
//			var_dump ($query);
			$this->db->db_debug = FALSE;
			if ( !@$res = $this->db->query ( $query ) ) {
				return [ "code" => 500, "message" => "Error al obtener resultados", "reason" => $this->db->error ()[ 'message' ] ];
			} else if ( !$res->num_rows () > 0 ) {
				return [ "code" => 404, "message" => "Error al obtener resultados", "reason" => 'No se encontraron resultados' ];
			}
			return [ "code" => 200, "result" => $res->result_array ()[ 0 ] ];
		}
	}
