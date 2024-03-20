<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $actac = base_url('boveda/'.$unique.'/acta_constitutiva.pdf');
?>
<p><strong>1. Acta Constitutiva (obligatorio)</strong></p>
<div class="col s3">
	<form id="fadactac" name="fadactac">
		<label for="actac" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="actac" id="actac" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s3">
	<p><a href="<?php echo $actac;?>" target="_blank">Ver Acta Constitutiva</a></p>
</div>
<div class="col s6">
	<p>Acta constitutiva (que incluya la constancia de inscripción en el RPPyC o una carta del notario en caso de que se encuentre en proceso de inscripción en el RPPyC)</p>
</div>
<script>
	M.toast({html: 'Acta Constitutiva Guardado Satisfactoriamente', 
			displayLength: 2000, 
			duration: 2000});
</script>