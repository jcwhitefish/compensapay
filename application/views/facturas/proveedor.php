<div class="p-5" id="app">


    <div class="row">
        <p class="px-3">Periodo:</p>
        <div class="col l3">
            <input type="date" id="start" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
            <label for="start">Inicio:</label>
        </div>
        <div class="col l3">
            <input type="date" id="fin" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
            <label for="fin">Fin:</label>
        </div>
        <div class="col l3 p-3">
            <button class=" <?= $this->session->userdata('vista') == 2 ? 'selected' : '' ?>" >
                Clientes
            </button>
            &nbsp;
            <button class=" <?= $this->session->userdata('vista') == 1 ? 'selected' : '' ?>" >
                Provedores
            </button>
        </div>
        <div class="col l3 right-align p-5">
            <a class="modal-trigger button-blue" href="#modal-factura" v-if="selectedButton === 'Facturas'">
                Añadir Facturas
            </a>
            <a class="modal-trigger button-blue" href="#modal-operacion" v-if="selectedButton === 'Operaciones'">
                Crear Operaciones
            </a>
        </div>
    </div>



    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div class="col l3 p-3">
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Operaciones' }" @click="selectButton('Operaciones')">
                        Operaciones
                    </button>
                    &nbsp;
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Facturas' }" @click="selectButton('Facturas')">
                        Facturas
                    </button>
                </div>
                <div class="col 9">
                    <form class="input-border" action="#" method="post" style="display: flex;">
                        <input type="search" placeholder="Buscar">
                    </form>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table v-if="selectedButton === 'Facturas'" class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Crear Operación</th>
                            <th>Proveedor</th>
                            <th>Factura</th>
                            <th>Fecha Factura</th>
                            <th>Fecha Alta</th>
                            <th>Fecha Transacción</th>
                            <th>Estatus</th>
                            <th>Subtotal</th>
                            <th>IVA</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="factura in facturas" :key="facturas.o_idPersona">
                        <td class="tabla-celda center-align">
                                <i v-if="factura.status == 'Pagada' " class="small material-icons" style="color: green;">check_circle</i>
                                <a v-if="factura.status != 'Pagada'" class="modal-trigger " href="#modal-cargar-factura">Crear Operacion</a>
                            </td>
                            <td>1</td>
                            <td>{{factura.sender_rfc}}</td>
                            <td>{{factura.invoice_date}}</td>
                            <td>{{factura.created_date}}</td>
                            <td>{{factura.transaction_date}}</td>
                            <td>{{factura.status}}</td>
                            <td>${{factura.subtotal}}</td>
                            <td>${{factura.iva}}</td>
                            <td>${{factura.total}}</td>
                        </tr>
                    </tbody>
                </table>
                <table v-if="selectedButton === 'Operaciones'" class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Aprobacion</th>
                            <th>ID Operacion</th>
                            <th>Proveedor</th>
                            <th>Fecha Factura</th>
                            <th>Fecha Alta</th>
                            <th>Factura</th>
                            <th>Nota de Débito</th>
                            <th>Fecha Nota de Débito</th>
                            <th>Fecha Transacción</th>
                            <th>Estatus</th>
                            <th>Monto Ingreso</th>
                            <th>Monto Egreso</th>
                            <!-- <th >Adelanta tu pago</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="operacion in operaciones" :key="operacion.ID_Operacion">
                            <td class="tabla-celda center-align">
                                <i v-if="operacion.Aprobacion == 1" class="small material-icons" style="color: green;">check_circle</i>
                                <a v-if="operacion.Aprobacion == 0" class="modal-trigger " href="#modal-cargar-factura"></a>
                            </td>
                            <td>{{ operacion.id_invoice }}</td>
                            <td>{{ operacion.id_debit_note }}</td>
                            <td>{{ operacion.id_uploaded_by }}</td>
                            <td>{{ operacion.id_client }}</td>
                            <td>{{ operacion.id_provider }}</td>
                            <td>{{ operacion.operation_number }}</td>
                            <td>{{ operacion.creation_date }}</td>
                            <td>{{ operacion.payment_date }}</td>
                            <td>{{ operacion.entry_money }}</td>
                            <td>{{ operacion.exit_money }}</td>
                            <td>{{ operacion.status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div id="modal-factura" class="modal">
        <div class="modal-content">
            <h5>Carga tus facturas</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6 class="p-3">Carga tu factura en formato .xml o múltiples facturas en un archivo .zip</h6>
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="row">

                            <div class="row">
                                <div class="col l9 input-border">
                                    <input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName" />
                                    <label for="invoiceDisabled">Una factura en xml o múltiples en .zip</label>
                                </div>
                                <div class="col l3 center-align p-5">
                                    <label for="invoiceUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                    <input @change="checkFormatInvoice" name="invoiceUpload" ref="invoiceUpload" id="invoiceUpload" type="file" accept=".zip, .xml" maxFileSize="5242880" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l12 d-flex">
                                    <div class="p-5">
                                        <input class="p-5" type="checkbox" v-model="checkboxChecked" required>
                                    </div>
                                    <p class="text-modal">
                                        El Proveedor acepta y otorga su consentimiento en este momento para que una vez recibido el pago por la presente factura, Compensa Pay descuente y transfiere de manera automática a nombre y cuenta del Proveedor, el monto debido por el Proveedor en relación con dicha factura en favor del Cliente.
                                        Los términos utilizados en mayúscula tendrán el significado que se le atribuye dicho término en los <a href="terminosycondiciones">Términos y Condiciones</a>.
                                    </p><br>
                                </div>
                            </div>
                            <div class="col l12 center-align">
                                <a class="modal-close button-gray" style="color: #fff; color:hover: #">Cancelar</a>
                                &nbsp;
                                <button class="button-blue modal-close" type="button" name="action" @click="uploadFile">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div id="modal-operacion" class="modal">
        <div class="modal-content" v-if='solicitud == 0'>
            <h5>Crear Operación</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6 class="p-3">Carga tu factura y selecciona una factura del proveedor</h6>
                    <form method="post" action="<?php echo base_url('facturas/carga'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l3 input-border">
                                <input type="text" name="operationDisabled" id="operationDisabled" disabled v-model="operationUploadName">
                                <label for="operationDisabled">Tu Nota de debito XML</label>
                            </div>
                            <div class="col l4 left-align p-5">
                                <label for="operationUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                <input @change="checkFormatOperation" name="operationUpload" ref="operationUpload" id="operationUpload" type="file" accept="application/xml" maxFileSize="5242880" />
                            </div>
                            <div class="col l5 input-border select-white">
                                <input type="text" name="providerDisabled" id="providerDisabled" disabled v-model="providerUploadName">
                                <label for="providerDisabled">Cliente</label>
                            </div>
                            <div>
                                <table class="striped">
                                    <thead>
                                        <tr>
                                            <!-- <th>Crear Operación</th> -->
                                            <th>Proveedor</th>
                                            <th>Factura</th>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Alta</th>
                                            <th>Fecha Transacción</th>
                                            <th>Estatus</th>
                                            <th>Subtotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="providerUploadName == 'Frontier'" class="visible-table striped">
                                        <tr v-if="facturas.length > 0" :key="facturas[0].o_idPersona">
        
                                        </tr>
                                    </tbody>
                                </table>
                            </div><br>
                            <div class="col l8">
                                <!-- <a @click="cambiarSolicitud(1)" class="button-blue" v-if="providerUploadName == 'Frontier'">Cargar Factura</a> -->
                            </div>
                            <div class="col l4 center-align">
                                <a class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                &nbsp;
                                <button onclick="M.toast({html: 'Operacion creada con exito'})" class="button-blue" type="submit" name="action">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-content" v-if='solicitud == 1'>
            <h5>Solicitar Factura</h5>
            <div class="card esquinasRedondas">
                <form @submit.prevent='cambiarSolicitud(2)' action="" method="post">
                    <div class="card-content ">
                        <div class="row">
                            <div class="col l12">
                                <label style="top: 0!important;" for="descripcion">Mensaje para Solicitar</label>
                                <textarea style="min-height: 30vh;" id="descripcion" name="descripcion" class="materialize-textarea validate" required></textarea>

                            </div>
                            <div class="col l12 d-flex justify-content-flex-end">
                                <a @click='cambiarSolicitud(0)' class="button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                &nbsp;
                                <button class="button-blue" type="submit">Solicitar</button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </div>
        <div class="modal-content" v-if='solicitud == 2'>
            <h5>&nbsp;</h5>
            <div class="card esquinasRedondas   center-align">
                <div class="row">
                    <div class="col l12 ">

                        <h5 style="margin: 120px auto;">Solicitud hecha correctamente</h5>

                        <a @click='cambiarSolicitud(0)' class="modal-close button-gray" style="position:relative; top:-30px; color:#fff; color:hover:#">Salir</a>
                    </div>
                </div>

            </div>
        </div>
    </div>






    <div id="modal-operacion-unico" class="modal">
        <div class="modal-content">
            <h5>Crear Operación</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6 class="p-3">Carga tu nota de debito y selecciona una factura del proveedor</h6>
                    <form method="post" action="<?php echo base_url('facturas/carga'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l3 input-border">
                                <input type="text" placeholder="92387278.xml">
                                <label for="invoiceDisabled">Tu Nota de debito XML</label>
                            </div>
                            <div class="col l4 left-align p-5">
                            </div>
                            <div class="col l5 input-border select-white">
                                <input type="text" placeholder="Frontier">
                                <label for="providerDisabled">Cliente</label>
                            </div>
                            <div>
                                <table class="striped">
                                    <thead>
                                        <tr>
                                            <!-- <th>Crear Operación</th> -->
                                            <th>Proveedor</th>
                                            <th>Factura</th>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Alta</th>
                                            <th>Fecha Transacción</th>
                                            <th>Estatus</th>
                                            <th>Subtotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="striped">

                                    </tbody>
                                </table>
                            </div><br>
                            <div class="col l8">
                                <a onclick="M.toast({html: 'Se ha solicitado la factura'})" class="button-blue modal-close" v-if="providerUploadName != ''">Canceler</a>
                            </div>
                            <div class="col l4 center-align">
                                <a class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                &nbsp;
                                <button class="button-blue" type="submit" name="action">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div id="modal-cargar-factura" class="modal">
        <div class="modal-content">
            <h5>Porfavor, autoriza la transacción</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="row">

                            <div class="row">
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="Frontier" disabled/>
                                    <label for="invoiceDisabled">Provedor</label>
                                </div>
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="XYZ832HS" disabled/>
                                    <label for="invoiceDisabled">Factura</label>
                                </div>
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="XYZ832HS" disabled/>
                                    <label for="invoiceDisabled">Nota de debito</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="TRA10035904" disabled/>
                                    <label for="invoiceDisabled">ID Transaccion</label>
                                </div>
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="$ 21,576.00" disabled/>
                                    <label for="invoiceDisabled">Monto Factura</label>
                                </div>
                                <div class="col l4 input-border">
                                    <input type="text" placeholder="$10,501.00" disabled/>
                                    <label for="invoiceDisabled">Monto Nota de Débito (ingreso):</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l4 input-border">
                                <input type="date" id="start" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
                                <label for="start">Inicio:</label>
                                </div>
                                <div class="col l4 input-border P-5">
                                    <input type="text" placeholder="123456789098745612" disabled/>
                                    <label for="invoiceDisabled">Cuenta CLABE del proveedor</label>
                                </div>
                            </div>
                            <div class="col l12">
                                <div class="col l8">
                                    <a class="button-gray modal-close">Cancelar</a>
                                </div>
                                <div class="col l4 center-align">
                                    <a onclick="M.toast({html: 'Se ha cancelado'})" class="button-white modal-close">Rechazar</a>
                                    &nbsp;
                                    <button onclick="M.toast({html: 'Se ha autorizado'})" class="button-blue modal-close">Siguiente</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<style>
    /* main styles */

    .text-modal {
        font-size: 13px;
    }

    .modal {
        max-height: 83% !important;
        width: 80% !important;
    }

    .input-border label {
        color: black;
        top: -75px;
        position: relative;
        font-weight: bold !important;
    }

    /* Fix show checkbox and radio buttons*/

    [type="checkbox"]:not(:checked),
    [type="checkbox"]:checked {
        opacity: 1;
        position: relative;
        pointer-events: auto;
    }

    [type="radio"]:not(:checked),
    [type="radio"]:checked {
        opacity: 1;
        position: relative;
        pointer-events: auto;
    }

    /* Fix button selected but all class selected afect */

    .selected {
        background-color: black !important;
        color: white !important;
        height: 50px;
        border: 2px solid black !important;
        border-radius: 10px;
    }
</style>

<script>
    const app = Vue.createApp({
        setup() {
            const invoiceUploadName = Vue.ref('');
            const operationUploadName = Vue.ref('');
            const providerUploadName = Vue.ref('');
            const selectedButton = Vue.ref('Operaciones');
            const checkboxChecked = Vue.ref(false);
            const operaciones = Vue.ref([]);
            const facturas = Vue.ref([]); 
            const solicitud = Vue.ref(0);


            const checkFormatInvoice = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    invoiceUploadName.value = fileInput.files[0].name;
                } else {
                    invoiceUploadName.value = '';
                }
            };

            const uploadFile = async () => {
                if (selectedButton.value === 'Facturas' && checkboxChecked.value) {
                    const fileInput = document.getElementById('invoiceUpload');
                    const formData = new FormData();
                    formData.append('invoiceUpload', fileInput.files[0]);

                    const response = await fetch("<?= base_url('facturas/subidaFactura') ?>", {
                        method: 'POST',
                        body: formData,
                        redirect: 'follow'
                    });

                    if (response.ok) {
                        getFacturas();
                        M.toast({html: 'Se ha subido la factura'});
                    } 
                } else {
                    alert('Ingresa una factura y acepta los terminos');
                }
            };

            const checkFormatOperation = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    operationUploadName.value = fileInput.files[0].name;
                    providerUploadName.value = 'Frontier';
                } else {
                    operationUploadName.value = '';
                    providerUploadName.value = '';
                }
            };

            const uploadOperation = async () => {
                if (selectedButton.value === 'operation') {
                    const fileInput = document.getElementById('operationUpload');
                    const formData = new FormData();
                    formData.append('user', 6);
                    formData.append('operationUpload', fileInput.files[0]);

                    const response = await fetch("<?= base_url('facturas/subida') ?>", {
                        method: 'POST',
                        body: formData,
                        redirect: 'follow'
                    });

                    if (response.ok) {
                        M.toast({html: 'Error al subir factura'});
                        getOperations();
                    } else {
                        M.toast({html: 'Error al subir factura'});
                    }
                } else {
                    alert('Ingresa una factura y acepta los terminos')
                }
            };

            const getOperations = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?= base_url("facturas/tablaOperaciones") ?>", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        operaciones.value = result.operaciones;
                        operaciones.value.reverse();
                    })
                    .catch(error => {
                        //console.log('error', error)
                    });
            };

            const getFacturas = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?= base_url("facturas/tablaFacturas")?>", requestOptions)
                .then(response => response.json())
                .then(result => { facturas.value = result.facturas; facturas.value.reverse();;})
                .catch(error => console.log('error', error));
            };

            const selectButton = (buttonName) => {
                if (selectedButton.value != buttonName) {
                    selectedButton.value = buttonName;
                }
            };

            Vue.onMounted(
                () => {
                    getOperations();
                    getFacturas();
                }
            )

            const cambiarSolicitud = (valor) => {
                solicitud.value = valor;
            };

            return {
                invoiceUploadName,
                operationUploadName,
                providerUploadName,
                selectedButton,
                checkFormatInvoice,
                checkFormatOperation,
                checkboxChecked,
                uploadFile,
                selectButton,
                operaciones,
                solicitud,
                facturas,
                cambiarSolicitud
            };
        }
    });
</script>