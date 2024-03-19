<?php
	//TODO: en todos los registros existe la clase invalid de materialize y es la que se tendrria que ocupar para poner el borde rojo se llama validate
	$unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];
	
	$urlArchivos = base_url ( 'boveda/' . $unique . '/' );

	//datos empresa
	if(is_array($empresa))
	{
		foreach($empresa AS $value){
			$legal_name = $value["legal_name"];
			$short_name = $value["short_name"];
			$regimen = $value["regimen"];
			$rfc = $value["rfc"];
			$direccion = $value["address"];
			$telefono = $value["telephone"];
			$correoe = $value["correoe"];
			$clabe = $value["account_clabe"];
			$cp = $value["zip_code"];
			$colonia = $value["colonia"];
			$municipio = $value["municipio"];
			$estado = $value["estado"];
			$banco = $value["banco"];
			$zipid = $value["zip_id"];
			$logotipo = $value["Logotipo"];
			$actac = $value["ActaConstitutiva"];
			$constanciasf = $value["ConstanciaSituacionF"];
			$comprobanted = $value["ComprobanteDomicilio"];
			$identificacionrl = $value["IdenRepresentante"];
		}
	}
?>
<div class="p-5">
	<h5>Configuración de la empresa</h5>
	<div class="row">
		<div class="col l12 card esquinasRedondas right-align" style="padding: 20px;">
			<a class="linkConfiguracion" href="<?= base_url ( 'Configuracion' ); ?>" style="color: #9118bd">
				Configuración Avanzada
				<i class="material-icons iconoSetting">
					settings
				</i></a>
		</div>
	</div>
	<div class="row card esquinasRedondas">
		<div class="col l9">
			<form name="fdatempresa" id="fdatempresa" method="POST" action="<?php echo base_url('perfil/updatedatosempresa');?>">
			<div class="col l4 especial-p">
				<div class="row">
					<div class="col l12" style="margin-bottom: 30px;">
						<p class="bold">Detalles de la empresa</p>
					</div>
					<div class="input-border col l12">
						<input type="text" name="bussinesName" id="bussinesName" value="<?php echo $legal_name;?>" required>
						<label for="bussinesName">Razón Social *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input type="text" name="nameComercial"	id="nameComercial" value="<?php echo $short_name;?>" required>
						<label for="nameComercial">Nombre Comercial *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input type="text" name="rfc" id="rfc" minlength="12" maxlength="13" pattern="[A-Z0-9]{12,13}" value="<?php echo $rfc;?>" title="Debe tener de 12 a 13 caracteres alfanuméricos" required>
						<label for="rfc">RFC *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<select name="regimen" id="regimen" required>
							<?php
								if(is_array($detalles["regimenfiscal"]))
								{
									foreach($detalles["regimenfiscal"] AS $rf)
									{
										echo '<option value="'.$rf["rg_id"].'"';if($regimen == $rf["rg_id"]){echo ' selected';} echo '>'.$rf["rg_clave"].' - '.$rf["rg_regimen"].'</option>';
									}
								}
							?>
						</select>
						<label for="regimen">Regimen Fiscal *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input type="text" name="telefono" id="telefono" required pattern="[0-9]{10}" maxlength="10" title="Por favor, ingresa exactamente 10 dígitos numéricos." value="<?php echo $telefono;?>">
						<label for="telefono">Telefono </label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input type="email" name="correoe" id="correoe" required pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" title="Por favor, ingresa un correo electrónico de contacto." value="<?php echo $correoe;?>">
						<label for="telefono">Correo Electrónico</label>
					</div>
				</div>
			</div>
			<div class="col l4 line-card line-card-l especial-p">
				<div class="row">
					<div class="col l12" style="margin-bottom: 30px;">
						<p class="bold">Domicilio de la empresa</p>
					</div>
					<div class="input-border col l12">
						<input type="text" name="direccion" id="direccion" required value="<?php echo $direccion;?>">
						<label for="direccion">Direccion *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input type="text" name="codigoPostal" id="codigoPostal" maxlength="5" pattern="[0-9]{5}" required onchange="datos_estado(this.value)" value="<?php echo $cp;?>">
						<label for="codigoPostal">Codigo Postal *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12" id="nombre_estado">
						<input type="text" name="estado" id="estado" disabled required value="<?php echo $estado;?>">
						<label for="estado">Estado</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12" id="nombre_municipio">
						<input type="text" name="municipio" id="municipio" required disabled value="<?php echo $municipio;?>">
						<label for="municipio">Municipio *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12" id="nombre_colonia">
						<select name="colonia" id="colonia" required>
							<?php
								if(is_array($detalles["colonias"]))
								{
									foreach($detalles["colonias"] AS $value)
									{
										echo '<option value="'.$value["id"].'"';if($zipid == $value["id"]){echo ' selected';} echo '>'.$value["colonia"].'</option>';
									}
								}
							?>
						</select>
						<label for="colonia">Colonia *</label>
					</div>
				</div>
			</div>
			<div class="col l4 line-card line-card-1 especial-p">
				<div class="row">
					<div class="col l12" style="margin-bottom: 30px;">
						<p class="bold">Datos Bancarios</p>
					</div>
					<div class="input-border col l12">
						<input type="text" name="clabe" id="clabe" required pattern="[0-9]{18}" maxlength="18" title="Por favor, ingresa exactamente 18 dígitos numéricos." onchange="datos_banco(this.value)" value="<?php echo $clabe;?>">
						<label for="clabe" style="margin-bottom: 10px !important;">Cuenta CLABE *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12" id="bancoemisor">
						<input type="text" name="bank" id="bank" disabled required value="<?php echo $banco;?>">
						<label for="bank">Banco emisor *</label>
					</div>
				</div>
				<div class="row" style="text-align: center;">
					<button class="button-gray" style="margin-left: 20px;" type="submit" name="action">Guardar datos de la empresa</button>	
				</div>
			</div>
			</form>
		</div>
		<div class="col l3 center-align">
			<div class="container" id="logotipo">
				<form id="fadlogotipo" name="fadlogotipo">
					<h5 class="card-title">Seleccionar logotipo</h5>
					<img src="<?php if ($logotipo == 1){ echo base_url('boveda/' . $unique . '/logotipo.jpg'); } else if ($logotipo == 0) { echo 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg'; }?>" alt="" style="max-width: 140px; max-height: 140px;"><br>
					<label for="imglogotipo" class="button-gray p-5">
						<?php if($logotipo == 0){ echo 'Seleccionar Imagen'; } else { echo 'Cambiar Imagen'; }?>
					</label>
					<input name="imglogotipo" id="imglogotipo" type="file" accept="image/jpeg" maxFileSize="1048576" />
				</form>
			</div>
		</div>
	</div>
		<div class="row card esquinasRedondas" style="padding:20px">
			<div class="row line-card-2" id="divactac">
				<div class="col s3">
					<form id="fadactac" name="fadactac">
						<label for="actac" class="button-gray p-5">
							<?php if($actac == 0){echo 'Seleccionar Archivo'; } else if ($actac == 1){ echo 'Actualizar Archivo';} ?>
						</label>
						<input name="actac" id="actac" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s9">
					<p><?php if($actac == 0){echo 'No existe documento';}else if ($actac == 1){echo '<a href="'.$urlArchivos.'acta_constitutiva.pdf" target="_blank">Ver Acta Constitutiva</a>';}?></p>
				</div>
			</div>

			<div class="row line-card-2"  id="divconstanciasf">
				<div class="col s3">
					<form id="fadconstanciasf" name="fadconstanciasf">
						<label for="constanciasf" class="button-gray p-5">
							<?php if($constanciasf == 0){echo 'Seleccionar Archivo';}else if($constanciasf == 1){echo 'Actualizar Archivo';} ?>
						</label>
						<input name="constanciasf" id="constanciasf" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s9">
					<p><?php if($constanciasf == 0){echo 'No existe documento';}else if ($constanciasf == 1){echo '<a href="'.$urlArchivos.'constancia_situacion_fistcal.pdf" target="_blank">Ver Constancia de Situación Fiscal</a>';}?></p>
				</div>
			</div>

			<div class="row line-card-2" id="divcomprobanted">
				<div class="col s3">
					<form id="fadcomprobanted" name="fadcomprobanted">
						<label for="comprobanted" class="button-gray p-5">
							<?php if($comprobanted == 0){echo 'Seleccionar Archivo';}else if($comprobanted == 1){echo 'Actualizar Archivo';} ?>
						</label>
						<input name="comprobanted" id="comprobanted" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s9">
					<p><?php if($comprobanted == 0){echo 'No existe documento';}else if($comprobanted == 1){echo '<a href="'.$urlArchivos.'comprobante_domicilio.pdf" target="_blank">Ver Comprobante de domicilio</a>';}?></p>
				</div>
			</div>

			<div class="row line-card-2" id="dividentificacionrl">
				<div class="col s3">
					<form id="fadidentificacionrl" name="fadidentificacionrl">
						<label for="identificacionrl" class="button-gray p-5">
							<?php if($identificacionrl == 0){echo 'Seleccionar Archivo';}else if($identificacionrl == 1){echo 'Actualizar Archivo';} ?>
						</label>
						<input name="identificacionrl" id="identificacionrl" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s9">
					<p><?php if($identificacionrl == 0){echo 'No existe documento';}else if($identificacionrl == 1){echo '<a href="'.$urlArchivos.'identificacion_representante_legal.pdf" target="_blank">Ver Identificacion de Representante Legal</a>';}?></p>
				</div>
			</div>
		
		</div>
	
	<!-- Modal Registrarse como Proveedor -->
	<div id="modal-proveedor" class="modal">
		<div class="modal-content">
			
		</div>
	</div>
	<!-- Modal Registrarse como Proveedor -->
	<div id="modal-proveedor-final" class="modal">
		<div class="modal-content">
			
		</div>
	</div>
	<!-- Modal datos faltantes -->
	<div id="modal-datos-empresa" class="modal">
		<div class="modal-content">
			<h5>Datos empresa</h5>
			<div class="card-content" id="form_accionistas">
				<p>Por favor completa los datos restantes para poder activar tu cuenta</p>
			</div>
		</div>
	</div>
