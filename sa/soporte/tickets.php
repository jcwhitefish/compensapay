<?php
    include ('../config/conexion.php');
    include('f_soporte.php');

    $fechai = isset($_POST["fechai"]) ? $_POST["fechai"] : '2023-01-01';
    $fechaf = isset($_POST["fechaf"]) ? $_POST["fechaf"] : date("Y-m-d");
    $empresa = isset($_POST["empresa"]) ? $_POST["empresa"] : '%';
    $topico = isset($_POST["topico"]) ? $_POST["topico"] : '%';
    $estatus = isset($_POST["estatus"]) ? $_POST["estatus"] : '%';

?>

<div class="container">   
    <div class="row">
        <div class="col s8">
            <div class="row">
                <div class="col s6">
                    <h5><strong>Periodo</strong></h5>
                    <input type="date" id="fechai" name="fechai" value="<?php echo $fechai;?>" style="margin-bottom: 0px;" onchange="tickets(this.value, document.getElementById('fechaf').value, document.getElementById('empresa').value, document.getElementById('topico').value, document.getElementById('estatus').value)">
                    <h6>Desde</h6>
                </div>
                <div class="col s6">
                    <h5>&nbsp;</h5>
                    <input type="date" id="fechaf" name="fechaf" value="<?php echo $fechaf;?>" style="margin-bottom: 0px;" onchange="tickets(document.getElementById('fechai').value, this.value, document.getElementById('empresa').value, document.getElementById('topico').value, document.getElementById('estatus').value)">
                    <h6>Hasta</h6>
                </div>
            </div>

            <div class="row">
                <div class="col s4">
                    <label for="empresa">Empresa</label>
                    <select name="empresa" id="empresa" class="browser-default" onchange="tickets(document.getElementById('fechai').value, document.getElementById('fechaf').value, this.value, document.getElementById('topico').value, document.getElementById('estatus').value)">
                        <option value="%">Todas</option>
                        <?php
                            $ResEmpresas=mysqli_query($conn, "SELECT id, legal_name, short_name FROM companies ORDER BY legal_name ASC");
                            while($RResE=mysqli_fetch_array($ResEmpresas))
                            {
                                echo '<option value="'.$RResE["id"].'"';if($RResE["id"]==$empresa){echo ' selected';}echo '>'.$RResE["legal_name"].' ('.$RResE["short_name"].')</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="col s4">
                    <label for="topico">Topico</label>
                    <select name="topico" id="topico" class="browser-default" onchange="tickets(document.getElementById('fechai').value, document.getElementById('fechaf').value, document.getElementById('empresa').value, this.value, document.getElementById('estatus').value)">
                        <option value="%">Todos</option>
                        <?php
                            $ResTopicos=mysqli_query($conn, "SELECT id_module, tct_id, tct_topic FROM tck_topic ORDER BY id_module ASC, tct_topic ASC");
                            $module='';
                            while($RResT=mysqli_fetch_array($ResTopicos))
                            {
                                if($module!=$RResT["id_module"])
                                {
                                    $ResM=mysqli_fetch_array(mysqli_query($conn, "SELECT tcm_module FROM tck_module WHERE tcm_id='".$RResT["id_module"]."' LIMIT 1"));

                                    if($module!=''){echo '</optgroup>';}
                                    echo '<optgroup label="'.$ResM["tcm_module"].'">';
                                }
                                echo '<option value="'.$RResT["tct_id"].'"';if($RResT["tct_id"]==$topico){echo ' selected';}echo '>'.$RResT["tct_topic"].'</option>';

                                $module=$RResT["id_module"];
                                
                            }
                        ?>
                        </optgroup>
                    </select>
                </div>
                <div class="col s4">
                    <label for="estatus">Estatus</label>
                    <select name="estatus" id="estatus"class="browser-default" onchange="tickets(document.getElementById('fechai').value, document.getElementById('fechaf').value, document.getElementById('empresa').value, document.getElementById('topico').value, this.value)">
                        <option value="%">Todos</option>
                        <option value="1"<?php if($estatus==1){echo ' selected';}?>>Abiertos</option>
                        <option value="2"<?php if($estatus==2){echo ' selected';}?>>En Proceso</option>
                        <option value="3"<?php if($estatus==3){echo ' selected';}?>>Cerrados</option>
                    </select>
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
                        <th>Modulo</th>
                        <th>Topico</th>
                        <th>Titulo</th>
                        <th>Descipción</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $ResT=mysqli_query($conn, "SELECT * FROM tck_ticket 
                                                WHERE tck_created_at>='".strtotime($fechai)."' AND tck_created_at<='".strtotime($fechaf)."' 
                                                AND id_companie LIKE '".$empresa."' AND id_topic LIKE '".$topico."' AND tck_status LIKE '".$estatus."' 
                                                ORDER BY tck_created_at DESC");
                    while($RResT=mysqli_fetch_array($ResT))
                    {
                        $ResE=mysqli_fetch_array(mysqli_query($conn, "SELECT legal_name, short_name FROM companies WHERE id='".$RResT["id_companie"]."' LIMIT 1"));
                        $ResTo=mysqli_fetch_array(mysqli_query($conn, "SELECT id_module, tct_topic FROM tck_topic WHERE tct_id='".$RResT["id_topic"]."' LIMIT 1"));
                        $ResTm=mysqli_fetch_Array(mysqli_query($conn, "SELECT tcm_module FROM tck_module WHERE tcm_id='".$ResTo["id_module"]."' LIMIT 1"));

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
                                <td>'.$ResTm["tcm_module"].'</td>
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
    var ctx = document.getElementById('myChart_tickets');

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