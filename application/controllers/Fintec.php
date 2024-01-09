<?php
/**
 *@property Settings_model $conf
 * @property Notification_model $nt
 * @property Arteria_model $dataArt
 */
class Fintec extends MY_Loggedout{
	public function createLog ($logname, $message): void
	{
		$logDir = '/home/appsolve/logs/';
//		$logDir = 'C:\web\logs\\';
		$this->logFile = fopen($logDir . $logname.'.log', 'a+');
		if ($this->logFile !== FALSE) {
			fwrite($this->logFile, '|'.date('Y-m-d H:i:s').'|   '.$message. "\r\n");
			fclose($this->logFile);
		}
	}
	public function getEvents() {
		$this->load->model('response');
		$error = 0;
		$resp = ["response" => 'ok'];
		if (Request::getStaticMethod() == 'POST' && ($body = Request::getBody())) {
			$this->createLog('ping', json_encode($body, JSON_PRETTY_PRINT));
			$this->load->model('Arteria_model','dataArt');
			$data = $body ?? NULL;
			if ($data['object_type'] === 'transaction' && $data['data']['type']  === 'deposit') {
				$args = [
					'receiverClabe' => $data['data']['destination']['account_number'],
					'operationNumber' => $data['data']['reference_number'],
					'descriptor' => $data['data']['descriptor'],
				];
				if ($op = $this->dataArt->SearchOperations($args, 'SANDBOX')){
					$args = [
						'trakingKey' => $data['data']['tracking_key'],
						'arteriaId' => $data['id'],
						'amount' => ($data['data']['amount']/100),
						'descriptor' => $data['data']['descriptor'],
						'sourceBank' => substr($data['data']['source']['account_number'], 0, 3),
						'receiverBank' => substr($data['data']['destination']['account_number'], 0, 3),
						'sourceRfc' => $data['data']['source']['rfc'],
						'receiverRfc' => $data['data']['destination']['rfc'],
						'sourceClabe' => $data['data']['source']['account_number'],
						'transactionDate' => $data['data']['created_at'],
						'operationNumber' => $op['operationNumber'],
						'receiverClabe' => $data['data']['destination']['account_number'],
					];
					$res = $this->dataArt->AddMovement($args, 'SANDBOX');
					$cep = $this->getCEP($args);
					$exitMoney = $op['exitD'] === NULL || $op['exitD'] === '' || empty($op['exitD']) ? $op['exitF'] : $op['exitD'];
					if (($op['entry']) != $data['data']['amount']){
						$rollback = [
							'clabe' =>  $data['data']['source']['account_number'],
							'amount' => $data['data']['amount'],
							'descriptor' => 'Devolucion por monto incorrecto',
							'name' => $data['data']['source']['name'],
							'idempotency_key' => base64_encode($data['data']['tracking_key']),
						];
						$back = json_decode($this->dataArt->CreateTransfer($rollback, 'SANDBOX'), true);
						$this->createLog('CreateTransfer', json_encode($back, JSON_PRETTY_PRINT));
						if ($back){
							$traking = json_decode($this->dataArt->getIdRastreo($back['id'], 'SANDBOX'), true);
							if(!$traking['tracking_key']){
								sleep(15);
								$traking = json_decode($this->dataArt->getIdRastreo($back['id'], 'SANDBOX'), true);
							}
							$argsR = [
								'trakingKey' => $traking['tracking_key'],
								'arteriaId' => $back['id'],
								'amount' => ($data['data']['amount'])/100,
								'descriptor' => $back['descriptor'],
								'sourceBank' => substr($data['data']['destination']['account_number'], 0, 3),
								'receiverBank' => substr($data['data']['source']['account_number'], 0, 3),
								'sourceRfc' => $data['data']['destination']['rfc'],
								'receiverRfc' => $data['data']['source']['rfc'],
								'sourceClabe' => $data['data']['destination']['account_number'],
								'receiverClabe' => $data['data']['source']['account_number'],
								'transactionDate' => $back['created_at'],
								'operationNumber' => NULL,
							];
							$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
							$cep = $this->getCEP($argsR);
							$newOPNumber = $this->dataArt->GetNewOperationNumber($op['operationId'],'SANDBOX');
							$this->load->helper('sendmail_helper');
							$this->load->helper('notifications_helper');
							$data['OpEntrty'] = ($op['entry']/100);
							$data['NewOpNumber'] = $newOPNumber;
							$notification = notificationBody($data,1);
							$notification2 = notificationBody($data,7);
							$data = [
								'user' => [
									'name' => $op['clientPerson']['name'],
									'lastName' => $op['clientPerson']['last'],
									'company' => $op['clientPerson']['company'],
								],
								'text' => $notification['body'],
								'urlDetail' => ['url' => base_url('/ModeloFiscal'), 'name' => 'Documentos'],
								'urlSoporte' => ['url' => base_url('/soporte'), 'name' => base_url('/soporte')],
							];
							send_mail($op['clientPerson']['mail'], $data, 2, 'uriel.magallon@whitefish.mx', $notification['title']);
							$this->nt->insertNotification(
								['id'=>$op['client'], 'title' =>$notification['title'], 'body' =>$notification['body'],],'SANDBOX');
							$notification = notificationBody($data,1);

							$data ['user']= [
								'name' => $op['providerPerson']['name'],
								'lastName' => $op['providerPerson']['last'],
								'company' => $op['providerPerson']['company'],
							];
							$data['text'] = $notification2['body'];
							send_mail($op['providerPerson']['mail'], $data, 2, 'uriel.magallon@whitefish.mx', $notification2['title']);
							$this->nt->insertNotification(
								['id'=>$op['provider'], 'title' =>$notification2['title'], 'body' =>$notification2['body'],],'SANDBOX');

							return $this->response->sendResponse(["response" => 'Operación correcta err 2'], $error);

						}
					}else{
						//====| Comenzamos a enviar el dinero del cliente |=====
						$clientT = [
							'clabe' => $data['data']['source']['account_number'],
							'amount' => filter_var($exitMoney, FILTER_VALIDATE_INT) ,
							'descriptor' => 'Pago por '.$op['uuid'],
							'name' => $data['data']['source']['name'],
							'idempotency_key' => rand(1000000,9999999),
						];
						$amountP = $op['entry']-$exitMoney;
						$provedor = [
							'clabe' => $op['companyClabe'],
							'amount' => filter_var($amountP, FILTER_VALIDATE_INT),
							'descriptor' => 'Movimiento entre cuentas',
							'name' => $op['companyName'],
							'idempotency_key' => rand(1000000,9999999),
						];

						$transferCliente = json_decode($this->dataArt->CreateTransfer($clientT, 'SANDBOX'), true);
						$this->createLog('CreateTransfer', 'Send ->'.json_encode($clientT, JSON_PRETTY_PRINT));
						$this->createLog('CreateTransfer', 'Response ->'.json_encode($transferCliente, JSON_PRETTY_PRINT));
						sleep(2);
						$traking = json_decode($this->dataArt->getIdRastreo($transferCliente['id'], 'SANDBOX'), true);
//						$traking = json_decode($this->dataArt->getIdRastreo('TRF6NOBgm_T6aF1zNigjxuFg', 'SANDBOX'), true);
						while (!$traking['tracking_key']){
							sleep(3);
							$traking = json_decode($this->dataArt->getIdRastreo($transferCliente['id'], 'SANDBOX'), true);
//							$traking = json_decode($this->dataArt->getIdRastreo('TRF6NOBgm_T6aF1zNigjxuFg', 'SANDBOX'), true);
							$this->createLog('getIdRastreo', 'Response ->'.json_encode($traking, JSON_PRETTY_PRINT));
						}
						$this->createLog('getIdRastreo', 'Response ->'.json_encode($traking, JSON_PRETTY_PRINT));
						$argsR = [
							'trakingKey' => $traking['tracking_key'],
							'amount' => ($exitMoney/100),
							'descriptor' => 'Pago por '.$op['uuid'],
							'sourceBank' => substr($data['data']['destination']['account_number'],0,3),
							'receiverBank' => substr($data['data']['source']['account_number'],0,3),
							'sourceRfc' => $data['data']['destination']['rfc'],
							'receiverRfc' => $data['data']['source']['rfc'],
							'sourceClabe' => $data['data']['destination']['account_number'],
							'receiverClabe' => $data['data']['source']['account_number'],
							'operationNumber' => $op['operationNumber'],
							'transactionDate' => $transferCliente['created_at'],
							'arteriaId' => $transferCliente['id'],
//							'transactionDate' => '2023-11-23T17:55:36.152000',
//							'arteriaId' => 'TRF6NOBgm_T6aF1zNigjxuFg',
						];
						$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
						$cepC = $this->getCEP($argsR);

						//====| Comenzamos a enviar el dinero del proveedor |=====
						$prov = json_decode($this->dataArt->CreateTransfer($provedor, 'SANDBOX'), true);
						$this->createLog('CreateTransfer', 'Send ->'.json_encode($provedor, JSON_PRETTY_PRINT));
						$this->createLog('CreateTransfer', 'Response ->'.json_encode($prov, JSON_PRETTY_PRINT));
//                        $this->createLog('var_dump', 'step1');
						sleep(2);
						$traking2 = json_decode($this->dataArt->getIdRastreo($prov['id'], 'SANDBOX'), true);
//                        $this->createLog('var_dump', 'step2');
//						$traking2 = json_decode($this->dataArt->getIdRastreo('TROA5qGQ47QeClEPTWiephsw', 'SANDBOX'), true);
//                        var_dump($traking2);
						while (!$traking2['tracking_key']){
							sleep(3);
							$traking2 = json_decode($this->dataArt->getIdRastreo($prov['id'], 'SANDBOX'), true);
//                            $this->createLog('var_dump', 'step2.1');
//							$traking2 = json_decode($this->dataArt->getIdRastreo('TROA5qGQ47QeClEPTWiephsw', 'SANDBOX'), true);
//                            var_dump($traking2);
							$this->createLog('getIdRastreo', 'Response ->'.json_encode($traking2, JSON_PRETTY_PRINT));
						}
						$this->createLog('getIdRastreo', 'Response ->'.json_encode($traking2, JSON_PRETTY_PRINT));
//                        $this->createLog('var_dump', 'step3');
						$argsProv = [
							'trakingKey' => $traking2['tracking_key'],
							'amount' => ($amountP/100),
							'descriptor' => 'Movimiento entre cuentas',
							'sourceBank' => substr($data['data']['destination']['account_number'], 0, 3),
							'receiverBank' => substr($op['clientClabe'], 0, 3),
							'sourceRfc' => $data['data']['destination']['rfc'],
							'receiverRfc' => $data['data']['destination']['rfc'],
							'sourceClabe' => $data['data']['destination']['account_number'],
							'receiverClabe' => $op['companyClabe'],
							'operationNumber' => $op['operationNumber'],
							'transactionDate' => $prov['created_at'],
							'arteriaId' => $prov['id'],
//							'transactionDate' => '2023-11-22T22:49:34.973828',
//							'arteriaId' => 'TROA5qGQ47QeClEPTWiephsw',
						];
//                        $this->createLog('var_dump', 'step4');
//                        var_dump($argsProv);
//						$this->createLog('AddMovement', 'Send ->'.json_encode($argsProv, JSON_PRETTY_PRINT));
						$res = $this->dataArt->AddMovement($argsProv, 'SANDBOX');
//                        $this->createLog('var_dump', 'step5');
//						$this->createLog('AddMovement', 'response ->'.json_encode($res, JSON_PRETTY_PRINT));
						$cepC = $this->getCEP($argsProv);
//                        $this->createLog('var_dump', 'step6');
//							$this->load->helper('sendmail_helper');
						$this->load->helper('sendmail_helper');
						$this->load->helper('notifications_helper');

						$data['OpEntrty'] = ($op['entry']/100);
						$notification = notificationBody($args,2);

						$data = [
							'user' => [
								'name' => $op['providerPerson']['name'],
								'lastName' => $op['providerPerson']['last'],
								'company' => $op['providerPerson']['company'],
							],
							'text' => $notification['body'],
							'urlDetail' => ['url' => base_url('/ModeloFiscal'), 'name' => 'Modelo Fiscal'],
							'urlSoporte' => ['url' => base_url('/soporte'), 'name' => base_url('/soporte')],
						];
						send_mail($op['providerPerson']['mail'], $data, 2, 'uriel.magallon@whitefish.mx', $notification['titulo']);
						$data['user'] = [
							'name' => $op['clientPerson']['name'],
							'lastName' => $op['clientPerson']['last'],
							'company' => $op['clientPerson']['company'],
						];
						send_mail($op['clientPerson']['mail'], $data, 2, 'uriel.magallon@whitefish.mx', $notification['titulo']);
						$args['tipoComprobante']=$op['tipoComprobante'];
						$args['idComprobante2']=$op['idComprobante2'];
						$args['idComprobante1']=$op['idComprobante1'];
						$args['idOP'] = $op['id'];
						$this->dataArt->succesConciliation($args,'SANDBOX');
						return $this->response->sendResponse(["response" => 'Operación correcta'], $error);
					}
				}else{
					$args = [
						'trakingKey' => $data['data']['tracking_key'],
						'arteriaId' => $data['id'],
						'amount' => ($data['data']['amount']/100),
						'descriptor' => $data['data']['descriptor'],
						'sourceBank' => substr($data['data']['source']['account_number'], 0, 3),
						'receiverBank' => substr($data['data']['destination']['account_number'], 0, 3),
						'sourceRfc' => $data['data']['source']['rfc'],
						'receiverRfc' => $data['data']['destination']['rfc'],
						'sourceClabe' => $data['data']['source']['account_number'],
						'transactionDate' => $data['data']['created_at'],
						'operationNumber' => NULL,
						'receiverClabe' => $data['data']['destination']['account_number'],
					];
					$res = $this->dataArt->AddMovement($args, 'SANDBOX');
					$cep = $this->getCEP($args);
					$rollback = [
						'clabe' => $args['sourceClabe'],
						'amount' => $data['data']['amount'],
						'descriptor' => 'Devolucion por referencia no encontrada',
						'name' => $data['data']['source']['name'],
						'idempotency_key' => $args['trakingKey'].'01',
					];
					$back = json_decode($this->dataArt->CreateTransfer($rollback, 'SANDBOX'), true);
					$this->createLog('CreateTransfer', json_encode($back, JSON_PRETTY_PRINT));
					if ($back){
						$traking = json_decode($this->dataArt->getIdRastreo($back['id'], 'SANDBOX'), true);
						if(!$traking['tracking_key']){
							sleep(15);
							$traking = json_decode($this->dataArt->getIdRastreo($back['id'], 'SANDBOX'), true);
						}
						$argsR = [
							'trakingKey' => $traking['tracking_key'],
							'arteriaId' => $back['id'],
							'amount' => ($data['data']['amount'])/100,
							'descriptor' => $back['descriptor'],
							'sourceBank' => substr($data['data']['destination']['account_number'], 0, 3),
							'receiverBank' => substr($data['data']['source']['account_number'], 0, 3),
							'sourceRfc' => $data['data']['destination']['rfc'],
							'receiverRfc' => $data['data']['source']['rfc'],
							'sourceClabe' => $data['data']['destination']['account_number'],
							'receiverClabe' => $data['data']['source']['account_number'],
							'transactionDate' => $back['created_at'],
							'operationNumber' => NULL,
						];
						$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
						$cep = $this->getCEP($argsR);
						return $this->response->sendResponse(["response" => 'Operación correcta err 1'], $error);
					}
				}
			}
		}
		return $this->response->sendResponse($resp, $error);
	}
	public function getCEP($args){
		$this->load->model('Arteria_model','dataArt');
		$sourceBank = $this->dataArt->getBankByClabe($args['sourceBank']);
		$receiverBank = $this->dataArt->getBankByClabe($args['receiverBank']);
		$data = [
			'tipoCriterio' => 'T',
			'receptorParticipante' => 0,
			'captcha' => 'c',
			'tipoConsulta' => 1,
			'fecha' => date('d-m-Y', strtotime($args['transactionDate'])),
			'criterio' => $args['trakingKey'],
			'emisor' => $sourceBank[0]['bnk_code'],
			'receptor' => $receiverBank[0]['bnk_code'],
			'cuenta' => $args['receiverClabe'],
			'monto' => $args['amount'],
		];
		$res = $this->dataArt->DownloadCEP($data,0, 'SANDBOX');
//		var_dump($res);
//		var_dump($res < 1);
		if ($res < 1){
			$this->createLog('CEP','No se pudo descargar '.$data['criterio']);
		}else{
			$this->dataArt->insertCEP($args, $res, 'SANDBOX');
		}
		return $res;
	}
	function checkTracking($id){
		$this->load->model('Arteria_model','dataArt');
		return json_decode($this->dataArt->getIdRastreo($id, 'SANDBOX'));
	}
	public function tryCEPMultiDownload(){
		$this->load->model('Arteria_model', 'dataArt');
		$balance = $this->dataArt->getAllBalanceCEP();
		foreach ($balance as $row => $item){
			$cep1 = [
				'transactionDate' => date('d-m-Y', $item['transaction_date']),
				'trakingKey' => $item['traking_key'],
				'sourceBank' => substr($item['source_clabe'], 0, 3),
				'receiverBank' => substr($item['receiver_clabe'], 0, 3),
				'receiverClabe' => $item['receiver_clabe'],
				'amount' => $item['amount'],
				'arteriaId' => $item['arteriaD_id'],
			];
//			var_dump($cep1);
			$this->getCEP($cep1);
		}
	}
	/**
	 * @param string $texto texto a encriptar
	 * @param string $key llave que será usada en la encriptación y necesaria para desencriptar
	 * @return string Devuelve el texto encriptado
	 */
	function encriptar(string $texto, string $key){
		return base64_encode($texto.'-'.$key);
		//return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $texto, MCRYPT_MODE_CBC, md5(md5($key))));
	}
	function desencriptar(string $texto, string $key){
		return base64_decode($texto.$key);
		//return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($texto), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	}
	public function ini(){
		phpinfo();
	}
}
