<div class="p-5" id="app">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title p-5">XML</h2>
            <form method="post" action="<?php echo base_url('xml/xmltemp'); ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col l9 input-border">
                        <input type="text" name="comprobantexmlDisabled" id="comprobantexmlDisabled" disabled v-model="comprobantexmlUploadName">
                        <label for="comprobantexmlDisabled">Comprobante de xml</label>
                    </div>
                    <div class="col l3 center-align p-5">
                        <label for="comprobantexmlUpload" class="custom-file-upload">Agregar</label>
                        <input @change="checkFormat" name="comprobantexmlUpload" ref="comprobantexmlUpload" id="comprobantexmlUpload" type="file" accept="application/xml" maxFileSize="5242880" required />
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
            const comprobantexmlUploadName = Vue.ref('');

            const checkFormat = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    comprobantexmlUploadName.value = fileInput.files[0].name;
                } else {
                    comprobantexmlUploadName.value = '';
                }
            };

            return {
                comprobantexmlUploadName,
                checkFormat,
            }
        }
    });
</script>
