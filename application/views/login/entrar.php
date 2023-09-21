<div class="p-5" id="app">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div class="col l6 center-align">
                    <img src="<?= base_url('assets/images/CompensaPay_Logos-01.png'); ?>" alt="Logo" class="custom-image">
                    <p>¿Aún no eres socio?, regístrate <a href="#">aquí</a></p><br>
                </div>
                <div class="col l6 p-5">
                    <form method="post" action="<?= base_url('login'); ?>">
                        <div class="container input-border">
                            <input v-model="data['user']" @blur="checkFormat('user')" :style="colorsBorder['user'] || {}" type="text" name="user" id="user" placeholder="Usuario" required>
                            <label for="user">Usuario</label>
                            <input v-model="data['password']" @blur="checkFormat('password')" :style="colorsBorder['password'] || {}" type="password" name="password" id="password" placeholder="Contraseña" required>
                            <label for="password">Contraseña</label>
                        </div>
                        <?php 
                            if (isset($error_message) && !empty($error_message)) {
                                echo $error_message;
                        } ?>
                        <div class="container right-align">
                            <label>
                                <input class="filled-in" type="checkbox" />
                                <span>Guardar datos en este equipo</span>
                            </label>
                        </div>
                        <div class="center-align p-5">
                            <p>aquí va el captcha xd</p>
                        </div>
                        <div class="right-align container">
                            <button class="button-gray" type="submit">Iniciar Sesión</button>
                            <p class="p-1"><a href="#"><u>Olvidé mi contraseña</u></a></p>
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
                user: ref(''),
                password: ref(''),
            });

            const colorsBorder = reactive({});
            

            const checkFormat = (nombreInput) => {
                if (!isRef(colorsBorder[nombreInput])) {
                    colorsBorder[nombreInput] = ref('');
                }

                switch (nombreInput) {
                    case 'user':
                    case 'password':
                        if (data[nombreInput] !== '') {
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

            return {
                data,
                colorsBorder,
                checkFormat,
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
</style>

<!-- cadena_validar = '{"Usuario":"DemoUser","Llave":"Pasrd"}';
$validar_acceso=$this->Interaccionbd->ValidarAcceso($cadena_validar);
echo $validar_acceso; -->