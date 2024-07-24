<?php
	/**
	 * Permite realizar peticiones al api solve para obtener información
	 *
	 * @param array  $data     Información de entrada
	 * @param string $endpoint Endpoint que se va a consultar
	 * @param string $env      Ambiente en el que se esta trabajando
	 *
	 * @return bool|string
	 */
	function getRequest ( array $data, string $endpoint, string $env ): bool|string {
		$data = http_build_query ( $data );
		$url = strtoupper ( $env ) === 'SANDBOX' ? 'https://apisandbox.solve.com.mx/public/' : 'https://apisandbox.solve.com.mx/public/';
		$curl = curl_init ();
//		var_dump ($url . $endpoint . $data);
		curl_setopt_array ( $curl, [
			CURLOPT_URL => $url . $endpoint . $data,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_TIMEOUT => 200,
			CURLOPT_FOLLOWLOCATION => TRUE,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_SSL_VERIFYHOST => FALSE,
			CURLOPT_SSL_VERIFYSTATUS => FALSE,
		] );
		$response = curl_exec ( $curl );
		curl_close ( $curl );
		return $response;
	}
