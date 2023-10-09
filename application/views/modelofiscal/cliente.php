

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
            <button @click="downloadFile" class="button-blue">Descargar</button>
        </div>
    </div>
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div class="col l4 p-3">
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Facturas' }" @click="selectButton('Facturas')">
                        Facturas
                    </button>
                    &nbsp;
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Operaciones' }" @click="selectButton('Operaciones')">
                        Comprobantes de pago
                    </button>            
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table v-if="selectedButton === 'Facturas'" class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Emitido por</th>
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
                        <?php $facturas = array_reverse($facturas);
                            foreach ($facturas as $row) : ?>
                            <tr>
                                <td class="center-align"><input type="checkbox"></td>
                                <td><a href="#modal-unica-operacion">Frontier</a></td><!--aqui deberia estar usuario -->
                                <td><a href="#modal-unica-operacion"><?= $row->o_NumOperacion ?></a></td><!--aqui deberia estar row -->
                                <td>{{modificarFecha('<?= $row->o_FechaEmision ?>')}}</td><!--aqui deberia estar las fechas bien -->
                                <td>{{modificarFecha('<?= $row->o_FechaUpload ?>')}}</td>
                                <td>{{modificarFecha('<?= $row->o_FechaEmision ?>')}}</td>
                                <td>Cargada</td>
                                <td>$<?= number_format($row->o_SubTotal,2); ?></td>
                                <td>$<?= number_format($row->o_Impuesto,2); ?></td>
                                <td>$<?= number_format($row->o_Total,2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <table v-if="selectedButton === 'Operaciones'" class="visible-table striped">       
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Institucion emisora</th>
                            <th>Clave de rastreo</th>
                            <th>Numero de referencia</th>
                            <th>Fecha de pago</th>
                            <th>Institución receptora</th>
                            <th>Monto del pago</th>
                            <th>Cuenta beneficiaria</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($facturas as $row) : ?>
                            <tr>
                                <td class="center-align"><input type="checkbox"></td>
                                <td>BBVA</td><!--aqui deberia estar usuario -->
                                <td><?= $row->o_NumOperacion ?></td><!--aqui deberia estar row -->
                                <td>REF-<?= $row->o_UUID ?></td><!--aqui deberia estar las fechas bien -->
                                <td>{{modificarFecha('<?= $row->o_FechaUpload ?>')}}</td>
                                <td>Banregio</td>
                                <td>$<?= number_format($row->o_Total); ?></td>
                                <td><?= $row->o_NumOperacion ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>

    /* Fix show checkbox and radiobuttons*/

    [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
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

    /* Buttons */

    .button-table {
        background-color: white;
        border: 2px solid white;
        height: 50px;
        width: 180px
    }

</style>

<script>
    const app = Vue.createApp({
        setup() {
            const invoiceUploadName = Vue.ref('');
            const selectedButton = Vue.ref('Facturas');

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

            const modificarFecha = (fecha) =>{
                    fecha = fecha.split(' ');

                    fecha[1] = '';
                    fecha = fecha.join(' ');
                    return fecha;
                };

            const downloadFile = () => {
                // Simulamos la descarga de un archivo de prueba
                const archivoPrueba = "Este es el contenido del archivo de prueba.";
                const nombreArchivo = "archivos.zip";

                // Crea un objeto Blob con el contenido del archivo
                const blob = new Blob([archivoPrueba], { type: "text/plain" });

                // Crea una URL de objeto Blob
                const url = window.URL.createObjectURL(blob);

                // Crea un elemento de enlace para iniciar la descarga
                const a = document.createElement("a");
                a.href = url;
                a.download = nombreArchivo;

                // Simula un clic en el enlace para iniciar la descarga
                a.click();

                // Limpia la URL de objeto Blob después de la descarga
                window.URL.revokeObjectURL(url);
            };

            return {
                invoiceUploadName,
                selectedButton,
                checkFormatInvoice,
                selectButton,
                modificarFecha,
                downloadFile,
            };
        },
    }).mount("#app");
</script>

