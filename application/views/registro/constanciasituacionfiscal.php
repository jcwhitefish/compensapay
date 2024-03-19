<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $constanciasf = base_url('boveda/'.$unique.'/constancia_situacion_fiscal.pdf');
?>
<div class="col s3">
	<form id="fadconstanciasf" name="fadconstanciasf">
		<label for="constanciasf" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="constanciasf" id="constanciasf" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s9">
	<p><a href="<?php echo $constanciasf;?>" target="_blank">Ver Constancia de Situación Fiscal</a></p>
</div>