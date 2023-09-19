<div class="p-5" id="app">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title p-5">Factura</h2>
            <form method="post" action="<?php echo base_url('xml/factura'); ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col l9 input-border">
                        <input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName">
                        <label for="invoiceDisabled">Comprobante de Factura.xml</label>
                    </div>
                    <div class="col l3 center-align p-5">
                        <label for="invoiceUpload" class="custom-file-upload">Agregar</label>
                        <input @change="checkFormatFactura" name="invoiceUpload" ref="invoiceUpload" id="invoiceUpload" type="file" accept="application/xml" maxFileSize="5242880" required />
                    </div>
                    <div class="col l12 right-align p-5">
                        <button class="button-white" type="submit" name="action">Siguiente</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title p-5">Nota de credito</h2>
            <form method="post" action="<?php echo base_url('xml/notaCredito'); ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col l9 input-border">
                        <input type="text" name="creditNoteDisabled" id="creditNoteDisabled" disabled v-model="creditNoteUploadName">
                        <label for="creditNoteDisabled">Comprobante de Factura.Nota</label>
                    </div>
                    <div class="col l3 center-align p-5">
                        <label for="creditNoteUpload" class="custom-file-upload">Agregar</label>
                        <input @change="checkFormatNota" name="creditNoteUpload" ref="creditNoteUpload" id="creditNoteUpload" type="file" accept="application/Nota" maxFileSize="5242880" required />
                    </div>
                    <div class="col l12 right-align p-5">
                        <button class="button-white" type="submit" name="action">Siguiente</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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
