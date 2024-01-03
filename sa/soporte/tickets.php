<?php
    include ('../config/conexion.php');
    include('f_soporte.php');

    $fechai = isset($_POST["fechai"]) ? $_POST["fechai"] : '2023-01-01';
    $fechaf = isset($_POST["fechaf"]) ? $_POST["fechaf"] : date("Y-m-d");

?>

<div class="container">   
    <div class="row">
        <div class="col s8">
            <div class="row">
                <div class="col s6">
                    <h5><strong>Periodo</strong></h5>
                    <input type="date" id="fechai" name="fechai" value="<?php echo $fechai;?>" style="margin-bottom: 0px;" onchange="usuarios(this.value, document.getElementById('fechaf').value)">
                    <h6>Desde</h6>
                </div>
                <div class="col s6">
                    <h5>&nbsp;</h5>
                    <input type="date" id="fechaf" name="fechaf" value="<?php echo $fechaf;?>" style="margin-bottom: 0px;" onchange="usuarios(document.getElementById('fechai').value, this.value)">
                    <h6>Hasta</h6>
                </div>
            </div>
        </div>
        
        <div class="col s4">
            <canvas id="myChart_tickets"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <table class="striped">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Empresa</th>
                        <th>Topico</th>
                        <th>Titulo</th>
                        <th>Descipción</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $ResT=mysqli_query($conn, "SELECT * FROM tck_ticket ORDER BY tck_created_at DESC");
                    while($RResT=mysqli_fetch_array($ResT))
                    {
                        $ResE=mysqli_fetch_array(mysqli_query($conn, "SELECT legal_name, short_name FROM companies WHERE id='".$RResT["id_companie"]."' LIMIT 1"));
                        $ResTo=mysqli_fetch_array(mysqli_query($conn, "SELECT tct_topic FROM tck_topic WHERE tct_id='".$RResT["id_topic"]."' LIMIT 1"));

                        switch ($RResT["tck_status"])
                        {
                            case 1: $status='<span style="color: #ff0000">Abierto</span>'; break;
                            case 2: $status='<span style="color: #fffc00">En proceso</span>'; break;
                            case 3: $status='<span style="color: #26b719">Cerrado</span>'; break;
                        }

                        echo '<tr>
                                <td><a href="#" onclick="ticket(\''.$RResT["tck_id"].'\')">'.$RResT["tck_folio"].'</a></td>
                                <td>'.date('d-m-y', $RResT["tck_created_at"]).'</td>
                                <td>';if($ResE["short_name"]!=NULL){echo $ResE["short_name"];}else{echo $ResE["legal_name"];}echo '</td>
                                <td>'.$ResTo["tct_topic"].'</td>
                                <td>'.$RResT["tck_issue"].'</td>
                                <td>'.substr($RResT["tck_description"], 0, 50).'...</td>
                                <td><strong>'.$status.'</strong></td>
                            </tr>';
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('myChart_tickets');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Abiertos', 'En Proceso', 'Cerrados'],
            datasets: [{
                label: 'Tickets: ',
                data: [<?php echo tickets($fechai, $fechaf, 'A');?>, <?php echo tickets($fechai, $fechaf, 'P');?>, <?php echo tickets($fechai, $fechaf, 'C');?>],
                borderWidth: 1,
                backgroundColor: ["#ff0000", "#fffc00", "#26b719"]
            }]
        },
        options: {
            scales: {
            }
        }
    });
</script>