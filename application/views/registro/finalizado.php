<div class="p-5">
    <div class="card esquinasRedondas">
        <div class="card-content especial-p">
            <a href="<?php echo base_url('login/validarCuenta/'.$enlace);?>">Esto no se va a ver pero es el link del correo</a>
            <p>Hola <?php echo $nombre;?>, bienvenido a <strong>Compensa</strong> pay, hemos enviado un correo a <?php echo $correo;?>, por favor activa tu cuenta para poder ingresar a nuestra plataforma.</p><br>
            <p>Si tienes dudas o comentarios puedes comunicarte al correo <strong>soporte@compensapay.mx</strong></p>
            <div class="center-align">
                <img src="<?= base_url('assets/images/CompensaPay_Logos-02.png'); ?>" alt="Logo" class="size-image">
            </div>
        </div>
    </div>
</div>

<style>
    .size-image{
        max-width: 40%; 
        max-height: 40%; 
        width: auto; 
        height: auto;
    }
    .especial-p {
        padding: 5% !important;
    }

</style>
