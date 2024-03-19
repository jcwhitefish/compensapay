<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $comprobanted = base_url('boveda/'.$unique.'/comprobante_domicilio.pdf');
?>
<div class="col s3">
	<form id="fadcomprobanted" name="fadcomprobanted">
		<label for="comprobanted" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="comprobanted" id="comprobanted" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s9">
	<p><a href="<?php echo $comprobanted;?>" target="_blank">Ver Comprobante de Domicilio</a></p>
</div>