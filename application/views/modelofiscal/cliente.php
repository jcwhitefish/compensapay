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
            <a class="button-blue" href="#">
                Descagar
            </a>
        </div>
    </div>


    <!-- Las tablas principales que se muestran -->
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div class="col l12 p-3">
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Facturas' }" @click="selectButton('Facturas')">
                        Facturas
                    </button>
                    &nbsp;
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Comprobantes' }" @click="selectButton('Comprobantes')">
                        Comprobantes de pago
                    </button>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table v-if="selectedButton === 'Facturas'" class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
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
                            <td class="center-align"><input type="checkbox"></td>
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
                <table v-if="selectedButton === 'Comprobantes'" class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Institución Emisora</th>
                            <th>Clave de rastreo</th>
                            <th>Numero de referencia</th>
                            <th>Fecha de pago</th>
                            <th>Institución receptora</th>
                            <th>Monto del pago</th>
                            <th>Cuenta beneficiaria</th>
                        </tr>
                    </thead>
                    <tbody>

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
            const selectedButton = Vue.ref('Facturas');
            const facturas = Vue.ref([]);

            //tabla de get facturas
            const getFacturas = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?= base_url("facturas/tablaFacturas") ?>", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        facturas.value = result.facturas;
                        facturas.value.reverse();
                    })
                    .catch(error => console.log('error', error));
            };

            //Ver que tabla vamos a ver segun el boton seleccionado
            const selectButton = (buttonName) => {
                if (selectedButton.value != buttonName) {
                    selectedButton.value = buttonName;
                }
            };

            //mandar a llamar las funciones
            Vue.onMounted(
                () => {
                    getFacturas();
                }
            );

            //Returnar todo
            return {
                selectedButton,
                selectButton,
                facturas,
             };
        }
    });
</script>