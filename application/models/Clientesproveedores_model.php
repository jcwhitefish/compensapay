<?php 
class Clientesproveedores_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function clientes(){

        $idCompanie = $this->session->userdata('datosEmpresa')['id'];

        //$queryc = "SELECT * FROM clientprovider AS c 
        //            INNER JOIN companies AS com ON c.client_id=com.id 
        //            INNER JOIN cat_zipcode AS cp ON com.id_postal_code=cp.zip_id 
        //            WHERE provider_id='".$idCompanie."' 
        //            ORDER BY com.legal_name;";
        $queryc = "SELECT * FROM companies AS c 
                    INNER JOIN cat_zipcode AS cp on c.id_postal_code = cp.zip_id
                    WHERE c.id IN 
                    (SELECT emp.empresa AS empresa FROM 
                        (SELECT client_id AS empresa FROM `clientprovider` WHERE provider_id = 1 
                        UNION ALL SELECT provider_id AS empresa FROM clientprovider WHERE client_id = 1) AS emp 
                        GROUP BY empresa)";


        if ($result = $this->db->query($queryc)) {
			if ($result->num_rows() > 0){
                $resultc = $result->result_array();
            }
            else {
                $resultc = '';
            }
		}


        $rescp = array (
            "clientes" => $resultc
        );

		return $rescp;
    }

    //public function get_cp(int $id) {
	//	
    //    $clipro = array();
//
	//	$queryc = "SELECT * FROM clientprovider WHERE provider_id = '{$id}'";
	//	if ($resultc = $this->db->query($queryc)) {
	//		if ($resultc->num_rows() > 0) {
	//			$clientes = $resultc->result_array();
	//		}
	//	}
//
    //    array_push($clipro, $clientes);
//
    //    $queryp = "SELECT * FROM clientprovider ORDER BY client_id = '{$id}'";
    //    if ($resultp = $this->db->query($queryp)) {
	//		if ($resultp->num_rows() > 0) {
	//			$provedores = $resultp->result_array();
	//		}
	//	}
//
    //    array_push($clipro, $provedores);
    //    
    //    return $clipro;
	//}
}