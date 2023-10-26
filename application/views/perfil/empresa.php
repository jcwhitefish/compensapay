<?php
//TODO: en todos los registros existe la clase invalid de materialize y es la que se tendrria que ocupar para poner el borde rojo se llama validate
$unique = $this->session->userdata('datosEmpresa')['unique_key'];

$urlArchivos = base_url('boveda/'.$unique.'/'.$unique.'-');
?>


<div class="p-5" id="app">
    <div class="row">
        <div class="col l12 d-flex space-between">
            <h5 class="card-title">Registro de Empresa</h5>

            <a class="linkConfiguracion" href="<?= base_url('Configuracion'); ?>">
                Configuración
                <i class="material-icons iconoSetting">
                    settings
                </i></a>
        </div>
    </div>
    <form @submit.prevent="submitForm" method="post" action="<?php echo base_url(''); ?>" class="col l12" enctype="multipart/form-data">
        <div class="row">
            <div class="col l5 especial-p">
                <div class="row">
                    <div class="col l12" style="margin-bottom: 30px;">
                        <p class="bold">Detalles de la empresa</p>
                    </div>
                    <div class="input-border col l12">
                        <input v-model="data['bussinesName']" @blur="checkFormat('bussinesName')" :style="colorsBorder['bussinesName'] || {}" type="text" name="bussinesName" id="bussinesName" required>
                        <label for="bussinesName">Razón Social *</label>
                        <p v-if="colorsBorder['bussinesName'] && colorsBorder['bussinesName'].border === '1px solid red!important'" class="error-message">¡Razón Social inválida!</p>
                    </div>

                </div>
                <div class="row">
                    <div class="input-border col l6">
                        <input v-model="data['nameComercial']" @blur="checkFormat('nameComercial')" :style="colorsBorder['nameComercial'] || {}" type="text" name="nameComercial" id="nameComercial" required>
                        <label for="nameComercial">Nombre Comercial *</label>
                        <p v-if="colorsBorder['nameComercial'] && colorsBorder['nameComercial'].border === '1px solid red!important'" class="error-message">¡Nombre Comercial inválido!</p>
                    </div>
                    <div class="input-border col l6">
                        <select name="giro" id="giro" v-model="data['giro']" required>
                            <option v-for="giro in listaGiros" :key="giro.gro_id" :value="giro.gro_id">{{ giro.gro_giro }}</option>

                        </select>
                        <label for="giro">Giro *</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-border col l6">
                        <input v-model="data['rfc']" @blur="checkFormat('rfc')" :style="colorsBorder['rfc'] || {}" type="text" name="rfc" id="rfc" minlength="12" maxlength="13" pattern="[A-Z0-9]{12,13}" title="Debe tener de 12 a 13 caracteres alfanuméricos" required>
                        <label for="rfc">RFC *</label>
                        <p v-if="colorsBorder['rfc'] && colorsBorder['rfc'].border === '1px solid red!important'" class="error-message">¡RFC inválido!</p>
                    </div>
                    <div class="input-border col l6">
                        <select name="regimen" id="regimen" v-model="data['regimen']" required>
                            <option v-for="(regimen,index) in listaRegimenes" :key="regimen.rg_id" :value="regimen.rg_id">{{ regimen.rg_regimen }}</option>

                        </select>
                        <label for="regimen">Regimen Fiscal *</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-border col l6">
                        <input v-model="data['codigoPostal']" @blur="checkFormat('codigoPostal')" :style="colorsBorder['codigoPostal'] || {}" type="text" name="codigoPostal" id="codigoPostal" maxlength="5" pattern="[0-9]{5}" required>
                        <label for="codigoPostal">Codigo Postal *</label>
                        <p v-if="colorsBorder['codigoPostal'] && colorsBorder['codigoPostal'].border === '1px solid red!important'" class="error-message">¡Código Postal inválido!</p>
                    </div>
                    <div class="input-border col l6">
                        <input type="text" name="estado" id="estado" disabled :placeholder="data['estado']['name']" required>
                        <label for="estado">Estado</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-border col l12">
                        <input v-model="data['direccion']" @blur="checkFormat('direccion')" :style="colorsBorder['direccion'] || {}" type="text" name="direccion" id="direccion" required>
                        <label for="direccion">Direccion *</label>
                        <p v-if="colorsBorder['direccion'] && colorsBorder['direccion'].border === '1px solid red!important'" class="error-message">¡Direccion inválida!</p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-border col l6">
                        <input v-model="data['telefono']" @blur="checkFormat('telefono')" :style="colorsBorder['telefono'] || {}" type="text" name="telefono" id="telefono" required pattern="[0-9]{10}" maxlength="10" title="Por favor, ingresa exactamente 10 dígitos numéricos.">
                        <label for="telefono">Telefono *</label>
                        <p v-if="colorsBorder['telefono'] && colorsBorder['telefono'].border === '1px solid red!important'" class="error-message">¡Telefono inválido!</p>
                    </div>
                </div>
            </div>
            <div class="col l4 line-card line-card-l especial-p">
                <div class="row">
                    <div class="col l12" style="margin-bottom: 30px;">
                        <p class="bold">Datos Bancarios</p>
                    </div>
                    <div class="input-border col l12">
                        <input v-model="data['clabe']" @blur="checkFormat('clabe')" :style="colorsBorder['clabe'] || {}" type="text" name="clabe" id="clabe" required pattern="[0-9]{18}" maxlength="18" title="Por favor, ingresa exactamente 18 dígitos numéricos.">
                        <label for="clabe">Cuenta CLABE *</label>
                        <p v-if="colorsBorder['clabe'] && colorsBorder['clabe'].border === '1px solid red!important'" class="error-message">¡Cuenta CLABE inválido!</p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-border col l12">
                        <input type="text" name="bank" id="bank" disabled :placeholder="data['bank']['bnk_alias']" required>
                        <label for="bank">Banco emisor *</label>
                    </div>
                </div>
                <div v-if="false" class="row">

                    <p class="bold p-3">
                        Soy Proveedor
                    </p>
                    <div class="input-border col l12">
                        <input type="text" name="partner" id="partner" disabled>
                        <label for="partner">Cliente *</label>
                    </div>
                </div>

            </div>
            <div class="col l3 center-align">
                <div class="container">
                    <h5 class="card-title">Seleccionar logotipo</h5>
                    <img :src="imageUploadURL" alt="" style="max-width: 140px; max-height: 140px;"><br>
                    <label for="imageUpload" class="custom-file-upload p-5">
                        Seleccionar Imagen
                    </label>
                    <input @change="checkFormat('imageUpload')" ref="imageUpload" name="imageUpload" id="imageUpload" type="file" accept="image/jpeg" maxFileSize="1048576" />
                </div>
            </div>
        </div>

        <div class="row">
            <table>
                <thead>
                    <tr>
                        <th>
                            <p>Documento</p>
                        </th>
                        <th>
                            <p>Archivo</p>
                        </th>
                        <th>
                            <p>Actualizar</p>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <p>Acta Constitutiva</p>
                        </td>
                        <td><a :href="actaConstitutivaUploadURL" target="_blank">{{actaConstitutivaUploadName}}</a></td>
                        <td>
                            <label for="actaConstitutivaUpload" class="custom-file-upload">Agregar</label>
                            <input @change="checkFormat('actaConstitutivaUpload')" name="actaConstitutivaUpload" ref="actaConstitutivaUpload" id="actaConstitutivaUpload" type="file" accept="application/pdf" maxFileSize="5242880"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Constancia de Situacion Fiscal</p>
                        </td>
                        <td><a :href="csfUploadURL" target="_blank">{{csfUploadName}}</a></td>
                        <td>
                            <label for="csfUpload" class="custom-file-upload">Agregar </label>
                            <input @change="checkFormat('csfUpload')" name="csfUpload" ref="csfUpload" id="csfUpload" type="file" accept="application/pdf" maxFileSize="5242880"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Comprobante de Domicilio</p>
                        </td>
                        <td><a :href="comprobanteDomicilioUploadURL" target="_blank">{{comprobanteDomicilioUploadName}}</a></td>
                        <td>
                            <label for="comprobanteDomicilioUpload" class="custom-file-upload">Agregar</label>
                            <input @change="checkFormat('comprobanteDomicilioUpload')" name="comprobanteDomicilioUpload" ref="comprobanteDomicilioUpload" id="comprobanteDomicilioUpload" type="file" accept="application/pdf" maxFileSize="5242880"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Identificacion de Representante Legal</p>
                        </td>
                        <td><a :href="representanteLegalUploadURL" target="_blank">{{representanteLegalUploadName}}</a></td>
                        <td>
                            <label for="representanteLegalUpload" class="custom-file-upload">Agregar</label>
                            <input @change="checkFormat('representanteLegalUpload')" name="representanteLegalUpload" ref="representanteLegalUpload" id="representanteLegalUpload" type="file" accept="application/pdf" maxFileSize="5242880"/>
                        </td>
                    </tr>
                </tbody>
            </table>


        </div>
        <div class="row">
            <div class="col l12 right-align p-5">
                <button @click="redireccion" class="btn waves-effect waves-light cancelar" name="action">Cancelar</button>

                <button class="btn waves-effect waves-light" style="margin-left: 20px;" type="submit" name="action">Guardar</button>
            </div>
        </div>
    </form>
