<div class="p-5" id="app">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <h6>Bienvenido <?= $nombre_d_usaurio; ?> <?= $apellido_usuario; ?>, tu cuenta ha sido verificada, por favor crea una contraseña para poder ingresar al sistema</h6>

                <div class="col l6 center-align">
                    <img src="<?= base_url('assets/images/SolveCapital_Branding-18.png'); ?>" alt="Logo" class="custom-image">
                    <p>¿Aún no eres socio?, regístrate <a href="<?= base_url('registro/Empresa');  ?>">aquí</a></p><br>
                </div>
                <div class="col l6 p-5">
                    <form @submit.prevent="submitForm" method="post" action="<?= base_url('login'); ?>">
                        <div class="container input-border">
                            <input v-model="data['userValidate']" @blur="checkFormat('userValidate')" :style="colorsBorder['userValidate'] || {}" type="text" name="userValidate" id="userValidate" :placeholder="data['userValidate']" required disabled>
                            <label for="userValidate">Usuario</label>
                            <input v-model="data['passwordValidate']" @blur="checkFormat('passwordValidate')" :style="colorsBorder['passwordValidate'] || {}" type="password" name="passwordValidate" id="passwordValidate" placeholder="Crea contraseña" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[#$%@&?!])(?=.*\d).{8,15}$" title="Debe tener una letra mayuscula, una letra minuscula, un caracter especial, un caracter numerico y de 8 a 15 caracteres" required>
                            <label for="passwordValidate">Contraseña</label>
                            <p v-if="colorsBorder['passwordValidate'] && colorsBorder['passwordValidate'].border === '1px solid red!important'" class="error-message">!Contraseña inválida! Asegurate de tener una letra mayuscula, una letra minuscula, un caracter especial, un caracter numerico y de 8 a 15 caracteres</p>
                            <input v-model="data['passwordCompareValidate']" @blur="checkFormat('passwordCompareValidate')" :style="colorsBorder['passwordCompareValidate'] || {}" type="password" name="passwordCompareValidate" id="passwordCompareValidate" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[#$%@&?!])(?=.*\d).{8,15}$" placeholder="Verificar contraseña" required>
                            <label for="passwordCompareValidate">Verificar contraseña</label>
                            <p v-if="colorsBorder['passwordCompareValidate'] && colorsBorder['passwordCompareValidate'].border === '1px solid red!important'" class="error-message">Tus contraseñas no coinciden!</p>
                        </div>

                        <div class="center-align p-5">
                            <p></p>
                        </div>
                        <div class="right-align container">
                            <button class="button-gray waves-effect waves-teal" type="submit">Ingresar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const {
        createApp,
        computed,
        reactive,
        ref,
        isRef
    } = Vue;

    const app = createApp({
        setup() {
            const data = reactive({
                userId: ref('<?= $id_usuario;  ?>'),
                userValidate: ref('<?= $nombre_usuario;  ?>'),
                passwordValidate: ref(''),
                passwordCompareValidate: ref(''),
                sessionValidate: ref(true)
            });

            const colorsBorder = reactive({});


            const checkFormat = (nombreInput) => {
                if (!isRef(colorsBorder[nombreInput])) {
                    colorsBorder[nombreInput] = ref('');
                }

                switch (nombreInput) {
                    case 'passwordValidate':
                        const password = data[nombreInput];
                        const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[#$%@&?!])(?=.*\d).{8,15}$/;
                        if (regex.test(password)) {
                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            };
                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            };
                        }
                        break;
                    case 'passwordCompareValidate':
                        if (data['passwordValidate'] == data['passwordCompareValidate']) {
                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            };
                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            };
                        }
                        break;
                    default:
                }
            };
            const submitForm = () => {
                //console.log('Verificamos que no esten en rojo');
                //TODO:esta es la forma correcta de validar los formularios
                for (const key in data) {

                    if (key != 'sessionValidate' && key != 'userValidate') {
                        if (JSON.stringify(colorsBorder[key]) === JSON.stringify({
                                border: '1px solid red!important'
                            })) {
                            return; //detiene el codigo
                        }

                    }

                }
                const formData = new FormData();
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        formData.append(key, data[key]);
                    }
                }
                fetch('<?php echo base_url('login/crearContrasena') ?>', {
                        method: 'POST',
                        body: formData,
                        redirect: 'follow'
                    })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error('La solicitud no fue exitosa');
                        }
                        return response.json();
                    })
                    .then((responseData) => {
                        //console.log(responseData);
                        // Hacer algo con los datos, por ejemplo, retornarlos
                        // accion = responseData
                        window.location.replace('<?php echo base_url('login'); ?>');


                    })
                    .catch((error) => {
                        console.error('Error al realizar la solicitud fetch:', error);
                    });


            }

            return {
                data,
                colorsBorder,
                checkFormat,
                submitForm
            };
        },
    });
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

    .error-message {
        color: red;
        font-size: 10px;
        top: -25px;
        position: relative;
    }

    .btn:hover {
        background: #e0e51d;
    }
</style>