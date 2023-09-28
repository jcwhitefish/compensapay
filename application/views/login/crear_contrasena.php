<div class="p-5" id="app">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
            <h6>Bienvenido <?= $nombre_d_usaurio; ?> <?= $apellido_usuario; ?>, tu cuenta ha sido verificada, por favor crea una contraseña para poder ingresar al sistema</h6>

                <div class="col l6 center-align">
                    <img src="<?= base_url('assets/images/CompensaPay_Logos-01.png'); ?>" alt="Logo" class="custom-image">
                    <p>¿Aún no eres socio?, regístrate <a href="<?= base_url('registro/Empresa');  ?>">aquí</a></p><br>
                </div>
                <div class="col l6 p-5">
                    <form @submit.prevent="submitForm" method="post" action="<?= base_url('login'); ?>">
                        <div class="container input-border">
                            <input v-model="data['userValidate']" @blur="checkFormat('userValidate')" :style="colorsBorder['userValidate'] || {}" type="text" name="userValidate" id="userValidate" :placeholder="data['userValidate']" required disabled>
                            <label for="userValidate">Usuario</label>
                            <input v-model="data['passwordValidate']" @blur="checkFormat('passwordValidate')" :style="colorsBorder['passwordValidate'] || {}" type="password" name="passwordValidate" id="passwordValidate" placeholder="Verificar contraseña" required>
                            <label for="passwordValidate">Contraseña</label>
                            <p v-if="colorsBorder['passwordValidate'] && colorsBorder['passwordValidate'].border === '1px solid red!important'" class="error-message">!Contraseña inválida! Asegurate de tener una letra mayuscula, una letra minuscula, una caracter especial y una caracter numerico</p>
                            <input v-model="data['passwordCompareValidate']" @blur="checkFormat('passwordCompareValidate')" :style="colorsBorder['passwordCompareValidate'] || {}" type="password" name="passwordCompareValidate" id="passwordCompareValidate" placeholder="Verificar contraseña" required>
                            <label for="passwordCompareValidate">Verificar contraseña</label>
                            <p v-if="colorsBorder['passwordCompareValidate'] && colorsBorder['passwordCompareValidate'].border === '1px solid red!important'" class="error-message">Tus contraseñas no coinciden!</p>
                        </div>
                        <div class="container right-align">
                            <label>
                                <input v-model="data['sessionValidate']" class="filled-in" type="checkbox" />
                                <span>Guardar datos en este equipo</span>
                            </label>
                        </div>
                        <div class="center-align p-5">
                            <p>aquí va el captcha xd</p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const { createApp, computed, reactive, ref, isRef } = Vue;

    const app = createApp({
        setup() {
            const data = reactive({
                userValidate: ref('<?= $nombre_usuario;  ?>'),
                passwordValidate: ref(''),
                passwordCompareValidate: ref(''),
                sessionValidate:ref(true)
            });

            const colorsBorder = reactive({});
            

            const checkFormat = (nombreInput) => {
                if (!isRef(colorsBorder[nombreInput])) {
                    colorsBorder[nombreInput] = ref('');
                }

                switch (nombreInput) {
                    case 'passwordValidate':
                        const password = data[nombreInput];
                        const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[#$%&?!])(?=.*\d).{8,15}$/;
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
            const submitForm = () =>{
                
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
</style>