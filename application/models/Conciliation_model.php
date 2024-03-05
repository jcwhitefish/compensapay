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
VALUES ( 1, NULL, 1, 10, 2, 1, '0020501', '1713052800', 2.32, 1.16, '1', NULL, '1709224755', NULL)";
			$this->db->db_debug = FALSE;
			if ( $res = $this->db->query ( $query ) ) {
				return $res;
			}
			return [ 'error' => $this->db->error () ];
		}
		public function multiTransaction ( $i ) {
			$curl = curl_init ();
			curl_setopt_array ( $curl, [
				CURLOPT_URL => 'https://sandbox-api.arteria.xyz/transfers',
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => TRUE,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '{
				"account_number": "036180500671547519",
				"amount":   100,
				"descriptor": "prueba multi deposito i ' . $i . '",
				"recipient_name": "SLV CAPERE",
				"idempotency_key": "' . rand ( 100, 999999 ) . '",
				"user_id": "US-dLo9HvKTS6MaU_pcJPtPA"}',
				CURLOPT_HTTPHEADER => [
					'Content-Type: application/json',
					'Authorization: Basic QUtzYklSaDhHaFFBLS1hdlFsaU55ekdROmJSUUNxdmxSN3IwQmJMU2EySlYxUWYxUE0tWVBiRFNMenNpUWh4ZmVyLVQ5ZlRHMGEtektPMEJjanJDd0g2WHNkU0xwOW5VbzBtQ2RZRHh6bzhLZElB',
				],
			] );
			return $curl;
		}
		public function multiD () {
			$res =[];
			$curlHandles = [];
			$multiHandle = curl_multi_init ();
			$startTime = microtime ( TRUE );
			for ( $i = 0; $i < 1000; $i++ ) {
				// Crear una nueva instancia de CURL y añadirla al array
				$curlHandles[ $i ] = $this->multiTransaction ( $i );
				// Añadir el recurso CURL al handler multi-cURL
				ini_set('max_execution_time', '300');
				curl_multi_add_handle ( $multiHandle, $curlHandles[ $i ] );
				$running = NULL;
				do {
					ini_set('max_execution_time', '300');
					curl_multi_exec ( $multiHandle, $running );
				} while ( $running > 0 );
				usleep ( 10000 );
				while ($info = curl_multi_info_read($multiHandle)) {
					$index = array_search($info['handle'], $curlHandles);
					$response = curl_multi_getcontent($info['handle']);
					$in = json_encode ( [ 'time' => strtotime ( 'now' ) ] );
					$query = "INSERT INTO $this->base.logs (id_company, id_user, module, code, data_in, result) VALUES ('1', '11', '2', '200',
                                                                                    '$in', '$response')";
					if ( !@$res = $this->db->query ( $query ) ) {
						var_dump( [ "code" => 500, "message" => "Error al insertar logs", "reason" => $this->db->error ()[ 'message' ] ]);
					}else{
						var_dump( [ "code" => 200, "message" => "logs registrado.",
							"id" => $this->db->insert_id () ]);
					}
				}
				
			}
			foreach ($curlHandles as $handle) {
				curl_multi_remove_handle($multiHandle, $handle);
				curl_close($handle);
			}
			curl_multi_close ( $multiHandle );
			$totalTime = microtime ( TRUE ) - $startTime;
			echo "Tiempo total transcurrido: $totalTime segundos";

			return $res;
		}
	}