</div>
<script>
    const {
        createApp,
        computed,
        reactive,
        ref,
        isRef,
        onMounted,
        nextTick
    } = Vue

    const app = createApp({
        setup() {
            const data = reactive({
                bussinesName: ref('<?= $this->session->userdata('datosEmpresa')['legal_name'] ?>'),
                nameComercial: ref('<?= $this->session->userdata('datosEmpresa')['short_name'] ?>'),
                giro: ref(<?= $this->session->userdata('datosEmpresa')['id_type'] ?>),
                rfc: ref('<?= $this->session->userdata('datosEmpresa')['rfc'] ?>'),
                regimen: ref(<?= $this->session->userdata('datosEmpresa')['id_fiscal'] ?>),

                codigoPostal: ref(<?= $postal ?>),
                estado: ref({
                    id: ref(<?= $this->session->userdata('datosEmpresa')['id_country'] ?>),
                    name: ref('<?= $state ?>')
                }),
                direccion: ref('<?= $this->session->userdata('datosEmpresa')['address'] ?>'),
                telefono: ref('<?= $this->session->userdata('datosEmpresa')['telephone'] ?>'),
                clabe: ref('<?= $this->session->userdata('datosEmpresa')['account_clabe'] ?>'),
                bank: ref({
                    bnk_id: ref(<?= $this->session->userdata('datosEmpresa')['id_broadcast_bank'] ?>),
                    bnk_alias: ref('<?= $bank ?>')
                }),
                imageUpload: ref(''),
                csfUpload: ref(''),
                actaConstitutivaUpload: ref(''),
                comprobanteDomicilioUpload: ref(''),
                representanteLegalUpload: ref(''),



                uniqueString: ref('')

            });
            // partes del image
            const imageUpload = ref(null);
            const imageUploadURL = ref('<?= $urlArchivos ?>logo.jpeg');
            const colorsBorder = reactive({});
            //partes del pdf
            const csfUpload = ref(null);
            const csfUploadName = ref('constanciaSituacionFiscal.pdf');
            const csfUploadURL = ref('<?= $urlArchivos ?>constanciaSituacionFiscal.pdf');
            //partes del pdf
            const actaConstitutivaUpload = ref(null);
            const actaConstitutivaUploadName = ref('actaConstitutiva.pdf');
            const actaConstitutivaUploadURL = ref('<?= $urlArchivos ?>actaConstitutiva.pdf');
            //partes del pdf
            const comprobanteDomicilioUpload = ref(null);
            const comprobanteDomicilioUploadName = ref('comprobanteDomicilio.pdf');
            const comprobanteDomicilioUploadURL = ref('<?= $urlArchivos ?>comprobanteDomicilio.pdf');
            //partes del pdf
            const representanteLegalUpload = ref(null);
            const representanteLegalUploadName = ref('representanteLegal.pdf');
            const representanteLegalUploadURL = ref('<?= $urlArchivos ?>representanteLegal.pdf');
            //partes de listar
            const listaRegimenes = ref([]);
            const listaGiros = ref([]);
            const codigoPostalID = ref('<?= $this->session->userdata('datosEmpresa')['id_postal_code'] ?>');
            // Se pudo haber hecho con evet 
            const checkFormat = (nombreInput) => {
                if (!isRef(colorsBorder[nombreInput])) {
                    colorsBorder[nombreInput] = ref('')
                }

                switch (nombreInput) {
                    case 'telefono':
                        var patron = /[^0-9]/;
                        if (data[nombreInput] != '' && data[nombreInput].length == 10 && !patron.test(data[nombreInput])) {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'codigoPostal':
                        var patron = /[^0-9]/;
                        if (data[nombreInput] != '' && data[nombreInput].length == 5 && !patron.test(data[nombreInput])) {
                            var requestOptions = {
                                method: 'GET',
                                redirect: 'follow'
                            };

                            fetch("<?php echo base_url('herramientas/listaPostal/'); ?>" + data[nombreInput].toString(), requestOptions)
                                .then(response => response.json())
                                .then(result => {
                                    // console.log(typeof result);
                                    if (Object.keys(result).length === 0) {
                                        colorsBorder[nombreInput] = {
                                            border: '1px solid red!important',
                                        }
                                    } else {
                                        codigoPostalID.value = result[0].zip_id;
                                        // console.log(codigoPostalID.value);
                                        data['estado']['id'] = result[0].zip_state;

                                        fetch("<?php echo base_url('herramientas/listaEstado/'); ?>" + String(data['estado']['id']), requestOptions)
                                            .then(response => response.json())
                                            .then(result => {
                                                //console.log(result);
                                                data['estado']['name'] = result[0]['stt_name'];
                                                //console.log(data['estado']['name']);
                                            })
                                            .catch(error => console.log('error', error));
                                        colorsBorder[nombreInput] = {
                                            border: '1px solid #03BB85!important',
                                        }
                                    }
                                })
                                .catch(error => console.log('error', error));



                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'estado':
                        if (data[nombreInput] !== '') {
                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }

                        break;
                    case 'direccion':
                        if (data[nombreInput] !== '') {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }

                        break;
                    case 'bussinesName':
                        if (data[nombreInput] !== '') {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }

                        break;
                    case 'nameComercial':
                        if (data[nombreInput] !== '') {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'rfc':
                        data[nombreInput] = data[nombreInput].toUpperCase();
                        var patron = /[^A-Z0-9]/;
                        if (data[nombreInput] != '' && (data[nombreInput].length == 12 || data[nombreInput].length == 13) && !patron.test(data[nombreInput])) {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'clabe':
                        var patron = /[^0-9]/;
                        if (data[nombreInput] != '' && data[nombreInput].length == 18 && !patron.test(data[nombreInput])) {

                            //Aqui estoy
                            var requestOptions = {
                                method: 'GET',
                                redirect: 'follow'
                            };

                            fetch("<?php echo base_url('herramientas/listaBanco/'); ?>" + data[nombreInput].toString().substring(0, 3), requestOptions)
                                .then(response => response.json())
                                .then(result => {
                                    if (result.length == 0) {
                                        colorsBorder[nombreInput] = {
                                            border: '1px solid red!important',
                                        }
                                    } else {
                                        data['bank'] = result[0];
                                        colorsBorder[nombreInput] = {
                                            border: '1px solid #03BB85!important',
                                        }
                                    }
                                })
                                .catch(error => console.log('error', error));

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'partner':
                        data[nombreInput] = data[nombreInput].toUpperCase();
                        var patron = /[^A-Z0-9]/;
                        if (data[nombreInput] != '' && (data[nombreInput].length == 12 || data[nombreInput].length == 13) && !patron.test(data[nombreInput])) {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'imageUpload':
                        if (imageUpload.value.files.length == 1) {

                            if (imageUpload.value.files[0].size <= 1024 * 1024) {
                                imageUploadURL.value = URL.createObjectURL(imageUpload.value.files[0])
                                data[nombreInput] = imageUpload.value;
                                subirArchivo(data[nombreInput], 'logo')

                            } else {
                                imageUploadURL.value = '';

                            }


                        } else if (imageUpload.value.files.length == 0) {}



                        break;
                    case 'csfUpload':
                        //falta el caso en el que se tiene que vaciar la variable porque no aceptamos su archivo creo va en el else
                        if (csfUpload.value.files.length == 1) {

                            if (csfUpload.value.files[0].size <= 1024 * 1024 * 30) {

                                csfUploadURL.value = URL.createObjectURL(csfUpload.value.files[0])
                                csfUploadName.value = csfUpload.value.files[0].name;
                                data[nombreInput] = csfUpload.value;
                                subirArchivo(data[nombreInput], 'constanciaSituacionFiscal')

                            } else {
                                csfUploadName.value = '';
                            }


                        } else if (csfUpload.value.files.length == 0) {}
                        break;
                    case 'actaConstitutivaUpload':
                        if (actaConstitutivaUpload.value.files.length == 1) {

                            if (actaConstitutivaUpload.value.files[0].size <= 1024 * 1024 * 30) {
                                
                                actaConstitutivaUploadURL.value = URL.createObjectURL(actaConstitutivaUpload.value.files[0])
                                actaConstitutivaUploadName.value = actaConstitutivaUpload.value.files[0].name;
                                data[nombreInput] = actaConstitutivaUpload.value;
                                subirArchivo(data[nombreInput], 'actaConstitutiva')

                            } else {
                                actaConstitutivaUploadName.value = '';
                            }


                        } else if (actaConstitutivaUpload.value.files.length == 0) {}
                        break;
                    case 'comprobanteDomicilioUpload':
                        if (comprobanteDomicilioUpload.value.files.length == 1) {

                            if (comprobanteDomicilioUpload.value.files[0].size <= 1024 * 1024 * 30) {

                                comprobanteDomicilioUploadURL.value = URL.createObjectURL(comprobanteDomicilioUpload.value.files[0])
                                comprobanteDomicilioUploadName.value = comprobanteDomicilioUpload.value.files[0].name;
                                data[nombreInput] = comprobanteDomicilioUpload.value;
                                subirArchivo(data[nombreInput], 'comprobanteDomicilio')

                            } else {
                                comprobanteDomicilioUploadName.value = '';
                            }


                        } else if (comprobanteDomicilioUpload.value.files.length == 0) {}
                        break;
                    case 'representanteLegalUpload':
                        if (representanteLegalUpload.value.files.length == 1) {

                            if (representanteLegalUpload.value.files[0].size <= 1024 * 1024 * 30) {

                                representanteLegalUploadURL.value = URL.createObjectURL(representanteLegalUpload.value.files[0])
                                representanteLegalUploadName.value = representanteLegalUpload.value.files[0].name;
                                data[nombreInput] = representanteLegalUpload.value;
                                subirArchivo(data[nombreInput], 'representanteLegal')

                            } else {
                                representanteLegalUploadName.value = '';
                            }


                        } else if (representanteLegalUpload.value.files.length == 0) {}
                        break;
                    default:
                        // Código a ejecutar si valor no coincide con ningún caso
                }

            }

            // Hacer la solicitud Fetch a tu API
            const subirArchivo = (archivo, nombre, lugar = 0) => {
                const formData = new FormData();
                formData.append('archivo', archivo.files[0]);


                var requestOptions = {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow'
                };

                fetch("<?php echo base_url('herramientas/subirArchivo/'); ?>" + data['uniqueString'] + '/' + nombre + '/' + lugar, requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        /*console.log(result)*/
                    })
                    .catch(error => console.log('error', error));
            }
            const idUnico = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };
                fetch("<?php echo base_url('herramientas/idUnico'); ?>", requestOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        data['uniqueString'] = result.idUnico; // Almacenar los datos en la propiedad listaEstados
                        // console.log(data['uniqueString']);

                    });
            }
            const listarEstados = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };
                fetch("<?php echo base_url('herramientas/listaEstados'); ?>", requestOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        listaEstados.value = JSON.parse(result); // Almacenar los datos en la propiedad listaEstados
                        // console.log(listaEstados.value);
                        nextTick(() => {
                            M.FormSelect.init(document.getElementById('estado'));
                        });

                    });
            }
            const listarRegimen = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };
                fetch("<?php echo base_url('herramientas/listaRegimenes/2'); ?>", requestOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        listaRegimenes.value = result; // Almacenar los datos en la propiedad listaRegimenes
                        // console.log(listaRegimenes.value);
                        nextTick(() => {
                            M.FormSelect.init(document.getElementById('regimen'));
                        });

                    });
            }
            const listarGiro = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?php echo base_url('herramientas/listaGiro'); ?>", requestOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        listaGiros.value = result; // Almacenar los datos en la propiedad listaRegimenes
                        //console.log(listaGiros.value);
                        nextTick(() => {
                            M.FormSelect.init(document.getElementById('giro'));
                        });

                    });
            }
            const submitForm = () => {
                // Obtén el objeto data
                const dataObject = {
                    bussinesName: data.bussinesName,
                    nameComercial: data.nameComercial,
                    codigoPostal: codigoPostalID.value,
                    estado: data.estado.id,
                    direccion: data.direccion,
                    telefono: data.telefono,
                    type: data.giro,
                    rfc: data.rfc,
                    fiscal: data.regimen,
                    clabe: data.clabe,
                    bank: data.bank.bnk_id,
                    documentos: data.uniqueString,
                };

                console.log(dataObject);

            }
            const redireccion = () => {
                window.location.replace("<?php echo base_url(''); ?>");
            }


            onMounted(
                () => {
                    idUnico();
                    listarRegimen();
                    listarGiro();
                }
            )


            return {
                data,
                colorsBorder,
                checkFormat,
                imageUpload,
                imageUploadURL,
                csfUpload,
                csfUploadName,
                csfUploadURL,
                actaConstitutivaUpload,
                actaConstitutivaUploadName,
                actaConstitutivaUploadURL,
                comprobanteDomicilioUpload,
                comprobanteDomicilioUploadName,
                comprobanteDomicilioUploadURL,
                representanteLegalUpload,
                representanteLegalUploadName,
                representanteLegalUploadURL,
                listaRegimenes,
                listaGiros,
                submitForm,
                redireccion,
                actaConstitutivaUploadURL


            }
        }
    });
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

    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        color: white;
        background: #444;
        display: inline-block;
        padding: 10px 40px;
        cursor: pointer;
        border-radius: 3px !important;
    }

    .error-message {
        color: red;
        font-size: 10px;
        top: -25px;
        position: relative;
    }

    .iconoSetting {
        position: relative;
        top: 6px;
    }

    .linkConfiguracion {
        color: black;
    }

    .custom-file-upload:hover {
        border: none;
    }

    .cancelar:hover,
    .cancelar:focus {
        background-color: #444 !important;
    }

    .guardar,
    .cancelar:focus {
        background-color: #e0e51d !important;
    }
</style>