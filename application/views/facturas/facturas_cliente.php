<div class="p-5" id="app">
    <div class="row">
        <p class="px-3">Periodo:</p>
        <div class="col l3">
            <input type="date" id="start" name="trip-start" value="2018-07-22" min="2018-01-01" max="2018-12-31" />
            <label for="start">Inicio:</label>
        </div>
        <div class="col l3">
            <input type="date" id="fin" name="trip-start" value="2018-07-22" min="2018-01-01" max="2018-12-31" />
            <label for="fin">Fin:</label>
        </div>
        <div class="col l6 right-align p-5">
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
                        <input type="search" placeholder="Buscar" >
                    </form>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table v-if="selectedButton === 'Facturas'" class="visible-table">
                    <thead>
                        <tr>
                            <th class="tabla-celda">Crear Operación</th>
                            <th class="tabla-celda">Emitido por</th>
                            <th class="tabla-celda">Factura</th>
                            <th class="tabla-celda">Fecha Factura</th>
                            <th class="tabla-celda">Fecha Alta</th>
                            <th class="tabla-celda">Fecha Transacción</th>
                            <th class="tabla-celda">Estatus</th>
                            <th class="tabla-celda">Subtotal</th>
                            <th class="tabla-celda">IVA</th>
                            <th class="tabla-celda">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($facturas as $factura) : ?>
                            <tr>
                                <td class="tabla-celda"><i class="tiny material-icons">check_box</i></td>                
                                <td class="tabla-celda"><?= $factura->Usuario ?></td>
                                <td class="tabla-celda"><?= $factura->NumOperacion ?></td><!--aqui deberia estar factura -->
                                <td class="tabla-celda"><?= $factura->FechaUpdate ?></td><!--aqui deberia estar las fechas bien -->
                                <td class="tabla-celda"><?= $factura->FechaEmision ?></td>
                                <td class="tabla-celda"><?= $factura->FechaUpdate ?></td>
                                <td class="tabla-celda"><?= $factura->Estatus?></td>
                                <td class="tabla-celda"><?= $factura->Subtotal ?></td>
                                <td class="tabla-celda"><?= $factura->Impuestos ?></td>
                                <td class="tabla-celda"><?= $factura->Total ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <table v-if="selectedButton === 'Operaciones'" class="visible-table">       
                    <thead>
                        <tr>
                            <th class="tabla-celda">Aprobacion</th>
                            <th class="tabla-celda">ID Operacion</th>
                            <th class="tabla-celda">Proveedor</th>
                            <th class="tabla-celda">Fecha Factura</th>
                            <th class="tabla-celda">Fecha Alta</th>
                            <th class="tabla-celda">Factura</th>
                            <th class="tabla-celda">Nota de Débito/Factura Proveedor</th>
                            <th class="tabla-celda">Fecha Nota de Débito / Fact Proveedor</th>
                            <th class="tabla-celda">Fecha Transacción</th>
                            <th class="tabla-celda">Estatus</th>
                            <th class="tabla-celda">Monto Ingreso</th>
                            <th class="tabla-celda">Monto Egreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        
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
                    <form method="post" action="<?php echo base_url('facturas/correcto'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l9 input-border">
                                <input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName">
                                <label for="invoiceDisabled">Una factura en xml o múltiples en .zip</label>
                            </div>
                            <div class="col l3 center-align p-5"> 
                                <label for="invoiceUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                <input @change="checkFormatInvoice" name="invoiceUpload" ref="invoiceUpload" id="invoiceUpload" type="file" accept="application/xml" maxFileSize="5242880" required />
                            </div><br>
                            <div class="col l12 center-align">
                                <a href="#!" class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                 &nbsp;
                                <button class="button-blue" type="submit" name="action">Siguiente</button><br><br>
                                <p class="text-modal">*Al dar clic en "crear operación", el proveedor acepta que al concluir la transacción por el pago de la factura, se descontará y enviará al cliente de forma automática el monto de la nota de débito o factura del cliente, de acuerdo con lo estipulado en nuestros términos y condiciones</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-operacion" class="modal">
        <div class="modal-content">
            <h5>Crear Operación</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6 class="p-3">Carga tu factura y selecciona una factura del proveedor o busca un proveedor y selecciona una factura</h6>
                    <form method="post" action="<?php echo base_url('xml/factura'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l3 input-border">
                                <input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName">
                                <label for="invoiceDisabled">Tu factura XML</label>
                            </div>
                            <div class="col l4 input-border">
                                <br>
                            </div>
                            <div class="col l5 input-border">
                                <input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName">
                                <label for="invoiceDisabled">Proveedor</label>
                            </div>
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="tabla-celda">Crear Operación</th>
                                            <th class="tabla-celda">Emitido por</th>
                                            <th class="tabla-celda">Factura</th>
                                            <th class="tabla-celda">Fecha Factura</th>
                                            <th class="tabla-celda">Fecha Alta</th>
                                            <th class="tabla-celda">Fecha Transacción</th>
                                            <th class="tabla-celda">Estatus</th>
                                            <th class="tabla-celda">Subtotal</th>
                                            <th class="tabla-celda">IVA</th>
                                            <th class="tabla-celda">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($facturas as $factura) : ?>
                                            <tr>
                                                <td class="tabla-celda"><i class="tiny material-icons">check_box</i></td>                
                                                <td class="tabla-celda"><?= $factura->Usuario ?></td>
                                                <td class="tabla-celda"><?= $factura->NumOperacion ?></td><!--aqui deberia estar factura -->
                                                <td class="tabla-celda"><?= $factura->FechaUpdate ?></td><!--aqui deberian estar las fechas bien -->
                                                <td class="tabla-celda"><?= $factura->FechaEmision ?></td>
                                                <td class="tabla-celda"><?= $factura->FechaUpdate ?></td>
                                                <td class="tabla-celda"><?= $factura->Estatus?></td>
                                                <td class="tabla-celda"><?= $factura->Subtotal ?></td>
                                                <td class="tabla-celda"><?= $factura->Impuestos ?></td>
                                                <td class="tabla-celda"><?= $factura->Total ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div><br>
                            <div class="col l12 center-align">
                                <button class="button-blue" type="submit" name="action">Solicitar Factura</button>
                                &nbsp;
                                <a href="#!" class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
                                 &nbsp;
                                <button class="button-blue" type="submit" name="action">Siguiente</button><br><br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<style>
    .text-modal{
        font-size: 10px;
    }
    .modal {
        max-height: 83% !important;
        width: 80% !important;
    }

    .input-border input[type=search] {
        border: 3px solid #ddd;
        border-radius: 30px !important;
        padding: 0 8px !important;
        margin: 15px 0 10px 0 !important;
        height: 35px !important;
        width: 180px !important;
    }

    .input-border input[type=search]:focus{
        border-color: #444 !important;
        border-bottom: 1px solid #444 !important;
        box-shadow: 0 1px 0 0 #444 !important;
    }

    .input-border label {
        color: black;
        top: -75px;
        position: relative;
        font-weight: bold !important;
    }

    .input-border input[type=search]:focus + label {
        color: #111 !important;
    }
    .tabla-celda {
        min-width: 100px;
        max-width: 150px; 
        padding: 5px; 
        text-align: center; 
        font-size: 13px;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    /* BORRAR */

    .selected {
        background-color: black !important;
        color: white;
        height: 50px;
        border: 2px solid black !important;
        border-radius: 10px;
    }

    .button-table {
        background-color: white;
        border: 2px solid white;
        height: 50px;
        width: 110px
    }

    .button-table:focus {
        background-color: black !important;
        color: white;
        height: 50px;
        border: 2px solid black !important;
        border-radius: 10px;
    }
   
</style>

<script>
    const app = Vue.createApp({
        setup() {
            const invoiceUploadName = Vue.ref('');
            const selectedButton = Vue.ref(null);

            const checkFormatInvoice = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    invoiceUploadName.value = fileInput.files[0].name;
                } else {
                    invoiceUploadName.value = '';
                }
            };

            const selectButton = (buttonName) => {
                if (selectedButton.value == buttonName) {
                    selectedButton.value = null;
                } else {
                    selectedButton.value = buttonName;
                }
            };

            return {
                invoiceUploadName,
                selectedButton,
                checkFormatInvoice,
                selectButton,
            };
        }
    });
</script>
