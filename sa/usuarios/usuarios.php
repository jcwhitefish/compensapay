<?php
    include ('../config/conexion.php');
    include('f_usuarios.php');

    $fechai = isset($_POST["fechai"]) ? $_POST["fechai"] : '2023-01-01';
    $fechaf = isset($_POST["fechaf"]) ? $_POST["fechaf"] : date("Y-m-d");

    if(isset($_POST["hacer"]))
    {
        if($_POST["hacer"]=='editusuario')
        {
            mysqli_query($conn, "UPDATE users SET user='".$_POST["username"]."', 
                                                    name='".$_POST["nombre"]."', 
                                                    last_name='".$_POST["apellidos"]."', 
                                                    email='".$_POST["correoe"]."', 
                                                    telephone='".$_POST["telefono"]."',
                                                    id_company='".$_POST["empresa"]."', 
                                                    updated_at='".time()."'
                                                WHERE id='".$_POST["idusuario"]."'") or die(mysqli_error($conn));
        }
    }
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
            <canvas id="myChart_usuarios"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
        <table class="striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Usuario</th>
                    <th>Empresa</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Telefono</th>
                    <th>Fecha alta</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ResUsuarios = mysqli_query($conn, "SELECT * FROM users AS u
                                                    INNER JOIN companies AS c ON c.id = u.id_company 
                                                    WHERE u.created_at <= '".strtotime($fechaf)."'");
                while($RResU=mysqli_fetch_array($ResUsuarios))
                {
                    if($RResU["cancel_at"]==NULL){$estatus='Activo';}else{$estatus='Cancelado';}

                    echo '<tr>
                            <td><a href="#" onclick="edit_usuario(\''.$RResU["id"].'\')">'.$RResU["id"].'</a></td>
                            <td>'.$RResU["user"].'</td>
                            <td>'.$RResU["legal_name"].'</td>
                            <td>'.$RResU["name"].' '.$RResU["last_name"].'</td>
                            <td>'.$RResU["email"].'</td>
                            <td>'.$RResU["telephone"].'</td>
                            <td>'.date("Y-m-d", $RResU["created_at"]).'</td>
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
    const ctx = document.getElementById('myChart_usuarios');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Activos', 'Nuevos', 'Cancelados'],
            datasets: [{
                label: 'Usuarios: ',
                data: [<?php echo usuarios($fechai, $fechaf, 'A');?>, <?php echo usuarios($fechai, $fechaf, 'N');?>, <?php echo usuarios($fechai, $fechaf, 'C');?>],
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