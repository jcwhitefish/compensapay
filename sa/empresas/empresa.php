<?php
    include ('../config/conexion.php');

    $ResE=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM companies WHERE id='".$_POST["idempresa"]."' LIMIT 1"));
    $ResZip=mysqli_fetch_array(mysqli_query($conn, "SELECT zip_code FROM cat_zipcode WHERE zip_id='".$ResE["id_postal_code"]."' LIMIT 1"));
?>

<div class="container">  
    <form name="feditempresa" id="feditempresa"> 
    <div class="row">
        <div class="col s12">
            <div class="input-border col l12">
                <input type="text" name="bussinesName" id="bussinesName" value="<?php echo $ResE["legal_name"];?>" required>
                <label for="bussinesName">Razón Social</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-border col l6">
            <input type="text" name="nameComercial" id="nameComercial" value="<?php echo $ResE["short_name"];?>" required>
            <label for="nameComercial">Nombre Comercial</label>
        </div>
        <div class="input-border col l6">
            <label for="giro">Giro</label>
            <select name="giro" id="giro" class="browser-default" required>
                <?php
                    $ResGiro=mysqli_query($conn, "SELECT * FROM cat_giro ORDER BY gro_giro ASC");
                    while($RResG=mysqli_fetch_array($ResGiro))
                    {
                        echo '<option value="'.$RResG["gro_id"].'">'.$RResG["gro_giro"].'</option>';
                    }
                ?>
            </select>
            
        </div>
    </div>

    <div class="row">
        <div class="input-border col l6">
            <input type="text" name="rfc" id="rfc" minlength="12" maxlength="13" pattern="[A-Z0-9]{12,13}" value="<?php echo $ResE["rfc"];?>" title="Debe tener de 12 a 13 caracteres alfanuméricos" required>
            <label for="rfc">RFC</label>
        </div>
        <div class="input-border col l6">
            <label for="regimen">Regimen Fiscal</label>
            <select name="regimen" id="regimen" class="browser-default" required>
            <?php
                $ResRegimen=mysqli_query($conn, "SELECT * FROM cat_regimenfiscal ORDER BY rg_clave ASC");
                while($RResR=mysqli_fetch_array($ResRegimen))
                {
                    echo '<option value="'.$RResR["rg_id"].'"';if($RResR["rg_id"]==$ResE["id_fiscal"]){echo ' selected';}echo '>'.$RResR["rg_clave"].' - '.$RResR["rg_regimen"].'</option>';
                }
            ?>
            </select>
        </div>
    </div>
    
    <div class="row">
        <div class="input-border col l12">
            <input type="text" name="direccion" id="direccion" value="<?php echo $ResE["address"];?>" required>
            <label for="direccion">Direccion</label>
        </div>
    </div>

    <div class="row">
        <div class="input-border col l4">
            <input type="text" name="cp" id="cp" value="<?php echo $ResZip["zip_code"];?>" required pattern="[0-9]{5}" maxlength="5">
            <label for="codigoPostal">Codigo Postal</label>
        </div>
        <div class="input-border col l4">
            <label for="estado">Estado</label>
            <select name="estado" id="estado" class="browser-default" required>
            <?php
                $ResEstados=mysqli_query($conn, "SELECT * FROM cat_state ORDER BY stt_name ASC");
                while($RResE=mysqli_fetch_array($ResEstados))
                {
                    echo '<option value="'.$RResE["stt_id"].'"';if($RResE["stt_id"]==$ResE["id_country"]){echo ' selected';}echo '>'.$RResE["stt_name"].'</option>';
                }
            ?>
            </select>
        </div>
        <div class="input-border col l4">
            <input type="text" name="telefono" id="telefono" value="<?php echo $ResE["telephone"];?>" required pattern="[0-9]{10}" maxlength="10" title="Por favor, ingresa exactamente 10 dígitos numéricos.">
            <label for="telefono">Telefono</label>
        </div>
    </div>

    <div class="row">
        <div class="col l12 right-align p-5">
            <input type="hidden" name="hacer" id="hacer" value="editempresa">
            <input type="hidden" name="idempresa" id="idempresa" value="<?php echo $ResE["id"];?>">
            <button class="btn waves-effect waves-light" type="submit" name="botguardar" id="botguardar">Guardar</button>
        </div>
    </div>
    </form>
</div>

<script>
$("#feditempresa").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditempresa"));

	$.ajax({
		url: "empresas/empresas.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#contenido").html(echo);
	});

    cerrarmodal();
});
</script>