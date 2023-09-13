<div class="p-5">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div class="col l6 center-align">
                <img src="<?= base_url('assets/images/CompensaPay_Logos-01.png'); ?>" alt="Logo" class="custom-image">
                    <p>¿Aún no eres socio?, registrate <a href="">aqui</a></p><br>
                </div>
                <div class="col l6 p-5">
                    <div class="container input-border">
                        <input type="text" name="user" id="user" placeholder="Usuario" required>
                        <label for="user">Usuario</label>
                        <input type="password" name="password" id="password" placeholder="Contraseña" required>
                        <label for="password">Contraseña</label>
                    </div>
                    <div class="container input-border right-align p-5">
                        <label>	                 
                            <input class="filled-in" type="checkbox" />	                               
                            <span>Guardar datos en este equipo</span>	                                
                        </label>
                        <button class="button-gray">Choose this plan</button>
                        <p class="p-1"><a href=""><u>Olvide mi contraseña</u></a></p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>

function onClick(e) {

  e.preventDefault();

  grecaptcha.enterprise.ready(async () => {

    const token = await grecaptcha.enterprise.execute('6LckTgEoAAAAAIwv6mQDBDjTsMnLolQ08wXF_fPC', {action: 'LOGIN'});

    // IMPORTANT: The 'token' that results from execute is an encrypted response sent by

    // reCAPTCHA Enterprise to the end user's browser.

    // This token must be validated by creating an assessment.

    // See https://cloud.google.com/recaptcha-enterprise/docs/create-assessment

  });

}

</script> 

<style>
    .card-title {
        margin-bottom: 30px !important;
        font-weight: bold !important;
    }

    .especial-p {
        padding-right: 3% !important;
    }

    .line-card {
        border-right: 1px solid #ddd;
        height: 400;
    }

    .line-card-right {
        border-right: 1px solid #ddd;
        height: 800px;
    }
</style>