</div>

<style>
	.card-title {
		margin-bottom: 30px !important;
		font-weight: bold !important;
	}
	
	.modal {
		max-height: 83% !important;
		width: 80% !important;
	}
	
	.h5-modular {
		line-height: 0%;
	}
	
	.btn {
		background: #444444;
	}
	
	.btn:hover {
		background: #e0e51d;
	}
	
	.especial-p {
		padding-right: 4% !important;
	}
	
	.cover {
		width: 99%;
	}
	
	input[type="file"] {
		display: none;
	}
	
	.custom-file-upload {
		color: white;
		background: #444;
		display: inline-block;
		padding: 10px 40px;
		cursor: pointer;
		border-radius: 3px !important;
	}
	
	.error-message {
		color: red;
		font-size: 10px;
		top: -25px;
		position: relative;
	}
	
	.iconoSetting {
		position: relative;
		top: 6px;
	}
	
	.linkConfiguracion {
		color: black;
	}
	
	.custom-file-upload:hover {
		border: none;
	}
	
	.cancelar:hover,
	.cancelar:focus {
		background-color: #444 !important;
	}
	
	.guardar,
	.cancelar:focus {
		background-color: #e0e51d !important;
	}
	
	]


</style>
<script>

	<?php if( $this->session->userdata('datosEmpresa')["address"] == '' OR $this->session->userdata('datosEmpresa')["telephone"] == '' OR $this->session->userdata('datosEmpresa')["account_clabe"] == '') { ?>
	
	$(document).ready(function(){
		$('#modal-datos-empresa').modal('open');
	});

	<?php } else if( $this->session->userdata('datosEmpresa')['accionistas'] == 0 )	{ ?>
		
	//$(document).ready(function(){
	//	$('#modal-proveedor-final').modal('open');
	//});

	<?php }	else if ( empty( $this->session->userdata ( 'datosEmpresa' )[ 'rec_id' ] ) ) { ?>

	//$(document).ready(function(){
	//	$('#modal-proveedor').modal('open');
	//});

	<?php } ?>

