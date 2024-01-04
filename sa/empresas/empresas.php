<?php
    include ('../config/conexion.php');
    include('f_empresas.php');

    $fechai = isset($_POST["fechai"]) ? $_POST["fechai"] : '2023-01-01';
    $fechaf = isset($_POST["fechaf"]) ? $_POST["fechaf"] : date("Y-m-d");

    if(isset($_POST["hacer"]))
    {
        if($_POST["hacer"]=='editempresa')
        {
            $ResIdCP=mysqli_fetch_array(mysqli_query($conn, "SELECT zip_id FROM cat_zipcode WHERE zip_code='".$_POST["cp"]."' LIMIT 1"));

            mysqli_query($conn, "UPDATE companies SET legal_name='".$_POST["bussinesName"]."', 
                                                        short_name='".$_POST["nameComercial"]."', 
                                                        id_type='".$_POST["giro"]."', 
                                                        rfc='".$_POST["rfc"]."', 
                                                        id_postal_code='".$ResIdCP["zip_id"]."', 
                                                        address='".$_POST["direccion"]."',
                                                        telephone='".$_POST["telefono"]."', 
                                                        updated_at='".time()."'
                                                WHERE id='".$_POST["idempresa"]."'") or die(mysqli_error($conn));
        }
    }
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
                            <td><a href="#" onclick="edit_empresa(\''.$RResE["id"].'\')">'.$RResE["id"].'</a></td>
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
