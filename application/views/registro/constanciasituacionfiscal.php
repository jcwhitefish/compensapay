<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $constanciasf = base_url('boveda/'.$unique.'/constancia_situacion_fiscal.pdf');
?>
<p><strong>5. Constancia de Situación Fiscal (obligatorio)</strong></p>
<div class="col s3">
	<form id="fadconstanciasf" name="fadconstanciasf">
		<label for="constanciasf" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="constanciasf" id="constanciasf" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s3">
	<p><a href="<?php echo $constanciasf;?>" target="_blank">Ver Constancia de Situación Fiscal</a></p>
</div>
<div class="col s6">
	<p>Constancia de situación fiscal de reciente emisión (del año en curso)</p>
</div>
<script>
	M.toast({html: 'Constancia de situación Fiscal Guardado Satisfactoriamente', 
			displayLength: 2000, 
			duration: 2000});
</script>