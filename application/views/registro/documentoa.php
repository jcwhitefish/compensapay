<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $documentoa = base_url('boveda/'.$unique.'/documento_adicional.pdf');
?>
<p><strong>10. Documentación Adicional</strong></p>
<div class="col s3">
	<form id="faddocumentoa" name="faddocumentoa">
		<label for="documentoa" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="documentoa" id="documentoa" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s3">
	<p><a href="<?php echo $documentoa;?>" target="_blank">Ver Documento Adicional</a></p>
</div>
<div class="col s6">
	<p>Solo en caso de pertenecer a alguno de estos sectores:</p>
	<ul>
		<li>Para actividades de <strong style="text-decoration: underline">outsourcing</strong>, su registro ante el REPSE</li>
		<li>Para actividades relacionadas con <strong style="text-decoration: underline">activos virtuales</strong>, su acuse como actividad vulnerable</li>
		<li>Para actividades relacionadas con <strong style="text-decoration: underline">juegos y apuestas</strong>, su autorización ante SEGOB</li>
	</ul>
</div>
<script>
	M.toast({html: 'Documento Adicional Guardado Satisfactoriamente', 
			displayLength: 2000, 
			duration: 2000});
</script>