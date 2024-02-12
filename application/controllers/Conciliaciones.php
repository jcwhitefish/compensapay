<?php
	
	/**
	 * @property Invoice_model      $invData
	 * @property Operation_model    $OpData
	 * @property User_model         $dataUsr
	 * @property Notification_model $nt
	 */
	class Conciliaciones extends MY_Loggedin {
		private string $environment = 'SANDBOX';
		public function index (): void {
			$data[ 'main' ] = $this->load->view ( 'conciliaciones', '', TRUE );
			$this->load->view ( 'plantilla', $data );
		}
		public function CFDI () {
			//Se obtienen la fecha mínima y máxima para filtrar las facturas
			$from = strtotime ( $this->input->post ( 'from' ) );
			$to = strtotime ( $this->input->post ( 'to' ) . ' +1 day' );
			//Se verifican que sean fechas válidas
			if ( $from & $to ) {
				//Se carga el modelo de donde se obtendrán los datos y se obtiene el ID de compañía de la sesión
				$this->load->model ( 'Invoice_model', 'invData' );
				$id = $this->session->userdata ( 'datosEmpresa' )[ "id" ];
				//Se buscan las facturas que coincidan con los criterios enviados
				$res = $this->invData->getCFDIByCompany ( $id, $from, $to );
				//Sí encuentra resultados el arreglo lo envia como JSON
				if ( $res[ 'code' ] === 200 ) {
					echo ( json_encode ( $res[ 'result' ] ) );
					return TRUE;
				}
				//En caso contrario regresa el error para mostrar una alerta
				echo ( json_encode ( $res ) );
				return FALSE;
			}
			echo json_encode ( [ "code" => 500, "message" => "Error al extraer la información", "reason" => "No se envió una fecha valida" ] );
			return FALSE;
		}
		public function conciliation () {
			//Se obtienen la fecha mínima y máxima para filtrar las facturas
			$from = strtotime ( $this->input->post ( 'from' ) );
			$to = strtotime ( $this->input->post ( 'to' ) . ' +1 day' );
			//Se verifican que sean fechas válidas
			if ( $from & $to ) {
				//Se carga el modelo de donde se obtendran los datos y se obtiene el id de compañia de la sesión
				$this->load->model ( 'Operation_model', 'OpData' );
				$id = $this->session->userdata ( 'datosEmpresa' )[ "id" ];
				//Se buscan las facturas que coincidan con los criterios enviados
				$res = $this->OpData->getConciliacionesByCompany ( $id, $from, $to );
				//Si encuentra resultados el arreglo lo envia como JSON
				if ( $res[ 'code' ] === 200 ) {
					echo ( json_encode ( $res[ 'result' ] ) );
					return TRUE;
				}
				//En caso contrario regresa el error para mostrar una alerta
				echo ( json_encode ( $res ) );
				return FALSE;
			}
			echo json_encode ( [ "code" => 500, "message" => "Error al extraer la información", "reason" => "No se envió una fecha valida" ] );
			return FALSE;
		}
		public function accept (): bool {
			//Se obtienen el ID y fecha de la conciliación que se acepta
			$id = $this->input->post ( 'id' );
			$payDate = $this->input->post ( 'payDate' );
			//Se valida que tengamos un dato valido
			if ( $id ) {
				//Se carga el modelo de donde se obtendrán los datos y se obtiene el ID de compañía de la sesión
				$this->load->model ( 'Operation_model', 'OpData' );
				$idCompany = $this->session->userdata ( 'datosEmpresa' )[ "id" ];
				//Se envía la instrucción para aceptar la conciliación
				$res = $this->OpData->acceptConciliation ( $id, $payDate, $idCompany, 'SANDBOX' );
				if ( $res[ 'code' ] === 200 ) {
					$conciliation = $this->OpData->getConciliationByID ( $id, 'SANDBOX' );
					$this->OpData->acceptCFDI ( $conciliation[ 0 ][ 'id_invoice' ], 'SANDBOX' );
					$this->OpData->acceptNote ( $conciliation[ 0 ][ 'id_debit_note' ], 'SANDBOX' );
					echo json_encode ( [
						"code" => 200,
						"message" => "Conciliación autorizada<br>Se envió a su correo las instrucciones para realizar el pago por transferencia",
					] );
					$this->adviseAuthorized ( $id );
					return TRUE;
				}
			}
			echo json_encode ( [ "code" => 500, "message" => "Error al actualizar el estatus", "reason" => "No es un Id valido" ] );
			return FALSE;
		}
		public function reject (): bool {
			//Se obtienen el ID y fecha de la conciliación que se acepta
			$comments = $this->input->post ( 'comments' );
			$idConciliation = $this->input->post ( 'idConciliation' );
			//Se valida que tengamos un dato valido
			if ( $idConciliation && $comments ) {
				//Se carga el modelo de donde se obtendrán los datos y se obtiene el ID de compañía de la sesión
				$this->load->model ( 'Operation_model', 'OpData' );
				$idCompany = $this->session->userdata ( 'datosEmpresa' )[ "id" ];
				$iduser = $this->session->userdata ( 'datosUsuario' )[ "id" ];
				//Se envía la instrucción para rechazar la conciliación
				$res = $this->OpData->rejectConciliation ( $idConciliation, $comments, $this->environment );
//				var_dump ($res);
				if ( $res[ 'code' ] === 200 ) {//en caso correcto se procede a notificar a la otra empresa y se guarda la información en logs
					$this->load->model ( 'User_model', 'dataUsr' );
					$conciliation = $this->OpData->getConciliacionesByID ( $idConciliation, $this->environment );
					$provider = $this->dataUsr->getInfoFromCompanyPrimary ( $conciliation[ 'result' ][ 'idEmisor' ], $this->environment );
					$args[ 'mail' ] = $provider[ 'result' ][ 'email' ];
					$args[ 'cc' ] = 'uriel.magallon@whitefish.mx';
					$args[ 'mailData' ] = [
						'name' => $provider[ 'result' ][ 'name' ],
						'lastName' => $provider[ 'result' ][ 'last_name' ],
						'company' => $provider[ 'result' ][ 'short_name' ],
					];
					$args[ 'notification' ] = [
						'reason' => $comments,
						'operationNumber' => $conciliation[ 'result' ][ 'operation_number' ],
						'idUser' => $iduser,
					];
					$m = 2;
					$args[ 'L' ] = [ 'id_c' => $idCompany, 'id' => $iduser, 'module' => $m, 'code' => $res[ 'code' ],
						'in' => json_encode ( [ 'rejectConciliation' => [ 'idConciliation' => $idConciliation, 'comment' => $comments, 'env' => $this->environment ] ] ),
						'out' => json_encode ( $res[ 'message' ] ) ];
					$this->Binnacle ( $args, 8, [ 1, 2, 3 ], $m, $this->environment );
					echo json_encode ( [
						"code" => 200,
						"message" => "Conciliación rechazada<br>
Se envió a su correo a su socio comercial con la información del rechazo de conciliación",
					] );
					return TRUE;
				}
			}
			echo json_encode ( [ "code" => 500, "message" => "Error al actualizar el estatus", "reason" => "No es un Id valido" ] );
			return FALSE;
		}
		/**
		 * Función para notificar que se a autorizado una conciliación
		 *
		 * @param int    $id  ID de la conciliación que se a autorizado
		 * @param string $env Ambiente en el que se va a trabajar
		 *
		 * @return void
		 */
		public function adviseAuthorized ( int $id, string $env = 'SANDBOX' ) {
			//Se cargan los helpers y modelos necesarios
			$this->load->model ( 'User_model', 'dataUsr' );
			$this->load->model ( 'Notification_model', 'nt' );
			$this->load->helper ( 'sendmail_helper' );
			$this->load->helper ( 'notifications_helper' );
			$conciliation = $this->OpData->getConciliacionesByID ( $id, $env );
			$provider = $this->dataUsr->getInfoFromCompanyPrimary ( $conciliation[ 'result' ][ 'idEmisor' ], $env );
			$data = [ 'operationNumber' => $conciliation[ 'result' ][ 'operation_number' ] ];
			$notification = notificationBody ( $data, 4 );
			$data = [
				'user' => [
					'name' => $provider[ 'result' ][ 'name' ],
					'lastName' => $provider[ 'result' ][ 'last_name' ],
					'company' => $provider[ 'result' ][ 'short_name' ],
				],
				'text' => $notification[ 'body' ],
				'urlDetail' => [ 'url' => base_url ( '/Conciliaciones' ), 'name' => 'Conciliaciones' ],
				'urlSoporte' => [ 'url' => base_url ( '/soporte' ), 'name' => base_url ( '/soporte' ) ],
			];
			send_mail ( 'uriel.magallon@whitefish.mx', $data, 2, [ 'alejandro@whitefish.mx', 'juan.carreno@whitefish.mx' ], $notification[ 'title' ] );
			$this->nt->insertNotification (
				[ 'id' => $provider[ 'result' ][ 'id' ], 'title' => $notification[ 'title' ], 'body' => $notification[ 'body' ], ], $env );
			$data = [
				'operationNumber' => $conciliation[ 'result' ][ 'operation_number' ],
				'amount' => $conciliation[ 'result' ][ 'total1' ],
				'clabe' => $conciliation[ 'result' ][ 'arteria_clabe' ],
			];
			$notification = notificationBody ( $data, 17 );
			$data = [
				'user' => [
					'name' => $this->session->userdata ( 'datosUsuario' )[ "name" ],
					'lastName' => $this->session->userdata ( 'datosUsuario' )[ "last_name" ],
					'company' => $this->session->userdata ( 'datosEmpresa' )[ "short_name" ],
				],
				'text' => $notification[ 'body' ],
				'urlDetail' => [ 'url' => base_url ( '/Conciliaciones' ), 'name' => 'Conciliaciones' ],
				'urlSoporte' => [ 'url' => base_url ( '/soporte' ), 'name' => base_url ( '/soporte' ) ],
			];
			send_mail ( 'uriel.magallon@whitefish.mx', $data, 2, [ 'alejandro@whitefish.mx', 'juan.carreno@whitefish.mx' ], $notification[ 'title' ] );
			$this->nt->insertNotification (
				[ 'id' => $this->session->userdata ( 'datosUsuario' )[ "id" ], 'title' => $notification[ 'title' ], 'body' => $notification[ 'body' ], ], $env );
		}
		public function adviseCreated ( array $args, string $env = 'SANDBOX' ) {
			//Se cargan los helpers y modelos necesarios
			$this->load->model ( 'User_model', 'dataUsr' );
			$this->load->model ( 'Notification_model', 'nt' );
			$this->load->helper ( 'sendmail_helper' );
			$this->load->helper ( 'notifications_helper' );
			$data = [ 'operationNumber' => $args[ 'opNumber' ] ];
			$notification = notificationBody ( $data, 13 );
			$provider = $this->dataUsr->getInfoFromCompanyPrimary ( $args[ 'receiver' ], $env );
			$data = [
				'user' => [
					'name' => $provider[ 'result' ][ 'name' ],
					'lastName' => $provider[ 'result' ][ 'last_name' ],
					'company' => $provider[ 'result' ][ 'short_name' ],
				],
				'text' => $notification[ 'body' ],
				'urlDetail' => [ 'url' => base_url ( '/Conciliaciones' ), 'name' => 'Conciliaciones' ],
				'urlSoporte' => [ 'url' => base_url ( '/soporte' ), 'name' => base_url ( '/soporte' ) ],
			];
			send_mail ( 'uriel.magallon@whitefish.mx', $data, 2, [ 'alejandro@whitefish.mx', 'juan.carreno@whitefish.mx' ], $notification[ 'title' ] );
			$arr = [
				'id' => $args[ 'receiver' ],
				'title' => $notification[ 'title' ],
				'body' => $notification[ 'body' ] ];
			$res = $this->nt->insertNotification ( $arr, $env );
		}
		public function cargarComprobantes () {
			if ( $_FILES[ 'file' ][ 'error' ] == UPLOAD_ERR_OK ) {
				$uploadedFile = $_FILES[ 'file' ];
				if ( pathinfo ( $uploadedFile[ 'name' ], PATHINFO_EXTENSION ) === 'zip' ) {
					$zip = new ZipArchive;
					if ( $zip->open ( $uploadedFile[ 'tmp_name' ] ) === TRUE ) {
						$extractedDir = './temporales/xml/';
						$zip->extractTo ( $extractedDir );
						$zip->close ();
						$xmlFiles = glob ( $extractedDir . '*.xml' );
						$filesErr = [];
						foreach ( $xmlFiles as $file ) {
							$xml = simplexml_load_file ( $file );
							$this->load->helper ( 'factura_helper' );
							$doc = XmlProcess ( $xml );
							$validation = $this->validaComprobante ( $doc, 1 );
							if ( $validation[ 'code' ] === 200 ) {
							
							} else {
								$errItem = [];
							}
							unlink ( $file );
						};
						rmdir ( $extractedDir );
					} else {
						$dato[ 'error' ] = "zip";
					}
				} else {
					$xml = simplexml_load_file ( $uploadedFile[ 'tmp_name' ] );
					$this->load->helper ( 'factura_helper' );
					$doc = XmlProcess ( $xml );
//				var_dump($doc);
					$validation = $this->validaComprobante ( $doc, 1 );
					if ( $validation[ 'code' ] === 200 ) {
						$this->load->model ( 'Invoice_model', 'invData' );
						$companyId = $this->session->userdata ( 'datosEmpresa' )[ 'id' ];
						$userId = $this->session->userdata ( 'datosUsuario' )[ 'id' ];
						$res = $this->invData->saveCFDI_I ( $doc, $companyId, $userId, 'SANDBOX' );
						if ( $res[ 'code' ] === 200 ) {
							echo json_encode ( $res );
							return TRUE;
						}
						echo json_encode ( $res );
					} else {
						echo json_encode ( $validation );
					}
					return FALSE;
				}
			}
			echo json_encode ( [ "code" => 500, "message" => "Error al guardar información", "reason" => "No se logro subir el documento" ] );
			return FALSE;
		}
		public function cargarNote () {
			if ( $_FILES[ 'file' ][ 'error' ] == UPLOAD_ERR_OK ) {
				$env = 'SANDBOX';
				$amount = $this->input->post ( 'OriginAmount' );
				$invoiceId = $this->input->post ( 'OriginCFDI' );
				$conciliaDate = $this->input->post ( 'conciliaDate' );
				$uploadedFile = $_FILES[ 'file' ];
				$xml = simplexml_load_file ( $uploadedFile[ 'tmp_name' ] );
				$this->load->helper ( 'factura_helper' );
				$doc = XmlProcess ( $xml );
//				var_dump($doc);
				$validation = $this->validaComprobante ( $doc, 2, $env, $amount );
				if ( $validation[ 'code' ] === 200 ) {
					$this->load->model ( 'Invoice_model', 'invData' );
					$companyId = $this->session->userdata ( 'datosEmpresa' )[ 'id' ];
					$userId = $this->session->userdata ( 'datosUsuario' )[ 'id' ];
					$res = $this->invData->saveCFDI_E ( $doc, $companyId, $userId, $invoiceId, $conciliaDate, $env );
					if ( $res[ 'code' ] === 200 ) {
						$this->load->model ( 'Operation_model', 'OpData' );
						$receiver = $this->invData->getReceptorByRFC ( $doc[ 'receptor' ][ 'rfc' ], $env );
						$data = [
							'invoiceId' => $invoiceId,
							'noteId' => $res[ 'id' ],
							'userId' => $userId,
							'receiver' => $receiver,
							'provider' => $companyId,
							'opNumber' => $this->MakeOperationNumber ( $invoiceId ),
							'paymentDate' => strtotime ( $conciliaDate ),
							'inCash' => $amount,
							'outCash' => $doc[ 'monto' ],
						];
						$op = $this->OpData->newConciliation_E ( $data, 'SANDBOX' );
						if ( $op[ 'code' ] === 200 ) {
//							var_dump($op);
							echo json_encode ( $op );
							$this->adviseCreated ( $data, $env );
							return TRUE;
						}
						echo json_encode ( $op );
						return FALSE;
					}
					echo json_encode ( $res );
				} else {
					echo json_encode ( $validation );
				}
				return FALSE;
			}
			echo json_encode ( [ "code" => 500, "message" => "Error al guardar información", "reason" => "No se logro subir el documento" ] );
			return FALSE;
		}
		public function WayContraCFDI () {
			$OriginCFDI = $this->input->post ( 'OriginCFDI' );
			$OriginAmount = $this->input->post ( 'OriginAmount' );
			$ReceiverId = $this->input->post ( 'ReceiverId' );
			$cfdiConciation = $this->input->post ( 'cfdiConciation' );
			$conciliaDate = $this->input->post ( 'conciliaDate' );
			$companyId = $this->session->userdata ( 'datosEmpresa' )[ 'id' ];
			$userId = $this->session->userdata ( 'datosUsuario' )[ 'id' ];
			if ( $OriginCFDI && $OriginAmount && $ReceiverId && $cfdiConciation && $conciliaDate ) {
				$this->load->model ( 'Operation_model', 'OpData' );
				$this->load->model ( 'Invoice_model', 'invData' );
				$cfdi0 = $this->invData->getCFDIById ( $cfdiConciation, 'SANDBOX' );
				$data = [
					'invoiceId' => $cfdiConciation,
					'invoiceRelId' => $OriginCFDI,
					'userId' => $userId,
					'receiver' => $companyId,
					'provider' => $cfdi0[ 'id_company' ],
					'opNumber' => $this->MakeOperationNumber ( $cfdiConciation ),
					'paymentDate' => strtotime ( $conciliaDate ),
					'inCash' => $cfdi0[ 'total' ],
					'outCash' => $OriginAmount,
				];
				$op = $this->OpData->newConciliation_I ( $data, 'SANDBOX' );
				echo json_encode ( [
					"code" => 200,
					"message" => "Conciliación creada y autorizada<br>Se envió a su correo las instrucciones para realizar el pago por transferencia",
				] );
				$this->adviseAuthorized ( $op[ 'id' ] );
				return TRUE;
			}
			echo json_encode ( [ "code" => 500, "message" => "Error al obtener información", "reason" => "No se logro obtener los registros" ] );
			return FALSE;
		}
		public function ContraCFDI () {
			$amount = $this->input->post ( 'amount' );
			$receiver = $this->input->post ( 'receiverId' );
			$userId = $this->session->userdata ( 'datosEmpresa' )[ 'id' ];
//		var_dump($amount, $receiver,$userId);
			if ( $amount && $receiver ) {
				$this->load->model ( 'Invoice_model', 'invData' );
				$res = $this->invData->getContraCFDI ( $receiver, $userId, $amount, 'SANDBOX' );
				echo json_encode ( $res );
				return TRUE;
			}
			echo json_encode ( [ "code" => 500, "message" => "Error al obtener información", "reason" => "No se logro obtener los registros" ] );
			return FALSE;
		}
		/**
		 * Función para validar el tipo de comprobante (Factura, Nora de débito)
		 * de acuerdo a las reglas de recepción para conciliaciones
		 *
		 * @param array       $factura Arreglo con los datos extraídos de factura_helper|XmlProcess
		 * @param int         $tipo    Tipo de comprobante que se validara: 1 = Factura | 2 = Nota de debito
		 * @param string|NULL $env     Ambiente en el que se trabajará “SANDBOX” | “LIVE”
		 * @param float|null  $monto   En caso de escoger tipo de documento 2 poner el monto de la factura a conciliar para su comparación
		 *
		 * @return array Devuelve el resultado de la validación con la descripcion caso de erro.
		 */
		public function validaComprobante ( array $factura, int $tipo, string $env = NULL, float $monto = NULL ): array {
			//Se selecciona el ambiente a trabajar
			$env = $env === NULL ? $this->environment : $env;
			//se obtienen los datos de la compañia que tienen iniciada sesión
			$company = $this->session->userdata ( 'datosEmpresa' );
			//Se verífica que el emisor de la factura sea el mismo que la compañia del usuario activo
			if ( $factura[ 'emisor' ][ 'rfc' ] === $company[ 'rfc' ] ) {
				//Si es factura
				if ( $tipo === 1 ) {
					//Valida que sea de tipo Ingreso
					if ( $factura[ 'tipo' ] === 'I' ) {
						return [
							'code' => 200,
							'reason' => 'Comprobante valido',
							'message' => '',
						];
					}
					return [
						'code' => 500,
						'reason' => 'Tipo de comprobante invalido',
						'message' => 'Ingrese un comprobante de ingresp',
					];
				} else if ( $tipo === 2 ) { //Si es nota de debito
					//Valida que sea de tipo Egreso
					if ( $factura[ 'tipo' ] === 'E' ) {
						//Se carga el modelo para obtener información del usuario
						$this->load->model ( 'User_model', 'dataUsr' );
						$id = $company[ "id" ];
						//Se obtiene la información de fintech del usuario
						$fintech = $this->dataUsr->getFintechInfo ( $id, $env );
						if ( $fintech[ 'code' ] === 200 ) {
							if ( $factura[ 'monto' ] < $monto ) {
								return [
									'code' => 200,
									'reason' => 'Comprobante valido',
									'message' => '',
								];
							}
							return [
								'code' => 500,
								'reason' => 'Monto incorrecto',
								'message' => 'El total del comprobante es mayor al de la factura a conciliar',
							];
						}
						return [
							'code' => 500,
							'reason' => 'No tiene cuenta "FINTECH"',
							'message' => 'La compañía no tiene una cuenta con la "FINTECH" para realizar conciliaciones',
						];
					}
					return [
						'code' => 500,
						'reason' => 'Tipo de comprobante invalido',
						'message' => 'Ingrese un comprobante de "Egreso"',
					];
				}
				return [
					'code' => 500,
					'reason' => 'Tipo de comprobante no reconocido',
					'message' => 'No hay validación para ese tipo de comprobante',
				];
			}
			return [
				'code' => 500,
				'reason' => 'RFC incorrecto',
				'message' => 'El RFC del emisor es diferente al que se registro para la empresa actual',
			];
		}
		/**
		 * Esta función permite crear un número único de operación para poner en la referencia numérica o en descripción de la transferencia
		 *
		 * @param int $operation id de la operación
		 *
		 * @return string numero para generar la transferencia
		 */
		private function MakeOperationNumber ( int $operation ): string {
			$trash = '010203040506070809';
			return str_pad ( $operation, 7, substr ( str_shuffle ( $trash ), 0, 10 ), STR_PAD_LEFT );
		}
		public function Binnacle ( array $args, int $cat, array $ins, string $module, string $env = 'SANDBOX' ): bool {
			$this->load->helper ( 'notifications_helper' );
			$this->load->model ( 'Notification_model', 'nt' );
			$this->load->helper ( 'sendmail_helper' );
			$nText = notificationBody ( $args[ 'notification' ], $cat );
			$nText[ 'id' ] = $args[ 'notification' ][ 'idUser' ];
			$args[ 'N' ] = $nText;
			$args[ 'A' ] = $nText;
			$module = $this->nt->getModuleByArgs ( $module, $this->environment );
			$support = $this->nt->getModuleByArgs ( '1', $this->environment );
			$binnacle = $this->nt->saveBinnacle ( $args, $ins, $env );
			$data = [
				'user' => [
					'name' => $args[ 'mailData' ][ 'name' ],
					'lastName' => $args[ 'mailData' ][ 'lastName' ],
					'company' => $args[ 'mailData' ][ 'company' ],
				],
				'text' => $nText[ 'body' ],
				'urlDetail' => [ 'url' => base_url ( $module[ 'result' ][ 'url' ] ), 'name' => $module[ 'result' ][ 'module' ] ],
				'urlSoporte' => [ 'url' => base_url ( $support[ 'result' ][ 'url' ] ), 'name' => $support[ 'result' ][ 'module' ] ],
			];
			send_mail ( $args[ 'mail' ], $data, 2, $args[ 'cc' ], $nText[ 'title' ] );
			return TRUE;
		}
	}
