<?php
    include ('../config/conexion.php');
    include('f_operaciones.php');

    $fechai = isset($_POST["fechai"]) ? $_POST["fechai"] : '2023-01-01';
    $fechaf = isset($_POST["fechaf"]) ? $_POST["fechaf"] : date("Y-m-d");
    $banco = isset($_POST["banco"]) ? $_POST["banco"] : '%';
    $empresa = isset($_POST["empresa"]) ? $_POST["empresa"] : '%';

    $ResTrans=mysqli_query($conn, "SELECT b.operationNumber AS operationNumber, b.traking_key AS traking_key, b.transaction_date AS transaction_date, 
                                                        prov.legal_name AS plegalname, prov.short_name AS pshortname, clie.legal_name AS clegalname, clie.short_name AS cshortname, 
                                                        sban.bnk_alias AS bancoorigen, dban.bnk_alias AS bancodestino 
                                                        FROM balance AS b 
                                                        INNER JOIN operations AS o ON o.operation_number = b.operationNumber
                                                        INNER JOIN companies AS prov ON prov.id = o.id_provider 
                                                        INNER JOIN companies AS clie ON clie.id = o.id_client
                                                        INNER JOIN cat_bancos AS sban ON sban.bnk_code = b.source_bank 
                                                        INNER JOIN cat_bancos AS dban ON dban.bnk_code = b.receiver_bank
                                                        WHERE transaction_date >= '".strtotime($fechai)."' AND transaction_date <= '".strtotime($fechaf)."' 
                                                        AND (prov.id LIKE '".$_POST["empresa"]."' OR clie.id LIKE '".$_POST["empresa"]."') 
                                                        AND (b.source_bank LIKE '".$_POST["banco"]."' OR b.receiver_bank LIKE '".$_POST["banco"]."') 
                                                        ORDER BY operationNumber DESC, transaction_date DESC");

    $costo = mysqli_num_rows($ResTrans) * 0.15;

?>
<div class="container">   
    <div class="row">
        <div class="col s4">
            <h5><strong>Periodo</strong></h5>
            <input type="date" id="fechai" name="fechai" value="<?php echo $fechai;?>" style="margin-bottom: 0px;" onchange="costos_operacion(this.value, document.getElementById('fechaf').value, document.getElementById('empresa').value, document.getElementById('banco').value)">
            <h6>Desde</h6>
        </div>
        <div class="col s4">
            <h5>&nbsp;</h5>
            <input type="date" id="fechaf" name="fechaf" value="<?php echo $fechaf;?>" style="margin-bottom: 0px;" onchange="costos_operacion(document.getElementById('fechai').value, this.value, document.getElementById('empresa').value, document.getElementById('banco').value)">
            <h6>Hasta</h6>
        </div>
        <div class="col s4">
            <h5>&nbsp;</h5>
            <input type="text" id="costo" name="costo" value="$ <?php echo number_format($costo, 2);?>" style="margin-bottom: 0px;">
            <h6>Costo</h6>
        </div>
    </div>

    <div class="row">
        <div class="col s4 input-border">
            <label for="empresa">Empresa</label>
            <select name="empresa" id="empresa" class="browser-default" onchange="costos_operacion(document.getElementById('fechai').value, document.getElementById('fechaf').value, this.value, document.getElementById('banco').value)">
                <option value="%">Todas</option>
                <?php
                    $ResEmpresas=mysqli_query($conn, "SELECT id, legal_name, short_name FROM companies ORDER BY legal_name ASC");
                    while($RResE=mysqli_fetch_array($ResEmpresas))
                    {
                        echo '<option value="'.$RResE["id"].'"';if($empresa==$RResE["id"]){echo ' selected';}echo '>'.$RResE["legal_name"].' ('.$RResE["short_name"].')</option>';
                    }
                ?>
            </select>
        </div>
        <div class="col s4 input-border">
            <label for="bancos">Banco</label>
            <select name="banco" id="banco" class="browser-default" onchange="costos_operacion(document.getElementById('fechai').value, document.getElementById('fechaf').value, document.getElementById('empresa').value, this.value)">
                <option value="%">Todos</option>
                <?php
                    $ResBancos=mysqli_query($conn, "SELECT bnk_alias, bnk_code FROM cat_bancos ORDER BY bnk_alias ASC");
                    while($RResB=mysqli_fetch_array($ResBancos))
                    {
                        echo '<option value="'.$RResB["bnk_code"].'"';if($banco==$RResB["bnk_code"]){echo ' selected';}echo '>'.$RResB["bnk_alias"].'</option>';
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col s12" style="overflow-x: auto;">
            <table class="visible-table striped responsive-table">
                <thead>
                    <tr>
                        <th>Id Operacion</th>
                        <th>Proveedor</th>
                        <th>Cliente</th>
                        <th>Traking Key</th>
                        <th>Banco Origen</th>
                        <th>Banco Destino</th>
                        <th>Fecha Transacción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($RResT=mysqli_fetch_array($ResTrans))
                        {
                            echo '<tr>
                                    <td>'.$RResT["operationNumber"].'</td>
                                    <td>';if($RResT["pshortname"]!=NULL){echo $RResT["pshortname"];}else{echo $RResT["plegalname"];}echo '</td>
                                    <td>';if($RResT["cshortname"]!=NULL){echo $RResT["cshortname"];}else{echo $RResT["clegalname"];}echo '</td>
                                    <td>'.$RResT["traking_key"].'</td>
                                    <td>'.$RResT["bancoorigen"].'</td>
                                    <td>'.$RResT["bancodestino"].'</td>
                                    <td>'.date("d-m-y h:m:s", $RResT["transaction_date"]).'</td>
                                </tr>';
                        }

                        
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>