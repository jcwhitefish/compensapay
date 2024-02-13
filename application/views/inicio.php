<div class="container section">
    <div class="row section black" style="border-radius: 15px">
        <div class="col s3 white-text">
            <h5><strong>Facturas por conciliar</strong></h5>
            <h6><?php echo $dashboard["Fpconciliar"][0]["facturas"];?></h6>
        </div>
        <div class="col s3 white-text">
            <h5 style="margin: 1.0933333333rem 0 -1rem 0;"><strong>Total por Cobrar</strong></h5>
            <p style="font-size: 12px">(Monto Facturas)</p>
            <h6>$ <?php 
                    $Stpoc = $dashboard["TotalPorCobrar"]["facturas"][0]["TTotal"];
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
<div class="container section">    
    <div class="row card esquinasRedondas">
        <div class="col s3">
            <h5><strong>Periodo</strong></h5>
            <div class="col valign-wrapper"><p>Desde:</p></div>
            <div class="col"><input type="date" value="<?php echo date("Y-m").'-01';?>"></div>
        </div>
        <div class="col s3">
            <h5>&nbsp;</h5>
            <div class="col valign-wrapper"><p>Hasta:</p></div>
            <div class="col"><input type="date" value="<?php echo date("Y-m-d");?>"></div>
        </div>
        <div class="col s6">
            <h5>&nbsp;</h5>
            <select>
                <option value="0">Socios de Negocios</option>
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
            <div class="card white lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Operaciones</strong><i class="material-icons right" style="rotate: 90deg; color:#9118bd;">import_export</i></span>
                    <p><?php echo $dashboard["OperacionesMes"];?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">-1.22%</h6>-->
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card white lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Ingresos</strong><i class="material-icons right" style="color:#9118bd;">arrow_downward</i></span>
                    <p>$ <?php echo number_format($dashboard["IngresosMes"], 2);?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">+2.031</h6>-->
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card white lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Egresos</strong><i class="material-icons right" style="color:#9118bd;">arrow_upward</i></span>
                    <p>$ <?php echo number_format($dashboard["EgresosMes"], 2);?></p>
                    <!--<h6 style="font-size: 12px; color: #bdbdbd;">+$2.201</h6>-->
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card white lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Diferencia</strong><i class="material-icons right" style="color:#9118bd;">attach_money</i></span>
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
            <div class="card large" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Ingresos vs. Egresos</strong></span>
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card large" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Operaciones</strong></span>
                    <p style="font-size: 12px">Socios con mayor numero de operaciones</p>
                    <div>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section esquinasRedondas card">
        <div class="col s12">
         <h5><strong>Operaciones recientes</strong></h5>
            <table class="stripe row-border order-column nowrap" id="table_i_oper_rec" width="100%">
            <thead>
      <tr>
        <th>Id Operación</th>
        <th>Proveedor</th>
        <th>Fecha</th>
        <th>Factura</th>
        <th>Monto</th>
        <th>Nota de Débito /<br /> Mi Factura</th>
        <th>Monto</th>
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
                        <td align="right">$'.number_format($value["money_prov"], 2).'</td>
                        <td><a href="';if($value["uuid_nota"]!=NULL){echo base_url('/assets/factura/nota.php?idnota='.$value["id_nota"]).'" target="_blank">'.$value["uuid_nota"];}else{echo base_url('/assets/factura/factura.php?idfactura='.$value["id_invoice_relational"]).'" target="_blank">'.$value["uuid_relation"];}echo '</a></td>
                        <td align="right">$';if($value["money_clie"]!=NULL){echo number_format($value["money_clie"], 2);}elseif($value["dn_total"]!=NULL){echo number_format($value["dn_total"], 2);} echo '</td>
                        <td>';
                    switch ($value["status"]) {
                        case 0: echo '<span class="estatus">Por autorizar</span>'; break;
                        case 1: echo '<span class="estatus" style="background-color:#8225fc">Autorizada</span>'; break;
                        case 2: echo '<span class="estatus" style="background-color:#c20005">Rechazada</span>'; break;
                        case 3: echo '<span class="estatus" style="background-color:#569700">Realizada</span>'; break;
                        case 4: echo '<span class="estatus" style="background-color:#dedc48">Vencida</span>'; break;
                    } 
                    echo '</td>
                        </tr>';
                }
            }
        ?>
        <!--<tr>
            <td colspan="8" class="right-align"><a href="<?php echo base_url('/facturas');?>">Ver mas>></a></td>
        </tr>-->
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
var ctx = document.getElementById('myChart');
var ctx2 = document.getElementById('myChart2');

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
                borderColor: ['rgb(92,150,219)',
                                'rgb(38,183,25',
                                'rgb(0,151,159)'
                ],
                backgroundColor: ['rgb(92,150,219)',
                                'rgb(38,183,25)',
                                'rgb(0,151,159)'
                ],
                hoverOffset: 4
            }
        ]}
});
</script>

<script>
        $('#table_i_oper_rec').DataTable({
            scrollX: true,
        scrollCollapse: true,
        scroller:       true,
        deferRender:    true,
        language: {
            decimal: '.',
            thousands: ',',
            url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        paging: false,
        info: false,
        searching: false,
        order: [[0, 'desc']],
        columnDefs: [
            {
                target: 0,
                visible: false,
                searchable: false,
            }
        ]
    });
</script>