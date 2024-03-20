<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $escriturasp = base_url('boveda/'.$unique.'/escrituras_publicas.pdf');
?>
<p><strong>2. Escrituras Públicas (obligatorio)</strong></p>
<div class="col s3">
	<form id="fadescriturasp" name="fadescriturasp">
		<label for="escriturasp" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="escriturasp" id="escriturasp" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s3">
	<p><a href="<?php echo $escriturasp;?>" target="_blank">Ver Escrituras Públicas</a></p>
</div>
<div class="col s6">
	<p>Escrituras públicas en donde consten modificaciones en la empresa (aplica para casos de transformación, fusión, escisión o cambio de denominación)</p>
</div>
<script>
	M.toast({html: 'Escrituras Públicas Guardado Satisfactoriamente', 
			displayLength: 2000, 
			duration: 2000});
</script>