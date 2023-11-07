<?php 
class Clientesproveedores_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_cp(int $id) {
		
        $clipro = array();

		$queryc = "SELECT * FROM clientprovider WHERE provider_id = '{$id}'";
		if ($resultc = $this->db->query($queryc)) {
			if ($resultc->num_rows() > 0) {
				$clientes = $resultc->result_array();
			}
		}

        array_push($clipro, $clientes);

        $queryp = "SELECT * FROM clientprovider ORDER BY client_id = '{$id}'";
        if ($resultp = $this->db->query($queryp)) {
			if ($resultp->num_rows() > 0) {
				$provedores = $resultp->result_array();
			}
		}

        array_push($clipro, $provedores);
        
        return $clipro;
	}
}