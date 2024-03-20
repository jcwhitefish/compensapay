<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $comprobanted = base_url('boveda/'.$unique.'/comprobante_domicilio.pdf');
?>
<p><strong>6. Comprobante de Domicilio (obligatorio)</strong></p>
<div class="col s3">
	<form id="fadcomprobanted" name="fadcomprobanted">
		<label for="comprobanted" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="comprobanted" id="comprobanted" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s3">
	<p><a href="<?php echo $comprobanted;?>" target="_blank">Ver Comprobante de Domicilio</a></p>
</div>
<div class="col s6">
	<p>Comprobante de domicilio no mayor a 3 meses de antigüedad (únicamente si es diferente al domicilio fiscal)</p>
</div>
<script>
	M.toast({html: 'Comprobante de Domicilio Guardado Satisfactoriamente', 
			displayLength: 2000, 
			duration: 2000});
</script>