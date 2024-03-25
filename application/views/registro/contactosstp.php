<h5 class="card-title">Formato Solicitud de Servicio STP</h5>
<p>Como parte de la solicitud de servicio STP, requerimos su apoyo para contestar el siguiente cuestionario:</p>
<p><strong>Contactos Autorizados</strong></p>
<p>A continuación colocar a las personas/responsables de las áreas indicadas en los recuadros siguientes, serán los únicos autorizados para solicitar/proporcionar información relacionada con la empresa de acuerdo con su respectiva área </p>
<form name="fcontactosstp2" id="fcontactosstp2">
	<div class="row">
		<div class="col s3">
			<div class="input-border col l12">
				<input type="text" name="nombre" id="nombre" required title="Exactamente como en la Identificación Oficial">
				<label for="nombre">Nombre Completo</label>
			</div>
		</div>
		<div class="col s3">
			<div class="input-border col l12">
				<input type="text" name="telefono" id="telefono" required >
				<label for="telefono">teléfono</label>
			</div>
		</div>
		<div class="col s3">
			<div class="input-border col l12">
				<input type="text" name="extension" id="extension" >
				<label for="extension">Extension</label>
			</div>
		</div>
		<div class="col s3">
			<div class="input-border col l12">
				<input type="text" name="celular" id="celular" required >
				<label for="celular">Celular</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col s3">
			<div class="input-border col l12">
				<input type="text" name="correoe" id="correoe" required >
				<label for="correoe">Correo Electrónico</label>
			</div>
		</div>
		<div class="col s3">
			<div class="input-border col l12">
				<select name="area" id="area" required class="browser-default">
					<option value="0">Elija un elemento</option>
					<option value="1">Responsable Operativo</option>
					<option value="2">Responsable del área de sistemas</option>
					<option value="3">Responsable del área de cuentas por pagar</option>
					<option value="4">Responsable Jurídico y/o oficial de complimiento</option>
				</select>
				<label for="area">Area</label>
			</div>
		</div>
		<div class="col s6">
			<div class="input-border col l12 right-align">
				<input type="submit" name="botadcontacto" id="botadcontacto" value="Agregar Contacto" class="button-gray">
			</div>
		</div>
	</div>
</form>
<?php
if(is_array($contactos["contactoso"]))
{
    echo '<div class="row">
            <div class="col s12">
                <table>
                    <thead>
                        <tr><th colspan="5">Responsable(s) Operativo(s):</th></tr>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Teléfono</th>
                            <th>Extensión</th>
                            <th>Celular</th>
                            <th>Correo Electrónico</th>
                        </tr>
                    <thead>
                    <tbody>';
    foreach($contactos["contactoso"] AS $value)
    {
        echo '          <tr>
                            <td>'.$value["Nombre"].'</td>
                            <td>'.$value["Telefono"].'</td>
                            <td>'.$value["Extension"].'</td>
                            <td>'.$value["Celular"].'</td>
                            <td>'.$value["CorreoE"].'</td>
                        </tr>';
    }
    echo '          </tbody>
                </table>
            </div>
        </div>';
}

if(is_array($contactos["contactoss"]))
{
    echo '<div class="row">
            <div class="col s12">
                <table>
                    <thead>
                        <tr><th colspan="5">Responsable(s) del área de Sistemas:</th></tr>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Teléfono</th>
                            <th>Extensión</th>
                            <th>Celular</th>
                            <th>Correo Electrónico</th>
                        </tr>
                    <thead>
                    <tbody>';
    foreach($contactos["contactoss"] AS $value)
    {
        echo '          <tr>
                            <td>'.$value["Nombre"].'</td>
                            <td>'.$value["Telefono"].'</td>
                            <td>'.$value["Extension"].'</td>
                            <td>'.$value["Celular"].'</td>
                            <td>'.$value["CorreoE"].'</td>
                        </tr>';
    }
    echo '          </tbody>
                </table>
            </div>
        </div>';
}

if(is_array($contactos["contactosc"]))
{
    echo '<div class="row">
            <div class="col s12">
                <table>
                    <thead>
                        <tr><th colspan="5">Responsable(s) del área de Cuentas por Pagar:</th></tr>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Teléfono</th>
                            <th>Extensión</th>
                            <th>Celular</th>
                            <th>Correo Electrónico</th>
                        </tr>
                    <thead>
                    <tbody>';
    foreach($contactos["contactosc"] AS $value)
    {
        echo '          <tr>
                            <td>'.$value["Nombre"].'</td>
                            <td>'.$value["Telefono"].'</td>
                            <td>'.$value["Extension"].'</td>
                            <td>'.$value["Celular"].'</td>
                            <td>'.$value["CorreoE"].'</td>
                        </tr>';
    }
    echo '          </tbody>
                </table>
            </div>
        </div>';
}

if(is_array($contactos["contactosj"]))
{
    echo '<div class="row">
            <div class="col s12">
                <table>
                    <thead>
                        <tr><th colspan="5">Responsable(s) Jurídico y/o Oficial de Cumplimiento:</th></tr>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Teléfono</th>
                            <th>Extensión</th>
                            <th>Celular</th>
                            <th>Correo Electrónico</th>
                        </tr>
                    <thead>
                    <tbody>';
    foreach($contactos["contactosj"] AS $value)
    {
        echo '          <tr>
                            <td>'.$value["Nombre"].'</td>
                            <td>'.$value["Telefono"].'</td>
                            <td>'.$value["Extension"].'</td>
                            <td>'.$value["Celular"].'</td>
                            <td>'.$value["CorreoE"].'</td>
                        </tr>';
    }
    echo '          </tbody>
                </table>
            </div>
        </div>';
}

?>
<div class="row">
    <div class="col l12 right-align">
        <button class="button-gray" id="butfinalizar">Finalizar</button>
    </div>
</div>
<script>
$("#fcontactosstp2").on("submit", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fcontactosstp2"));
    $.ajax({
		url: "<?= base_url('perfil/savestpcontactos'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#formulario_stp_contactos").html(echo);
	});
});

$("#butfinalizar").on('click', function(){
	$.ajax({
		url: "<?= base_url('perfil/finalizastp'); ?>",
		type: "POST",
		dataType: "HTML"
	}).done(function(echo){
		$("#formulario_stp_contactos").html(echo);
	});
});
</script>