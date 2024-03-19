<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $identificacionrl = base_url('boveda/'.$unique.'/identificacion_representante_legal.pdf');
?>
<div class="col s3">
	<form id="fadidentificacionrl" name="fadidentificacionrl">
		<label for="identificacionrl" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="identificacionrl" id="identificacionrl" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s9">
	<p><a href="<?php echo $identificacionrl;?>" target="_blank">Ver Identificación de Representante Legal</a></p>
</div>