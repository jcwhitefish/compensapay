<?php
	
	/**
	 * @property Settings_model     $conf
	 * @property Notification_model $nt
	 * @property Arteria_model      $dataArt
	 * @property Response           $response
	 */
	class Fintec extends MY_Loggedout {
		private string $environment = 'SANDBOX';
		public function __construct () {
			parent::__construct ();
			$this->load->model ( 'response' );
		}
		public function createLog ( string $logName, string $message ): void {
			$logDir = ( strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN' ) ? 'C:/web/logs/' : '/home/compensatest/logs/';
			$this->logFile = fopen ( $logDir . $logName . '.log', 'a+' );
			if ( $this->logFile !== FALSE ) {
				$logMessage = '|' . date ( 'Y-m-d H:i:s' ) . '|   ' . $message . "\r\n";
				fwrite ( $this->logFile, $logMessage );
				fclose ( $this->logFile );
			}
		}
		public function getEvents () {
			$error = 0;
			$resp = [ "response" => 'ok' ];
			//Se revisa que la petición sea por POST y haya información en el cuerpo del mensaje
			if ( Request::getStaticMethod () == 'POST' && ( $data = Request::getBody () ) ) {
				//Se crea el log que guarda todo lo que se recibe
				$this->createLog ( 'ping', json_encode ( $data, JSON_PRETTY_PRINT ) );
				$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
					'in' => json_encode ( [ $data[ 'object_type' ], $data[ 'data' ][ 'type' ], $data[ 'event' ] ] ),
					'out' => json_encode ( 'ok' ) ];
				$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
				//Verificar que el tipo de evento sea de una transferencia entrante.
				if ( $data[ 'object_type' ] === 'deposit' && $data[ 'data' ][ 'type' ] === 'deposit' ) {
					$this->load->model ( 'Arteria_model', 'dataArt' );
					//Se empieza a crear el arreglo con los datos que vamos a utilizar
					$args = [
						'receiverClabe' => $data[ 'data' ][ 'destination' ][ 'account_number' ],
						'operationNumber' => $data[ 'data' ][ 'reference_number' ],
						'descriptor' => $data[ 'data' ][ 'descriptor' ],
					];
					// Verificar que el depósito sea de una conciliación activa
					if ( $op = $this->dataArt->SearchOperations ( $args, 'SANDBOX' ) ) {
						$args = [
							'trakingKey' => $data[ 'data' ][ 'tracking_key' ],
							'arteriaId' => $data[ 'id' ],
							'amount' => ( $data[ 'data' ][ 'amount' ] / 100 ),
							'descriptor' => $data[ 'data' ][ 'descriptor' ],
							'sourceBank' => substr ( $data[ 'data' ][ 'source' ][ 'account_number' ], 0, 3 ),
							'receiverBank' => substr ( $data[ 'data' ][ 'destination' ][ 'account_number' ], 0, 3 ),
							'sourceRfc' => $data[ 'data' ][ 'source' ][ 'rfc' ],
							'receiverRfc' => $data[ 'data' ][ 'destination' ][ 'rfc' ],
							'sourceClabe' => $data[ 'data' ][ 'source' ][ 'account_number' ],
							'transactionDate' => $data[ 'data' ][ 'created_at' ],
							'operationNumber' => $op[ 'operationNumber' ],
							'receiverClabe' => $data[ 'data' ][ 'destination' ][ 'account_number' ],
						];
						$this->AddMovement ( $args, 'SANDBOX' );
						$this->getCEP ( $args );
						$exitMoney = empty( $op[ 'exitD' ] ) ? $op[ 'exitF' ] : $op[ 'exitD' ];
						if ( ( $op[ 'entry' ] ) != $data[ 'data' ][ 'amount' ] ) {
							$rollback = [
								'clabe' => $data[ 'data' ][ 'source' ][ 'account_number' ],
								'amount' => $data[ 'data' ][ 'amount' ],
								'descriptor' => 'Devolución por monto incorrecto',
								'name' => $data[ 'data' ][ 'source' ][ 'name' ],
								'idempotency_key' => base64_encode ( $data[ 'data' ][ 'tracking_key' ] ),
							];
							$back = json_decode ( $this->dataArt->CreateTransfer ( $rollback, 'SANDBOX' ), TRUE );
							$this->createLog ( 'CreateTransfer', json_encode ( $back, JSON_PRETTY_PRINT ) );
							$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
								'in' => json_encode ( $rollback ),
								'out' => json_encode ( $back ) ];
							$binnacle[ 'notification' ] = [ 'clabe' => $rollback[ 'clabe' ], 'monto' => $rollback[ 'amount' ],
								'idUser' => 1 ];
							$binnacle[ 'mail' ] = [ 'alejandro@whitefish.mx', 'juan.carreno@whitefish.mx' ];
							$binnacle[ 'cc' ] = 'uriel.magallon@whitefish.mx';
							$binnacle[ 'mailData' ] = [
								'name' => 'usuario',
								'lastName' => 'administrator',
								'company' => 'whitefish / Solve',
							];
							$this->Binnacle ( $binnacle, 100, [ 2, 3 ], 3, $this->environment );
							if ( $back ) {
								$traking = json_decode ( $this->dataArt->getIdRastreo ( $back[ 'id' ], 'SANDBOX' ), TRUE );
								if ( !$traking[ 'tracking_key' ] ) {
									sleep ( 15 );
									$traking = json_decode ( $this->dataArt->getIdRastreo ( $back[ 'id' ], 'SANDBOX' ), TRUE );
								}
								$argsR = [
									'trakingKey' => $traking[ 'tracking_key' ],
									'arteriaId' => $back[ 'id' ],
									'amount' => ( $data[ 'data' ][ 'amount' ] ) / 100,
									'descriptor' => $back[ 'descriptor' ],
									'sourceBank' => substr ( $data[ 'data' ][ 'destination' ][ 'account_number' ], 0, 3 ),
									'receiverBank' => substr ( $data[ 'data' ][ 'source' ][ 'account_number' ], 0, 3 ),
									'sourceRfc' => $data[ 'data' ][ 'destination' ][ 'rfc' ],
									'receiverRfc' => $data[ 'data' ][ 'source' ][ 'rfc' ],
									'sourceClabe' => $data[ 'data' ][ 'destination' ][ 'account_number' ],
									'receiverClabe' => $data[ 'data' ][ 'source' ][ 'account_number' ],
									'transactionDate' => $back[ 'created_at' ],
									'operationNumber' => NULL,
								];
								$this->AddMovement ( $argsR, 'SANDBOX' );
								$this->getCEP ( $argsR );
								$newOPNumber = $this->dataArt->GetNewOperationNumber ( $op[ 'operationId' ], 'SANDBOX' );
								$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
									'in' => json_encode ( [ 'idAnterior' => $op[ 'operationId' ] ] ),
									'out' => json_encode ( [ 'newOP' => $newOPNumber ] ) ];
								$binnacle[ 'notification' ] = [
									'OpEntrty' => ( $op[ 'entry' ] / 100 ),
									'amount' => ( $data[ 'data' ][ 'amount' ] ) / 100,
									'operationNumber' => $newOPNumber,
									'client' => $op[ 'client' ],
								];
								$binnacle[ 'mail' ] = $op[ 'clientPerson' ][ 'mail' ];
								$binnacle[ 'cc' ] = 'uriel.magallon@whitefish.mx';
								$binnacle[ 'mailData' ] = [
									'name' => $op[ 'clientPerson' ][ 'name' ],
									'lastName' => $op[ 'clientPerson' ][ 'last' ],
									'company' => $op[ 'clientPerson' ][ 'company' ],
								];
								$this->Binnacle ( $binnacle, 1, [ 1, 2, 3 ], 3, $this->environment );
								$binnacle[ 'mail' ] = $op[ 'providerPerson' ][ 'mail' ];
								$binnacle[ 'mailData' ] = [
									'name' => $op[ 'providerPerson' ][ 'name' ],
									'lastName' => $op[ 'providerPerson' ][ 'last' ],
									'company' => $op[ 'providerPerson' ][ 'company' ],
								];
								$this->Binnacle ( $binnacle, 7, [ 1, 2, 3 ], 3, $this->environment );
								return $this->response->sendResponse ( [ "response" => 'Operación correcta err 2' ], $error );
							}
						} else {
							//====| Comenzamos a enviar el dinero del cliente |=====
							$clientT = [
								'clabe' => $data[ 'data' ][ 'source' ][ 'account_number' ],
								'amount' => filter_var ( $exitMoney, FILTER_VALIDATE_INT ),
								'descriptor' => 'Pago por ' . $op[ 'uuid' ],
								'name' => $data[ 'data' ][ 'source' ][ 'name' ],
								'idempotency_key' => rand ( 1000000, 9999999 ),
							];
							$amountP = $op[ 'entry' ] - $exitMoney;
							$provedor = [
								'clabe' => $op[ 'companyClabe' ],
								'amount' => filter_var ( $amountP, FILTER_VALIDATE_INT ),
								'descriptor' => 'Movimiento entre cuentas',
								'name' => $op[ 'companyName' ],
								'idempotency_key' => rand ( 1000000, 9999999 ),
							];
							$transferCliente = json_decode ( $this->dataArt->CreateTransfer ( $clientT, 'SANDBOX' ), TRUE );
							$this->createLog ( 'CreateTransfer', 'Send ->' . json_encode ( $clientT, JSON_PRETTY_PRINT ) );
							$this->createLog ( 'CreateTransfer', 'Response ->' . json_encode ( $transferCliente, JSON_PRETTY_PRINT ) );
							$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
								'in' => json_encode ( $clientT ),
								'out' => json_encode ( $transferCliente ) ];
							$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
							sleep ( 2 );
							$traking = json_decode ( $this->dataArt->getIdRastreo ( $transferCliente[ 'id' ], 'SANDBOX' ), TRUE );
							while ( !$traking[ 'tracking_key' ] ) {
								sleep ( 3 );
								$traking = json_decode ( $this->dataArt->getIdRastreo ( $transferCliente[ 'id' ], 'SANDBOX' ), TRUE );
								$this->createLog ( 'getIdRastreo', 'Response ->' . json_encode ( $traking, JSON_PRETTY_PRINT ) );
								$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
									'in' => json_encode ( [ 'idCuenca' => $transferCliente[ 'id' ] ] ),
									'out' => json_encode ( $traking ) ];
								$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
							}
							$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
								'in' => json_encode ( [ 'idCuenca' => $transferCliente[ 'id' ] ] ),
								'out' => json_encode ( $traking ) ];
							$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
							$this->createLog ( 'getIdRastreo', 'Response ->' . json_encode ( $traking, JSON_PRETTY_PRINT ) );
							$argsR = [
								'trakingKey' => $traking[ 'tracking_key' ],
								'amount' => ( $exitMoney / 100 ),
								'descriptor' => 'Pago por ' . $op[ 'uuid' ],
								'sourceBank' => substr ( $data[ 'data' ][ 'destination' ][ 'account_number' ], 0, 3 ),
								'receiverBank' => substr ( $data[ 'data' ][ 'source' ][ 'account_number' ], 0, 3 ),
								'sourceRfc' => $data[ 'data' ][ 'destination' ][ 'rfc' ],
								'receiverRfc' => $data[ 'data' ][ 'source' ][ 'rfc' ],
								'sourceClabe' => $data[ 'data' ][ 'destination' ][ 'account_number' ],
								'receiverClabe' => $data[ 'data' ][ 'source' ][ 'account_number' ],
								'operationNumber' => $op[ 'operationNumber' ],
								'transactionDate' => $transferCliente[ 'created_at' ],
								'arteriaId' => $transferCliente[ 'id' ],
							];
							$res = $this->dataArt->AddMovement ( $argsR, 'SANDBOX' );
							$cepC = $this->getCEP ( $argsR );
							//====| Comenzamos a enviar el dinero del proveedor |=====
							$prov = json_decode ( $this->dataArt->CreateTransfer ( $provedor, 'SANDBOX' ), TRUE );
							$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
								'in' => json_encode ( $provedor ),
								'out' => json_encode ( $prov ) ];
							$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
							$this->createLog ( 'CreateTransfer', 'Send ->' . json_encode ( $provedor, JSON_PRETTY_PRINT ) );
							$this->createLog ( 'CreateTransfer', 'Response ->' . json_encode ( $prov, JSON_PRETTY_PRINT ) );
							sleep ( 2 );
							$traking2 = json_decode ( $this->dataArt->getIdRastreo ( $prov[ 'id' ], 'SANDBOX' ), TRUE );
							$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
								'in' => json_encode ( [ 'idCuenca' => $prov[ 'id' ] ] ),
								'out' => json_encode ( $traking2 ) ];
							$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
							while ( !$traking2[ 'tracking_key' ] ) {
								sleep ( 3 );
								$traking2 = json_decode ( $this->dataArt->getIdRastreo ( $prov[ 'id' ], 'SANDBOX' ), TRUE );
								$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
									'in' => json_encode ( [ 'idCuenca' => $prov[ 'id' ] ] ),
									'out' => json_encode ( $traking2 ) ];
								$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
								$this->createLog ( 'getIdRastreo', 'Response ->' . json_encode ( $traking2, JSON_PRETTY_PRINT ) );
							}
							$this->createLog ( 'getIdRastreo', 'Response ->' . json_encode ( $traking2, JSON_PRETTY_PRINT ) );
							$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
								'in' => json_encode ( [ 'idCuenca' => $prov[ 'id' ] ] ),
								'out' => json_encode ( $traking2 ) ];
							$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
							$argsProv = [
								'trakingKey' => $traking2[ 'tracking_key' ],
								'amount' => ( $amountP / 100 ),
								'descriptor' => 'Movimiento entre cuentas',
								'sourceBank' => substr ( $data[ 'data' ][ 'destination' ][ 'account_number' ], 0, 3 ),
								'receiverBank' => substr ( $data[ 'data' ][ 'source' ][ 'account_number' ], 0, 3 ),
								'sourceRfc' => $data[ 'data' ][ 'destination' ][ 'rfc' ],
								'receiverRfc' => $data[ 'data' ][ 'destination' ][ 'rfc' ],
								'sourceClabe' => $data[ 'data' ][ 'destination' ][ 'account_number' ],
								'receiverClabe' => $data[ 'data' ][ 'source' ][ 'account_number' ],
								'operationNumber' => $op[ 'operationNumber' ],
								'transactionDate' => $prov[ 'created_at' ],
								'arteriaId' => $prov[ 'id' ],
//							'transactionDate' => '2023-11-22T22:49:34.973828',
//							'arteriaId' => 'TROA5qGQ47QeClEPTWiephsw',
							];
							$this->dataArt->AddMovement ( $argsProv, 'SANDBOX' );
							$this->getCEP ( $argsProv );
							$data[ 'OpEntrty' ] = ( $op[ 'entry' ] / 100 );
							$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
								'in' => json_encode ( $argsProv ),
								'out' => json_encode ( [ 'result' => 'OK' ] ) ];
							$binnacle[ 'notification' ] = $args;
							$binnacle[ 'notification' ][ 'idUser' ] = 1;
							$binnacle[ 'notification' ][ 'client' ] = $op[ 'clientPerson' ][ 'company' ];
							$binnacle[ 'mail' ] = $op[ 'providerPerson' ][ 'mail' ];
							$binnacle[ 'cc' ] = 'uriel.magallon@whitefish.mx';
							$binnacle[ 'mailData' ] = [
								'name' => $op[ 'providerPerson' ][ 'name' ],
								'lastName' => $op[ 'providerPerson' ][ 'last' ],
								'company' => $op[ 'providerPerson' ][ 'company' ],
							];
							$this->Binnacle ( $binnacle, 2, [ 1, 2, 3 ], 3, $this->environment );
							$binnacle[ 'mail' ] = $op[ 'clientPerson' ][ 'mail' ];
							$binnacle[ 'mailData' ] = [
								'name' => $op[ 'clientPerson' ][ 'name' ],
								'lastName' => $op[ 'clientPerson' ][ 'last' ],
								'company' => $op[ 'clientPerson' ][ 'company' ],
							];
							$this->Binnacle ( $binnacle, 2, [ 1, 2, 3 ], 3, $this->environment );
							return $this->response->sendResponse ( [ "response" => 'Operación correcta' ], $error );
						}
					} else {
						return $this->operationNotFound ( $data, $error );
					}
				}
			}
			return $this->response->sendResponse ( $resp, $error );
		}
		/**
		 * @param $data
		 * @param $error
		 *
		 * @return null
		 */
		public function operationNotFound ( $data, $error ) {
			$args = [
				'trakingKey' => $data[ 'data' ][ 'tracking_key' ],
				'arteriaId' => $data[ 'id' ],
				'amount' => ( $data[ 'data' ][ 'amount' ] / 100 ),
				'descriptor' => $data[ 'data' ][ 'descriptor' ],
				'sourceBank' => substr ( $data[ 'data' ][ 'source' ][ 'account_number' ], 0, 3 ),
				'receiverBank' => substr ( $data[ 'data' ][ 'destination' ][ 'account_number' ], 0, 3 ),
				'sourceRfc' => $data[ 'data' ][ 'source' ][ 'rfc' ],
				'receiverRfc' => $data[ 'data' ][ 'destination' ][ 'rfc' ],
				'sourceClabe' => $data[ 'data' ][ 'source' ][ 'account_number' ],
				'transactionDate' => $data[ 'data' ][ 'created_at' ],
				'operationNumber' => NULL,
				'receiverClabe' => $data[ 'data' ][ 'destination' ][ 'account_number' ],
			];
			$this->AddMovement ( $args, 'SANDBOX' );
			$this->getCEP ( $args );
			$rollback = [
				'clabe' => $args[ 'sourceClabe' ],
				'amount' => $data[ 'data' ][ 'amount' ],
				'descriptor' => 'Devolucion por referencia no encontrada',
				'name' => $data[ 'data' ][ 'source' ][ 'name' ],
				'idempotency_key' => str_shuffle ( $args[ 'trakingKey' ] . '01' ),
			];
			$back = json_decode ( $this->dataArt->CreateTransfer ( $rollback, 'SANDBOX' ), TRUE );
			$this->createLog ( 'CreateTransfer', json_encode ( $back, JSON_PRETTY_PRINT ) );
			if ( $back ) {
				$binnacle[ 'notification' ] = [
					'monto' => $args[ 'amount' ],
					'clabe' => $rollback[ 'clabe' ],
				];
				$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 0,
					'in' => json_encode ( $rollback ),
					'out' => json_encode ( $back ) ];
				$this->Binnacle ( $binnacle, 102, [ 2, 3 ], 3, $this->environment );
				$traking = json_decode ( $this->dataArt->getIdRastreo ( $back[ 'id' ], 'SANDBOX' ), TRUE );
				if ( !$traking[ 'tracking_key' ] ) {
					sleep ( 15 );
					$traking = json_decode ( $this->dataArt->getIdRastreo ( $back[ 'id' ], 'SANDBOX' ), TRUE );
				}
				$argsR = [
					'trakingKey' => $traking[ 'tracking_key' ],
					'arteriaId' => $back[ 'id' ],
					'amount' => ( $data[ 'data' ][ 'amount' ] ) / 100,
					'descriptor' => $back[ 'descriptor' ],
					'sourceBank' => substr ( $data[ 'data' ][ 'destination' ][ 'account_number' ], 0, 3 ),
					'receiverBank' => substr ( $data[ 'data' ][ 'source' ][ 'account_number' ], 0, 3 ),
					'sourceRfc' => $data[ 'data' ][ 'destination' ][ 'rfc' ],
					'receiverRfc' => $data[ 'data' ][ 'source' ][ 'rfc' ],
					'sourceClabe' => $data[ 'data' ][ 'destination' ][ 'account_number' ],
					'receiverClabe' => $data[ 'data' ][ 'source' ][ 'account_number' ],
					'transactionDate' => $back[ 'created_at' ],
					'operationNumber' => NULL,
				];
				$binnacle['notification'] = [];
				$binnacle[ 'mail' ] = $op[ 'providerPerson' ][ 'mail' ];
				$binnacle[ 'cc' ] = 'uriel.magallon@whitefish.mx';
				$binnacle[ 'mailData' ] = [
					'name' => $op[ 'providerPerson' ][ 'name' ],
					'lastName' => $op[ 'providerPerson' ][ 'last' ],
					'company' => $op[ 'providerPerson' ][ 'company' ],
				];
				$this->AddMovement ( $argsR, $this->environment );
				$this->getCEP ( $argsR );
				return $this->response->sendResponse ( [ "response" => 'Operación correcta err 1' ], $error );
			}
			$error = 500;
			return $this->response->sendResponse ( [ "response" => 'No se pudo generar la devolución' ], $error );
		}
		public function getCEP ( $args ): int|string|null {
			$this->load->model ( 'Arteria_model', 'dataArt' );
			$sourceBank = $this->dataArt->getBankByClabe ( $args[ 'sourceBank' ] );
			$receiverBank = $this->dataArt->getBankByClabe ( $args[ 'receiverBank' ] );
			$data = [
				'tipoCriterio' => 'T',
				'receptorParticipante' => 0,
				'captcha' => 'c',
				'tipoConsulta' => 1,
				'fecha' => date ( 'd-m-Y', strtotime ( $args[ 'transactionDate' ] ) ),
				'criterio' => $args[ 'trakingKey' ],
				'emisor' => $sourceBank[ 0 ][ 'bnk_code' ],
				'receptor' => $receiverBank[ 0 ][ 'bnk_code' ],
				'cuenta' => $args[ 'receiverClabe' ],
				'monto' => $args[ 'amount' ],
			];
			$res = $this->dataArt->DownloadCEP ( $data, 0, 'SANDBOX' );
			if ( $res < 1 ) {
				$this->createLog ( 'CEP', 'No se pudo descargar ' . $data[ 'criterio' ] );
				$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => $res,
					'in' => json_encode ( $data ),
					'out' => json_encode ( 'No se pudo descargar ' . $data[ 'criterio' ] ) ];
			} else {
				$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => 200, 'in' => json_encode ( $data ), 'out' => json_encode ( $res ) ];
				$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
				$insert = $this->dataArt->insertCEP ( $args, $res, 'SANDBOX' );
				$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => $insert[ 'code' ], 'in' => json_encode ( $args ) . ( $res ), 'out' => json_encode ( $insert ) ];
			}
			$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
			return $res;
		}
		public function tryCEPMultiDownload (): void {
			$this->load->model ( 'Arteria_model', 'dataArt' );
			$balance = $this->dataArt->getAllBalanceCEP ();
			foreach ( $balance as $row => $item ) {
				$cep1 = [
					'transactionDate' => date ( 'd-m-Y', $item[ 'transaction_date' ] ),
					'trakingKey' => $item[ 'traking_key' ],
					'sourceBank' => substr ( $item[ 'source_clabe' ], 0, 3 ),
					'receiverBank' => substr ( $item[ 'receiver_clabe' ], 0, 3 ),
					'receiverClabe' => $item[ 'receiver_clabe' ],
					'amount' => $item[ 'amount' ],
					'arteriaId' => $item[ 'arteriaD_id' ],
				];
//			var_dump($cep1);
				$this->getCEP ( $cep1 );
			}
		}
		public function ini (): void {
			phpinfo ();
		}
		public function testNotifications (): void {
			$this->load->model ( 'Notification_model', 'nt' );
			$data = [
				'id' => 1,
				'title' => 'prueba',
				'body' => 'Esto es una pruebaaa',
			];
			var_dump ( $this->nt->insertNotification ( $data, 'SANDBOX' ) );
		}
		public function AddMovement ( array $args, string $env = NULL ): void {
			$this->load->model ( 'Arteria_model', 'dataArt' );
			$res = $this->dataArt->AddMovement ( $args, $env );
			$binnacle [ 'L' ] = [ 'id_c' => 1, 'id' => 1, 'module' => 3, 'code' => $res[ 'code' ],
				'in' => json_encode ( $args ),
				'out' => json_encode ( $res ) ];
			$this->Binnacle ( $binnacle, 0, [ 3 ], 3, $this->environment );
		}
		public function insertLog () {
		
		}
		/**
		 * @param array  $args Arreglo con la información a guardar
		 * @param int    $cat  Categoria de notificación
		 * @param array  $ins
		 * @param string $module
		 * @param string $env
		 *
		 * @return bool
		 */
		public function Binnacle ( array  $args, int $cat, array $ins, string $module,
		                           string $env = 'SANDBOX' ): bool {
			$this->load->helper ( 'notifications_helper' );
			$this->load->model ( 'Notification_model', 'nt' );
			$this->load->helper ( 'sendmail_helper' );
			$nText = '';
			if ( $cat != 0 ) {
				$nText = notificationBody ( $args[ 'notification' ], $cat );
				$nText[ 'id' ] = $args[ 'notification' ][ 'idUser' ];
			}
			foreach ( $ins as $binnacle ) {
				switch ( $binnacle ) {
					case 1:
						$args[ 'N' ] = $nText;
						break;
					case 2:
						$args[ 'A' ] = $nText;
						break;
					case 3:
						$module = $this->nt->getModuleByArgs ( $module, $this->environment );
						$support = $this->nt->getModuleByArgs ( '1', $this->environment );
						break;
				}
			}
			$binnacle = $this->nt->saveBinnacle ( $args, $ins, $env );
			if ( isset( $args[ 'mailData' ], $args[ 'mail' ] ) ) {
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
				if ( isset( $args[ 'cc' ] ) ) {
					send_mail ( $args[ 'mail' ], $data, 2, $args[ 'cc' ], $nText[ 'title' ] );
				} else {
					send_mail ( $args[ 'mail' ], $data, 2, NULL, $nText[ 'title' ] );
				}
			}
			return TRUE;
		}
	}
