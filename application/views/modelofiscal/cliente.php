<?php
    $factura = base_url('assets/factura/factura.php?idfactura=');
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
    integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {

        $('#download').on('click', function() {
            var resume_table = document.getElementById("activeTbl");
            var menu = document.getElementsByClassName("selected")[0].id;

            var inputCheck = resume_table.querySelectorAll('input[id="checkTbl"]');
            var inputChecked = resume_table.querySelectorAll('input[id="checkTbl"]:checked');
            //var menu = menu.querySelectorAll('button[class="selected"]');
            if(inputChecked.length == 0){
                return false;
            }
            var numCheck = 0;
            var content = '';
            var doc = new Array();

            for (var i = 1, row; row = resume_table.rows[i]; i++) {

              //alert(cell[i].innerText);
                if (inputCheck[numCheck].checked){

                    for (var j = 1, col; col = row.cells[j]; j++, content+= ',') {
                        //alert(col[j].innerText);
                        //console.log(`Txt: ${col.innerText} \tFila: ${i} \t Celda: ${j}`);
                        content += col.innerText;
                    }
                    doc.push(content);
                    content = '';
                }
              numCheck++;
            }

            $.ajax({
                    url: '/Facturas/crearExcel',
                    data: {
                        info: doc,
                        menu: menu
                    },
                    dataType: 'json',
                    method: 'post',
                    beforeSend: function () {
                        
                    },
                    success: function (data) {
                        var opResult = data;
                        var $a=$("<a>");
                        $a.attr("href",opResult.data);
                        //$a.html("LNK");
                        $("body").append($a);
                        $a.attr("download",menu+".xlsx");
                        $a[0].click();
                        $a.remove();
                        //console.log(data);
                        //var toastHTML = '<span><strong>¡ticket creado exitosamente!</strong><p>Su numero de folio es: #'+data.folio+'</span>';
                        //M.toast({html: toastHTML});
                    },
                    complete: function () {
                        //$('#descripcion').val('');
                        //$('#asunto').val('');
                        //getTickets();
                    },
                    error: function (data){
                        alert('Ha ocurrido un problema');
                        console.log(data)
                        //location.reload();
                    }
                });
                  
        });


    });
    function hideForms(){
        
    }
</script>
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
            <a id="download" class="button-blue" href="#">
                Descargar
            </a>
        </div>
    </div>

    <!-- Las tablas principales que se muestran -->
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div class="col l12 p-3">
                    <button id="Facturas" class="button-table" :class="{ 'selected': selectedButton == 'Facturas' }" @click="selectButton('Facturas')">
                        Facturas
                    </button>
                    &nbsp;
                    <button id="Comprobantes" class="button-table" :class="{ 'selected': selectedButton == 'Comprobantes' }" @click="selectButton('Comprobantes')">
                        Comprobantes de pago
                    </button>
                    &nbsp;
                    <button id="Movimientos" class="button-table" :class="{ 'selected': selectedButton == 'Movimientos' }" @click="selectButton('Movimientos')">
                        Movimientos
                    </button>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table id="activeTbl" v-if="selectedButton === 'Facturas'" class="visible-table striped responsive-table">
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
                            <td class="center-align"><input id="checkTbl" type="checkbox"></td>
                            <td>{{factura.short_name}}</td>
                            <td><a v-bind:href='factura.idurl' target="_blank">{{factura.uuid}}</a> </td>
                            <td>{{factura.invoice_date}}</td>
                            <td>{{factura.created_at}}</td>
                            <td>
                                <p v-if="factura.transaction_date == '0000-00-00' " >Pendiente</p>
                                <p v-if="factura.transaction_date != '0000-00-00' " >{{factura.transaction_date}}</p>
                            </td>
                            <td>
                                <p v-if="factura.status == '0' " >Libre</p>
                                <p v-if="factura.status == '1' " >En Operación</p>
                                <p v-if="factura.status == '2' " >Pagada</p>
                            </td>
                            <td>${{factura.subtotal}}</td>
                            <td>${{factura.iva}}</td>
                            <td>${{factura.total}}</td>
                        </tr>
                    </tbody>
                </table>
                <table id="activeTbl" v-if="selectedButton === 'Comprobantes'" class="visible-table striped">
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
							<th>Descargar CEP</th>
                        </tr>
                    </thead>
                    <tbody>
						<tr v-for="cep in CEPS">
							<td class="center-align"><input id="checkTbl" type="checkbox"></td>
							<td>{{cep.source_bank}}</td>
							<td>{{cep.traking_key}}</td>
							<td>{{cep.operationNumber}}</td>
							<td>{{cep.transaction_date}}</td>
							<td>{{cep.receiver_bank}}</td>
							<td>{{cep.amount}}</td>
							<td>{{cep.receiver_clabe}}</td>
							<td><a v-bind:href='cep.cepUrl' target="_blank">Descargar CEP</a></td>
						</tr>
                    </tbody>
                </table>
                <table id="activeTbl" v-if="selectedButton === 'Movimientos'" class="visible-table striped responsive-table">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Monto</th>
                            <th>Numero de Referencia</th>
                            <th>Comprobante electrónico (CEP)</th>
                            <th>Descripción</th>
                            <th>Banco origen</th>
                            <th>Banco destino</th>
                            <th>Razón social origen</th>
                            <th>RFC Origen</th>
                            <th>Razón social destino</th>
                            <th>RFC Destino</th>
                            <th>CLABE origen</th>
                            <th>CLABE destino</th>
                            <th>Fecha de transacción</th>
                            <th>CFDI correspondiente</th>
                            <th>Fecha de Transacción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="moves in movements">
                            <td class="center-align"><input id="checkTbl" type="checkbox"></td>
                            <td>{{moves.ammountf}}</td>
                            <td>{{moves.traking_key}}</td>
							<td><a v-bind:href='moves.cepUrl' target="_blank">Descargar CEP</a></td>
                            <td>{{moves.descriptor}}</td>
                            <td>{{moves.bank_source}}</td>
                            <td>{{moves.bank_receiver}}</td>
                            <td>{{moves.provider}}</td>
                            <td>{{moves.source_rfc}}</td>
                            <td>{{moves.client}}</td>
                            <td>{{moves.receiver_rfc}}</td>
                            <td>{{moves.source_clabe}}</td>
                            <td>{{moves.receiver_clabe}}</td>
                            <td>{{moves.transaction_date}}</td>
                            <td><a v-bind:href='moves.idurl' target="_blank"><p class="uuid-text">{{moves.uuid}}</p></a></td>
                            <td>{{moves.transaction_date}}</td>
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
            const selectedButton = Vue.ref('Facturas');
            const facturas = Vue.ref([]);
            const movements = Vue.ref([]);
			const CEPS = Vue.ref([]);

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

            const getMovements = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?= base_url("facturas/tablaMovimientos") ?>", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        console.log(result)
                        movements.value = result.movements;
                        movements.value.reverse();
                    })
                    .catch(error => console.log('error', error));
            };

			const getCEP = () => {
				var requestOptions = {
					method: 'GET',
					redirect: 'follow'
				};
				fetch("<?= base_url("ModeloFiscal/tablaCEP") ?>", requestOptions)
					.then(response => response.json())
					.then(result => {
						console.log(result)
						CEPS.value = result.CEPS;
						CEPS.value.reverse();
					})
					.catch(error => console.log('error', error));
			}

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
                    getMovements();
					getCEP();
                }
            );

            //Returnar todo
            return {
                selectedButton,
                movements,
                selectButton,
                facturas,
				CEPS,
             };
        }
    });
</script>
