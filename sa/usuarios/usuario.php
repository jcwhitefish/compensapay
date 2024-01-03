<?php
    include ('../config/conexion.php');

    $ResU=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id='".$_POST["idusuario"]."' Limit 1"));
?>

<div class="container">  
    <form name="feditusuario" id="feditusuario"> 
    <div class="row">
        <div class="input-border col s6">
            <input type="text" name="nombre" id="nombre" value="<?php echo $ResU["name"];?>" required>
            <label for="nombre">Nombres</label>
        </div>
        <div class="input-border col s6">
            <input type="text" name="apellidos" id="apellidos" value="<?php echo $ResU["last_name"];?>" required>
            <label for="apellidos">Apellidos</label>
        </div> 
    </div>

    <div class="row">
        <div class="input-border col s4">
            <input type="text" name="username" id="username" value="<?php echo $ResU["user"];?>" required>
            <label for="username">Nombre de usuario</label>
        </div>
        <div class="input-border col s4">
            <input type="text" name="correoe" id="correoe" value="<?php echo $ResU["email"];?>" required>
            <label for="correoe">Correo Electrónico</label>
        </div>
        <div class="input-border col s4">
            <input type="text" name="telefono" id="telefono" value="<?php echo $ResU["telephone"];?>" required>
            <label for="telefono">Teléfono</label>
        </div>
    </div>

    <div class="row">
        <div class="col s8">
            <label for="empresa">Empresa</label>
            <select name="empresa" id="empresa" class="browser-default" required>
                <?php
                    $ResE=mysqli_query($conn, "SELECT id, legal_name FROM companies ORDER BY legal_name ASC");
                    while($RResE=mysqli_fetch_array($ResE))
                    {
                        echo '<option value="'.$RResE["id"].'"';if($RResE["id"]==$ResU["id_company"]){echo ' selected';}echo '>'.$RResE["legal_name"].'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="col s4">
            <div class="switch">
                <label>
                <input type="checkbox">
                <span class="lever"></span>
                Suspender cuenta
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 right-align">
            <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $ResU["id"];?>">
            <input type="hidden" name="hacer" id="hacer" value="editusuario">
            <button class="btn waves-effect waves-light" type="submit" name="botguardar" id="botguardar">Guardar</button>
        </div>
    </div>
    </form>
</div>

<script>
$("#feditusuario").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditusuario"));

	$.ajax({
		url: "usuarios/usuarios.php",
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