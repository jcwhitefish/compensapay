<div class="container section">
    <div class="row section black" style="border-radius: 15px">
        <div class="col s3 white-text">
            <h5><strong>Oper. Totales</strong></h5>
            <h6><?php echo $dashboard["TotalOperaciones"][0]["TotOper"];?></h6>
        </div>
        <div class="col s3 white-text">
            <h5 style="margin: 1.0933333333rem 0 -1rem 0;"><strong>Total por Cobrar</strong></h5>
            <p style="font-size: 12px">(Monto Facturas)</p>
            <h6>$ <?php 
                    $Stpoc = $dashboard["TotalPorCobrar"]["facturas"][0]["TTotal"] + $dashboard["TotalPorCobrar"]["notas"][0]["TTotal"];
                    echo number_format($Stpoc,2);
            ?></h6>
        </div>
        <div class="col s3 white-text">
        <h5 style="margin: 1.0933333333rem 0 -1rem 0;"><strong>Total por pagar</strong></h5>
        <p style="font-size: 12px">(Monto Facturas)</p>
            <h6>$ <?php 
            $Stpp = $dashboard["TotalPorPagar"]["facturas"][0]["TTotal"] + $dashboard["TotalPorPagar"]["notas"][0]["TTotal"];
            echo number_format($Stpp, 2);?></h6>
        </div>
        <div class="col s3 white-text">
            <h5><strong>Diferencia Total</strong></h5>
            <h6>$ <?php echo number_format(($Stpoc - $Stpp), 2);?></h6>
        </div>
    </div>
</div>
<div class="container">    
    <div class="row">
        <div class="col s3">
            <h5><strong>Periodo</strong></h5>
            <input type="date" value="<?php echo date("Y-m").'-01';?>">
            <h6>Desde</h6>
        </div>
        <div class="col s3">
            <h5>&nbsp;</h5>
            <input type="date" value="<?php echo date("Y-m-d");?>">
            <h6>Hasta</h6>
        </div>
        <div class="col s6">
            <h5>&nbsp;</h5>
            <select>
                <option value="0">Todos los proveedores</option>
                <?php
                if(is_array($dashboard["Proveedores"]))
                {
                    foreach ($dashboard["Proveedores"] as $proveedor){
                        echo '<option value="'.$proveedor["Id"].'">'.$proveedor["Proveedor"].'</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Operaciones</strong><i class="material-icons right" style="rotate: 90deg;">import_export</i></span>
                    <p><?php echo $dashboard["OperacionesMes"];?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">-1.22%</h6>-->
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Ingresos</strong><i class="material-icons right">arrow_downward</i></span>
                    <p>$ <?php echo number_format($dashboard["IngresosMes"], 2);?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">+2.031</h6>-->
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Egresos</strong><i class="material-icons right">arrow_upward</i></span>
                    <p>$ <?php echo number_format($dashboard["EgresosMes"], 2);?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">+$2.201</h6>-->
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Diferencia</strong><i class="material-icons right">attach_money</i></span>
                    <p>$ <?php echo number_format(($dashboard["IngresosMes"] - $dashboard["EgresosMes"]), 2);?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">+3.392</h6>-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s8">
            <div class="card" style="border-radius: 15px; height:600px;">
                <div class="card-content">
                    <span class="card-title"><strong>Ingresos vs. Egresos</strong></span>
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card" style="border-radius: 15px; height:600px;">
                <div class="card-content">
                    <span class="card-title"><strong>Proveedores Principales</strong></span>
                    <div>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s12">
         <h5><strong>Operaciones recientes</strong></h5>
            <table class="striped">
            <thead>
      <tr>
        <th>Id Operación</th>
        <th>Proveedor</th>
        <th>Fecha</th>
        <th>Factura</th>
        <th class="right-align">Monto</th>
        <th>Nota de Débito /<br /> Mi Factura</th>
        <th class="right-align">Monto</th>
        <th>Estatus</th>
      </tr>
    </thead>
    <tbody>
        <?php
            if(is_array($dashboard["OperRecientes"]))
            {
                foreach ($dashboard["OperRecientes"] as $value)
                {
                    echo '<tr>
                        <td>'.$value["operation_number"].'</td>
                        <td>';if($value["short_name"]!=NULL){echo $value["short_name"];}else{echo $value["legal_name"];}echo '</td>
                        <td>'.$value["created_at"].'</td>
                        <td><a href="'.base_url('/assets/factura/factura.php?idfactura='.$value["id_invoice"]).'" target="_blank">'.$value["uuid"].'</a></td>
                        <td class="right-align">$'.number_format($value["money_prov"], 2).'</td>
                        <td><a href="';if($value["uuid_nota"]!=NULL){echo base_url('/assets/factura/nota.php?idnota='.$value["uudi_nota"]).'" target="_blank">'.$value["uudi_nota"];}else{echo base_url('/assets/factura/factura.php?idfactura='.$value["id_invoice_relational"]).'" target="_blank">'.$value["uuid_relation"];}echo '</a></td>
                        <td class="right-align">$'.number_format($value["money_clie"], 2).'</td>
                        <td>';
                    switch ($value["status"]) {
                        case 0: echo 'Por autorizar'; break;
                        case 1: echo 'Autorizada'; break;
                        case 2: echo 'Rechazada'; break;
                        case 3: echo 'Realizada'; break;
                        case 4: echo 'Vencida'; break;
                    } 
                    echo '</td>
                        </tr>';
                }
            }
        ?>
        <tr>
            <td colspan="8" class="right-align"><a href="<?php echo base_url('/facturas');?>">Ver mas>></a></td>
        </tr>
    </tbody>
  </table>
        </div>
    </div>
</div>

<style>
    
    .container {
  width: 90%;
  max-width:initial;
}


</style>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');
  const ctx2 = document.getElementById('myChart2');

  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $dashboard["GraficoMovimientos"]["meses"];?>],
            datasets: [{
            label: 'Ingresos',
            data: [<?php echo $dashboard["GraficoMovimientos"]["Ingresos"];?>],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgb(75, 192, 192)',
            tension: 0.1
            }, 
            {
            label: 'Egresos',
            data: [<?php echo $dashboard["GraficoMovimientos"]["Egresos"];?>],
            fill: false,
            borderColor: 'rgb(194, 0, 5)',
            backgroundColor: 'rgb(194, 0, 5)',
            tension: 0.1
            }
        ]}
});

  var myLineChart2 = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: [<?php echo $dashboard["GraficoProveedores"]["Proveedores"];?>],
            datasets: [{
                label: 'Operaciones',
                data: [<?php echo $dashboard["GraficoProveedores"]["NumeroOperaciones"];?>],
                fill: false,
                borderColor: ['rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)'
                ],
                backgroundColor: ['rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }
        ]}
});

</script>