<div class="container">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title">Registro de usuario</h2>
            <form method="post" action="<?php echo site_url('controladorcontroller/save_xd'); ?>" class="col l12" enctype="multipart/form-data">
                <div class="row">
                    <div class="col l5 especial-p">
                        <div class="row">
                            <div class="col l12" style="margin-bottom: 30px;">
                                <p class="bold">Datos generales</p>
                            </div>
                            <div class="input-border col l6">
                                <input v-model="inputValue" @input="validateInput" type="text" name="user" id="user" required>
                                <label for="user">Usuario *</label>
                            </div>
                            <div class="input-border col l6">
                                <!-- Aqui se modifica dependiendo del si fue invitado o no -->
                                <input type="text" name="profile" id="profile" value="" disabled>
                                <label for="profile">Perfil</label>
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
                            <div class="p-5">
                                <button class="btn" name="savePicture">Guardar</button>
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
<script>
    const {
        createApp,
        computed,
        ref
    } = Vue

    createApp({
        setup() {
            const inputValue = ref('');


            const validateInput = async () => {
                try {
                    // Esto solo sirve en POST
                    // const response = await fetch('<?php echo base_url('registro/usuarioUnico') ?>',  {
                    const response = await fetch('<?php echo base_url('registro/usuarioUnico') ?>'+'/'+inputValue.value,  {
                        method: "GET", // *GET, POST, PUT, DELETE, etc.
                        mode: "cors", // no-cors, *cors, same-origin
                        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
                        credentials: "same-origin", // include, *same-origin, omit
                        headers: {
                            "Content-Type": "application/json",
                            // 'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        redirect: "follow", // manual, *follow, error
                        referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                        //Esto solo sirve en POST
                        //body: JSON.stringify({'nombre': 11}), // body data type must match "Content-Type" header
                    }); // Reemplaza la URL con la URL de tu API
                    const responseData = await response.json();
                    //data.value = responseData; // Almacena los datos en data
                    console.log(responseData)
                } catch (error) {
                    console.error('Error al realizar la solicitud fetch:', error);
                }

            }
            return {
                inputValue,
                validateInput
            }
        }
    }).mount('#app')
</script>
<style>
    .card-title {
        margin-bottom: 30px !important;
        font-weight: bold !important;
    }

    .btn {
        background: #444444;
    }

    .btn:hover {
        background: #e0e51d;
    }

    .especial-p {
        padding-right: 4% !important;
    }
</style>