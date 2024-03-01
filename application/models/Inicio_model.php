<?php
class Inicio_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function dashboard() {

        $idCompanie = $this->session->userdata('datosEmpresa')['id'];
        $rfcEmpresa = $this->session->userdata('datosEmpresa')["rfc"];

        //facturas por conciliar
        $querytop = "SELECT count(*) AS facturas FROM invoices AS i
                        INNER JOIN operations AS o ON o.id_invoice != i.id 
                        INNER JOIN operations AS op ON op.id_invoice_relational != i.id
                        WHERE i.id_company = ".$idCompanie." AND (o.id_client = ".$idCompanie." OR o.id_provider = ".$idCompanie.") 
                        AND (op.id_client = ".$idCompanie." OR op.id_provider = ".$idCompanie.") AND i.status=0";

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
        $querytpc2 = "SELECT SUM(dn.total) AS TTotal FROM debit_notes AS dn WHERE dn.id_company = ".$idCompanie." AND status=1";

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
        $Qtpp = "SELECT SUM(total) AS TTotal FROM invoices WHERE receiver_rfc = '".$rfcEmpresa."' AND status=1"; 
        $Qtpp2 = "SELECT SUM(dn.total) AS TTotal FROM debit_notes AS dn WHERE dn.receiver_rfc = '".$rfcEmpresa."' AND dn.status=1";
        
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
        $Qprov = "SELECT c.legal_name AS Proveedor FROM companies AS c 
                INNER JOIN cat_zipcode AS cp on c.id_postal_code = cp.zip_id
                WHERE c.id IN 
                (SELECT emp.empresa AS empresa FROM 
                    (SELECT client_id AS empresa FROM `clientprovider` WHERE provider_id = '".$idCompanie."' 
                    UNION ALL SELECT provider_id AS empresa FROM clientprovider WHERE client_id = '".$idCompanie."') AS emp 
                    GROUP BY empresa)";

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
                        AND b.created_at >= '".strtotime(date('Y-m').'-01 00:00:00')."' AND b.created_at <= '".strtotime(date("Y-m").'-31 23:59:59')."' 
                        LIMIT 1";

        if($resOperMes = $this->db->query($ResOperMes)){
            $NumResOperMes = $resOperMes->num_rows();
        }

        //ingresos mes
        $ResIngMesF = "SELECT i.total AS ingreso
                        FROM invoices AS i
                        INNER JOIN operations AS o ON o.id_invoice = i.id OR o.id_invoice_relational=i.id
                        INNER JOIN balance AS b ON o.operation_number = b.operationNumber
                        WHERE i.id_company = '".$idCompanie."' AND i.status = 3 AND b.transaction_date >= '".strtotime(date('Y-m').'-01 00:00:00')."' AND b.transaction_date <= '".strtotime(date("Y-m").'-31 23:59:59')."' GROUP BY o.id";

        $ResIngMesNC = "SELECT dn.total AS ingreso
                        FROM debit_notes AS dn
                        INNER JOIN operations AS o ON o.id_debit_note = dn.id 
                        INNER JOIN balance AS b ON o.operation_number = b.operationNumber
                        WHERE dn.receiver_rfc = '".$rfcEmpresa."' AND dn.status = 3 AND b.transaction_date >= '".strtotime(date('Y-m').'-01 00:00:00')."' AND b.transaction_date <= '".strtotime(date("Y-m").'-31 23:59:59')."' GROUP BY o.id";

        $RRResIngMesF= 0; $RRResIngMesNC = 0;

        if($RResIngMesF = $this->db->query($ResIngMesF)) {
            if($RResIngMesF->num_rows() > 0){
                foreach ($RResIngMesF->result_array() as $row){
                    $RRResIngMesF =$RRResIngMesF + $row["ingreso"];
                }
            }
        }

        if($RResIngMesNC = $this->db->query($ResIngMesNC)) {
            if($RResIngMesNC->num_rows() > 0){
                foreach($RResIngMesNC->result_array() as $row){
                    $RRResIngMesNC = $RRResIngMesNC + $row["ingreso"];
                }
            }
        }

        $IngresosMes = $RRResIngMesF + $RRResIngMesNC;

