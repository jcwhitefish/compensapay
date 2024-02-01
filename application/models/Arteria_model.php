<?php
	ini_set ( "xdebug.var_display_max_children", '-1' );
	ini_set ( "xdebug.var_display_max_data", '-1' );
	ini_set ( "xdebug.var_display_max_depth", '-1' );
	
	/**
	 * Class Arteria_model model
	 * @property Arteria_model $dataArt Arteria module
	 */
	class Arteria_model extends CI_Model {
		private $ArteriaSandbox = 'https://api.arteria.xyz';
		private $ArteriaLive = '';
		private $usernameSandbox = 'AKJa__kN9gQ2WTRWg8Vx6ycw';
		private $passwordSandbox = 'ElPZBMlRrohxumQJkL6QrLLayjrowxk53I4LLFKy_lUDAFHxBxpGm1Xq-80nkIU-o1sxn-JFxzw1loBKtwZNQA';
		private $usernameProd = 'AKJa__kN9gQ2WTRWg8Vx6ycw';
		private $passwordProd = 'ElPZBMlRrohxumQJkL6QrLLayjrowxk53I4LLFKy_lUDAFHxBxpGm1Xq-80nkIU-o1sxn-JFxzw1loBKtwZNQA';
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
		public function CreateClabe ( array $args, string $env ) {
			$data = [
				'names' => $args[ 'name' ],
				'first_surname' => $args[ 'lastname' ],
			];
			$endpoint = 'clabes';
			return $this->SendRequest ( $endpoint, $data, $env, 'POST', 'JSON' );
		}
		public function CreateTransfer ( array $args, string $env ) {
			$data = [
				'account_number' => $args[ 'clabe' ],
				'amount' => $args[ 'amount' ],
				'descriptor' => $args[ 'descriptor' ],
				'recipient_name' => $args[ 'name' ],
				'idempotency_key' => $args[ 'idempotency_key' ],
				'user_id' => 'USgdLo9HvKTS6MaU_pcJPtGS',
			];
			$this->headers = [];
			$endpoint = 'transfers';
			return $this->SendRequest ( $endpoint, $data, $env, 'POST', 'JSON' );
		}
		public function AddMovement ( array $args, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//Se obtiene la información faltante para insertar los datos
			$sourceBank = $this->getBankByClabe ( $args[ 'sourceBank' ] );
			$receiverBank = $this->getBankByClabe ( $args[ 'receiverBank' ] );
			$fecha = strtotime ( $args[ 'transactionDate' ] );
			//Se genera el query para insertar datos
			$query = "INSERT INTO $this->base.balance (operationNumber, traking_key, arteriaD_id, amount, descriptor,
                                 source_bank, receiver_bank, source_rfc, receiver_rfc, 
                                 source_clabe, receiver_clabe, transaction_date) VALUES (";
			$query .= $args[ 'operationNumber' ] === NULL ? "NULL, " : "'{$args['operationNumber']}', ";
			$query .= $args[ 'trakingKey' ] === NULL ? "NULL, " : "'{$args['trakingKey']}', ";
			$query .= "'{$args['arteriaId']}', '{$args['amount']}', '{$args['descriptor']}',
					'{$sourceBank[0]['bnk_code']}', '{$receiverBank[0]['bnk_code']}', '{$args['sourceRfc']}', '{$args['receiverRfc']}', 
					'{$args['sourceClabe']}', '{$args['receiverClabe']}', '$fecha')";
			//Se verífica que se pueda insertar la información
			$this->db->db_debug = FALSE;
			if ( !@$res = $this->db->query ( $query ) ) {
				//En caso de error
				return [ "code" => 500, "message" => "Error al actualizar la información", "reason" => $this->db->error ()[ 'message' ] ];
			}
			//En caso correcto
			return [ "code" => 200, "result" => $this->db->insert_id () ];
		}
		public function getBankByClabe ( string $clabe, string $env = NULL ) {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "SELECT * FROM $this->base.cat_bancos WHERE bnk_clave = '{$clabe}'";
//        var_dump($query);
			if ( $result = $this->db->query ( $query ) ) {
				if ( $result->num_rows () > 0 ) {
					return $result->result_array ();
				}
			}
		}
		public function SearchOperations ( array $args, string $env = NULL ) {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//se genera el query
			$query = "SELECT t1.id, t1.operation_number, t1.id_client, t2.legal_name as 'cname', t2.rfc as 'crfc', t2.account_clabe as 'cclabe',
					t1.id_provider, t3.legal_name as 'pname', t3.rfc as 'prfc', t3.account_clabe as 'pclabe', 
					t4.arteria_clabe, (t5.total*100) AS 'entry_money', (t6.total*100) AS 'exit_money_d', (t8.total*100) as 'exit_money_f', 
					t3.account_clabe as 'companyClabe', t3.legal_name, t7.bnk_clave, t5.uuid,
					t9.name AS 'provName', t9.last_name AS 'provLast', t9.email AS 'provEmail', t2.legal_name AS 'provCompany',
					t10.name AS 'clientName', t10.last_name AS 'clientLast', t10.email AS 'clientEmail', t3.legal_name AS 'clientCompany'
					FROM $this->base.operations t1
					LEFT JOIN $this->base.companies t2
					ON t1.id_client = t2.id
					LEFT JOIN $this->base.companies t3
					ON t1.id_provider = t3.id
					INNER JOIN $this->base.fintech t4
					ON t4.companie_id = t1.id_provider
					INNER JOIN $this->base.invoices t5
					ON t1.id_invoice = t5.id
					LEFT JOIN $this->base.debit_notes t6
					ON t1.id_debit_note = t6.id
					INNER JOIN $this->base.cat_bancos t7
					ON t2.id_broadcast_bank = t7.bnk_id
					LEFT JOIN $this->base.invoices t8
					ON t1.id_invoice_relational = t8.id
					INNER JOIN $this->base.users t9
					ON t9.id_company = t3.id
					INNER JOIN $this->base.users t10
					ON t10.id_company = t2.id
					WHERE t4.arteria_clabe = '{$args['receiverClabe']}' and t1.status = 1 
					and (t1.operation_number = '{$args['operationNumber']}' OR t1.operation_number = '{$args['descriptor']}')";
//		var_dump($result = $this->db->query($query));
			if ( $result = $this->db->query ( $query ) ) {
				if ( $result->num_rows () > 0 ) {
					$opData = [];
					foreach ( $result->result_array () as $row ) {
						$opData = [
							'operationId' => $row[ 'id' ],
							'companyName' => $row[ 'legal_name' ],
							'companyClabe' => $row[ 'companyClabe' ],
							'companyBank' => $row[ 'bnk_clave' ],
							'operationNumber' => $row[ 'operation_number' ],
							'client' => $row[ 'id_client' ],
							'clientName' => $row[ 'cname' ],
							'clientRfc' => $row[ 'crfc' ],
							'clientClabe' => $row[ 'cclabe' ],
							'provider' => $row[ 'id_provider' ],
							'providerName' => $row[ 'pname' ],
							'providerRfc' => $row[ 'prfc' ],
							'providerClabe' => $row[ 'pclabe' ],
							'entry' => intval ( $row[ 'entry_money' ] ),
							'exitD' => intval ( $row[ 'exit_money_d' ] ),
							'exitF' => intval ( $row[ 'exit_money_f' ] ),
							'uuid' => $row[ 'uuid' ],
							'providerPerson' => [
								'name' => $row[ 'provName' ],
								'last' => $row[ 'provLast' ],
								'mail' => $row[ 'provEmail' ],
								'company' => $row[ 'provCompany' ],
							],
							'clientPerson' => [
								'name' => $row[ 'clientName' ],
								'last' => $row[ 'clientLast' ],
								'mail' => $row[ 'clientEmail' ],
								'company' => $row[ 'clientCompany' ],
							],
						];
					}
//                var_dump($opData);
					return $opData;
				}
			}
		}
		public function DownloadCEP ( array $args, int $try, string $env ) {
			sleep ( rand ( 5, 10 ) );
			if ( $ch = curl_init () ) {
				curl_setopt ( $ch, CURLOPT_URL, "https://www.banxico.org.mx/cep/valida.do" );
				curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
				curl_setopt ( $ch, CURLOPT_TIMEOUT, 200 );
				curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
				curl_setopt ( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
				curl_setopt ( $ch, CURLOPT_POST, TRUE );
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $args ) );
				curl_setopt ( $ch, CURLOPT_HTTPHEADER, [
					'Content-Type: application/x-www-form-urlencoded',
				] );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYSTATUS, FALSE );
				$cookieFile = fopen ( "cookie.txt", "w+" );
				curl_setopt ( $ch, CURLOPT_COOKIEJAR, $cookieFile );
				$response = curl_exec ( $ch );
