<div class="p-5" id="app">

    <!-- head con el calendario -->
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
        <div class="col l3">
        </div>
        <div class="col l3">
            <a class="modal-trigger button-blue" href="#modal-factura" v-if="selectedButton === 'Facturas'">
                Añadir Facturas
            </a>
            <a class="modal-trigger button-blue" href="#modal-operacion" v-if="selectedButton === 'Operaciones'">
                Crear Operaciones
            </a>
        </div>
    </div>


    <!-- Las tablas principales que se muestran -->
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
                        <tr v-for="factura in facturas">
                            <td class="tabla-celda center-align">
                                <i v-if="factura.status == '1' " class="small material-icons" style="color: green;">check_circle</i>
                                <a v-if="factura.status != '1'" class="modal-trigger " href="#modal-operacion-unica" @click="operacionUnicaCliente(factura)">Crear Operacion</a>
                            </td>
                            <td>{{factura.short_name}}</td>
                            <td>{{factura.invoice_number}}</td>
                            <td>{{factura.invoice_date}}</td>
                            <td>{{factura.created_at}}</td>
                            <td>
                                <p v-if="factura.transaction_date == '0000-00-00' " >Pendiente</p>
                                <p v-if="factura.transaction_date != '0000-00-00' " >{{factura.transaction_date}}</p>
                            </td>
                            <td>
                                <p v-if="factura.status == '0' " >Por Aprobar</p>
                                <p v-if="factura.status == '1' " >Pagado</p>
                                <p v-if="factura.status == '2' " >Recahazada</p>
                            </td>
                            <td>${{factura.subtotal}}</td>
                            <td>${{factura.iva}}</td>
                            <td>${{factura.total}}</td>
                        </tr>
                    </tbody>
                </table>
                <table v-if="selectedButton === 'Operaciones'" class="visible-table striped">
                <thead>
                        <tr>
                            <th>Aprobación<br>Operación</th>
                            <th>Estatus <br>Factura</th>
                            <th>ID Operación</th>
                            <th>Proveedor</th>
                            <th>Fecha Factura</th>
                            <th>Fecha Alta</th>
                            <th>UUID<br>Factura Proveedor</th>
                            <th>Monto<br>Factura Proveedor</th>
                            <th>UUID<br>Mi Factura</th>
                            <th>Monto<br>Mi Factura</th>
                            <th>UUID Nota</th>
                            <th>Monto Nota</th>
                            <th>Fecha Transacción</th>
                            <!-- <th >Adelanta tu pago</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="operacion in operaciones">
                            <td class="tabla-celda center-align">
                                <i v-if="operacion.status == '2'" class="small material-icons" style="color: red;">cancel</i>
                                <i v-if="operacion.status == '1'" class="small material-icons" style="color: green;">check_circle</i>
                                <i v-if="operacion.status == '0'" class="small material-icons">panorama_fish_eye</i>
                            </td>
                            <td class="tabla-celda center-align">
                                <p v-if="operacion.status == '0'">pendiente</p>
                                <p v-if="operacion.status == '1'">aprobada</p>
                                <p v-if="operacion.status == '2'">rechazada</p>
                            </td>
                            <td>
                                <a class="modal-trigger " href="#modal-vista-operacion" @click="vistaOperacion(operacion)">{{ operacion.operation_number }}</a>
                            </td>
                            <td>
                                <p v-if="operacion.short_name != null && operacion.short_name != ''">{{ operacion.short_name }}</p>
                                <p v-if="operacion.short_name == null || operacion.short_name == ''">{{ operacion.legal_name }}</p>
                            </td>
                            <td>{{ operacion.payment_date }}</td>
                            <td>{{ operacion.created_at}}</td>
                            <td>
                                <p class="uuid-text">{{ operacion.uuid }}</p>
                            </td>
                            <td>
                                <p v-if="operacion.money_prov != null">${{ operacion.money_prov }}</p>
                            </td>
                            <td>
                                <p v-if="operacion.uuid_relation != null" class="uuid-text">{{ operacion.uuid_relation }}</p>
                                <p v-if="operacion.uuid_relation == null" class="uuid-text">N.A.</p>
                            </td>
                            <td>
                                <p v-if="operacion.money_clie != null">${{ operacion.money_clie }}</p>
                                <p v-if="operacion.money_clie == null">N.A.</p>
                            </td>
                            <td>
                                <p v-if="operacion.uuid_nota != null" class="uuid-text">{{ operacion.uuid_nota }}</p>
                                <p v-if="operacion.uuid_nota == null" class="uuid-text">N.A.</p>
                            </td>
                            <td>
                                <p v-if="operacion.money_nota != null">${{ operacion.money_nota }}</p>
                                <p v-if="operacion.money_nota == null">N.A.</p>
                            </td>
                            <td>{{ operacion.transaction_date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Subir una factura -->
    <div id="modal-factura" class="modal">
        <div class="modal-content">
            <h5>Carga tus facturas</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6 class="p-3">Carga tu factura en formato .xml</h6>
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="row">
                                <div class="col l9 input-border">
                                    <input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName" />
                                    <label for="invoiceDisabled">Una factura en xml</label>
                                </div>
                                <div class="col l3 center-align p-5">
                                    <label for="invoiceUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                    <input @change="checkFormatInvoice" name="invoiceUpload" ref="invoiceUpload" id="invoiceUpload" type="file" accept="application/xml" maxFileSize="5242880" required />
                                </div>
                            </div>

                            <div class="row">
                                <div class="row">
                                    <div class="col l12 d-flex">
                                        <div class="p-3">
                                            <input class="p-2" type="checkbox" v-model="checkboxChecked" required>
                                        </div>
                                        <p class="text-modal">
                                            Al momento en dar click en “Aceptar” el Cliente acuerda que la factura en cuestión será utilizada para efectos de las operaciones en la Plataforma conforme a los <a href="terminosycondiciones">Términos y Condiciones</a>.
                                        </p><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col l12 center-align">
                                <a class="modal-close button-gray" style="color: #fff; color:hover: #">Cancelar</a>
                                &nbsp;
                                <button class="button-blue" :class="{ 'modal-close': checkboxChecked }" type="reset" name="action" @click="uploadFile">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Crear una operacion -->
    <div id="modal-operacion" class="modal">
        <div class="modal-content">
            <h5>Crear Operación</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6 class="p-3">Carga tu xml relacionada a una factura</h6>
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l3 input-border">
                                <input type="text" name="operationDisabled" id="operationDisabled" disabled v-model="operationUploadName">
                                <label for="operationDisabled">Tu factura XML</label>
                            </div>
                            <div class="col l4 left-align p-5">
                                <label for="operationUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                <input @change="checkFormatOperation" name="operationUpload" ref="operationUpload" id="operationUpload" type="file" accept="application/xml" maxFileSize="5242880" required/>
                            </div>
                            <div class="col l5 input-border select-white">
                                <input type="text" name="providerDisabled" id="providerDisabled" disabled v-model="providerUploadName">
                                <label for="providerDisabled">Proveedor</label>
                            </div>
                            <div>
                                <table class="striped">
                                    <thead>
                                        <tr>
                                            <th>Crear Operación</th>
                                            <th>Cliente</th>
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
                                        <tr v-for="facturaClient in facturasClient">
                                            <td class="tabla-celda center-align">
                                                <input type="radio" name="grupoRadio" :value="facturaClient.id" ref="grupoRadio" id="grupoRadio" v-model="radioChecked" required></i>
                                            </td>
                                            <td>{{facturaClient.receiver_rfc}}</td>
                                            <td>{{facturaClient.invoice_number}}</td>
                                            <td>{{facturaClient.invoice_date}}</td>
                                            <td>{{facturaClient.created_at}}</td>
                                            <td>
                                                <p v-if="facturaClient.transaction_date == '0000-00-00' " >Pendiente</p>
                                                <p v-if="facturaClient.transaction_date != '0000-00-00' " >{{facturaClient.transaction_date}}</p>
                                            </td>
                                            <td>
                                                <p v-if="facturaClient.status == '0' " >Pendiente</p>
                                                <p v-if="facturaClient.status == '1' " >Aprobada</p>
                                                <p v-if="facturaClient.status == '2' " >Recahazada</p>
                                            </td>
                                            <td>${{facturaClient.subtotal}}</td>
                                            <td>${{facturaClient.iva}}</td>
                                            <td>${{facturaClient.total}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><br>
                            <div class="col l8">
                                <a class="modal-trigger modal-close button-blue" href="#modal-solicitar-factura" v-if="providerUploadName != ''">Solicitar otra factura</a>
                            </div>
                            <div class="col l4 center-align">
                                <a class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                &nbsp;
                                <button class="button-blue" :class="{ 'modal-close': radioChecked }" name="action" type="reset" @click="uploadOperation">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Desde cliente crera operacion especifica a factura -->
    <div id="modal-operacion-unica" class="modal">
        <div class="modal-content">
            <h5>Crear Operación</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6 class="p-3">Carga tu xml relacionada a una factura</h6>
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l3 input-border">
                                <input type="text" name="operationDisabledUnique" id="operationDisabledUnique" disabled v-model="operationUploadNameUnique">
                                <label for="operationDisabledUnique">Tu factura XML</label>
                            </div>
                            <div class="col l0 left-align p-5">
                                <label for="uniqueOperationUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                <input @change="checkFormatOperationUnique" name="uniqueOperationUpload" ref="uniqueOperationUpload" id="uniqueOperationUpload" type="file" accept="application/xml" maxFileSize="5242880" required/>
                            </div>
                            <div class="col l5 input-border select-white">
                                <input type="text" name="providerDisabledUnique" id="providerDisabledUnique" disabled v-model="providerUploadNameUnique">
                                <label for="providerDisabledUnique">Proveedor</label>
                            </div>
                            <div>
                                <table class="striped">
                                    <thead>
                                        <tr>
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
                                        <tr v-for="factura in facturasClientUnique">
                                            <td>{{factura.sender_rfc}}</td>
                                            <td>{{factura.invoice_number}}</td>
                                            <td>{{factura.invoice_date}}</td>
                                            <td>{{factura.created_at}}</td>
                                            <td>
                                                <p v-if="factura.transaction_date == '0000-00-00' " >Pendiente</p>
                                                <p v-if="factura.transaction_date != '0000-00-00' " >{{factura.transaction_date}}</p>
                                            </td>
                                            <td>
                                                <p v-if="factura.status == '0' " >Por Aprobar</p>
                                                <p v-if="factura.status == '1' " >Pagado</p>
                                                <p v-if="factura.status == '2' " >Recahazada</p>
                                            </td>
                                            <td>${{factura.subtotal}}</td>
                                            <td>${{factura.iva}}</td>
                                            <td>${{factura.total}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><br>
                            <div class="col l8"></div>
                            <div class="col l4 center-align">
                                <a class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                &nbsp;
                                <button class="button-blue modal-close" type="reset" name="action" @click="uploadOperationUnica">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- solicitar factura -->
    <div id="modal-solicitar-factura" class="modal p-5">
        <h5>Solicitar Factura</h5>
        <div class="card esquinasRedondas">
            <form>
                <div class="card-content ">
                    <div class="row">
                        <div class="col l12">
                            <label style="top: 0!important;" for="descripcion">Mensaje para Solicitar</label>
                            <textarea style="min-height: 30vh;" id="descripcion" name="descripcion" class="materialize-textarea validate" required></textarea>
                        </div>
                        <div class="col l12 d-flex justify-content-flex-end">
                            <a class="button-gray modal-close " style="color:#fff; color:hover:#">Cancelar</a>
                            &nbsp;
                            <button class="button-blue modal-close" onclick="M.toast({html: 'Se solicito Factura'})">Solicitar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- darle aceptar a una factura -->
    <div id="modal-cargar-factura" class="modal">
        <div class="modal-content">
            <h5>Porfavor, autoriza la transacción</h5>
            <div class="card esquinasRedondas">
                <div class="card-content" v-for="operationClient in operationsClient">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="row">
                                <div class="col l4 input-border">
                                    <input type="text" :placeholder="operationClient.id_uploaded_by" disabled />
                                    <label for="invoiceDisabled">Provedor: </label>
                                </div>
                                <div class="col l4 input-border">
                                    <input type="text" :placeholder="operationClient.id_invoice" disabled />
                                    <label for="invoiceDisabled">Factura: </label>
                                </div>
                                <div class="col l4 input-border">
                                    <input type="text" :placeholder="operationClient.id_debit_note !== null ? operationClient.id_debit_note : (operationClient.id_invoice_relational !== null ? operationClient.id_invoice_relational : '')" disabled />
                                    <label for="invoiceDisabled">Nota de Credito/ Factura: </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l4 input-border">
                                    <input class="input-border-null" type="text" :placeholder="operationClient.operation_number" disabled />
                                    <label for="invoiceDisabled">ID Transaccion: </label>
                                </div>
                                <div class="col l4 input-border">
                                    <input class="input-border-null" type="text" :placeholder="operationClient.entry_money" disabled />
                                    <label for="invoiceDisabled">Monto Factura: </label>
                                </div>
                                <div class="col l4 input-border">
                                    <input class="input-border-null" type="text" :placeholder="operationClient.exit_money" disabled />
                                    <label for="invoiceDisabled">Monto Nota de Débito (ingreso):</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l4 input-border">
                                    <input type="date" id="start" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
                                    <label for="start">Inicio:</label>
                                </div>
                                <div class="col l1"></div>
                                <div class="col l4 input-border px-3">
                                    <input class="input-border-null" type="text" placeholder="1(cuenta_clave)" disabled />
                                    <label for="invoiceDisabled">Cuenta CLABE del proveedor:</label>
                                </div>
                            </div>
                            <div class="col l12">
                                <div class="col l8">
                                    <a class="button-gray modal-close">Cancelar</a>
                                </div>
                                <div class="col l4 center-align">
                                    <a class="modal-trigger button-orange modal-close" href="#modal-rechazo">Rechazar</a>
                                    &nbsp;
                                    <button class="button-blue modal-close" name="action" type="reset"  @click="changeStatus('1')">Autorizar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Visualizar información de operación -->
    <div id="modal-vista-operacion" class="modal">
        <div class="modal-content" v-for="operationClient in operationsView">
            <h5>ID Operacion: {{operationClient.operation_number}}</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <div class="row">
                        <div class="row">
                            <div class="col l4">
                                <p class="font_head_op_info" for="invoiceDisabled">Estatus Factura: </p>
                                <h6 v-if="operationClient.status == '0'">Pendiente</h6>
                                <h6 v-if="operationClient.status == '1'">Aprobada</h6>
                                <h6 v-if="operationClient.status == '2'">Rechazada</h6>
                            </div>
                            <div class="col l4">
                                <p class="font_head_op_info" for="invoiceDisabled">Proveedor: </p>
                                <h6 v-if="operationClient.short_name != null && operationClient.short_name != ''">{{operationClient.short_name}}</h6>
                                <h6 v-if="operationClient.short_name == null || operationClient.short_name == ''">{{operationClient.legal_name}}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Fecha factura: </p>
                                <h6>{{operationClient.payment_date}}</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Fecha Alta: </p>
                                <h6>{{operationClient.created_at}}</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Fecha Transacción: </p>
                                <h6>{{operationClient.transaction_date}}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">UUID Factura Proveedor: </p>
                                <h6>{{operationClient.uuid}}</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">UUID Mi Factura: </p>
                                <h6 v-if="operationClient.uuid_relation != null">{{operationClient.uuid_relation}}</h6>
                                <h6 v-if="operationClient.uuid_relation == null">N.A.</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">UUID Nota: </p>
                                <h6 v-if="operationClient.uuid_nota != null">{{operationClient.uuid_nota}}</h6>
                                <h6 v-if="operationClient.uuid_nota == null">N.A.</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Monto Factura Proveedor: </p>
                                <h6>${{operationClient.money_prov}}</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Monto Mi Factura: </p>
                                <h6 v-if="operationClient.money_clie != null">${{operationClient.money_clie}}</h6>
                                <h6 v-if="operationClient.money_clie == null">N.A.</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Monto Nota: </p>
                                <h6 v-if="operationClient.money_nota != null">${{operationClient.money_nota}}</h6>
                                <h6 v-if="operationClient.money_nota == null">N.A.</h6>
                            </div>
                        </div>
                        <div class="col l12">
                            <div class="col l8">
                                <a class="button-gray modal-close">Cerrar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- darle rechazar una factura -->
    <div id="modal-rechazo" class="modal p-5">
        <h5>Operacion rechazada</h5>
        <div class="card esquinasRedondas">
            <form>
                <div class="card-content ">
                    <div class="row">
                        <div class="col l12">
                            <label style="top: 0!important;" for="descripcion">Indique la razón específica de la cancelación de la operacion.</label>
                            <textarea style="min-height: 30vh;" id="descripcion" name="descripcion" class="materialize-textarea validate" required></textarea>
                        </div>
                        <div class="col l12 d-flex justify-content-flex-end">
                            <a class="button-gray modal-close " style="color:#fff; color:hover:#">Cancelar</a>
                            &nbsp;
                            <button class="button-blue modal-close" name="action" type="reset"  @click="changeStatus('2')">Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


<style>
    input:disabled::placeholder {
        color: black !important;
        /* Cambia el color según tus preferencias */
        /* Otros estilos que desees aplicar al marcador de posición */
    }

    /* Modal */

    .text-modal {
        font-size: 13px;
    }

    .modal {
        max-height: 83% !important;
        width: 80% !important;
    }

    /* Fix show checkbox and radiobuttons*/

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

    .input-border-null input[type=text] {
        border-color: #fff !important;
        border-bottom: 1px solid #fff !important;
        box-shadow: 0 1px 0 0 #fff !important;
    }

    /* Puntos suspensivos a fila donde se muestrael UUID */
    .uuid-text{
        width: 130px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    /* Estilo vista de operacion */
    .font_head_op_info{
        font-weight: bold;
        font-size: 20px;
    }

</style>

<script>
    const app = Vue.createApp({
        setup() {
            const invoiceUploadName = Vue.ref('');
            const operationUploadName = Vue.ref('');
            const operationUploadNameUnique = Vue.ref('');
            const providerUploadName = Vue.ref('');
            const providerUploadNameUnique = Vue.ref('');
            const selectedButton = Vue.ref('Operaciones');
            const checkboxChecked = Vue.ref(false);
            const radioChecked = Vue.ref(false);
            const operaciones = Vue.ref([]);
            const operationsClient = Vue.ref([]);
            const operationsView = Vue.ref([]);
            const facturas = Vue.ref([]);
            const facturasClient = Vue.ref([]);
            const facturasClientUnique = Vue.ref([]);
            const autorizar = Vue.ref(0);
            const selectedoperationId = Vue.ref('');
            const acceptDecline = Vue.ref('');

            //darle aceptar a una factura 
            const actualizacion = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?= base_url('facturas/actualizacion/')?>" + autorizar.value, requestOptions)
                    .then(response => response.json())
                    .then(result => {console.log(result);alert('Se autorizo la operacion con exito'); window.location.replace('<?php echo base_url('facturas'); ?>');})
                    .catch(error => console.log('error', error));

            };

            //Subir una factura
            const uploadFile = async () => {
                if (selectedButton.value === 'Facturas' && checkboxChecked.value) {
                    const fileInput = document.getElementById('invoiceUpload');
                    const formData = new FormData();
                    formData.append('invoiceUpload', fileInput.files[0]);

                    var requestOptions = {
                        method: 'POST',
                        body: formData,
                        redirect: 'follow'
                    };

                    fetch("<?= base_url("facturas/subidaFacturaCliente") ?>", requestOptions)
                        .then(response => response.json())
                        .then(result => {
                            getFacturas();
                            if(result.error == 'factura'){
                                M.toast({html: 'Se ha subido la factura'});
                            } else if(result.error == 'uuid'){
                                M.toast({html: 'Ya se ha subido la factura'});
                            } else if(result.error == 'rfc'){
                                M.toast({html: 'el rfc no corresponde a el de su factura '});
                            }
                        })
                        .catch(error => console.log('error', error));
                } else {
                    alert('Ingresa una factura y acepta los terminos');
                }
            };

            //Subir una operacion
            const uploadOperation = async () => {

                if (selectedButton.value == 'Operaciones' && radioChecked.value) {
                    const fileInput = document.getElementById('operationUpload');
                    const grupoRadio = document.getElementsByName('grupoRadio');
                    let selectedRadioValue;
                    grupoRadio.forEach(radio => {
                        if (radio.checked) {
                            selectedRadioValue = radio.value;
                        }
                    });
                    const formData = new FormData();
                    formData.append('operationUpload', fileInput.files[0]);
                    formData.append('grupoRadio', selectedRadioValue);

                    var requestOptions = {
                        method: 'POST',
                        body: formData,
                        redirect: 'follow'
                    };

                    fetch("<?= base_url("facturas/cargaOperacionFactura") ?>", requestOptions)
                        .then(response => response.json())
                        .then(result => {
                            if(result.status == 'ok'){
                                getOperations();
                                M.toast({ html: 'Se ha subido la operacion' });
                            }else{
                                M.toast({ html: 'Error con la operacion, verifique su factura' });
                            }

                        })
                        .catch(error => console.log('error', error));

                } else {
                    alert('Ingresa una factura')
                }
            };

            //Subir una operacion unica
            const uploadOperationUnica = async () => {
                if (selectedButton.value == 'Operaciones') {
                    const fileInput = document.getElementById('uniqueOperationUpload');
                    let selectedValue = facturasClientUnique.value[0]['id'];
                    
                    const formData = new FormData();
                    formData.append('operationUpload', fileInput.files[0]);
                    formData.append('grupoRadio', selectedValue);

                    var requestOptions = {
                        method: 'POST',
                        body: formData,
                        redirect: 'follow'
                    };

                    fetch("<?= base_url("facturas/cargaOperacionFacturaUnica") ?>", requestOptions)
                        .then(response => response.json())
                        .then(result => {
                            if(result.status == 'ok'){
                                getOperations();
                                M.toast({ html: 'Se ha subido la operacion' });
                            }else{
                                M.toast({ html: 'Error con la operacion, verifique su factura' });
                            }

                        })
                        .catch(error => console.log('error', error));

                } else {
                    alert('Ingresa una factura')
                }
            };

            //tabla de get operaciones
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
                    .catch(error => console.log('error', error));
            };

            //tabla de get facturas
            const getFacturas = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?= base_url("facturas/tablaFacturasCliente") ?>", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        facturas.value = result.facturas;
                        facturas.value.reverse();
                    })
                    .catch(error => console.log('error', error));
            };


            //tabla de get facturas por cliente
            const getFacturasByClient = async () => {

                const fileInput = document.getElementById('operationUpload');
                const formData = new FormData();
                formData.append('operationUpload', fileInput.files[0]);

                var requestOptions = {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow'
                };
                fetch("<?= base_url("facturas/cargaFacturasPorCliente") ?>", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        providerUploadName.value = result.emisor;
                        facturasClient.value = result.facturasClient;
                        facturasClient.value.reverse();
                    })
                    .catch(error => console.log('error', error));
            };

            //tabla de get facturas por cliente
            const getFacturasByClientUnica = async () => {
                const fileInput = document.getElementById('uniqueOperationUpload');
                const formData = new FormData();
                formData.append('operationUpload', fileInput.files[0]);

                var requestOptions = {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow'
                };
                fetch("<?= base_url("facturas/cargaFacturasPorCliente") ?>", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        providerUploadNameUnique.value = result.emisor;
                        //facturasClient.value = result.facturasClient;
                        //acturasClient.value.reverse();
                    })
                    .catch(error => console.log('error', error));
            };

            //tabla get operacion por id y obtencion del id
            const guardarSeleccion = async (id) => {
                selectedoperationId.value = id;
                getOperationById(id);
            }; 
            
            const getOperationById = async (selectedoperationId) => {

                const formData = new FormData();
                console.log(selectedoperationId);
                formData.append('selectedoperationId', selectedoperationId);

                var requestOptions = {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow'
                };
                fetch("<?= base_url("facturas/cargaOperacionPorId") ?>", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        operationsClient.value = result.operationsClient;
                        operationsClient.value.reverse();                    
                    }).catch(error => console.log('error', error));
            };

            //aprobar operacion
            const changeStatus =  async (acceptOrDecline)  => {

                const formData = new FormData();
                acceptDecline.value = acceptOrDecline;
                formData.append('selectedoperationId', selectedoperationId.value);
                formData.append('acceptDecline', acceptDecline.value);

                var requestOptions = {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow'
                };

                fetch("<?= base_url("facturas/statusOperacion") ?>", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        getOperations();
                        M.toast({ html: 'Se ha aprobo la operacion' });
                    })
                    .catch(error => console.log('error', error));
            };

            //cambiar de nombre el input para subir una operacion y manda a llamar las operaciones
            const checkFormatOperation = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    operationUploadName.value = fileInput.files[0].name;
                    getFacturasByClient();
                } else {
                    operationUploadName.value = '';
                    providerUploadName.value = '';
                }
            };

            //cambiar de nombre el input para subir una operacion y manda a llamar las operaciones
            const checkFormatOperationUnique = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    operationUploadNameUnique.value = fileInput.files[0].name;
                    getFacturasByClientUnica();
                } else {
                    operationUploadNameUnique.value = '';
                    providerUploadNameUnique.value = '';
                }
            };

            //cambiar de nombre el input para subir una factura
            const checkFormatInvoice = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    invoiceUploadName.value = fileInput.files[0].name;;
                } else {
                    invoiceUploadName.value = '';
                }
            };

            //Ver que tabla vamos a ver segun el boton seleccionado
            const selectButton = (buttonName) => {
                if (selectedButton.value != buttonName) {
                    selectedButton.value = buttonName;
                }
            };

            //Llenar tabla de operación unica con factura seleccionada
            const operacionUnicaCliente = (factura) => {
                facturasClientUnique.value[0] = factura;
                if (selectedButton.value != 'Operaciones') {
                    selectedButton.value = 'Operaciones';
                }
            }

            //Llenar vista de operación seleccionada
            const vistaOperacion = (operacion) => {
                operationsView.value[0] = operacion;
            }

            //mandar a llamar las funciones
            Vue.onMounted(
                () => {
                    getOperations();
                    getFacturas();
                }
            );

            //Returnar todo
            return {
                invoiceUploadName,
                operationUploadName,
                providerUploadName,
                selectedButton,
                checkFormatInvoice,
                checkFormatOperation,
                checkboxChecked,
                radioChecked,
                uploadFile,
                uploadOperation,
                selectButton,
                getFacturasByClient,
                getOperationById,
                operaciones,
                facturas,
                operationsClient,
                facturasClient,
                autorizar,
                actualizacion,
                guardarSeleccion,
                changeStatus,
                operacionUnicaCliente,
                facturasClientUnique,
                checkFormatOperationUnique,
                operationUploadNameUnique,
                providerUploadNameUnique,
                getFacturasByClientUnica,
                uploadOperationUnica,
                vistaOperacion,
                operationsView
            };
        }
    });
</script>