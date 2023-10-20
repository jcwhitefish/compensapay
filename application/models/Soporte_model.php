<?php

class Soporte_model extends CI_Model{

	private $link = NULL;
	private ?string $environment;
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function getModules(){
		$items = [];
		$query = "SELECT tcm_id, tcm_module FROM compensapay.tck_module ORDER BY tcm_id";
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0)
				foreach ($result->result_array() as $row){
					$items [$row['tcm_module']]= $row['tcm_id'];
			}
		}else{
			return false;
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
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0) {
				foreach ($result->result_array() as $row){
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
		if ($result = $this->db->query($query)){
			$id = $this->db->insert_id();
			$query = "INSERT INTO compensapay.tck_tracking(id_ticket, tcs_status, tcs_message, tcs_flow) 
				VALUES ('{$id}', 1, '{$args['description']}', 1)";
			if ($this->db->query($query)){
				return ['folio'=>$folio];
			}else{
				return ($result->error());
			}
		}else{
			return ($result->error());
		}
	}

	public function getTicketsFromCompanie(int $companie){
		$tickets = [];
		$query = "SELECT tck_folio, tck_issue, tck_status, tck_description, tck_created_at 
					FROM compensapay.tck_ticket 
					where id_companie = '{$companie}'";
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0) {
				foreach ($result->result_array() as $row){
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
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0) {
				foreach ($result->result_array() as $row){
					$items = [
						'status' => intval($row['tcs_status']),
						'message' => $row['tcs_message'],
						'flow' => $row['tcs_flow'],
					];
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
        if ($result = $this->db->query($query)) {
            if ($result->num_rows() > 0) {
				foreach ($result->result_array() as $row){
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
		if ($this->db->query($query)){
			$query = "UPDATE compensapay.tck_ticket SET tck_status = 2 WHERE tck_id = '{$id}'";
			if ($this->db->query($query)){
				return $this->getTickettraking($args['folio']);
			}
		}
	}

}
