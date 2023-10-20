<?php

class Soporte_model extends CI_Model{

	private $link = NULL;
	private ?string $environment;


	private function connect(?string $env = 'SANDBOX')
	{
		if ($this->link && $this->environment == $env) {
			return;
		} else if ($this->link && $this->environment != $env) {
			mysqli_close($this->link);
		}
		$dbhost = $dbuser = $dbpass = $dbtest = $dbprod = '';
		$this->environment = $env;
		include 'Conn.php';
		$this->db = ($env == 'LIVE') ? $dbprod : $dbtest;
		if ($link = mysqli_connect($dbhost, $dbuser, $dbpass)) {
			$this->link = $link;
			$this->link->set_charset('utf8mb4');
		}
	}

	public function __construct(){
		parent::__construct();
		$dbhost = $dbuser = $dbpass = $dbname = '';
		//$dbhostApiLocal = $dbuserApiLocal = $dbpassApiLocal = $dbnameApiLocal = '';
		include 'Conn.php';
		if ($link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
			$this->conn = $link;
			$this->conn->set_charset("utf8");
		} else {
			die('Connect Error (' . mysqli_connect_errno() . ') '
				. mysqli_connect_error());
		}
	}

	public function getModules(){
		$items = [];
		$query = "SELECT tcm_id, tcm_module FROM compensapay.tck_module ORDER BY tcm_id";
		if ($result = mysqli_query($this->conn, $query)) {
			$error = 0;
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$items [$row['tcm_module']]= $row['tcm_id'];

				}
			}
		}
		return $items;
	}

	/**
	 * @param string $arg
	 * @param string|null $env
	 * @return array
	 */
	public function getTopic(int $arg, ?string $env ='SANDBOX'){
		$items = [];
		$query = "SELECT tct_id, tct_topic FROM compensapay.tck_topic WHERE id_module = '{$arg}' order by tct_id";
		//var_dump($query);
		if ($result = mysqli_query($this->conn, $query)) {
			$error = 0;
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$item=[
						'id'        => $row['tct_id'],
						'topic'     => $row['tct_topic'],
					];
					$items[] = $item;
				}
			}
		}
		return $items;
	}

	public function newTicket (array $args, ?string $env = 'SANDBOX'){
		$folio = $args['topic'].str_pad($args['companie'], 5, "0", STR_PAD_LEFT).strtotime("now");
		$query = "INSERT INTO compensapay.tck_ticket (id_topic, id_companie, tck_folio, tck_issue, tck_description, tck_status) 
            VALUES ('{$args['topic']}', '{$args['companie']}', '{$folio}','{$args['issue']}', '{$args['description']}', 
                    '{$args['status']}')";
//        var_dump($query);
		if (mysqli_query($this->conn, $query)){
			$id = $this->conn->insert_id;
			$query = "INSERT INTO compensapay.tck_tracking(id_ticket, tcs_status, tcs_message, tcs_flow) 
				VALUES ('{$id}', 1, '{$args['description']}', 1)";
			if (mysqli_query($this->conn, $query)){
				return ['folio'=>$folio];
			}else{
				return ($this->conn->error);
			}
		}else{
			return ($this->conn->error);
		}
	}
	public function getTicketsFromCompanie(int $companie){
		$tickets = [];
		$query = "SELECT tck_folio, tck_issue, tck_status, tck_description, tck_created_at 
					FROM compensapay.tck_ticket 
					where id_companie = '{$companie}'";
		if ($result = mysqli_query($this->conn, $query)) {
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$items = [
						'folio' => $row['tck_folio'],
						'issue' => $row['tck_issue'],
                        'status' => intval($row['tck_status']),
                        'description' => $row['tck_description'],
                        'date' => date( 'Y-m-d', $row['tck_created_at']),
                    ];
					$tickets[] = $items;
				}
				return $tickets;
			}
		}
		return false;
	}

	public function getTickettraking(int $idTicket){
		$tickets = [];
		$query = "SELECT t1.tcs_status, t1.tcs_message, t1.tcs_flow FROM compensapay.tck_tracking t1 
					inner JOIN compensapay.tck_ticket t2 ON t2.tck_id = t1.id_ticket 
					WHERE t2.tck_folio = '{$idTicket}';";
		if ($result = mysqli_query($this->conn, $query)) {
//			var_dump('hola');
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
//					var_dump($result);
					$items = [
						'status' => intval($row['tcs_status']),
						'message' => $row['tcs_message'],
						'flow' => $row['tcs_flow'],
					];
//					var_dump($items);
					$tickets[] = $items;
				}
				return $tickets;
			}else{
				return ($this->conn->error);
			}
		}
		return false;
	}

	public function getIdTicketByFolio($folio) {
		$query = "SELECT tck_id FROM compensapay.tck_ticket WHERE tck_folio = '{$folio}'";
        if ($result = mysqli_query($this->conn, $query)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $idTicket = $row['tck_id'];
                }
                return $idTicket;
            }
        }
        return false;
	}

	public function newMssUser(array $args,?string $env = 'SANDBOX'){
		$id = $this->getIdTicketByFolio($args['folio']);
		$query = "INSERT INTO compensapay.tck_tracking(id_ticket, tcs_status, tcs_message, tcs_flow) 
				VALUES ('{$id}', 2, '{$args['msg']}', 1)";
		if (mysqli_query($this->conn, $query)){
			$query = "UPDATE compensapay.tck_ticket SET tck_status = 2 WHERE tck_id = '{$id}'";
			if (mysqli_query($this->conn, $query)){
				return $this->getTickettraking($args['folio']);
			}
		}
	}

}
