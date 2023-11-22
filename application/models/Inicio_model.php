<?php
class Inicio_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function dashboard() {

        $idCompanie = $this->session->userdata('datosEmpresa')['id'];
        $rfcEmpresa = $this->session->userdata('datosEmpresa')["rfc"];

        //total de operaciones
        $querytop = "SELECT COUNT(id) AS TotOper FROM operations WHERE id_client = ".$idCompanie." OR id_provider = ".$idCompanie." LIMIT 1";

        if ($restop = $this->db->query($querytop)) {
			if ($restop->num_rows() > 0){
                $rrestop = $restop->result_array();
            }
            else {
                $rrestop = '0';
            }
		}

        //total por cobrar
        $querytpc = "SELECT SUM(total) AS TTotal FROM invoices WHERE id_company=".$idCompanie." AND status=1";
        $querytpc2 = "SELECT SUM(dn.total) AS TTotal FROM debit_notes AS dn
                        INNER JOIN invoices AS i ON dn.id_invoice = i.id
                        WHERE i.id_company=".$idCompanie."";

        if($restpc = $this->db->query($querytpc))
        {
            if($restpc->num_rows() > 0){
                $rrestpc = $restpc->result_array();
            }else
            {
                $rrestpc = 0;
            }
        }
        if($restpc2 = $this->db->query($querytpc2))
        {
            if($restpc2->num_rows() > 0){
                $rrestpc2 = $restpc2->result_array();
            }else
            {
                $rrestpc2 = 0;
            }
        }

        //total por pagar
        $Qtpp = "SELECT SUM(total) AS TTotal FROM invoices WHERE receiver_rfc = '".$rfcEmpresa."'"; 
        $Qtpp2 = "SELECT SUM(dn.total) AS TTotal FROM debit_notes AS dn
                        INNER JOIN invoices AS i ON dn.id_invoice = i.id
                        WHERE i.receiver_rfc = '".$rfcEmpresa."'";
        
        if($restpp = $this->db->query($Qtpp))
        {
            if($restpp->num_rows() > 0){
                $rrestpp = $restpp->result_array();
            }else
            {
                $rrestpp = 0;
            }
        }
        if($restpp2 = $this->db->query($Qtpp2))
        {
            if($restpp2->num_rows() > 0){
                $rrestpp2 = $restpp2->result_array();
            }else
            {
                $rrestpp2 = 0;
            }
        }

        //filtro proveedores
        $Qprov = "SELECT com.id AS Id, com.legal_name AS Proveedor FROM clientprovider AS c
                    INNER JOIN companies AS com On c.provider_id=com.id
                    INNER JOIN cat_zipcode AS cp on com.id_postal_code=cp.zip_id 
                    WHERE client_id='".$idCompanie."' 
                    ORDER BY com.legal_name;";

        if($resprov = $this->db->query($Qprov)) {
            if($resprov->num_rows() > 0){
                $rresprov = $resprov->result_array();
            }
            else{
                $rresprov = '';
            }
        }

        $ResDash = array (
            "TotalOperaciones" => $rrestop,
            "TotalPorCobrar" => array(
                "facturas" => $rrestpc,
                "notas" => $rrestpc2
            ),
            "TotalPorPagar" => array(
                "facturas" => $rrestpp,
                "notas" => $rrestpp2
            ),
            "Proveedores" => $rresprov
        );

		return $ResDash;

    }
}