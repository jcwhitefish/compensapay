<?php
	
	/**
	 * @property Fiscal_model  $fData
	 * @property Invoice_model $invData
	 */
	class Documentos extends MY_Loggedin {
		public function index (): void {
			$data = [
				'user' => $this->session->userdata ( 'datosUsuario' ),
				'company' => $this->session->userdata ( 'datosEmpresa' ),
				'main' => $this->load->view ( 'documents', '', true ),
			];
			$data = [
				'user' => $this->session->userdata ( 'datosUsuario' ),
				'company' => $this->session->userdata ( 'datosEmpresa' ),
			];
			$data[ 'main' ] = $this->load->view ( 'documents', $data, TRUE );
			$this->load->view ( 'plantilla', $data );
		}
		/**
		 * Esta función obtiene los CFDI (Facturas y Notas de débito) que están ligadas a una operación y a la compañía del usuario que consulta
		 * @return bool
		 */
		public function DocsCFDI (): bool {
			//Se obtienen la fecha mínima y máxima para filtrar las facturas
			$from = strtotime ( $this->input->post ( 'from' ) );
			$to = strtotime ( $this->input->post ( 'to' ) . ' +1 day' );
			//Se verifican que sean fechas válidas
			if ( $from & $to ) {
				//Se carga el modelo de donde se obtendran los datos y se obtiene el id de compañia de la sesión
				$this->load->model ( 'Invoice_model', 'invData' );
				$id = $this->session->userdata ( 'datosEmpresa' )[ "id" ];
				//Se buscan las facturas que coincidan con los criterios enviados
				$res = $this->invData->getDocsCFDI ( $id, $from, $to );
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
		/**
		 * Esta función obtiene los movimientos monetarios en la cuenta de la Fintech ligada a la compañía del usuario que consulta
		 * @return bool
		 */
		public function DocsMovimientos (): bool {
			//Se obtienen la fecha mínima y máxima para filtrar las facturas
			$from = strtotime ( $this->input->post ( 'from' ) );
			$to = strtotime ( $this->input->post ( 'to' ) . ' +1 day' );
			//Se verifican que sean fechas válidas
			if ( $from & $to ) {
				//Se carga el modelo de donde se obtendran los datos y se obtiene el id de compañia de la sesión
				$this->load->model ( 'Invoice_model', 'invData' );
				$id = $this->session->userdata ( 'datosEmpresa' )[ "id" ];
				//Se buscan los movimientos que coincidan con los criterios enviados
				$res = $this->invData->getDocsMovements ( $id, $from, $to );
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
		/**
		 * Esta función obtiene los comprobantes electrónicos de los movimientos en la cuenta de la Fintech
		 * ligada a la compañía del usuario que consulta
		 * @return bool
		 */
		public function DocsCEP (): bool {
			//Se obtienen la fecha mínima y máxima para filtrar las facturas
			$from = strtotime ( $this->input->post ( 'from' ) );
			$to = strtotime ( $this->input->post ( 'to' ) . ' +1 day' );
			//Se verifican que sean fechas válidas
			if ( $from & $to ) {
				//Se carga el modelo de donde se obtendrán los datos y se obtiene el ID de compañía de la sesión
				$this->load->model ( 'Fiscal_model', 'fData' );
				$id = $this->session->userdata ( 'datosEmpresa' )[ "id" ];
				//Se buscan los movimientos que coincidan con los criterios enviados
				$res = $this->fData->getInfoCEP ( $id, $from, $to );
				//Sí encuentra resultados el arreglo lo envía como JSON
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
	}
