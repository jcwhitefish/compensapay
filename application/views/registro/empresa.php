<div class="container">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title regEmpresa bold">Registro de Empresa</h2>

            <form method="post" action="<?php echo site_url('controladorcontroller/save_xd'); ?>" class="col s12" enctype="multipart/form-data">
                <div class="row">
                    <div class="col l6" >
                        <div class="row">

                            <div class="col l12 detEmpresa">
                                <p class="bold">Detalles de la empresa</p>
                            </div>
                            <div class="input-border col l5">
                                <input type="text" name="user" id="user" required>
                                <label class="bold" for="user">Razon Social</label>
                            </div>
                            <div class="input-border col l5 offset-l2">
                                <select name="profile" id="profile" required>
                                    <option value="perfil1">Perfil 1</option>
                                    <option value="perfil2">Perfil 2</option>
                                    <option value="perfil3">Perfil 3</option>
                                </select>
                                <label class="bold">Giro</label>
                            </div>
                            <div class="input-border col l12">
                                <input type="text" name="user" id="user" required>
                                <label class="bold" for="user">Nombre Comercial</label>
                            </div>
                            <div class="input-border col l5">
                                <input type="text" name="user" id="user" required>
                                <label class="bold" for="user">RFC</label>
                            </div>
                            <div class="input-border col l5 offset-l2">
                                <select name="profile" id="profile" required>
                                    <option value="perfil1">Perfil 1</option>
                                    <option value="perfil2">Perfil 2</option>
                                    <option value="perfil3">Perfil 3</option>
                                </select>
                                <label class="bold">Regimen Fiscal</label>
                            </div>

                        </div>
                    </div>
                    <div class="col l1"></div>
                    <div class="col l3">
                        <div class="col l12 detEmpresa">
                            <p class="bold">Datos Bancarios</p>
                        </div>
                        <div class="input-border col l12">
                            <input type="text" name="user" id="user" required>
                            <label class="bold" for="user">Cuenta Clabe</label>
                        </div>
                        <div class="input-border col l12">
                            <input type="text" name="user" id="user" required>
                            <label class="bold" for="user">Banco Emisor</label>
                        </div>
                    </div>
                    <div class="col l2">
                        hola
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .card-title {
        margin-bottom: 30px !important;
        font-weight: bold !important;
    }

    .detEmpresa {
        margin-left: 40px;
        margin-bottom: 30px;
    }

</style>