<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<div class="p-5">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title p-5">XML</h2>
            <form method="post" action="<?php echo base_url('xml/xmltemp'); ?>" enctype="multipart/form-data">
                <div class="row" id="app">
                    <div class="col l9 input-border">
                        <input type="text" name="xmlDisabled" id="xmlDisabled" disabled v-model="xmlUploadName">
                        <label for="xmlDisabled">XML</label>
                    </div>
                    <div class="col l3 center-align p-5">
                        <label for="xmlUpload" class="custom-file-upload">Agregar</label>
                        <input @change="handleFileUpload" name="xmlUpload" ref="xmlUpload" id="xmlUpload" type="file" accept="application/xml" maxFileSize="5242880" required />
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
    data() {
        return {
        xmlUploadName: "", // Inicialmente, el nombre del archivo está vacío
        };
    },
    methods: {
        handleFileUpload(event) {
        const uploadedFile = event.target.files[0];
        if (uploadedFile) {
            this.xmlUploadName = uploadedFile.name; // Actualiza el nombre del archivo en la instancia de Vue
        } else {
            this.xmlUploadName = ""; // Si no se selecciona ningún archivo, borra el nombre
        }
        },
    },
    });

    app.mount("#app"); // Monta la aplicación Vue en el elemento con el ID "app"
</script>


