<?php
	
	/**
	 * Class Settings model
	 * @property Settings_model $conf Settings module
	 */
	class Settings_model extends \CI_Model {
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
		/**
		 * @param             $id
		 * @param string|null $env
		 *
		 * @return mixed
		 */
		public function getNotificationsSettings ( $id, string $env = NULL ): mixed {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "SELECT * FROM compensatest_base.conf_notifications WHERE user_id = '{$id}'";
			if ( $result = $this->db->query ( $query ) ) {
				if ( $result->num_rows () > 0 ) {
					return $result->result_array ();
				}
			}
			return FALSE;
		}
		/**
		 * Función para actualizar la configuración de las notificaciones
		 *
		 * @param array  $args array con la configuración de las notificaciones
		 * @param string $id   id del usuario que está actualizando la configuración
		 * @param string $env  Environment
		 *
		 * @return array
		 */
		public function updateNotifications ( array $args, string $id, string $env = NULL ): array {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$this->db->where ( 'user_id', $id );
			$this->db->update ( 'conf_notifications', $args );
			$n = $this->db->affected_rows ();
			if ( $n >= 1 ) {
				$update[ 0 ] = $n > 1 ? 'actualizaron' : 'actualizó';
				$update[ 1 ] = $n > 1 ? 'configuraciones' : 'configuración';
				return [ 'message' => "Se $update[0] $n $update[1]" ];
			} else {
				return [ 'message' => "No hay cambios en la configuración" ];
			}
		}
		public function validateNotification ( int $user, int $notification, string $env = NULL ): bool {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$columns = [ 'nt_OperationNew', 'nt_OperationApproved', 'nt_OperationStatus', 'nt_OperationPaid', 'nt_OperationExternalAccount',
				'nt_OperationReturn', 'nt_OperationReject', 'nt_OperationDate', 'nt_OperationInvoiceNew', 'nt_OperationInvoiceRequest',
				'nt_DocumentStatementReady', 'nt_InviteNew', 'nt_InviteStatus', 'nt_SupportTicketStatus', 'nt_SupportReply' ];
			$query = "SELECT $columns[$notification] FROM $this->base.conf_notifications WHERE user_id = '$user'";
			if ( $result = $this->db->query ( $query ) ) {
				if ( $result->num_rows () > 0 ) {
					$result = $result->result_array ();
					$not = '';
					foreach ( $result as $res ) {
						$not = intval ( $res[ $columns[ $notification ] ] );
					}
					if ( $not === 1 ) {
						return TRUE;
					} else {
						return FALSE;
					}
				}
			}
			return FALSE;
		}
	}