        //total egresos mes
        $ResEgrMesF = "SELECT i.total AS egreso
                        FROM invoices AS i
                        INNER JOIN operations AS o ON o.id_invoice = i.id OR o.id_invoice_relational=i.id
                        INNER JOIN balance AS b ON o.operation_number = b.operationNumber
                        WHERE i.receiver_rfc = '".$rfcEmpresa."' AND i.status = 3 AND b.transaction_date >= '".strtotime(date('Y-m').'-01 00:00:00')."' AND b.transaction_date <= '".strtotime(date("Y-m").'-31 23:59:59')."' GROUP BY o.id";

        $ResEgrMesC = "SELECT dn.total AS egreso
                        FROM compensatest_base.debit_notes AS dn
                        INNER JOIN compensatest_base.operations AS o ON o.id_debit_note = dn.id 
                        INNER JOIN compensatest_base.balance AS b ON o.operation_number = b.operationNumber
                        WHERE dn.id_company = $idCompanie AND dn.status = 3 AND b.transaction_date >= '".strtotime(date('Y-m').'-01 00:00:00')."' AND b.transaction_date <= '".strtotime(date("Y-m").'-31 23:59:59')."' GROUP BY o.id";

        $RRResEgrMesF= 0; $RRResEgrMesC = 0;
            
