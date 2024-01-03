<?php
    include ('../config/conexion.php');
    
    if(isset($_POST["hacer"]))
    {
        if($_POST["hacer"]=='adseguimiento')
        {
            mysqli_query($conn, "INSERT INTO tck_tracking (id_ticket, tcs_status, tcs_message, tcs_flow, tcs_created_at)
                                                VALUES ('".$_POST["idticket"]."', '1', '".$_POST["mensaje"]."', '1', '".time()."')");

            if(mysqli_num_rows(mysqli_query($conn, "SELECT tcs_id FROM tck_tracking WHERE id_ticket='".$_POST["idticket"]."'"))>0)
            {
                mysqli_query($conn, "UPDATE tck_ticket SET tck_status='2' WHERE tck_id='".$_POST["idticket"]."'");
            }

            if(isset($_POST["cerrarticket"]))
            {
                mysqli_query($conn, "UPDATE tck_ticket SET tck_status='3' WHERE tck_id='".$_POST["idticket"]."'");
            }
        }
    }

    $ResTi=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tck_ticket WHERE tck_id='".$_POST["idticket"]."' Limit 1"));
    $ResE=mysqli_fetch_array(mysqli_query($conn, "SELECT legal_name, short_name FROM companies WHERE id='".$ResTi["id_companie"]."' LIMIT 1"));
    $ResTo=mysqli_fetch_array(mysqli_query($conn, "SELECT tct_topic FROM tck_topic WHERE tct_id='".$ResTi["id_topic"]."' LIMIT 1"));

    switch ($ResTi["tck_status"])
    {
        case 1: $status='<span style="color: #ff0000">Abierto</span>'; break;
        case 2: $status='<span style="color: #fffc00">En proceso</span>'; break;
        case 3: $status='<span style="color: #26b719">Cerrado</span>'; break;
    }
?>

<div class="container">  
    <div class="row">
        <div class="col s12">
            <table class="striped">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Empresa</th>
                        <th>Topico</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $ResTi["tck_folio"]; ?></td>
                        <td><?php echo date("d-m-Y", $ResTi["tck_created_at"]); ?></td>
                        <td><?php if($ResE["short_name"]!=NULL){echo $ResE["short_name"];}else{echo $ResE["legal_name"];} ?></td>
                        <td><?php echo $ResTo["tct_topic"]; ?></td>
                        <td><?php echo $status; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <table class="striped">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $ResTi["tck_issue"]; ?></td>
                        <td><?php echo $ResTi["tck_description"]; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <?php
                if($ResTi["tck_status"]<3)
                {
                    echo '<div class="container">
                            <form name="fadseguimientot" id="fadseguimientot">
                                <div class="row">
                                    <div class="input-field col s3">
                                        <input type="date" id="fechas" name="fechas" value="'.date('Y-m-d').'">
                                    </div>
                                    <div class="input-field col s6">
                                        <textarea id="mensaje" name="mensaje" class="materialize-textarea"></textarea>
                                    </div>
                                    <div class="input-field col s3">
                                        <div class="switch col s12">
                                            <label>
                                                <input type="checkbox" value="1" name="cerrarticket" id="cerrarticket">
                                                <span class="lever"></span>
                                                Cerrar Ticket
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 right-align">
                                        <input type="hidden" name="idticket" id="idticket" value="'.$ResTi["tck_id"].'">
                                        <input type="hidden" name="hacer" id="hacer" value="adseguimiento">
                                        <input class="btn waves-effect waves-light" type="submit" name="botadseguimiento" id="botadseguimiento" value="Guardar">
                                    </div>
                                </div>
                            </form>
                        </div>';
                }
            ?>
            <table class="striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Seguimiento</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $ResS=mysqli_query($conn, "SELECT * FROM tck_tracking WHERE id_ticket='".$ResTi["tck_id"]."' ORDER BY tcs_created_at DESC");
                    while($RResS=mysqli_fetch_array($ResS))
                    {
                        echo '<tr>
                            <td>'.date('d-m-y', $RResS["tcs_created_at"]).'</td>
                            <td>'.$RResS["tcs_message"].'</td>
                        </tr>';
                    }
                ?>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $("#fadseguimientot").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadseguimientot"));

	$.ajax({
		url: "soporte/ticket.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#modal-body").html(echo);
	});
});
</script>
