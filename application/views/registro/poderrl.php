<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $poderrl = base_url('boveda/'.$unique.'/poder_representante_legal.pdf');
?>
<p><strong>3. Poder del representante legal </strong></p>
<div class="col s3">
	<form id="fadpoderrl" name="fadpoderrl">
		<label for="poderrl" class="button-gray p-5">
			Actualizar Archivo
		</label>
		<input name="poderrl" id="poderrl" type="file" accept="application/pdf" maxFileSize="5242880" />
	</form>
</div>
<div class="col s3">
	<p><a href="<?php echo $poderrl;?>" target="_blank">Ver Poder del Representante Legal</a></p>
</div>
<div class="col s6">
	<p>Poder del representante legal (solo cuando no se encuentre contenido en el acta constitutiva de la empresa)</p>
</div>
<script>
	M.toast({html: 'Poder Representante Legal Guardado Satisfactoriamente', 
			displayLength: 2000, 
			duration: 2000});
</script>