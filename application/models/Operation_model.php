<?php
	
	/**
	 * Class Operation_model model
	 * @property Operation_model $OpData Operation processing model
	 */
	class Operation_model extends CI_Model {
		private string $enviroment = 'SANDBOX';
		private string $dbsandbox = 'compensatest_base';
//	private string $dbprod = 'compensapay';
		private string $dbprod = 'compensatest_base';
		public string $base = '';
		public function __construct () {
			parent::__construct ();
			$this->load->database ();
			$this->base = $this->enviroment === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		}
		public function get_my_operation ( $user, $tipo ) {
			$this->db->select ( 'o.*, ip.uuid, ip.transaction_date, ic.uuid as uuid_relation,
        companies.short_name, companies.legal_name, ip.id_user, ip.total as money_prov, ic.total as money_clie,
        debit_notes.uuid AS uuid_nota, debit_notes.total as money_nota ' );
			$this->db->from ( 'operations as o' );
			//$this->db->where('id_uploaded_by', $user);
			$this->db->join ( 'debit_notes', 'debit_notes.id = o.id_debit_note', 'left' );
			$this->db->join ( 'invoices as ip', 'ip.id = o.id_invoice', 'left' );
			$this->db->join ( 'invoices as ic', 'ic.id = o.id_invoice_relational', 'left' );
			if ( $tipo == 'P' ) {
				$this->db->join ( 'companies', 'companies.id = o.id_client' );
				$this->db->where ( 'o.id_provider', $user );
			} else {
				$this->db->join ( 'companies', 'companies.id = o.id_provider' );
				$this->db->where ( 'o.id_client', $user );
			}
			$query = $this->db->get ();
			return $query->result ();
		}
		public function get_operation_calendar ( $user, $mes = NULL ) {
			$year = date ( 'Y', time () );
			$mes = $mes === NULL ? date ( 'Y', time () ) : $mes;
			$fechaI = date ( 'Y-m-d', strtotime ( "01-{$mes}-{$year}" ) );
			$fechaF = date ( 'Y-m-t', strtotime ( "01-{$mes}-{$year}" ) );
			//$this->db->select('o.*, ip.uuid, ip.transaction_date, ic.uuid as uuid_relation,
			//c.short_name, c.legal_name, ip.id_user, ip.total as money_prov, ic.total as money_clie,
			//d.uuid AS uuid_nota, d.total as money_nota ');
			$this->db->select ( 'o.*, ip.id AS urlid, ip.uuid AS uuid, ip.transaction_date,
                            ic.id AS urlidrel,ic.uuid as uuid_relation, 
                            c.short_name, c.legal_name, ip.id_user, ip.total as money_prov, ic.total as money_clie,
                            d.id AS urldeb, d.uuid AS uuid_nota, d.total as money_nota ' );
			$this->db->from ( 'operations as o' );
			$this->db->join ( 'debit_notes as d', 'd.id = o.id_debit_note', 'left' );
			$this->db->join ( 'invoices as ip', 'ip.id = o.id_invoice', 'left' );
			$this->db->join ( 'invoices as ic', 'ic.id = o.id_invoice_relational', 'left' );
			$this->db->join ( 'companies as c', 'c.id = o.id_provider' );
			$this->db->where ( "(o.id_provider = $user OR o.id_client = $user)" );
			$this->db->where ( "(o.status = 0 OR o.status = 4)" );
			$this->db->where ( "(ip.transaction_date BETWEEN '$fechaI' AND '$fechaF')" );
			$query = $this->db->get ();
			return $query->result ();
		}
		public function get_operation_by_id ( $id ) {
			$this->db->select ( 'o.*, f.arteria_clabe, c.short_name as name_proveedor, d.uuid as uuid_nota, i.transaction_date, i.uuid AS uuid_factura' );
			$this->db->from ( 'operations as o' );
			$this->db->join ( 'companies as c', 'c.id = o.id_provider' );
			$this->db->join ( 'debit_notes as d', 'd.id = o.id_debit_note' );
			$this->db->join ( 'invoices as i', 'i.id = o.id_invoice' );
			$this->db->join ( 'fintech as f', 'f.companie_id = c.id', 'left' );
			$this->db->where ( 'o.id', $id );
			$query = $this->db->get ();
			return $query->result ();
		}
		public function post_my_invoice ( $xml ) {
			$this->db->insert ( 'operations', $xml );
			return $this->db->insert_id ();
		}
		public function getConciliacionesByCompany ( string $id, int $from, int $to, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->enviroment = $env === NULL ? $this->enviroment : $env;
			$this->base = strtoupper ( $this->enviroment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//se crea la variable url de las facturas para concatenarlo
			$urlF = base_url ( 'assets/factura/factura.php?idfactura=' );
			$urlN = base_url ( 'assets/factura/nota.php?idnota=' );
			//Se crea el query para obtener las facturas
			$query = "SELECT t1.id ,t1.status, t1.operation_number, t2.short_name AS 'receptor', t3.short_name AS 'emisor', t4.uuid AS 'uuid1',
       CONCAT('$urlF', t4.id) AS 'idurl', t3.account_clabe,
       t4.total AS 'total1', DATE_FORMAT(FROM_UNIXTIME(t4.invoice_date), '%d-%m-%Y') AS 'dateCFDI1',
       DATE_FORMAT(FROM_UNIXTIME(t4.payment_date), '%d-%m-%Y') AS 'datePago1',
       (IF(t5.id IS NULL, t6.uuid, t5.uuid)) AS 'uuid2',
       (case WHEN t5.id IS NULL THEN CONCAT('$urlN', t6.id) ELSE CONCAT('$urlF', t5.id) END) AS 'idur2',
       (IF(t5.id IS NULL, t6.total, t5.total)) AS 'total2',
       (IF(t5.id IS NULL, DATE_FORMAT(FROM_UNIXTIME(t6.debitNote_date), '%d-%m-%Y'),
       DATE_FORMAT(FROM_UNIXTIME(t5.invoice_date), '%d-%m-%Y'))) AS 'dateCFDI2',
       DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'datePago',
       (IF(t5.id IS NULL, (SELECT short_name FROM $this->base.companies where rfc= t6.sender_rfc),
       (SELECT short_name FROM $this->base.companies where rfc= t5.sender_rfc))) AS 'senderConciliation',
    	(IF(t5.id IS NULL, (SELECT short_name FROM $this->base.companies where rfc= t6.receiver_rfc),
    	(SELECT short_name FROM $this->base.companies where rfc= t5.receiver_rfc))) AS 'receiverConciliation',
    	DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'conciliationDate', 
    	(IF(t1.id_provider = '$id', 'emisor', 'receptor')) AS 'role',
    	(IF(t5.id IS NULL, 'nota', 'cfdi')) AS 'tipoCFDI'
		FROM $this->base.operations t1 
		    INNER JOIN $this->base.companies t2 ON t2.id = t1.id_client 
		    INNER JOIN $this->base.companies t3 ON t3.id = t1.id_provider 
		    INNER JOIN $this->base.invoices t4 ON t1.id_invoice = t4.id
		    LEFT JOIN $this->base.invoices t5 ON t1.id_invoice_relational = t5.id
		    LEFT JOIN $this->base.debit_notes t6 ON t1.id_debit_note = t6.id
		WHERE (t1.id_client = $id OR t1.id_provider = $id) 
		  AND t1.created_at >= '$from' AND t1.created_at <= '$to'
		ORDER BY t1.created_at DESC";
			//Se verífica que la consulta se ejecute bien
			if ( $res = $this->db->query ( $query ) ) {
				//se verífica que haya información
				if ( $res->num_rows () > 0 ) {
					//si no hay datos de notas de debito solo se envian las facturas
					return [ "code" => 200, "result" => $res->result_array () ];
				} else {
					//En caso de que no hay informacion lo notifica para que se ingrese otro valor de busqueda
					return [ "code" => 404, "message" => "No se encontraron registros",
						"reason" => "No hay resultados con los criterios de búsqueda utilizados" ];
				}
			}
			//En caso de error igual notifica
			return [ "code" => 500, "message" => "Error al extraer la información", "reason" => "Error con la fuente de información" ];
		}
		/**
		 * Función para obtener los datos de una operación de conciliación
		 *
		 * @param string      $id
		 * @param string|null $env
		 *
		 * @return array
		 */
		public function getConciliacionesByID ( string $id, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->enviroment = $env === NULL ? $this->enviroment : $env;
			$this->base = strtoupper ( $this->enviroment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//se crea la variable url de las facturas para concatenarlo
			$url = base_url ( 'assets/factura/factura.php?idfactura=' );
			//Se crea el query para obtener las facturas
			$query = "SELECT t1.id ,t1.status, t1.operation_number, t2.short_name AS 'receptor', t3.short_name AS 'emisor', t4.uuid AS 'uuid1',
       CONCAT('$url', t4.id) AS 'idurl', t3.account_clabe, t7.arteria_clabe, 
       t4.total AS 'total1', DATE_FORMAT(FROM_UNIXTIME(t4.invoice_date), '%d-%m-%Y') AS 'dateCFDI1', 
       (case WHEN t5.id IS NULL THEN t6.uuid ELSE t5.uuid END) AS 'uuid2',
       (case WHEN t5.id IS NULL THEN CONCAT('$url', t6.id) ELSE CONCAT('$url', t5.id) END) AS 'idur2', 
       (case WHEN t5.id IS NULL THEN t6.total ELSE t5.total END) AS 'total2', 
       (case WHEN t5.id IS NULL 
           THEN DATE_FORMAT(FROM_UNIXTIME(t6.debitNote_date), '%d-%m-%Y') 
           ELSE DATE_FORMAT(FROM_UNIXTIME(t5.invoice_date), '%d-%m-%Y') END) AS 'dateCFDI2', 
    	DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'datePago', 
    	DATE_FORMAT(FROM_UNIXTIME(t1.payment_date), '%d-%m-%Y') AS 'conciliationDate', 
    	(CASE WHEN t1.id_provider = '$id' THEN 'emisor' ELSE 'receptor' END) AS 'role',
    	t3.id as 'idEmisor', t2.id as 'idReceptor'
		FROM $this->base.operations t1 
		    INNER JOIN $this->base.companies t2 ON t2.id = t1.id_client 
		    INNER JOIN $this->base.companies t3 ON t3.id = t1.id_provider 
		    INNER JOIN $this->base.invoices t4 ON t1.id_invoice = t4.id
		    LEFT JOIN $this->base.invoices t5 ON t1.id_invoice_relational = t5.id
		    LEFT JOIN $this->base.debit_notes t6 ON t1.id_debit_note = t6.id
			INNER JOIN $this->base.fintech t7 ON t7.companie_id = t3.id
		WHERE (t1.id = $id)";
			//Se verífica que la consulta se ejecute bien
			if ( $res = $this->db->query ( $query ) ) {
				//se verífica que haya información
				if ( $res->num_rows () > 0 ) {
					//si no hay datos de notas de debito solo se envían las facturas
					return [ "code" => 200, "result" => $res->result_array ()[ 0 ] ];
				} else {
					//En caso de que no hay información lo notifica para que se ingrese otro valor de búsqueda
					return [ "code" => 404, "message" => "No se encontraron registros",
						"reason" => "No hay resultados con los criterios de búsqueda utilizados" ];
				}
			}
			//En caso de error igual notifica
			return [ "code" => 500, "message" => "Error al extraer la información", "reason" => "Error con la fuente de información" ];
		}
		/**
		 * Función para aceptar una conciliación
		 *
		 * @param int         $id        ID de la conciliación que es aceptada
		 * @param int         $idCompany ID de la compañía que realiza el proceso
		 * @param string|NULL $env       Ambiente en el que se va a trabajar
		 *
		 * @return array Resultado de la operación
		 */
		public function acceptConciliation ( int $id, string $payDate, int $idCompany, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->enviroment = $env === NULL ? $this->enviroment : $env;
			$this->base = strtoupper ( $this->enviroment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$payDate = strtotime ( $payDate );
			//Creamos el query para actualizar la }}BD
			$query = "UPDATE $this->base.operations SET status = 1, payment_date = '$payDate' WHERE id = '$id'";
			//Sé verífica que la consulta se ejecute bien
			if ( $res = $this->db->query ( $query ) ) {
				//Sé verífica que haya una actualización
				if ( $this->db->affected_rows () > 0 ) {
					//Devolvemos que la operación se realizo con éxito
					return [ "code" => 200, "result" => $this->db->affected_rows () ];
				}
				//Devolvemos que no hubo una actualización
				return [ "code" => 500, "message" => "Error al actualizar la conciliación", "reason" => "No se realizo ninguna actualización" ];
			}
			//Devolvemos el error de la operación
			return [ "code" => 500, "message" => "Error al actualizar la conciliación", "reason" => "Error de comunicación" ];
		}
		/**
		 * Función para rechazar una conciliación
		 *
		 * @param int         $id        ID de la conciliación que es aceptada
		 * @param int         $idCompany ID de la compañía que realiza el proceso
		 * @param string|NULL $env       Ambiente en el que se va a trabajar
		 *
		 * @return array Resultado de la operación
		 */
		public function rejectConciliation ( int $id, string $comment, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->enviroment = $env === NULL ? $this->enviroment : $env;
			$this->base = strtoupper ( $this->enviroment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//Obtenemos los ID de los CFDI involucrados en la conciliación
			$cfdi = $this->getCFDIFromConciliation ( $id, $env );
			//Creamos el query para obtener los id de los CFDI
			$query = "UPDATE compensatest_base.operations SET status = 2, operations.commentary = '$comment' WHERE id = '$id'";
			//Sé verífica que la consulta se ejecute bien
			if ( $this->db->query ( $query ) && $this->db->affected_rows () > 0 ) {
				//Validamos que tipo de camino se va a seguir
				if ( $cfdi[ 'res' ][ 'tipo' ] === 'nota' ) {
					$query = "UPDATE compensatest_base.invoices SET status = 0 WHERE id = '$id'";
					//Sé verífica que haya una actualización
					if ( $this->db->query ( $query ) && $this->db->affected_rows () > 0 ) {
						$query = "UPDATE compensatest_base.debit_notes SET status = 4 WHERE id = '{$cfdi['res']['id2']}'";
						if ( $this->db->query ( $query ) && $this->db->affected_rows () > 0 ) {
							//Sé verífica que haya una actualización
							return [
								'code' => 200,
								'message' => 'Conciliación rechazada!',
								'reason' => 'Se enviará notificacion a tu socio comercial. ' ];
						}
					}
				} else {
					$query = "UPDATE compensatest_base.invoices SET status = 0 WHERE id IN ('$id', '{$cfdi['res']['id']}' )";
					if ( $this->db->query ( $query ) ) {
						//Sé verífica que haya una actualización
						if ( $this->db->affected_rows () > 1 ) {
							return [
								'code' => 200,
								'message' => 'Conciliación rechazada!',
								'reason' => 'Se enviará notificacion a tu socio comercial. ' ];
						}
					}
					//Devolvemos que la operación se realizo con éxito
					return [ "code" => 200, "result" => $this->db->affected_rows () ];
				}
			}
			//Devolvemos que no hubo una actualización
			return [ "code" => 500, "message" => "Error al actualizar la conciliación", "reason" => "No se realizo ninguna actualización" ];
		}
		public function getCFDIFromConciliation ( int $id, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->enviroment = $env === NULL ? $this->enviroment : $env;
			$this->base = strtoupper ( $this->enviroment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//Creamos el query para obtener los id de los CFDI
			$query = "SELECT t2.id, (IF(t3.id IS NULL, t4.id, t3.id)) AS 'id2', (IF(t3.id IS NULL, 'nota', 'cfdi')) AS 'tipo'
FROM $this->base.operations t1
	INNER JOIN $this->base.invoices t2 ON t2.id = t1.id_invoice
	LEFT JOIN $this->base.invoices t3 ON t3.id = t1.id_invoice_relational
	LEFT JOIN $this->base.debit_notes t4 ON t4.id =id_debit_note";
			if ( $res = $this->db->query ( $query ) ) {
				if ( $res->num_rows () ) {
					return [ 'code' => 200, 'res' =>$res->result_array ()[ 0 ] ];
				}
				return [ 'code' => 404, 'message' => 'No se encontraron resultados', 'reason' => 'No se encontraron resultados para el id ingresado' ];
			}
			return [ 'code' => 500, 'message' => 'Error', 'reason' => 'Error de conexion' ];
		}
		public function newConciliation_E ( array $args, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->enviroment = $env === NULL ? $this->enviroment : $env;
			$this->base = strtoupper ( $this->enviroment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//Query para insertar la nueva conciliacion
			$query = "INSERT INTO $this->base.operations (id_invoice, id_debit_note, id_uploaded_by, id_client, id_provider, operation_number, payment_date, entry_money, exit_money, status)
VALUES ('{$args['invoiceId']}','{$args['noteId']}','{$args['userId']}','{$args['receiver']}','{$args['provider']}','{$args['opNumber']}','{$args['paymentDate']}','{$args['inCash']}','{$args['outCash']}','0')";
			if ( !@$this->db->query ( $query ) ) {
				return [ "code" => 500, "message" => "Error al guardar información", "reason" => $this->db->error() ];
				// do something in error case
			} else {
				$res = [
					"code" => 200,
					"message" => 'Conciliacion creada correctamente, espere por la autorizacion de la compania receptora',
					'id' => $this->db->insert_id () ];
				$this->acceptCFDI ( $args[ 'invoiceId' ], $env );
				$this->acceptNote ( $args[ 'noteId' ], $env );
				return $res;
				// do something in success case
			}
			return [ "code" => 500, "message" => "Error al actualizar la conciliación", "reason" => "Error de comunicación" ];
		}
		public function newConciliation_I ( array $args, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->enviroment = $env === NULL ? $this->enviroment : $env;
			$this->base = strtoupper ( $this->enviroment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			//Query para insertar la nueva conciliacion
			$query = "INSERT INTO $this->base.operations (id_invoice, id_invoice_relational, id_uploaded_by, id_client,
                                          id_provider, operation_number, payment_date, entry_money, exit_money, status)
VALUES ('{$args['invoiceId']}','{$args['invoiceRelId']}','{$args['userId']}','{$args['receiver']}', 
        '{$args['provider']}','{$args['opNumber']}','{$args['paymentDate']}','{$args['inCash']}','{$args['outCash']}','1')";
			if ( !@$this->db->query ( $query ) ) {
				return [ "code" => 500, "message" => "Error al guardar información", "reason" => "CFDI duplicado" ];
			} else {
				$res = [
					"code" => 200,
					"message" => 'Conciliación creada correctamente,',
					'id' => $this->db->insert_id () ];
				$this->acceptCFDI ( $args[ 'invoiceId' ], $env );
				$this->acceptCFDI ( $args[ 'invoiceRelId' ], $env );
				return $res;
				// do something in success case
			}
			return [ "code" => 500, "message" => "Error al actualizar la conciliación", "reason" => "Error de comunicación" ];
		}
		public function getConciliationByID ( int $id, string $env = NULL ) {
			//Se declara el ambiente a utilizar
			$this->enviroment = $env === NULL ? $this->enviroment : $env;
			$this->base = strtoupper ( $this->enviroment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "SELECT * FROM $this->base.operations WHERE id = '$id'";
			if ( $res = $this->db->query ( $query ) ) {
				if ( $res->num_rows () > 0 ) {
					return $res->result_array ();
				}
			}
			return [ 'code' => 500, 'message' => 'No se pudo obtener la información', 'reason' => 'Error con la fuente de información' ];
		}
		public function acceptCFDI ( int $id, string $env = NULL ) {
			
			$this->enviroment = $env === NULL ? $this->enviroment : $env;
			$this->base = strtoupper ( $this->enviroment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "UPDATE $this->base.invoices set status=1 WHERE id = '$id'";
			if ( $res = $this->db->query ( $query ) ) {
				return $res;
			}
			return FALSE;
		}
		public function acceptNote ( int $id, string $env ) {
			$this->enviroment = $env === NULL ? $this->enviroment : $env;
			$this->base = strtoupper ( $this->enviroment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "UPDATE $this->base.debit_notes set status=1 WHERE id = '$id'";
			if ( $res = $this->db->query ( $query ) ) {
				return $res;
			}
			return FALSE;
		}
	}
