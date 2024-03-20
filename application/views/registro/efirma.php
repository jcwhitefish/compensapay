<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $efirma = base_url('boveda/'.$unique.'/e_firma.pdf');
?>
<p><strong>7. Documento e.firma (obligatorio)</strong></p>
<div class="col s3">
	<form id="fadefirma" name="fadefirma">
		<label for="efirma" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="efirma" id="efirma" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s3">
	<p><a href="<?php echo $efirma;?>" target="_blank">Ver Documento e.firma</a></p>
</div>
<div class="col s6">
	<p>Documento donde conste la e.firma de la empresa</p>
</div>
<script>
	M.toast({html: 'Documento  Guardado Satisfactoriamente', 
			displayLength: 2000, 
			duration: 2000});
</script>