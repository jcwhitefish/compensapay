<?php
if(is_array($propietario))
{
    foreach($propietario AS $value){
        $correoepr = $value["CorreoE"];
        $domiciliopr = $value["Domicilio"];
        $curppr =  $value["Curp"];
        $telefonopr = $value["Telefono"];
        $ocupacionpr = $value["Ocupacion"];
    }
}
?>
<p><strong>9. Información del Propietario Real</strong></p>
<form id="fadinfopropietarior" name="fadinfopropietarior">
	<div class="row">
		<div class="col s4">
			<div class="input-border col l12">
				<input type="email" name="correoepr" id="correoepr" required pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" title="Por favor, ingresa un correo electrónico de contacto." value="<?php echo $correoepr;?>">
				<label for="correoepr">Correo Electrónico *</label>
			</div>
		</div>
		<div class="col s4">
			<div class="input-border col l12">
				<input type="text" name="domiciliopr" id="domiciliopr" required title="Por favor, ingresa el domicilio completo." value="<?php echo $domiciliopr;?>">
				<label for="domiciliopr">Domiclio *</label>
			</div>
		</div>
		<div class="col s4">
			<div class="input-border col l12">
				<input type="text" name="curppr" id="curppr" required pattern="^[A-Z]{4}\d{6}[H,M][A-Z]{5}[A-Z0-9]{2}$" title="Por favor, ingresa el curp." value="<?php echo $curppr;?>">
				<label for="correoepr">CURP *</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col s4">
			<div class="input-border col l12">
				<input type="text" name="telefonopr" id="telefonopr" required pattern="[0-9]{10}" maxlength="10" title="Por favor, ingresa un teléfono de contacto." value="<?php echo $telefonopr;?>">
				<label for="telefonopr">Numero Telefonico *</label>
			</div>
		</div>
		<div class="col s4">
			<div class="input-border col l12">
				<input type="text" name="ocupacionpr" id="ocupacionpr" required title="Por favor, ingresa la ocupación del propietario real." value="<?php echo $ocupacionpr;?>">
				<label for="ocupacionpr">Ocupación *</label>
			</div>
		</div>
		
		<div class="col s4">
			<div style="padding: 20px;">
				<input type="submit" name="savepr" id="savepr" value="Guardar Datos del propietario real" class="button-gray">
			</div>
		</div>
	</div>
</form>
<script>
	M.toast({html: 'Información del propietario guardada satisfactoriamente', 
			displayLength: 2000, 
			duration: 2000});
</script>