function ad_acc(nombreacc, capital, tipo){
	$.ajax({
		type: 'POST',
		url : '<?php echo base_url('Proveedor/registra_accionista');?>',
		data: 'nombreacc=' + nombreacc + '&capitalsocial=' + capital + '&tipoa=' + tipo
    }).done (function ( info ){
		$('#accionistas' + tipo).html(info);
	});
}

function add_persona_control(){

	var personacontrol = document.getElementById('personacontrol').value;
	var cargofuncion = document.getElementById('cargofuncion').value;
	var nombre = document.getElementById('nombre').value;
	var appaterno = document.getElementById('appaterno').value;
	var apmaterno = document.getElementById('apmaterno').value;
	var fechanacimiento = document.getElementById('fechanacimiento').value;
	var paisnacimiento = document.getElementById('paisnacimiento').value;
	var entidadnacimiento = document.getElementById('entidadnacimiento').value;
	var rfc = document.getElementById('rfc').value;
	var paisrecidencia = document.getElementById('paisrecidencia').value;
	var paisresidenciafiscal = document.getElementById('paisresidenciafiscal').value;
	var nacionalidad = document.getElementById('nacionalidad').value;
	var curp = document.getElementById('curp').value;
	var tipodireccion = document.getElementById('tipodireccion').value;
	var calle = document.getElementById('calle').value;
	var numext = document.getElementById('numext').value;
	var numint = document.getElementById('numint').value;
	var pais = document.getElementById('pais').value;
	var cp = document.getElementById('cp').value;
	var colonia = document.getElementById('colonia').value;
	var entidad = document.getElementById('entidad').value;
	var numtelefono = document.getElementById('numtelefono').value;
	var tipoiden = document.getElementById('tipoiden').value;
	var numiden = document.getElementById('numiden').value;

	$.ajax({
		url: "<?php echo base_url('Proveedor/guarda_accionista');?>",
		type: "POST",
		data: "personacontrol=" + personacontrol +
				"&cargofuncion=" + cargofuncion +
				"&nombre=" + nombre +
				"&appaterno=" + appaterno + 
				"&apmaterno=" + apmaterno + 
				"&fechanacimiento=" + fechanacimiento + 
				"&paisnacimiento=" + paisnacimiento + 
				"&entidadnacimiento=" + entidadnacimiento + 
				"&rfc=" + rfc + 
				"&paisrecidencia=" + paisrecidencia + 
				"&paisresidenciafiscal" + paisresidenciafiscal +
				"&nacionalidad=" + nacionalidad +
				"&curp=" + curp +
				"&tipodireccion=" + tipodireccion +
				"&calle=" + calle +
				"&numext=" + numext + 
				"&numint=" + numint + 
				"&pais=" + pais + 
				"&cp=" + cp + 
				"&colonia=" + colonia + 
				"&entidad=" + entidad + 
				"&numtelefono=" + numtelefono +
				"&tipoiden=" + tipoiden +
				"&numiden=" + numiden
	}).done(function(info){
		$("#form_accionistas").html(info);
	});
}

