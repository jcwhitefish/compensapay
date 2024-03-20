<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $propietarior = base_url('boveda/'.$unique.'/propietario_real.pdf');
?>
<p><strong>8. Propietario Real</strong></p>
<div class="col s3">
	<form id="fadpropietarior" name="fadpropietarior">
		<label for="propietarior" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="propietarior" id="propietarior" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s3">
	<p><a href="<?php echo $propietarior;?>" target="_blank">Ver Identificación del Propietario Real</a></p>
</div>
<div class="col s6">
	<p>Identificación oficial vigente del propietario real</p>
</div>
<script>
	M.toast({html: 'Identificación Guardado Satisfactoriamente', 
			displayLength: 2000, 
			duration: 2000});
</script>