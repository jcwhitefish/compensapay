<?php
	
	/**
	 * Class Notification_model model
	 * @property Conciliation_model $dataConc Conciliation module
	 */
	class Conciliation_model extends CI_Model {
		private $headers = [];
		private string $environment = '';
		private string $dbsandbox = '';
		private string $dbprod = '';
		public string $base = '';
		public function __construct () {
			parent::__construct ();
			$this->load->database ();
			require 'conf.php';
			$this->base = $this->environment === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		}
		public function extracGroups ( string $env = NULL ) {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "SELECT t1.sender_rfc AS sender, t1.receiver_rfc AS receiver, w.W, s.S,
       (IF(w.W > s.S, w.W - s.S, s.S - w.W)) AS difference,
       (IF(w.W > s.S, 'Favor', 'Contra')) AS saldo
FROM (SELECT sender_rfc, receiver_rfc
      FROM $this->base.invoices_white
      GROUP BY sender_rfc, receiver_rfc) AS t1
	LEFT JOIN (SELECT sender_rfc, receiver_rfc, SUM(total) AS W
	           FROM $this->base.invoices_white
	           GROUP BY sender_rfc, receiver_rfc) AS w
		ON t1.sender_rfc = w.sender_rfc AND t1.receiver_rfc = w.receiver_rfc
	LEFT JOIN (SELECT sender_rfc, receiver_rfc, SUM(total) AS S
	           FROM $this->base.invoices_white
	           GROUP BY sender_rfc, receiver_rfc) AS s
		ON t1.sender_rfc = s.receiver_rfc AND t1.receiver_rfc = s.sender_rfc";
			$this->db->db_debug = FALSE;
			if ( $res = $this->db->query ( $query ) ) {
				$res = $res->result_array ();
				$res[ 'test' ] = date ( 'Y-m-d H:i:s', strtotime ( 'now' ) );
				return $res;
			}
			return [ 'error' => $this->db->error () ];
		}
		public function makeConciliations ( string $env = NULL ) {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "INSERT INTO $this->base.operations (`id_invoice`, `id_invoice_relational`, `id_debit_note`, `id_uploaded_by`, `id_client`, `id_provider`,
                        `operation_number`, `payment_date`, `entry_money`, `exit_money`, `status`, `commentary`, `created_at`, `updated_at`)
VALUES ( 1, 2, NULL, 10, 2, 1, '0020501', '1713052800', 2.32, 1.16, '1', NULL, '1709224755', NULL)";
			$this->db->db_debug = FALSE;
			if ( $res = $this->db->query ( $query ) ) {
				return $res;
			}
			return [ 'error' => $this->db->error () ];
		}
		public function multiTransaction ( $postData ) {
			$this->headers = [];
			$this->headers [] = 'Content-Type: application/json; charset=utf-8';
			$secret = base64_encode ( 'AKsbIRh8GhQA--avQliNyzGQ:bRQCqvlR7r0BbLSa2JV1Qf1PM-YPbDSLzsiQhxfer-T9fTG0a-zKO0BcjrCwH6XsdSLp9nUo0mCdYDxzo8KdIA' );
			$this->headers[] = 'Authorization: Basic ' . $secret;
			$curl = curl_init ();
			curl_setopt_array ( $curl, [
				CURLOPT_URL => 'https://sandbox-api.arteria.xyz/transfers/',
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => TRUE,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $postData,
				CURLOPT_HTTPHEADER => $this->headers,
				CURLOPT_SSL_VERIFYPEER => FALSE,
				CURLOPT_SSL_VERIFYHOST => FALSE,
				CURLOPT_SSL_VERIFYSTATUS => FALSE,
			] );
			return $curl;
		}
		public function multiD (): array {
			$data = [];
			// Array para almacenar los recursos CURL
			$curlHandles = [];
// Datos de la petición POST
// Inicializar el handler multi-cURL
			$multiHandle = curl_multi_init ();
// Crear 150 peticiones CURL
			for ( $h = 0; $h < 1; $h++ ) {
				sleep ( 4 );
				for ( $i = 0; $i < 500; $i++ ) {
					$data = [
						'account_number' => '723969000058858897',
						'amount' => 1,
						'descriptor' => "prueba multi deposito h$h i$i",
						'recipient_name' => "Whitefish",
						'idempotency_key' => rand ( 100, 999999 ),
						'user_id' => 'USgdLo9HvKTS6MaU_pcJPtGS', ];
					$postData = json_encode ( $data );
					// Crear una nueva instancia de CURL y añadirla al array
					$curlHandles[ $i ] = $this->multiTransaction ( $postData );
					// Añadir el recurso CURL al handler multi-cURL
					curl_multi_add_handle ( $multiHandle, $curlHandles[ $i ] );
				}
				// Ejecutar las peticiones
				$running = NULL;
				do {
					curl_multi_exec ( $multiHandle, $running );
				} while ( $running > 0 );
// Cerrar todos los recursos CURL
				foreach ( $curlHandles as $i => $curlHandle ) {
					$response = curl_multi_getcontent ( $curlHandle );
					$responses[ $i ] = $response;
					// Cerrar el recurso CURL
					curl_multi_remove_handle ( $multiHandle, $curlHandle );
					curl_close ( $curlHandle );
				}
// Cerrar el handler multi-cURL
				curl_multi_close ( $multiHandle );
				foreach ( $responses as $response ) {
					$in = json_encode(['time'=>strtotime('now')]);
					$query = "INSERT INTO $this->base.logs (id_company, id_user, module, code, data_in, result) VALUES ('1', '11', '2', '200',
                                                                                    '$in', json_encode($response))";
					//Revisa que sea correcta la conexión y ejecución con la BD
					$this->db->db_debug = FALSE;
					if ( !@$res = $this->db->query ( $query ) ) {
						return [ "code" => 500, "message" => "Error al insertar logs", "reason" => $this->db->error ()[ 'message' ] ];
					}
					return [ "code" => 200, "message" => "logs registrado.",
						"id" => $this->db->insert_id () ];
				}
			}
		}
	}