        if($RResEgrMesF = $this->db->query($ResEgrMesF)) {
            if($RResEgrMesF->num_rows() > 0){
                foreach ($RResEgrMesF->result_array() as $row){
                    $RRResEgrMesF =$RRResEgrMesF + $row["egreso"];
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

        $EgresosMes = $RRResEgrMesF + $RRResEgrMesC;

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

            //ingreso
            $ResIngMesF = "SELECT i.total AS ingreso
                            FROM invoices AS i
                            INNER JOIN operations AS o ON o.id_invoice = i.id OR o.id_invoice_relational=i.id
                            INNER JOIN balance AS b ON o.operation_number = b.operationNumber
                            WHERE i.id_company = '".$idCompanie."' AND i.status = 3 AND b.transaction_date >= '".strtotime($fechai)."' AND b.transaction_date <= '".strtotime($fechaf)."' GROUP BY o.id";

            $ResIngMesNC = "SELECT dn.total AS ingreso
                        FROM debit_notes AS dn
                        INNER JOIN operations AS o ON o.id_debit_note = dn.id 
                        INNER JOIN balance AS b ON o.operation_number = b.operationNumber
                        WHERE dn.receiver_rfc = '".$rfcEmpresa."' AND dn.status = 3 AND b.transaction_date >= '".strtotime($fechai)."' AND b.transaction_date <= '".strtotime($fechaf)."' GROUP BY o.id";

            //$ResIngMesP = "SELECT SUM(b.amount) AS ingreso 
            //            FROM balance b INNER JOIN operations o ON b.operationNumber = o.operation_number 
            //            INNER JOIN companies c ON o.id_provider = c.id 
            //            INNER JOIN fintech f ON f.companie_id = c.id 
            //            WHERE c.id = ".$idCompanie." AND b.receiver_clabe = f.arteria_clabe
            //            AND b.created_at >= '".strtotime($fechai)."' AND b.created_at <= '".strtotime($fechaf)."'";
//
            //$ResIngMesC = "SELECT b.amount AS ingreso 
            //                FROM balance b INNER JOIN operations o ON b.operationNumber = o.operation_number 
            //                INNER JOIN companies c ON o.id_provider = c.id 
            //                INNER JOIN fintech f ON f.companie_id = c.id 
            //                WHERE o.id_client = ".$idCompanie." AND b.receiver_clabe != f.arteria_clabe AND b.receiver_clabe != c.account_clabe 
            //                AND b.created_at >= '".strtotime($fechai)."' AND b.created_at <= '".strtotime($fechaf)."'";

            $RRResIngMesF= 0; $RRResIngMesNC = 0;

            if($RResIngMesF = $this->db->query($ResIngMesF)) {
                if($RResIngMesF->num_rows() > 0){
                    foreach ($RResIngMesF->result_array() as $row){
                        $RRResIngMesF =$RRResIngMesF + $row["ingreso"];
                    }
                }
            }

            if($RResIngMesNC = $this->db->query($ResIngMesNC)) {
                if($RResIngMesNC->num_rows() > 0){
                    foreach($RResIngMesNC->result_array() as $row){
                        $RRResIngMesNC = $RRResIngMesNC + $row["ingreso"];
                    }
                }
            }

            //egreso
            $ResEgrMesF = "SELECT i.total AS egreso
                        FROM invoices AS i
                        INNER JOIN operations AS o ON o.id_invoice = i.id OR o.id_invoice_relational=i.id
                        INNER JOIN balance AS b ON o.operation_number = b.operationNumber
                        WHERE i.receiver_rfc = '".$rfcEmpresa."' AND i.status = 3 AND b.transaction_date >= '".strtotime($fechai)."' AND b.transaction_date <= '".strtotime($fechaf)."' GROUP BY o.id";

            $ResEgrMesC = "SELECT dn.total AS egreso
                        FROM compensatest_base.debit_notes AS dn
                        INNER JOIN compensatest_base.operations AS o ON o.id_debit_note = dn.id 
                        INNER JOIN compensatest_base.balance AS b ON o.operation_number = b.operationNumber
                        WHERE dn.id_company = $idCompanie AND dn.status = 3 AND b.transaction_date >= '".strtotime($fechai)."' AND b.transaction_date <= '".strtotime($fechaf)."' GROUP BY o.id";

            //$ResEgrMesP = "SELECT SUM(b.amount) AS egreso 
            //            FROM balance b 
            //            INNER JOIN operations o ON b.operationNumber = o.operation_number 
            //            INNER JOIN companies c ON o.id_provider = c.id 
            //            INNER JOIN fintech f ON f.companie_id = c.id 
            //            WHERE c.id = ".$idCompanie." AND (b.receiver_clabe = f.arteria_clabe OR b.receiver_clabe = c.account_clabe)
            //            AND b.created_at >= '".strtotime($fechai)."' AND b.created_at <= '".strtotime($fechaf)."'";
//
            //$ResEgrMesC = "SELECT SUM(b.amount) AS egreso
            //                FROM balance b
            //                INNER JOIN operations o ON b.operationNumber = o.operation_number
            //                INNER JOIN companies c ON o.id_provider = c.id
            //                INNER JOIN fintech f ON f.companie_id = c.id
            //                WHERE o.id_client = ".$idCompanie." AND b.source_clabe != f.arteria_clabe AND  b.source_clabe != c.account_clabe
            //                AND b.created_at >= '".strtotime($fechai)."' AND b.created_at <= '".strtotime($fechaf)."'";

            $RRResEgrMesF= 0; $RRResEgrMesC = 0;

            if($RResEgrMesF = $this->db->query($ResEgrMesF)) {
                if($RResEgrMesF->num_rows() > 0){
                    foreach ($RResEgrMesF->result_array() as $row){
                        $RRResEgrMesF =$RRResEgrMesF + $row["egreso"];
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

            $datai.=''.($RRResIngMesF + $RRResIngMesNC).''; if($j>0){$datai.=', ';}
            $dataf.=''.($RRResEgrMesC + $RRResEgrMesF).''; if($j>0){$dataf.=', ';}

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
        $ResProvPrin = "SELECT c.id, c.legal_name, c.short_name, COUNT(*) AS cuantos 
                        FROM operations AS o 
                        INNER JOIN companies AS c ON (c.id = o.id_provider OR c.id = o.id_client) AND c.id != '".$idCompanie."'
                        WHERE (o.id_client = '".$idCompanie."' OR o.id_provider = '".$idCompanie."') AND o.status='3'
                        GROUP BY c.id ORDER BY cuantos DESC LIMIT 3;";


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
        $ResOper = "SELECT o.*, ip.uuid, ip.transaction_date, ic.uuid as uuid_relation, companies.short_name, companies.legal_name, ip.id_user, 
                            ip.total as money_prov, ic.total as money_clie, debit_notes.uuid AS uuid_nota, debit_notes.total as money_nota, debit_notes.id AS id_nota, 
                            debit_notes.total AS dn_total
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
            "Fpconciliar" => $rrestop,
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

    public function pago (){

        $idCompanie = $this->session->userdata('datosEmpresa')['id'];

        $query = "SELECT id FROM subscription WHERE company_id='".$idCompanie."' AND nextPay > '".time()."' ORDER BY created_at DESC LIMIT 1";

        if($ResQ = $this->db->query($query)) {
            if($ResQ->num_rows() == 0){
                $this->session->set_userdata('pago_suscription', 0); 
                return FALSE;
            }
            else{
                $this->session->set_userdata('pago_suscription', 1); 
                return TRUE;
            }
        }
        

    }
}