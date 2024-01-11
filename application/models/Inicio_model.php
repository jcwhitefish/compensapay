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
                    INNER JOIN operations AS o ON dn.id = o.id_debit_note
                    WHERE dn.sender_rfc = '".$rfcEmpresa."' AND o.status = 1";
        
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

        //Operaciones mensuales
        $ResOperMes = "SELECT 0.id FROM operations AS o 
                        INNER JOIN balance AS b ON o.operation_number = b.operationNumber
                        WHERE (o.id_client = ".$idCompanie." OR o.id_provider = ".$idCompanie.") 
                        AND b.created_at >= '".strtotime(date('Y-m').'-01 00:00:00')."' AND b.created_at <= '".strtotime(date("Y-m-d").'-31 23:59:59')."' 
                        LIMIT 1";

        if($resOperMes = $this->db->query($ResOperMes)){
            $NumResOperMes = $resOperMes->num_rows();
        }

        //ingresos mes
        $ResIngMesP = "SELECT SUM(b.amount) AS ingreso 
                        FROM balance b INNER JOIN operations o ON b.operationNumber = o.operation_number 
                        INNER JOIN companies c ON o.id_provider = c.id 
                        INNER JOIN fintech f ON f.companie_id = c.id 
                        WHERE c.id = ".$idCompanie." AND b.receiver_clabe = f.arteria_clabe
                        AND b.created_at >= '".strtotime(date('Y-m').'-01 00:00:00')."' AND b.created_at <= '".strtotime(date("Y-m-d").'-31 23:59:59')."'";

        $ResIngMesC = "SELECT b.amount AS ingreso 
                        FROM balance b INNER JOIN operations o ON b.operationNumber = o.operation_number 
                        INNER JOIN companies c ON o.id_provider = c.id 
                        INNER JOIN fintech f ON f.companie_id = c.id 
                        WHERE o.id_client = ".$idCompanie." AND b.receiver_clabe != f.arteria_clabe AND b.receiver_clabe != c.account_clabe 
                        AND b.created_at >= '".strtotime(date('Y-m').'-01 00:00:00')."' AND b.created_at <= '".strtotime(date("Y-m-d").'-31 23:59:59')."'";

        $RRResIngMesP= 0; $RRResIngMesC = 0;

        if($RResIngMesP = $this->db->query($ResIngMesP)) {
            if($RResIngMesP->num_rows() > 0){
                foreach ($RResIngMesP->result_array() as $row){
                    $RRResIngMesP =$RRResIngMesP + $row["ingreso"];
                }
            }
        }

        if($RResIngMesC = $this->db->query($ResIngMesC)) {
            if($RResIngMesC->num_rows() > 0){
                foreach($RResIngMesC->result_array() as $row){
                    $RRResIngMesC = $RRResIngMesC + $row["ingreso"];
                }
            }
        }

        $IngresosMes = $RRResIngMesP + $RRResIngMesC;

        //total egresos mes
        $ResEgrMesP = "SELECT SUM(b.amount) AS egreso 
                        FROM balance b 
                        INNER JOIN operations o ON b.operationNumber = o.operation_number 
                        INNER JOIN companies c ON o.id_provider = c.id 
                        INNER JOIN fintech f ON f.companie_id = c.id 
                        WHERE c.id = ".$idCompanie." AND (b.receiver_clabe = f.arteria_clabe OR b.receiver_clabe = c.account_clabe)
                        AND b.created_at >= '".strtotime(date('Y-m').'-01 00:00:00')."' AND b.created_at <= '".strtotime(date("Y-m-d").'-31 23:59:59')."'";

        $ResEgrMesC = "SELECT SUM(b.amount) AS egreso
                        FROM balance b
                        INNER JOIN operations o ON b.operationNumber = o.operation_number
                        INNER JOIN companies c ON o.id_provider = c.id
                        INNER JOIN fintech f ON f.companie_id = c.id
                        WHERE o.id_client = ".$idCompanie." AND b.source_clabe != f.arteria_clabe AND  b.source_clabe != c.account_clabe
                        AND b.created_at >= '".strtotime(date('Y-m').'-01 00:00:00')."' AND b.created_at <= '".strtotime(date("Y-m-d").'-31 23:59:59')."'";

        $RRResEgrMesP= 0; $RRResEgrMesC = 0;
            
        if($RResEgrMesP = $this->db->query($ResEgrMesP)) {
            if($RResEgrMesP->num_rows() > 0){
                foreach ($RResEgrMesP->result_array() as $row){
                    $RRResEgrMesP =$RRResEgrMesP + $row["egreso"];
                }
            }
        }
        
        if($RResEgrMesC = $this->db->query($ResEgrMesC)) {
            if($RResEgrMesC->num_rows() > 0){
                foreach($RResEgrMesC->result_array() as $row){
                    $RRResEgrMesC = $RRResEgrMesC + $row["egreso"];
                }
            }
        }

        $EgresosMes = $RRResEgrMesP + $RRResEgrMesC;

        //datos grafica ingreso y egreso
        $fecha_actual=date("Y-m").'-01';
        $datai=''; $dataf=''; $dmes='';
        for($j=6; $j>=0; $j--)
        {
            $date = date("Y-m-d",strtotime($fecha_actual."- ".$j." months"));
        
            $fecha = new DateTime($date);
            $fecha->modify('first day of this month');
            $fechai = $fecha->format('Y-m-d'); 
        
            $fecha2 = new DateTime($date);
            $fecha2->modify('last day of this month');
            $fechaf = $fecha2->format('Y-m-d'); 

            $ResIngMesP = "SELECT SUM(b.amount) AS ingreso 
                        FROM balance b INNER JOIN operations o ON b.operationNumber = o.operation_number 
                        INNER JOIN companies c ON o.id_provider = c.id 
                        INNER JOIN fintech f ON f.companie_id = c.id 
                        WHERE c.id = ".$idCompanie." AND b.receiver_clabe = f.arteria_clabe
                        AND b.created_at >= '".strtotime($fechai)."' AND b.created_at <= '".strtotime($fechaf)."'";

            $ResIngMesC = "SELECT b.amount AS ingreso 
                            FROM balance b INNER JOIN operations o ON b.operationNumber = o.operation_number 
                            INNER JOIN companies c ON o.id_provider = c.id 
                            INNER JOIN fintech f ON f.companie_id = c.id 
                            WHERE o.id_client = ".$idCompanie." AND b.receiver_clabe != f.arteria_clabe AND b.receiver_clabe != c.account_clabe 
                            AND b.created_at >= '".strtotime($fechai)."' AND b.created_at <= '".strtotime($fechaf)."'";

            $RRResIngMesP= 0; $RRResIngMesC = 0;

            if($RResIngMesP = $this->db->query($ResIngMesP)) {
                if($RResIngMesP->num_rows() > 0){
                    foreach ($RResIngMesP->result_array() as $row){
                        $RRResIngMesP =$RRResIngMesP + $row["ingreso"];
                    }
                }
            }

            if($RResIngMesC = $this->db->query($ResIngMesC)) {
                if($RResIngMesC->num_rows() > 0){
                    foreach($RResIngMesC->result_array() as $row){
                        $RRResIngMesC = $RRResIngMesC + $row["ingreso"];
                    }
                }
            }

            $ResEgrMesP = "SELECT SUM(b.amount) AS egreso 
                        FROM balance b 
                        INNER JOIN operations o ON b.operationNumber = o.operation_number 
                        INNER JOIN companies c ON o.id_provider = c.id 
                        INNER JOIN fintech f ON f.companie_id = c.id 
                        WHERE c.id = ".$idCompanie." AND (b.receiver_clabe = f.arteria_clabe OR b.receiver_clabe = c.account_clabe)
                        AND b.created_at >= '".strtotime($fechai)."' AND b.created_at <= '".strtotime($fechaf)."'";

            $ResEgrMesC = "SELECT SUM(b.amount) AS egreso
                            FROM balance b
                            INNER JOIN operations o ON b.operationNumber = o.operation_number
                            INNER JOIN companies c ON o.id_provider = c.id
                            INNER JOIN fintech f ON f.companie_id = c.id
                            WHERE o.id_client = ".$idCompanie." AND b.source_clabe != f.arteria_clabe AND  b.source_clabe != c.account_clabe
                            AND b.created_at >= '".strtotime($fechai)."' AND b.created_at <= '".strtotime($fechaf)."'";

            $RRResEgrMesP= 0; $RRResEgrMesC = 0;

            if($RResEgrMesP = $this->db->query($ResEgrMesP)) {
                if($RResEgrMesP->num_rows() > 0){
                    foreach ($RResEgrMesP->result_array() as $row){
                        $RRResEgrMesP =$RRResEgrMesP + $row["egreso"];
                    }
                }
            }
            
            if($RResEgrMesC = $this->db->query($ResEgrMesC)) {
                if($RResEgrMesC->num_rows() > 0){
                    foreach($RResEgrMesC->result_array() as $row){
                        $RRResEgrMesC = $RRResEgrMesC + $row["egreso"];
                    }
                }
            }

            $datai.=''.($RRResIngMesP + $RRResIngMesC).''; if($j>0){$datai.=', ';}
            $dataf.=''.($RRResEgrMesC + $RRResEgrMesP).''; if($j>0){$dataf.=', ';}

            switch($date[5].$date[6])
            {
                case '01': $mes='Ene'; break;
                case '02': $mes='Feb'; break;
                case '03': $mes='Mar'; break;
                case '04': $mes='Abr'; break;
                case '05': $mes='May'; break;
                case '06': $mes='Jun'; break;
                case '07': $mes='Jul'; break;
                case '08': $mes='Ago'; break;
                case '09': $mes='Sep'; break;
                case '10': $mes='Oct'; break;
                case '11': $mes='Nov'; break;
                case '12': $mes='Dic'; break;
            }

            $dmes.='"'.$mes.'"'; if($j>0){$dmes.=', ';}

        }

        //obtener los proveedores principales
        $ResProvPrin = "SELECT o.id_provider, c.legal_name, c.short_name, COUNT(*) AS cuantos FROM operations AS o 
                        INNER JOIN companies AS c ON c.id=o.id_provider 
                        INNER JOIN clientprovider AS cp ON cp.provider_id=c.id 
                        WHERE cp.client_id = '".$idCompanie."'
                        GROUP BY o.id_provider ORDER BY cuantos DESC LIMIT 3";


        $nomProv=''; $numOpe=''; $i=1;
        if($RResProvPrin = $this->db->query($ResProvPrin)) {
            if($RResProvPrin->num_rows() > 0){
                foreach($RResProvPrin->result_array() as $row){
                    if($row["short_name"]!=NULL){$nomProv.='"'.$row["short_name"].'"';}else{$nomProv.='"'.$row["legal_name"].'"';}
                    if($i<$RResProvPrin->num_rows()){$nomProv.=', ';}

                    $numOpe.=$row["cuantos"];if($i<$RResProvPrin->num_rows()){$nomProv.=', ';}
                }
            }
        }

        //operaciones recientes
        $ResOper = "SELECT o.*, ip.uuid, ip.transaction_date, ic.uuid as uuid_relation, companies.short_name, companies.legal_name, ip.id_user, ip.total as money_prov, ic.total as money_clie, debit_notes.uuid AS uuid_nota, debit_notes.total as money_nota 
                    FROM operations as o 
                    LEFT JOIN debit_notes ON debit_notes.id = o.id_debit_note 
                    LEFT JOIN invoices as ip ON ip.id = o.id_invoice 
                    LEFT JOIN invoices as ic ON ic.id = o.id_invoice_relational 
                    INNER JOIN companies ON companies.id = o.id_provider 
                    WHERE o.id_client = '".$idCompanie."' OR o.id_provider = '".$idCompanie."'
                    ORDER BY o.id DESC LIMIT 10";

        if($RResOper = $this->db->query($ResOper)){
            if($RResOper->num_rows() > 0)
            {
                $RRResOper = $RResOper->result_array();
            }
            else{
                $RRResOper = ''; 
            }
        }


        //creamos la respuesta

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
            "Proveedores" => $rresprov,
            "OperacionesMes" => $NumResOperMes, 
            "IngresosMes" => $IngresosMes,
            "EgresosMes" => $EgresosMes,
            "GraficoMovimientos" => array(
                "Ingresos" => $datai,
                "Egresos" => $dataf,
                "meses" => $dmes
            ),
            "GraficoProveedores" => array(
                "Proveedores" => $nomProv,
                "NumeroOperaciones" => $numOpe
            ),
            "OperRecientes" => $RRResOper
        );

		return $ResDash;

    }
}