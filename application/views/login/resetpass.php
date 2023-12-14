<div class="p-5" id="app">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div class="col l6 center-align">
                    <img src="<?= base_url('assets/images/logo_solve_1.svg'); ?>" alt="Logo" class="custom-image">
                </div>
                <div class="col l6 p-5">
                    <form method="POST" action="<?= base_url('login/resetpass'); ?>">
                        <div class="container input-border">
                            <input type="text" name="user" id="user" placeholder="Usuario o correo" required>
                            <label for="user">Ingresa usuario o correo electrónico</label>
                        </div>
                        
                       

                        <div class="right-align container">
                            <button class="button-gray" type="submit">Validar Correo</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>