
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
                            <th class="tabla-celda">Proveedor</th>
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
                        <?php $facturas = array_reverse($facturas);
                            foreach ($facturas as $row) : ?>
                            <tr>
                                <td class="tabla-celda">
                                    <?php
                                    if ($row->o_Activo == 0) {
                                        echo '<a href="#">Crear Operación</a>';
                                    } elseif ($row->o_Activo == 1) {
                                        echo '<i class="tiny material-icons" style="color: green;">check_circle</i>';
                                    }
                                    ?>
                                </td>             
                                <td class="tabla-celda"><a href="#">Empresa 1</a></td><!--aqui deberia estar usuario -->
                                <td class="tabla-celda"><?= $row->o_NumOperacion ?></td><!--aqui deberia estar row -->
                                <td class="tabla-celda">{{modificarFecha('<?= $row->o_FechaEmision ?>')}}</td><!--aqui deberia estar las fechas bien -->
                                <td class="tabla-celda">{{modificarFecha('<?= $row->o_FechaUpload ?>')}}</td>
                                <td class="tabla-celda">{{modificarFecha('<?= $row->o_FechaEmision ?>')}}</td>
                                <td class="tabla-celda">
                                    <?php
                                    if ($row->o_Activo == 0) {
                                        echo 'Pendiente';
                                    } elseif ($row->o_Activo == 1) {
                                        echo 'Cargada';
                                    }
                                    ?>
                                </td>   
                                <td class="tabla-celda">$<?= $row->o_SubTotal ?></td>
                                <td class="tabla-celda">$<?= $row->o_Impuesto ?></td>
                                <td class="tabla-celda">$<?= $row->o_Total ?></td>
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
                            <th class="tabla-celda">Nota de Débito</th>
                            <th class="tabla-celda">Fecha Nota de Débito</th>
                            <th class="tabla-celda">Fecha Transacción</th>
                            <th class="tabla-celda">Estatus</th>
                            <th class="tabla-celda">Monto Ingreso</th>
                            <th class="tabla-celda">Monto Egreso</th>
                            <th class="tabla-celda">Adelanta tu pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $operaciones = array_reverse($operaciones);
                            foreach ($operaciones as $operacion) : ?>
                            <tr>
                                <td class="tabla-celda">
                                    <?php
                                    if ($operacion->Aprobacion == 0) {
                                        echo '';
                                    } elseif ($operacion->Aprobacion == 1) {
                                        echo '<i class="tiny material-icons" style="color: green;">check_circle</i>';
                                    }
                                    ?>
                                </td>
                                <td class="tabla-celda"><?php echo $operacion->ID_Operacion; ?></td>
                                <td class="tabla-celda"><?php echo $operacion->Proveedor; ?></td>
                                <td class="tabla-celda"><?php echo $operacion->Fecha_Factura; ?></td>
                                <td class="tabla-celda"><?php echo $operacion->Fecha_Alta; ?></td>
                                <td class="tabla-celda"><?php echo $operacion->Factura; ?></td>
                                <td class="tabla-celda"><?php echo $operacion->Nota_Debito_Factura_Proveedor; ?></td>
                                <td class="tabla-celda"><?php echo $operacion->Fecha_Nota_Debito_Fact_Proveedor; ?></td>
                                <td class="tabla-celda"><?php echo $operacion->Fecha_Transaccion; ?></td>
                                <td class="tabla-celda"><?php echo $operacion->Estatus; ?></td>
                                <td class="tabla-celda"><?php echo $operacion->Monto_Ingreso; ?></td>
                                <td class="tabla-celda"><?php echo $operacion->Monto_Egreso; ?></td>
                                <td class="tabla-celda">
                                    <?php
                                    if ($operacion->Aprobacion == 0) {
                                        echo '<a href="#modal-unica-operacion">Adelantar pago</a>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
                            <div class="col l9 input-border">
                                <input
                                type="text"
                                name="invoiceDisabled"
                                id="invoiceDisabled"
                                disabled
                                v-model="invoiceUploadName"
                                />
                                <label for="invoiceDisabled">Una factura en xml o múltiples en .zip</label>
                            </div>
                            <div class="col l3 center-align p-5">
                                <label for="invoiceUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                <input @change="checkFormatInvoice" name="invoiceUpload" ref="invoiceUpload" id="invoiceUpload" type="file" accept="application/xml" maxFileSize="5242880" required />
                            </div><br>
                            <div class="col l12 center-align">
                                <a class="modal-close button-gray" style="color: #fff; color:hover: #"
                                >Cancelar</a
                                >
                                &nbsp;
                                <button class="button-blue" type="button" name="action" @click="uploadFile">Siguiente</button><br /><br />
                                <p class="text-modal">
                                *Al dar clic en "crear operación", el proveedor acepta que al concluir la transacción por el pago de la factura,
                                se descontará y enviará al cliente de forma automática el monto de la nota de débito o factura del cliente,
                                de acuerdo con lo estipulado en nuestros términos y condiciones
                                </p>
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
                    <form method="post" action="<?php echo base_url('facturas/carga'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l3 input-border">
                                <input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName">
                                <label for="invoiceDisabled">Tu factura XML</label>
                            </div>
                            <div class="col l4 left-align p-5">
                                <label for="invoiceUpload" class="custom-file-upload button-blue">Seleccionar</label>
                                <input @change="checkFormatInvoice" name="invoiceUpload" ref="invoiceUpload" id="invoiceUpload" type="file" accept="application/xml" maxFileSize="5242880" />
                            </div>
                            <div class="col l5 input-border select-white">
                                <input type="text" name="providerDisabled" id="providerDisabled" disabled v-model="providerUploadName">
                                <label for="providerDisabled">Proveedor</label>
                            </div>
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="tabla-celda">Crear Operación</th>
                                            <th class="tabla-celda">Proveedor</th>
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
                                    <tbody v-if="providerUploadName == 'Frontier'" class="visible-table">
                                        <?php foreach ($facturas as $row) : ?>
                                            <?php if ($row->o_Activo == 0) : ?> <!-- Verificar si o_Activo es igual a 0 -->
                                                <tr>
                                                    <td class="tabla-celda"><input type="radio" name="grupo" value="opcion1"></td>
                                                    <td class="tabla-celda">Frontier</td><!-- Aquí debería estar usuario -->
                                                    <td class="tabla-celda"><?= $row->o_NumOperacion ?></td><!-- Aquí debería estar row -->
                                                    <td class="tabla-celda"><?= $row->o_FechaEmision ?></td><!-- Aquí debería estar las fechas bien -->
                                                    <td class="tabla-celda"><?= $row->o_FechaUpload ?></td>
                                                    <td class="tabla-celda"><?= $row->o_FechaEmision ?></td>
                                                    <td class="tabla-celda">Pendiente</td>
                                                    <td class="tabla-celda">$<?= $row->o_SubTotal ?></td>
                                                    <td class="tabla-celda">$<?= $row->o_Impuesto ?></td>
                                                    <td class="tabla-celda">$<?= $row->o_Total ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div><br>
                            <div class="col l8">
                                <a onclick="M.toast({html: 'Se ha solicitado la factura'})" class="button-blue modal-close">Solicitar Factura</a>
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
        color: white !important;
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
    [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
        opacity: 1;
        position: relative;
        pointer-events: auto;
    }

    [type="radio"]:not(:checked), [type="radio"]:checked {
        opacity: 1;
        position: relative;
        pointer-events: auto;
    }

    
   
</style>

<script>
    const app = Vue.createApp({
        setup() {
            const invoiceUploadName = Vue.ref('');
            const providerUploadName = Vue.ref('');
            const selectedButton = Vue.ref('Operaciones');

            const checkFormatInvoice = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    invoiceUploadName.value = fileInput.files[0].name;
                    providerUploadName.value = 'Frontier';
                } else {
                    invoiceUploadName.value = '';
                    providerUploadName.value = '';
                }
            };


            const uploadFile = async () => {
                if (selectedButton.value === 'Facturas') {
                    
                    const fileInput = document.getElementById('invoiceUpload');
                    const formData = new FormData();
                    formData.append('user', 6);
                    formData.append('invoiceUpload', fileInput.files[0]);

                 
                        const response = await fetch("<?= base_url('facturas/subida') ?>", {
                            method: 'POST',
                            body: formData,
                            redirect: 'follow'
                        });

                        if (response.ok) {
                            console.log('se subio');
                            window.location.href = '<?php base_url('facturas') ?>';
                        } else {
                            console.error('Error');
                        }

                }
            };

            const modificarFecha = (fecha) =>{
                    fecha = fecha.split(' ');

                    fecha[1] = '';
                    fecha = fecha.join(' ');
                    return fecha;
                }

            const selectButton = (buttonName) => {
                if (selectedButton.value == buttonName) {
                    selectedButton.value = null;
                } else {
                    selectedButton.value = buttonName;
                }
            };

            return {
                invoiceUploadName,
                providerUploadName,
                selectedButton,
                checkFormatInvoice,
                uploadFile,
                modificarFecha,
                selectButton,
            };
        }
    }); 
</script>
