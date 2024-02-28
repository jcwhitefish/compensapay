<?php
	/**
	 * Class Notification_model model
	 * @property Conciliation_model $dataConc Conciliation module
	 */
	class Conciliation_model extends CI_Model {
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
		public function extracGroups ( string $env = NULL ) {
			//Se declara el ambiente a utilizar
			$this->environment = $env === NULL ? $this->environment : $env;
			$this->base = strtoupper ( $this->environment ) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
			$query = "SELECT t1.sender_rfc AS sender, t1.receiver_rfc AS receiver, w.W, s.S,
       (IF(w.W > s.S, w.W - s.S, s.S - w.W)) AS difference,
       (IF(w.W > s.S, 'Favor', 'Contra')) AS saldo
FROM (SELECT sender_rfc, receiver_rfc
      FROM $this->base.invoices_white
      GROUP BY sender_rfc, receiver_rfc) AS t1
	LEFT JOIN (SELECT sender_rfc, receiver_rfc, SUM(total) AS W
	           FROM $this->base.invoices_white
	           GROUP BY sender_rfc, receiver_rfc) AS w
		ON t1.sender_rfc = w.sender_rfc AND t1.receiver_rfc = w.receiver_rfc
	LEFT JOIN (SELECT sender_rfc, receiver_rfc, SUM(total) AS S
	           FROM $this->base.invoices_white
	           GROUP BY sender_rfc, receiver_rfc) AS s
		ON t1.sender_rfc = s.receiver_rfc AND t1.receiver_rfc = s.sender_rfc;";
			$this->db->db_debug = FALSE;
			if ( $res = $this->db->query ( $query ) ) {
				$res = $res->result_array ();
				$res['test'] = date('Y-m-d H:i:s',strtotime('now'));
				return $res;
			}
		}
	}
