<?php

class Fintec extends MY_Loggedout
{
	public function createLog ($logname, $message){
		$logDir = '/var/www/logs/';
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
			$this->load->model('Arteria_model','dataArt');
			$data = $body ?? NULL;
			if ($data['object_type'] === 'transaction' && $data['data']['type']  === 'deposit') {
				$args = [
					'trakingKey' => $data['data']['tracking_key'],
					'arteriaId' => $data['_id'],
					'amount' => $data['data']['amount'],
					'descriptor' => $data['data']['descriptor'],
					'sourceBank' => $data['data']['source']['bank_code'],
					'receiverBank' => $data['data']['destination']['bank_code'],
					'sourceRfc' => $data['data']['source']['rfc'],
					'receiverRfc' => $data['data']['destination']['rfc'],
					'sourceClabe' => $data['data']['source']['account_number'],
					'receiverClabe' => $data['data']['destination']['account_number'],
					'transactionDate' => $data['data']['created_at'],
				];
				$res = $this->dataArt->AddMovement($args, 'SANDBOX');
				if ($res){
					$op = $this->dataArt->SearchOperations($args, 'SANDBOX');
					if ($op){
						if ($op['operationNumber'] != $args['trakingKey']){
							$rollback = [
								'clabe' => $args['sourceClabe'],
								'amount' => $args['amount'],
								'descriptor' => 'Devolucion por referencia no encontrada',
								'name' => $data['data']['source']['name'],
								'idempotency_key' => 'Rsolve'.$args['trakingKey'].'03',
							];
							$back = json_decode($this->dataArt->CreateTransfer($rollback, 'SANDBOX'), true);
							if ($back){
								$argsR = [
									'trakingKey' => $back['idempotency_key'],
									'arteriaId' => $back['id'],
									'amount' => $back['amount'],
									'descriptor' => $back['descriptor'],
									'sourceBank' => $data['data']['destination']['bank_code'],
									'receiverBank' => $data['data']['source']['bank_code'],
									'sourceRfc' => $data['data']['destination']['rfc'],
									'receiverRfc' => $data['data']['source']['rfc'],
									'sourceClabe' => $data['data']['destination']['account_number'],
									'receiverClabe' => $data['data']['source']['account_number'],
									'transactionDate' => $back['created_at'],
								];
								$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
//								var_dump($res);
								return $this->response->sendResponse(["response" => 'Devolucion por referencia'], $error);
							}
						}else if ((floatval($op['entry'])*100) != $args['amount']){
							$rollback = [
								'clabe' => $args['sourceClabe'],
								'amount' => $args['amount'],
								'descriptor' => 'Devolucion por monto incorrecto',
								'name' => $data['data']['source']['name'],
								'idempotency_key' => $args['trakingKey'].'02',
							];
							$back = json_decode($this->dataArt->CreateTransfer($rollback, 'SANDBOX'), true);
							if ($back){
								$argsR = [
									'trakingKey' => $back['idempotency_key'],
									'arteriaId' => $back['id'],
									'amount' => $back['amount'],
									'descriptor' => $back['descriptor'],
									'sourceBank' => $data['data']['destination']['bank_code'],
									'receiverBank' => $data['data']['source']['bank_code'],
									'sourceRfc' => $data['data']['destination']['rfc'],
									'receiverRfc' => $data['data']['source']['rfc'],
									'sourceClabe' => $data['data']['destination']['account_number'],
									'receiverClabe' => $data['data']['source']['account_number'],
									'transactionDate' => $back['created_at'],
								];
								$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
								return $this->response->sendResponse(["response" => 'Devolucion por monto'], $error);
							}
						}else{
							$amountP = (floatval($op['entry']) - floatval($op['exit']))*100;
							$provedor = [
								'clabe' => $op['companyClabe'],
								'amount' => $amountP,
								'descriptor' => 'OSolve '.$args['trakingKey'],
								'name' => $op['companyName'],
								'idempotency_key' => $args['trakingKey'].'001',
							];
							$prov = json_decode($this->dataArt->CreateTransfer($provedor, 'SANDBOX'), true);
							var_dump($prov);
							$argsR = [
								'trakingKey' => $prov['idempotency_key'].'001',
								'arteriaId' => $prov['id'],
								'amount' => $prov['amount'],
								'descriptor' => 'OSolve '.$args['trakingKey'],
								'sourceBank' => $data['data']['destination']['bank_code'],
								'receiverBank' => $op['companyBank'],//poner banco destino
								'sourceRfc' => $data['data']['destination']['rfc'],
								'receiverRfc' => $data['data']['destination']['rfc'],
								'sourceClabe' => $data['data']['destination']['account_number'],
								'receiverClabe' => $op['companyClabe'],
								'transactionDate' => $prov['created_at'],
							];
							$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');

							$clientT = [
								'clabe' => $args['sourceClabe'],
								'amount' => (floatval($op['exit'])*100),
								'descriptor' => 'OSolve '.$args['trakingKey'],
								'name' => $data['data']['source']['name'],
								'idempotency_key' => $args['trakingKey'].'01',
							];
							$transferCliente = json_decode($this->dataArt->CreateTransfer($clientT, 'SANDBOX'), true);
							var_dump($transferCliente);
							$argsR = [
								'trakingKey' => $transferCliente['idempotency_key'].'01',
								'arteriaId' => $transferCliente['id'],
								'amount' => ($op['exit'])*100,
								'descriptor' => 'OSolve '.$args['trakingKey'].'01',
								'sourceBank' => $data['data']['destination']['bank_code'],
								'receiverBank' => $data['data']['source']['bank_code'],
								'sourceRfc' => $data['data']['destination']['rfc'],
								'receiverRfc' => $data['data']['source']['rfc'],
								'sourceClabe' => $data['data']['destination']['account_number'],
								'receiverClabe' => $data['data']['source']['account_number'],
								'transactionDate' => $transferCliente['created_at'],
							];
							$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
							return $this->response->sendResponse(["response" => 'Devolucion correta a ambas partes'], $error);
						}
					}
				}
			}
		}
		return $this->response->sendResponse($resp, $error);
	}
}
