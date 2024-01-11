<?php 
class Reportes_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function reportes(){

        $idCompanie = $this->session->userdata('datosEmpresa')['id'];

        $ResRep  = "SELECT cp.provider_id, cp.client_id, c.id, c.legal_name, c.short_name, COUNT(o.id) AS operaciones, 
                    (SELECT COUNT(Id) FROM operations WHERE id_client = ".$idCompanie." OR id_provider = ".$idCompanie." AND status = 3) AS realizadas, 
                    (SELECT COUNT(Id) FROM operations WHERE id_client = ".$idCompanie." OR id_provider = ".$idCompanie." AND status = 2) AS canceladas, 
                    (SELECT COUNT(Id) FROM operations WHERE id_client = ".$idCompanie." OR id_provider = ".$idCompanie." AND status = 0) AS pendientes, 
                    (SELECT COUNT(Id) FROM operations WHERE id_client = ".$idCompanie." OR id_provider = ".$idCompanie." AND status = 1) AS autorizadas, 
                    (SELECT created_at FROM operations WHERE id_client = ".$idCompanie." OR id_provider = ".$idCompanie." ORDER BY created_at LIMIT 1) AS ultimaoperacion, 
                    (SELECT SUM(entry_money) FROM operations WHERE id_client = ".$idCompanie." OR id_provider = cp.provider_id ORDER BY created_at LIMIT 1) AS ingresos, 
                    (SELECT SUM(exit_money) FROM operations WHERE id_client = ".$idCompanie." OR id_provider = cp.provider_id ORDER BY created_at LIMIT 1) AS egresos 
                    FROM clientprovider  AS cp 
                    INNER JOIN companies AS c ON c.id = cp.client_id OR c.id = cp.provider_id 
                    INNER JOIN operations AS o ON c.id = o.id_client OR c.id = o.id_provider
                    WHERE (cp.client_id = ".$idCompanie."  OR cp.provider_id = ".$idCompanie.") AND c.id != ".$idCompanie." 
                    GROUP BY c.id ORDER BY c.legal_name ASC";

        if ($RResRep = $this->db->query($ResRep)) {
            if ($RResRep->num_rows() > 0){
                $RRResRep = $RResRep->result_array();
            }
            else {
                $RRResRep = '';
            }
        }

        $reporte = array (
            "reporte" => $RRResRep, 
        );

        return $reporte;
    }
}