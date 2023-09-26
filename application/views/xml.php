<div class="p-5" id="app">

    <a class="waves-effect waves-light btn modal-trigger" href="#modal-factura">Añadir Facturas</a>
    <div id="modal-factura" class="modal">
        <div class="modal-content">
            <h5>Carga tus facturas</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h6>Carga tu factura en formato .xml o múltiples facturas en un archivo .zip</h6>
                    <form method="post" action="<?php echo base_url('xml/factura'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l9 input-border">
                                <input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName">
                                <label for="invoiceDisabled">Una factura en xml o múltiples en .zip</label>
                            </div>
                            <div class="col l3 center-align p-5"> 
                                <label for="invoiceUpload" class="custom-file-upload">Agregar</label>
                                <input @change="checkFormatInvoice" name="invoiceUpload" ref="invoiceUpload" id="invoiceUpload" type="file" accept="application/xml" maxFileSize="5242880" required />
                            </div>
                            <div class="col l12 center-align">
                                <button class="button-white"><a href="#!" class="modal-close waves-effect button-black" style="color:#444;">Cancelar</a></button>
                                <button class="button-white" type="submit" name="action">Siguiente</button><br><br>
                                <p class="text-modal">*Al dar clic en "crear operación", el proveedor acepta que al concluir la transacción por el pago de la factura, se descontará y enviará al cliente de forma automática el monto de la nota de débito o factura del cliente, de acuerdo con lo estipulado en nuestros términos y condiciones</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a class="waves-effect waves-light btn modal-trigger" href="#modal-notas">Añadir Notas de credito</a>
    <div id="modal-notas" class="modal">
        <div class="modal-content">
            <h5>Carga tus Notas de credito</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <h2 class="card-title">Nota de credito</h2>
                    <form method="post" action="<?php echo base_url('xml/notaCredito'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col l9 input-border">
                                <input type="text" name="creditNoteDisabled" id="creditNoteDisabled" disabled v-model="creditNoteUploadName">
                                <label for="creditNoteDisabled">Comprobante de Nota</label>
                            </div>
                            <div class="col l3 center-align p-5">
                                <label for="creditNoteUpload" class="custom-file-upload">Agregar</label>
                                <input @change="checkFormatNote" name="creditNoteUpload" ref="creditNoteUpload" id="creditNoteUpload" type="file" accept="application/Nota" maxFileSize="5242880" required />
                            </div>
                            <div class="col l12 center-align">
                                <button class="button-white"><a href="#!" class="modal-close waves-effect button-black" style="color:#444;">Cancelar</a></button>
                                <button class="button-white" type="submit" name="action">Siguiente</button><br><br>
                                <p class="text-modal">*Al dar clic en "crear operación", el proveedor acepta que al concluir la transacción por el pago de la factura, se descontará y enviará al cliente de forma automática el monto de la nota de débito o factura del cliente, de acuerdo con lo estipulado en nuestros términos y condiciones</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<style>
    .text-modal{
        font-size: 8px;
    }
</style>

<script>
    const app = Vue.createApp({
        setup() {
            const invoiceUploadName = Vue.ref('');
            const creditNoteUploadName = Vue.ref('');

            const checkFormatInvoice = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    invoiceUploadName.value = fileInput.files[0].name;
                } else {
                    invoiceUploadName.value = '';
                }
            };

            const checkFormatNote = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    creditNoteUploadName.value = fileInput.files[0].name;
                } else {
                    creditNoteUploadName.value = '';
                }
            };

            return {
                invoiceUploadName,
                creditNoteUploadName,
                checkFormatInvoice,
                checkFormatNote
            };
        }
    });
</script>
