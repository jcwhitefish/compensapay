<div class="p-5" id="app">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title">Registro de usuario</h2>
            <form @submit.prevent="submitForm" class="col l12" enctype="multipart/form-data">
                <div class="row">
                    <div class="col l5 line-card-right especial-p">
                        <div class="row">
                            <div class="col l12" style="margin-bottom: 30px;">
                                <p class="bold">Datos generales</p>
                            </div>
                            <div class="input-border col l6">
                                <input v-model="data['user']" @blur="checkFormat('user')" :style="colorsBorder['user'] || {}" type="text" name="user" id="user" required>
                                <label for="user">Usuario *</label>
                            </div>
                            <div class="input-border col l6">
                                <input v-model="data['profile']" type="text" name="profile" id="profile" disabled>
                                <label for="profile">Perfil</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l6">
                                <input v-model="data['name']" @blur="checkFormat('name')" :style="colorsBorder['name'] || {}" type="text" name="name" id="name" required>
                                <label for="name">Nombre *</label>
                            </div>
                            <div class="input-border col l6">
                                <input v-model="data['lastname']" @blur="checkFormat('lastname')" :style="colorsBorder['lastname'] || {}" type="text" name="lastname" id="lastname" required>
                                <label for="lastname">Apellidos *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input v-model="data['email']" @blur="checkFormat('email')" :style="colorsBorder['email'] || {}" type="email" name="email" id="email" required>
                                <label for="email">Correo *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input v-model="data['validateEmail']" @blur="checkFormat('validateEmail')" :style="colorsBorder['validateEmail'] || {}" type="email" name="validate-email" id="validate-email" required>
                                <label for="validate-email">Confirmar Correo *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input v-model="data['number']" @blur="checkFormat('number')" :style="colorsBorder['number'] || {}" type="text" name="phone-number" id="phone-number" pattern="[0-9]{10}" minlength="10" maxlength="10" required>
                                <label for="phone-number">Teléfono Movil *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input v-model="data['validateNumber']" @blur="checkFormat('validateNumber')" :style="colorsBorder['validateNumber'] || {}" type="text" name="validate-phone-number" pattern="[0-9]{10}" minlength="10" maxlength="10" id="validate-phone-number" required>
                                <label for="validate-phone-number">Confirmar Teléfono Movil *</label>
                            </div>
                        </div>
                    </div>
                    <div class="col l4 line-card especial-p">
                        <div class="row">
                            <div class="col l12" style="margin-bottom: 30px;">
                                <p class="bold">Pregunta secreta para recuperar la contraseña</p>
                            </div>
                            <div class="input-border col l12">
                                <select v-model="data['question']" name="question" id="question" required>
                                    <option value="perfil1">Perfil 1</option>
                                    <option value="perfil2">Perfil 2</option>
                                    <option value="perfil3">Perfil 3</option>
                                </select>
                                <label for="question">Pregunta *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input v-model="data['answer']" @blur="checkFormat('answer')" :style="colorsBorder['answer'] || {}" type="text" name="answer" id="answer" required>
                                <label for="answer">Respuesta *</label>
                            </div>
                        </div>
                    </div>
                    <div class="col l3 center-align">
                        <div class="container">
                            <h2 class="card-title">Imagen de Perfil</h2>
                            <img :src="imageUploadURL" alt="" style="max-width: 140px; height: 140px;"><br>
                            <label for="imageUpload" class="custom-file-upload p-5">
                                Seleccionar Imagen
                            </label>
                            <input @change="checkFormat('imageUpload')" ref="imageUpload" name="imageUpload" id="imageUpload" type="file" accept="image/jpeg" maxFileSize="1048576"  />
                        </div>
                    </div>
                    <div class="col l7 p-5 center-align">
                        <button class="custom-file-upload" type="submit" name="action">Guardar</button>
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
        reactive,
        ref,
        isRef,
    } = Vue;

    const app = createApp({
        setup() {

            <?php
            if (isset($datosEmpresa)) {
                echo 'const dataEmpresa =' . $datosEmpresa . ';';
            }
            ?>
            const data = reactive({
                user: ref(''),
                profile: ref(''),
                name: ref(''),
                lastname: ref(''),
                email: ref(''),
                validateEmail: ref(''),
                number: ref(''),
                validateNumber: ref(''),
                question: ref(''),
                answer: ref(''),
            });

            const imageUpload = ref(null);
            const imageUploadURL = ref('https://socialistmodernism.com/wp-content/uploads/2017/07/placeholder-image.png?w=640');
            const colorsBorder = reactive({});

            const checkFormat = (fieldName) => {
                if (!isRef(colorsBorder[fieldName])) {
                    colorsBorder[fieldName] = ref('');
                }
                switch (fieldName) {
                    case 'user':
                    case 'name':
                    case 'lastname':
                    case 'question':
                    case 'answer':
                        if (data[fieldName] !== '') {
                            colorsBorder[fieldName] = {
                                border: '1px solid #03BB85!important',
                            };
                        } else {
                            colorsBorder[fieldName] = {
                                border: '1px solid red!important',
                            };
                        }
                        break;
                    case 'number':
                    case 'validateNumber':
                        // Validación para permitir solo números
                        if (/^\d{10}$/.test(data[fieldName])) {
                            colorsBorder[fieldName] = {
                                border: '1px solid #03BB85!important',
                            };
                        } else {
                            colorsBorder[fieldName] = {
                                border: '1px solid red!important',
                            };
                        }
                        if (data['validateNumber'] != '' || colorsBorder['validateNumber'] != undefined) {
                            if (data['number'] == data['validateNumber']) {
                                colorsBorder['validateNumber'] = {
                                    border: '1px solid #03BB85!important',
                                };
                            } else {
                                if (data['validateNumber'] != '') {
                                    colorsBorder['validateNumber'] = {
                                        border: '1px solid red!important'
                                    }
                                } else {
                                    colorsBorder['validateNumber'] = '';
                                }
                            }
                        }


                        break;
                    case 'email':
                    case 'validateEmail':
                        // Validación para un formato de correo electrónico
                        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(data[fieldName])) {
                            colorsBorder[fieldName] = {
                                border: '1px solid red!important',
                            };
                        } else {
                            colorsBorder[fieldName] = {
                                border: '1px solid #03BB85!important',
                            };
                        }
                        if (data['validateEmail'] != '' || colorsBorder['validateEmail'] != undefined) {
                            if (data['email'] == data['validateEmail']) {
                                colorsBorder['validateEmail'] = {
                                    border: '1px solid #03BB85!important',
                                };
                            } else {
                                if (data['validateEmail'] != '') {
                                    colorsBorder['validateEmail'] = {
                                        border: '1px solid red!important'
                                    }
                                } else {
                                    colorsBorder['validateEmail'] = '';
                                }
                            }
                        }
                        break;


                    case 'imageUpload':
                        if (imageUpload.value.files[0].size <= 1024 * 1024) { // 1 MB en bytes
                            imageUploadURL.value = URL.createObjectURL(imageUpload.value.files[0])
                            data[fieldName] = imageUpload.value
                            // El archivo es demasiado grande, muestra un mensaje de error o realiza alguna acción adecuada.
                        } else {
                            alert("El archivo es demasiado grande. Debe ser menor de 1 MB.");

                            imageUpload.value.files[0].value = null;
                        }

                        break;
                    default:
                        break;
                }
            };
            const validateInput = async () => {
                try {
                    // Esto solo sirve en POST
                    // const response = await fetch('<?php echo base_url('registro/usuarioUnico') ?>',  {
                    const response = await fetch('<?php echo base_url('registro/usuarioUnico') ?>' + '/' + inputValue.value, {
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
            const submitForm = (event) => {
                event.preventDefault();
                <?php
                if (isset($datosEmpresa)) {
                    echo 'let empresa = formEmpresa();';
                }
                ?>

            }
            const formUsuario = (empresa = array('')) => {
                
                if (typeof empresa['id'] === 'undefined'){
                    empresa['id'] = 0;
                }
                // Esto solo sirve en POST
                const formData = new FormData();
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        formData.append(key, data[key]);
                    }
                }
                formData.append('idEmpresa', empresa['id']);
                formData.append('imagen', imageUpload.value.files[0]);
                fetch('<?php echo base_url('registro/registraUsuario') ?>', {
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
                        console.log(responseData);
                        console.log(responseData.url);
                        // Hacer algo con los datos, por ejemplo, retornarlos
                        // accion = responseData
                        window.location.replace('<?php echo base_url(); ?>'+responseData.url+'/'+responseData.enlace);


                    })
                    .catch((error) => {
                        console.error('Error al realizar la solicitud fetch:', error);
                    });
            };
            <?php
            if (isset($datosEmpresa)) {
            ?>

                const formEmpresa = () => {

                    // Esto solo sirve en POST
                    const formData = new FormData();
                    for (const key in dataEmpresa) {
                        if (dataEmpresa.hasOwnProperty(key)) {
                            formData.append(key, dataEmpresa[key]);
                        }
                    }

                    fetch('<?php echo base_url('registro/registraEmpresa') ?>', {
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
                            formUsuario(responseData)


                        })
                        .catch((error) => {
                            console.error('Error al realizar la solicitud fetch:', error);
                        });
                };
            <?php
            }
            ?>

            return {
                data,
                colorsBorder,
                checkFormat,
                imageUpload,
                imageUploadURL,
                submitForm,
                validateInput
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