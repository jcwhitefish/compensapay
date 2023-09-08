<div class="container">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title">Registro de usuario</h2>
            <form method="post" action="<?php echo site_url('controladorcontroller/save_xd'); ?>" class="col l12" enctype="multipart/form-data">
                <div class="row">
                    <div class="col l5 especial-p">
                        <div class="row">
                            <div class="col l12" style="margin-bottom: 30px;">
                                <p>Datos generales</p>
                            </div>
                            <div class="input-border col l6">
                                <input type="text" name="user" id="user" required>
                                <label for="user">Usuario *</label>
                            </div>
                            <div class="input-border col l6">
                                <select name="profile" id="profile">
                                    <option value="perfil1">Perfil 1</option>
                                    <option value="perfil2">Perfil 2</option>
                                    <option value="perfil3">Perfil 3</option>
                                </select>
                                <label>Perfil</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input type="email" name="email" id="email" required>
                                <label for="email">Correo *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l6">
                                <input type="text" name="name" id="name">
                                <label for="name">Nombre</label>
                            </div>
                            <div class="input-border col l6">
                                <input type="text" name="lastname" id="lastname">
                                <label for="lastname">Apellidos</label>
                            </div>
                        </div>
                        <div class="col l12">
                            <label>
                                <input id="indeterminate-checkbox" class="filled-in" type="checkbox" />
                                <span>Enviar confirmación por correo electrónico</span>
                            </label>
                        </div>
                    </div>
                    <div class="col l4 line-card hide-on-med-and-down"></div>
                    <div class="col l3 center-align">
                        <div class="container">
                            <h2 class="card-title">Imagen de perfil</h2>
                                <img src="https://socialistmodernism.com/wp-content/uploads/2017/07/placeholder-image.png?w=640" alt="" style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
                                <div class="file-field">
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate " type="text">
                                    </div>
                                    <div class="btn">
                                        <span>Foto de Perfil</span>
                                        <input type="file" name="photo" id="photo">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12 center-align">
                        <button class="btn waves-effect waves-light" type="submit" name="action">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .card-title{
        margin-bottom: 30px !important;
        font-weight: bold !important;
    }
    .btn{
        background: #444444;
    }
    
    .btn:hover {
        background: #e0e51d;
    }

    .especial-p{
        padding-right: 4% !important;
    }
    
</style>