//			var_dump($response);
				if ( $response === FALSE ) {
					$error = 500;
					curl_close ( $ch );
					$resp = [ 'error' => 500, 'error_description' => 'SAPLocalTransport' ];
					$response = json_encode ( $resp );
				}
				curl_setopt_array ( $ch, [
					CURLOPT_URL => 'http://www.banxico.org.mx/cep/descarga.do?formato=PDF',
					CURLOPT_RETURNTRANSFER => TRUE,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => TRUE,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'GET',
					CURLOPT_COOKIEFILE => $cookieFile,
				] );
				set_time_limit ( 180 );
				$pdf_content = curl_exec ( $ch );
				if ( curl_errno ( $ch ) ) {
					header ( 'HTTP/1.1 500 Internal Server Error' );
					echo 'Error al descargar el PDF.';
					exit;
				}
				curl_close ( $ch );
				$filename = strtotime ( 'now' ) . $args[ 'criterio' ] . '.pdf';
				$ruta_destino = './boveda/CEP/' . $filename;
				file_put_contents ( $ruta_destino, $pdf_content );
				$tipoMIME = mime_content_type ( $ruta_destino );
				if ( $tipoMIME === 'application/pdf' ) {
//				var_dump($filename);
					if ( file_exists ( "cookie.txt" ) ) {
						unlink ( "cookie.txt" );
					}
					array_map ( 'unlink', glob ( "Resource id #" ) );
					return $filename;
				} else {
					if ( $try <= 3 ) {
						$try++;
//					var_dump('Reintentando '.$filename);
//					var_dump( 'Intento '.$try);
						$this->DownloadCEP ( $args, $try, $env );
					}
//				var_dump('No se logro descargar '.$filename);
					if ( file_exists ( $ruta_destino ) ) {
						unlink ( $ruta_destino );
					} else {
						echo "El archivo no existe o no es un archivo.";
					}
					if ( file_exists ( "cookie.txt" ) ) {
						unlink ( "cookie.txt" );
					}
					array_map ( 'unlink', glob ( "Resource id #" ) );
					return -1;
					
				}
			} else {
				$resp[ 'reason' ] = 'No se pudo inicializar cURL';
				$response = json_encode ( $resp );
			}
			return -2;
		}
		public function insertCEP ( array $args, $cep, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "UPDATE $this->base.balance SET url_cep = '{$cep}'
                                 WHERE traking_key = '{$args['trakingKey']}' and arteriaD_id = '{$args['arteriaId']}'";
			$this->db->db_debug = FALSE;
			if ( !@$res = $this->db->query ( $query ) ) {
				return [ "code" => 500, "message" => "Error al actualizar la información", "reason" => $this->db->error ()[ 'message' ] ];
			} else {
				return [ "code" => 200, "result" => $this->db->insert_id () ];
			}
		}
		public function getAllBalanceCEP ( string $env = NULL ) {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "SELECT transaction_date, traking_key, receiver_clabe, source_clabe, amount, arteriaD_id
					FROM $this->base.balance where url_cep IS NULL
				   	ORDER BY transaction_date DESC";
//		var_dump($query);
			if ( $result = $this->db->query ( $query ) ) {
				if ( $result->num_rows () > 0 ) {
					return $result->result_array ();
				}
			}
		}
		/**
		 * Permite crear una nueva operación a partir de una anterior ($id) y genera un nuevo número de operación para que sea utilizado en las
		 * transferencias entre cliente y proveedor
		 *
		 * @param string $idOperation
		 * @param string $env
		 *
		 * @return bool|string
		 */
		public function GetNewOperationNumber ( string $idOperation, string $env = NULL ): bool|string {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$opNumber = $this->MakeOperationNumber ( $idOperation );
			$query = "INSERT INTO $this->base.operations (id_invoice, id_invoice_relational, id_debit_note, id_uploaded_by, id_client,
                                          id_provider, operation_number, payment_date, entry_money, exit_money, status, commentary) 
                                          SELECT id_invoice, id_invoice_relational, id_debit_note, id_uploaded_by, id_client, 
                                          id_provider, '$opNumber', payment_date, entry_money, exit_money, status, commentary 
                                          FROM $this->base.operations WHERE id = '$idOperation'";
			if ( $this->db->query ( $query ) ) {
				$query = "UPDATE $this->base.operations SET status = 5 WHERE id = '$idOperation'";
				if ( $this->db->query ( $query ) ) {
					return $opNumber;
				}
			}
			return FALSE;
		}
		public function getIdRastreo ( string $id, string $env ) {
			$this->headers = [];
			$endpoint = 'transfers/' . $id;
			return $this->SendRequest ( $endpoint, [], $env, 'GET', 'JSON' );
		}
		/**
		 * Función para generar el número de referencia a partir del Id de operación
		 *
		 * @param string $operation Id de operación a hash
		 *
		 * @return string Número de referencia
		 */
		private function MakeOperationNumber ( string $operation ): string {
			$trash = '010203040506070809';
			return str_pad ( $operation, 7, substr ( str_shuffle ( $trash ), 0, 10 ), STR_PAD_LEFT );
		}
		private function SendRequest ( string $endpoint, $data, ?string $env, ?string $method, ?string $dataType ) {
			$env = strtoupper ( $env ) ?? 'SANDBOX';
			$url = ( $env == 'SANDBOX' ) ? $this->ArteriaSandbox : $this->ArteriaLive;
			$method = !empty( $method ) ? strtoupper ( $method ) : 'POST';
			$resp = [ 'error' => 500, 'error_description' => 'OpenPayTransport' ];
			$data = json_encode ( $data );
			if ( strtoupper ( $dataType ) === 'JSON' ) {
				$this->headers[] = 'Content-Type: application/json; charset=utf-8';
			}
			$secret = base64_encode ( ( $env == 'SANDBOX' ) ? $this->usernameSandbox . ':' . $this->passwordSandbox :
				$this->usernameProd . ':' . $this->passwordProd );
			$this->headers[] = 'Authorization: Basic ' . $secret;
			if ( ( $ch = curl_init () ) ) {
				curl_setopt ( $ch, CURLOPT_URL, "$url/$endpoint/" );
				curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
				curl_setopt ( $ch, CURLOPT_TIMEOUT, 200 );
				curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
				curl_setopt ( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
				if ( $method == 'POST' ) {
					curl_setopt ( $ch, CURLOPT_POST, TRUE );
				} else {
					curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, $method );
				}
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
				curl_setopt ( $ch, CURLOPT_HTTPHEADER, $this->headers );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
				curl_setopt ( $ch, CURLOPT_SSL_VERIFYSTATUS, FALSE );
				$response = curl_exec ( $ch );
				$code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
				if ( $response === FALSE ) {
					$error = 500;
					curl_close ( $ch );
					$resp = [ 'error' => 500, 'error_description' => 'SAPLocalTransport' ];
					$response = json_encode ( $resp );
				}
				curl_close ( $ch );
//			var_dump($this->headers);
//			var_dump("$url/$endpoint/");
//			var_dump(json_encode($data));
//			var_dump($response);
				return $response;
			} else {
				$resp[ 'reason' ] = 'No se pudo inicializar cURL';
				$response = json_encode ( $resp );
			}
			return $response;
		}
		public function successConciliation ( mixed $operationId, array $cfdi, string $env = NULL ) {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "UPDATE compensatest_base.operations set status = 3 WHERE id = '$operationId'";
			$this->db->db_debug = FALSE;
			if ( $this->db->query ( $query ) ) {
				if ( $cfdi['res'][ 'tipo' ] === 'nota' ) {
					$query = "UPDATE compensatest_base.invoices SET status = 3 WHERE id = '{$cfdi['res']['id']}'";
					$this->db->db_debug = FALSE;
					if ( $this->db->query ( $query ) ) {
						$query = "UPDATE compensatest_base.debit_notes SET status = 3 WHERE id = '{$cfdi['res']['id2']}'";
						$this->db->db_debug = FALSE;
						if ( $this->db->query ( $query ) ) {
							return [ "code" => 200, "message" => "Conciliación realizada", "reason" => 'ok' ];
						} else {
							return [ "code" => 500, "message" => "Error al guardar información", "reason" => $this->db->error () ];
						}
					} else {
						return [ "code" => 500, "message" => "Error al guardar información", "reason" => $this->db->error () ];
					}
				} else {
					$query = "UPDATE compensatest_base.invoices SET status = 3 WHERE id in ('{$cfdi['res']['id']}', '{$cfdi['res']['id2']}')";
					$this->db->db_debug = FALSE;
					if ( $this->db->query ( $query ) ) {
						return [ "code" => 200, "message" => "Conciliación realizada", "reason" => 'ok' ];
					} else {
						return [ "code" => 500, "message" => "Error al guardar información", "reason" => $this->db->error () ];
					}
				}
			}
		}
	}
