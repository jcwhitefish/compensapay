<?php
    include ('../config/conexion.php');
    include('f_empresas.php');

    $fechai = $_POST["fechai"];
    $fechaf = $_POST["fechaf"];
?>
<div class="container">   
    <div class="row">
        <div class="col s8">
            <div class="row">
                <div class="col s6">
                    <h5><strong>Periodo</strong></h5>
                    <input type="date" id="fechai" name="fechai" value="<?php echo $fechai;?>" style="margin-bottom: 0px;" onchange="dashboard(this.value, document.getElementById('fechaf').value)">
                    <h6>Desde</h6>
                </div>
                <div class="col s6">
                    <h5>&nbsp;</h5>
                    <input type="date" id="fechaf" name="fechaf" value="<?php echo $fechaf;?>" style="margin-bottom: 0px;" onchange="dashboard(document.getElementById('fechai').value, this.value)">
                    <h6>Hasta</h6>
                </div>
            </div>
        </div>
        
        <div class="col s4">
            <canvas id="myChart_empresas"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
        <table class="striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Empresa</th>
                    <th>Alias</th>
                    <th>Rfc</th>
                    <th>Operaciones</th>
                    <th>CFDI's</th>
                    <th>Fecha alta</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ResEmpresas = mysqli_query($conn, "SELECT * FROM companies WHERE created_at <= '".strtotime($fechaf)."'");
                while($RResE=mysqli_fetch_array($ResEmpresas))
                {
                    $ResOper=mysqli_fetch_array(mysqli_query($conn, "SELECT count(id) AS operaciones FROM operations WHERE id_client='".$RResE["id"]."' OR id_provider='".$RResE["id"]."' "));

                    $ResCfdis=mysqli_fetch_array(mysqli_query($conn, "SELECT count(id) AS cfdis FROM invoices WHERE id_company='".$RResE["id"]."'"));
                    $ResDN=mysqli_fetch_array(mysqli_query($conn, "SELECT count(id) AS dn FROM debit_notes WHERE id_company='".$RResE["id"]."'"));

                    if($RResE["cancel_at"]==NULL){$estatus='Activa';}else{$estatus='Cancelada';}

                    echo '<tr>
                            <td>'.$RResE["id"].'</td>
                            <td>'.$RResE["legal_name"].'</td>
                            <td>'.$RResE["short_name"].'</td>
                            <td>'.$RResE["rfc"].'</td>
                            <td style="text-align: center">'.$ResOper["operaciones"].'</td>
                            <td style="text-align: center">'.($ResCfdis["cfdis"]+$ResDN["dn"]).'</td>
                            <td>'.date("Y-m-d", $RResE["created_at"]).'</td>
                            <td>'.$estatus.'</td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<script>
  const ctx = document.getElementById('myChart_empresas');

  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Activas', 'Nuevas', 'Canceladas'],
      datasets: [{
        label: 'Empresas: ',
        data: [<?php echo empresas($fechai, $fechaf, 'A');?>, <?php echo empresas($fechai, $fechaf, 'N');?>, <?php echo empresas($fechai, $fechaf, 'C');?>],
        borderWidth: 1,
        backgroundColor: ["#9118bd", "#5c96db", "#ff0000"]
      }]
    },
    options: {
      scales: {
        
      }
    }
  });
</script>
