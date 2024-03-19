<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $actac = base_url('boveda/'.$unique.'/acta_constitutiva.pdf');
?>
<div class="col s3">
	<form id="fadactac" name="fadactac">
		<label for="actac" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="actac" id="actac" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s9">
	<p><a href="<?php echo $actac;?>" target="_blank">Ver Acta Constitutiva</a></p>
</div>