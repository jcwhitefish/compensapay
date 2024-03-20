<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $identificacionrl = base_url('boveda/'.$unique.'/identificacion_representante_legal.pdf');
?>
<p><strong>4. Identificación del representante legal (obligatorio)</strong></p>
<div class="col s3">
	<form id="fadidentificacionrl" name="fadidentificacionrl">
		<label for="identificacionrl" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="identificacionrl" id="identificacionrl" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s3">
	<p><a href="<?php echo $identificacionrl;?>" target="_blank">Ver Identificación de Representante Legal</a></p>
</div>
<div class="col s6">
	<p>Identificación oficial y vigente del representante legal</p>
</div>
<script>
	M.toast({html: 'Identificación Representante Legal Guardado Satisfactoriamente', 
			displayLength: 2000, 
			duration: 2000});
</script>