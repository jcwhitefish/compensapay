<?php
	
	/**
	 * @property Response $response
	 */
	class Webhook extends MY_Loggedout {
		public function createLog ( string $logName, string $message ): void {
			$logDir = ( strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN' ) ? 'C:/web/logs/' : '/home/compensatest/logs/';
			$logFile = fopen ( $logDir . $logName . '.log', 'a+' );
			if ( $logFile !== FALSE ) {
				$logMessage = '|' . date ( 'Y-m-d H:i:s' ) . '|   ' . $message . "\r\n";
				fwrite ( $logFile, $logMessage );
				fclose ( $logFile );
			}
		}
		/**
		 * @return mixed
		 */
		public function transactions (): mixed {
			$this->load->model ( 'response', 'response' );
			if ( $data = Request::getBody () ) {
				$this->createLog ( 'STP', json_encode ( $data, JSON_PRETTY_PRINT ) );
				$data =['err' => 'ok'];
				return $this->response->sendResponse ( $data, 0 );
			}
			$data = [ 'error' => 400,
				'reason'=>'mal function'];
			return $this->response->sendResponse ( $data,  400);
		}
	}
