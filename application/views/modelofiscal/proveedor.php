

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
                <div class="col l6 p-3">
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Facturas' }" @click="selectButton('Facturas')">
                        Facturas
                    </button>
                    &nbsp;
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Operaciones' }" @click="selectButton('Operaciones')">
                        Comprobantes de pago
                    </button>
                    &nbsp;
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Cuenta' }" @click="selectButton('Cuenta')">
                        Estados de cuenta
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
                                <td><?= $row->o_idPersona ?></td><!--aqui deberia estar usuario -->
                                <td><?= $row->o_NumOperacion ?></td><!--aqui deberia estar row -->
                                <td><?= $row->o_FechaEmision ?></td><!--aqui deberia estar las fechas bien -->
                                <td><?= $row->o_FechaUpload ?></td>
                                <td><?= $row->o_FechaEmision ?></td>
                                <td>Cargada</td>
                                <td><?= $row->o_SubTotal ?></td>
                                <td><?= $row->o_Impuesto ?></td>
                                <td><?= $row->o_Total ?></td>
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
                                <td><?= $row->o_FechaUpload ?></td>
                                <td>Banregio</td>
                                <td>$<?= $row->o_Total ?></td>
                                <td><?= $row->o_NumOperacion ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <table v-if="selectedButton === 'Cuenta'" class="visible-table striped">       
                    <thead>
                        <th>Seleccionar</th>
                        <th>Mes</th>
                        <th>Días del periodo</th>
                        <th>Depósitos</th>
                        <th>Retiros</th>
                        <th>Depósitos</th>
                        <th>Retiros</th>
                        <th>Saldo inicial</th>
                        <th>Saldo final</th>
                        <th>Movimientos</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="center-align"><input type="checkbox"></td>
                            <td>Noviembre</td>
                            <td>30</td>
                            <td>3</td>
                            <td>1</td>
                            <td>$3,452.16</td>
                            <td>$25,028</td>
                            <td>$254,339</td>
                            <td>$21,576</td>
                            <td><a href="#">Ver detalles</a></td>
                        </tr>
                        <tr>
                            <td class="center-align"><input type="checkbox"></td>
                            <td>Octubre</td>
                            <td>31</td>
                            <td>5</td>
                            <td>5</td>
                            <td>$5,599.68</td>
                            <td>$40,589</td>
                            <td>$149,993</td>
                            <td>$34,998</td>
                            <td><a href="#">Ver detalles</a></td>
                        </tr>
                        <tr>
                            <td class="center-align"><input type="checkbox"></td>
                            <td>Noviembre</td>
                            <td>30</td>
                            <td>3</td>
                            <td>1</td>
                            <td>$3,452.16</td>
                            <td>$25,028</td>
                            <td>$254,339</td>
                            <td>$21,576</td>
                            <td><a href="#">Ver detalles</a></td>
                        </tr>
                        <tr>
                            <td class="center-align"><input type="checkbox"></td>
                            <td>Octubre</td>
                            <td>31</td>
                            <td>5</td>
                            <td>5</td>
                            <td>$5,599.68</td>
                            <td>$40,589</td>
                            <td>$149,993</td>
                            <td>$34,998</td>
                            <td><a href="#">Ver detalles</a></td>
                        </tr>
                        <tr>
                            <td class="center-align"><input type="checkbox"></td>
                            <td>Septiembre</td>
                            <td>30</td>
                            <td>2</td>
                            <td>2</td>
                            <td>$15,232.16</td>
                            <td>$110,433</td>
                            <td>$145,990</td>
                            <td>$95,201</td>
                            <td><a href="#">Ver detalles</a></td>
                        </tr>
                        <tr>
                            <td class="center-align"><input type="checkbox"></td>
                            <td>Agosto</td>
                            <td>31</td>
                            <td>8</td>
                            <td>4</td>
                            <td>$6,544.32</td>
                            <td>$47,446</td>
                            <td>$124,990</td>
                            <td>$40,902</td>
                            <td><a href="#">Ver detalles</a></td>
                        </tr>
                        <tr>
                            <td class="center-align"><input type="checkbox"></td>
                            <td>Julio</td>
                            <td>31</td>
                            <td>4</td>
                            <td>3</td>
                            <td>$11,351.22</td>
                            <td>$82,296</td>
                            <td>$98,259</td>
                            <td>$70,945</td>
                            <td><a href="#">Ver detalles</a></td>
                        </tr>
                        <tr>
                            <td class="center-align"><input type="checkbox"></td>
                            <td>Junio</td>
                            <td>30</td>
                            <td>3</td>
                            <td>3</td>
                            <td>$15,873.44</td>
                            <td>$115,082</td>
                            <td>$56,998</td>
                            <td>$99,209</td>
                            <td><a href="#">Ver detalles</a></td>
                        </tr>
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
            const selectedButton = Vue.ref('Facturas');

            const checkFormatInvoice = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length> 0) {
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

            const downloadFile = () => {
                const archivoPrueba = "Este es el contenido del archivo de prueba.";
                const nombreArchivo = "archivos.zip";
                const blob = new Blob([archivoPrueba], { type: "text/plain" });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href = url;
                a.download = nombreArchivo;
                a.click();
                window.URL.revokeObjectURL(url);
            };

            return {
                invoiceUploadName,
                selectedButton,
                checkFormatInvoice,
                selectButton,
                downloadFile,
            };
        },
    }).mount("#app");
</script>

