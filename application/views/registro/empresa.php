<div class="container">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title">Registro de Empresa</h2>
            <form method="post" action="<?php echo site_url('controladorcontroller/save_xd'); ?>" class="col l12" enctype="multipart/form-data">
                <div class="row">
                    <div class="col l5 especial-p">
                        <div class="row">
                            <div class="col l12" style="margin-bottom: 30px;">
                                <p class="bold">Detalles de la empresa</p>
                            </div>
                            <div class="input-border col l6">
                                <input type="text" name="bussinesName" id="bussinesName" required>
                                <label for="bussinesName">Razón Social</label>
                            </div>
                            <div class="input-border col l6">
                                <select name="type" id="type">
                                    <option value="perfil1">Perfil 1</option>
                                    <option value="perfil2">Perfil 2</option>
                                    <option value="perfil3">Perfil 3</option>
                                </select>
                                <label>Giro</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input type="text" name="nameComercial" id="nameComercial" required>
                                <label for="nameComercial">Nombre Comercial</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l6">
                                <input type="text" name="rfc" id="rfc">
                                <label for="rfc">RFC</label>
                            </div>
                            <div class="input-border col l6">
                                <select name="fiscal" id="fiscal">
                                    <option value="perfil1">Perfil 1</option>
                                    <option value="perfil2">Perfil 2</option>
                                    <option value="perfil3">Perfil 3</option>
                                </select>
                                <label>Regimen Fiscal</label>
                            </div>
                        </div>
                    </div>
                    <div class="col l4 line-card especial-p">
                        <div class="row">
                            <div class="col l12" style="margin-bottom: 30px;">
                                <p class="bold">Datos Bancarios</p>
                            </div>
                            <div class="input-border col l12">
                                <input type="text" name="clabe" id="clabe" required>
                                <label for="clabe">Cuenta CLABE</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <select name="bank" id="bank">
                                    <option value="perfil1">Perfil 1</option>
                                    <option value="perfil2">Perfil 2</option>
                                    <option value="perfil3">Perfil 3</option>
                                </select>
                                <label>Banco emisor</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <p class="bold p-3">Soy Proveedor</p>
                                <select name="bank" id="bank">
                                    <option value="perfil1">Trafigura</option>
                                    <option value="perfil2">Perfil 2</option>
                                    <option value="perfil3">Perfil 3</option>
                                </select>
                                <label>Cliente</label>
                            </div>
                        </div>
                    </div>
                    <div class="col l3 center-align">
                        <div class="container">
                            <h2 class="card-title">Imagen de perfil</h2>
                                <img src="https://socialistmodernism.com/wp-content/uploads/2017/07/placeholder-image.png?w=640" alt="" style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
                                <div class="file-field">
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate " type="text" style="visibility: hidden;">
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
                    <div class="col l12 ">
                        <div class="col l12">
                           <p class="bold">Sube tus documentos</p>
                        </div>
                        <div class="file-field">
                            <div class="row">
                                <div class=" col l9 file-path-wrapper input-border especial-p">
                                    <input class="file-path validate " type="text">
                                </div>
                                <div class=" col l3 p-4 center-button hide">
                                    <div class="btn">
                                        <span>Agregar</span>
                                        <input type="file" name="photo" id="photo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col l12 right-align">
                        <button class="btn waves-effect waves-light " type="submit" name="action">Siguiente</button>
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
    .input-border p{
        
    }

</style>