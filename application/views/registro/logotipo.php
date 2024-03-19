<?php
    $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

    $image = base_url('boveda/'.$unique.'/logotipo.jpg');
?>
<form id="fadlogotipo" name="fadlogotipo">
	<h5 class="card-title">Seleccionar logotipo</h5>
	<img src="<?php echo $image;?>" alt="" style="max-width: 140px; max-height: 140px;"><br>
	<label for="imglogotipo" class="button-gray p-5">
		Cambiar Imagen
	</label>
	<input name="imglogotipo" id="imglogotipo" type="file" accept="image/jpeg" maxFileSize="1048576" />
</form>