function datos_estado(cp){
    $.ajax({
		url: "<?= base_url('perfil/estado'); ?>",
		type: "POST",
		data: 'codigopostal=' + cp
	}).done(function(echo){
		$("#nombre_estado").html(echo);
	});

    $.ajax({
		url: "<?= base_url('perfil/municipio'); ?>",
		type: "POST",
		data: 'codigopostal=' + cp
	}).done(function(echo){
		$("#nombre_municipio").html(echo);
	});

	$.ajax({
		url: "<?= base_url('perfil/colonia'); ?>",
		type: "POST",
		data: 'codigopostal=' + cp
	}).done(function(echo){
		$("#nombre_colonia").html(echo);
	});
}

function datos_banco(clabe){
    $.ajax({
		url: "<?= base_url('perfil/banco'); ?>",
		type: "POST",
		data: 'clabe=' + clabe
	}).done(function(echo){
		$("#bancoemisor").html(echo);
	});
}

$("#imglogotipo").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadlogotipo"));
    $.ajax({
		url: "<?= base_url('perfil/adlogo'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#logotipo").html(echo);
	});
});

$("#actac").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadactac"));
    $.ajax({
		url: "<?= base_url('perfil/adactac'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divactac").html(echo);
	});
});

$("#constanciasf").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadconstanciasf"));
    $.ajax({
		url: "<?= base_url('perfil/adconstanciasf'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divconstanciasf").html(echo);
	});
});

$("#comprobanted").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadcomprobanted"));
    $.ajax({
		url: "<?= base_url('perfil/adcomprobanted'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divcomprobanted").html(echo);
	});
});

$("#identificacionrl").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadidentificacionrl"));
    $.ajax({
		url: "<?= base_url('perfil/adidentificacionrl'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#dividentificacionrl").html(echo);
	});
});


</script>
