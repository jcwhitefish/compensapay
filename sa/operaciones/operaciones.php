<?php
    include ('../config/conexion.php');
    include('f_operaciones.php');

    $fechai = isset($_POST["fechai"]) ? $_POST["fechai"] : '2023-01-01';
    $fechaf = isset($_POST["fechaf"]) ? $_POST["fechaf"] : date("Y-m-d");

?>
<div class="container">   
    <div class="row">
        <div class="col s8">
            <div class="row">
                <div class="col s6">
                    <h5><strong>Periodo</strong></h5>
                    <input type="date" id="fechai" name="fechai" value="<?php echo $fechai;?>" style="margin-bottom: 0px;" onchange="empresas(this.value, document.getElementById('fechaf').value)">
                    <h6>Desde</h6>
                </div>
                <div class="col s6">
                    <h5>&nbsp;</h5>
                    <input type="date" id="fechaf" name="fechaf" value="<?php echo $fechaf;?>" style="margin-bottom: 0px;" onchange="empresas(document.getElementById('fechai').value, this.value)">
                    <h6>Hasta</h6>
                </div>
            </div>
        </div>
        
        <div class="col s4">
            <canvas id="myChart_operaciones"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col s12" style="overflow-x: auto;">
            <table class="visible-table striped responsive-table">
                <thead>
                    <tr>
                        <th>Estatus</th>
                        <th>Id<br />Operación</th>
                        <th>Proveedor</th>
                        <th>Cliente</th>
                        <th>Fecha<br />Factura</th>
                        <th>Fecha<br />Alta</th>
                        <th>UUID<br />Factura<br />Proveedor</th>
                        <th>Monto<br />Factura<br />Proveedor</th>
                        <th>UUID<br />Factura<br />Cliente</th>
                        <th>Monto<br />Factura<br />Cliente</th>
                        <th>UUID<br />Nota<br />Debito</th>
                        <th>Monto<br />Nota<br />Debito</th>
                        <th>Fecha<br />Transacción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ResOp=mysqli_query($conn, "SELECT * FROM operations WHERE created_at >= '".strtotime($fechai)."' AND created_at <= '".strtotime($fechaf)."'");
                    while($RResOp=mysqli_fetch_array($ResOp))
                    {
                        switch($RResOp["status"])
                        {
                            case 0: $status='Por Autorizar'; break;
                            case 1: $status='Autorizada'; break;
                            case 2: $status='Rechazada'; break;
                            case 3: $status='Realizada'; break;
                            case 4: $status='Vencida'; break;
                        }

                        //proveedor
                        $ResProve=mysqli_fetch_array(mysqli_query($conn, "SELECT legal_name, short_name FROM companies WHERE id='".$RResOp["id_provider"]."' LIMIT 1"));
                        //Cliente
                        $ResClien=mysqli_fetch_array(mysqli_query($conn, "SELECT legal_name, short_name FROM companies WHERE id='".$RResOp["id_client"]."' LIMIT 1"));
                        //factura
                        $ResInvoice=mysqli_fetch_array(mysqli_query($conn, "SELECT uuid, total, invoice_date, payment_date, created_at FROM invoices WHERE id='".$RResOp["id_invoice"]."' LIMIT 1"));
                        //factura cliente
                        if($RResOp["id_invoice_relational"]!=NULL)
                        {
                            $ResInCli=mysqli_fetch_array(mysqli_query($conn, "SELECT uuid, total, invoice_date, created_at FROM invoices WHERE id='".$RResOp["id_invoice_relational"]."' LIMIT 1"));
                            $uuid_ir=$ResInCli["uuid"];
                            $total_ir='$ '.number_format($ResInCli["total"], 2);
                        }
                        else{
                            $uuid_ir='N/A';
                            $total_ir='N/A';
                        }
                        
                        //nota debito
                        if($RResOp["id_debit_note"]!=NULL)
                        {
                            $ResND=mysqli_fetch_array(mysqli_query($conn, "SELECT uuid, total, debitNote_date, created_at FROM debit_notes WHERE id='".$RResOp["id_debit_note"]."' LIMIT 1"));
                            $uuid_nd=$ResND["uuid"];
                            $total_nd='$ '.number_format($ResND["total"], 2);
                        }
                        else{
                            $uuid_nd='N/A';
                            $total_nd='N/A';
                        }
                        
                        echo '<tr>
                                <td>'.$status.'</td>
                                <td>'.$RResOp["operation_number"].'</td>
                                <td>';if($ResProve["short_name"]!=NULL){echo $ResProve["short_name"];}else{echo $ResProve["legal_name"];}echo '</td>
                                <td>';if($ResClien["short_name"]!=NULL){echo $ResClien["short_name"];}else{echo $ResClien["legal_name"];}echo '</td>
                                <td>'.date('d-m-y', $ResInvoice["invoice_date"]).'</td>
                                <td>'.date('d-m-y', $ResInvoice["created_at"]).'</td>
                                <td>'.$ResInvoice["uuid"].'</td>
                                <td style="text-align: right">$ '.number_format($ResInvoice["total"], 2).'</td>
                                <td>'.$uuid_ir.'</td>
                                <td style="text-align: right">'.$total_ir.'</td>
                                <td>'.$uuid_nd.'</td>
                                <td style="text-align: right">'.$total_nd.'</td>
                                <td>'.date('d-m-y', $ResInvoice["payment_date"]).'</td>
                            </tr>';
                            
                    }
                    ?>
                </tbody>
            </table>
        </div>
</div>
</div>

<script>
  const ctx = document.getElementById('myChart_operaciones');

  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Por Autorizar', 'Autorizadas', 'Rechazadas', 'Realizadas', 'Vencidas'],
      datasets: [{
        label: 'Empresas: ',
        data: [<?php echo operaciones($fechai, $fechaf, 'P');?>, 
                <?php echo operaciones($fechai, $fechaf, 'A');?>, 
                <?php echo operaciones($fechai, $fechaf, 'R');?>,
                <?php echo operaciones($fechai, $fechaf, 'E');?>,
                <?php echo operaciones($fechai, $fechaf, 'V');?>],
        borderWidth: 1,
        backgroundColor: ["#685de8", "#00cccc", "#c20005", "#26b719", "#e4820c"]
      }]
    },
    options: {
      scales: {
        
      }
    }
  });
</script>
