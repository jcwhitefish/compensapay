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
			const resume_table = document.getElementById("activeTbl");
			const menu = document.getElementsByClassName("selected")[0].id;

			const inputCheck = resume_table.querySelectorAll('input[id="checkTbl"]');
			const inputChecked = resume_table.querySelectorAll('input[id="checkTbl"]:checked');
			if(inputChecked.length === 0){
                return false;
            }
			let numCheck = 0;
			let content = '';
			const doc = [];

			for (let i = 1, row; row = resume_table.rows[i]; i++) {
                if (inputCheck[numCheck].checked){
                    for (let j = 1, col; col = row.cells[j]; j++, content+= '|') {
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
                    success: function (data) {
						let opResult = data;
						let $a=$("<a>");
                        $a.attr("href",opResult.data);
                        $("body").append($a);
                        $a.attr("download",menu+".xlsx");
                        $a[0].click();
                        $a.remove();
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
<div class="p-5" id="app" style="margin: 0;padding: 0 !important;">
    <!-- head con el calendario -->
    <div class="row" style="padding:0;">
		<form id="dateFilter">
			<fieldset>
				<legend>Periodo</legend>
				<div class="col l3">
					<label for="start">
						<span>Desde:</span>
						<input type="date" id="start" name="trip-start" value="<?=date('Y-m-d', strtotime('now'))?>" min="2023-11-01" max="<?=date('Y-m-d', strtotime('now'))?>" />
					</label>
				</div>
				<div class="col l3">
					<label for="fin">
						<span>Hasta:</span>
						<input type="date" id="fin" name="trip-start" value="<?=date('Y-m-d', strtotime('now'))?>" min="2023-11-01" max="<?=date('Y-m-d', strtotime('now'))?>" />
					</label>
				</div>
				<div class="col l3">
				</div>
				<div class="col l3">
					<a id="download" class="button-blue" href="#" download>
						Descargar
					</a>
				</div>
			</fieldset>
		</form>
    </div>
    <!-- Las tablas principales que se muestran -->
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div id="Menus" class="row l12 p-3">
					<div class="col l2">
						<button id="cfdi" class="button-table" onclick="cfdi()">
							CFDI
						</button>
					</div>
					<div class="col l2">
						<button id="comprobantes" class="button-table" onclick="comprobantesP()">
							Comprobantes de pago
						</button>
					</div>
					<div class="col l2">
						<button id="movimientos" class="button-table" onclick="movimientos()">
							Movimientos
						</button>
					</div>
					<div class="col l2">
						<button id="estados" class="button-table" onclick="estados()">
							Estados de cuenta
						</button>
					</div>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table id="activeTbl" class="visible-table striped responsive-table">
					<tbody>
						<tr><td>No hay datos</td></tr>
					</tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
	$(document).ready(function() {
		cfdi();
	});
	function noSelect(){
		$('#cfdi').removeClass("selected");
		$('#comprobantes').removeClass("selected");
		$('#movimientos').removeClass("selected");
		$('#estados').removeClass("selected");
		$('#activeTbl').empty();
	}
	function cfdi(){
		noSelect();
		$('#cfdi').addClass("selected");
		const tableBase = '<thead><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Emisor</th>' +
			'<th>Receptor</th>' +
			'<th>CFDI</th>' +
			'<th>Fecha CFDI</th>' +
			'<th>Fecha Alta</th>' +
			'<th>Fecha limite de pago</th>' +
			'<th>Subtotal</th>' +
			'<th>IVA</th>' +
			'<th>Total</th>' +
			'<th>tipo</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan=11">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
	}
	function comprobantesP(){
		noSelect();
		$('#comprobantes').addClass("selected");
		const tableBase = '<thead><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Descargar CEP</th>' +
			'<th>Institución emisora</th>' +
			'<th>Institución receptora</th>' +
			'<th>Cuenta beneficiaria</th>' +
			'<th>Clave de rastreo</th>' +
			'<th>Numero de referencia</th>' +
			'<th>Fecha de pago</th>' +
			'<th>Monto del pago</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan="9">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
	}
	function movimientos(){
		noSelect();
		$('#movimientos').addClass("selected");
		const tableBase = '<thead><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Monto</th>' +
			'<th>Número de referencia</th>' +
			'<th>Comprobante electrónico (CEP)</th>' +
			'<th>Descripción</th>' +
			'<th>Banco origen</th>' +
			'<th>Banco destino</th>' +
			'<th>Razón social origen</th>' +
			'<th>RFC Origen</th>' +
			'<th>Razón social destino</th>' +
			'<th>RFC Destino</th>' +
			'<th>CLABE origen</th>' +
			'<th>CLABE destino</th>' +
			'<th>Fecha de transacción</th>' +
			'<th>CFDI correspondiente</th>' +
			'<th>Fecha de Transacción</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan="16">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
	}
	function estados(){
		noSelect();
		$('#estados').addClass("selected");
		const tableBase = '<thead><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Mes</th>' +
			'<th>Días del periodo</th>' +
			'<th>Depósitos</th>' +
			'<th>Retiros</th>' +
			'<th>Saldo inicial</th>' +
			'<th>Saldo Final</th>' +
			'<th>Movimientos</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan="8">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
	}
</script>

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
                }
            );

            //Returnar todo
            return {
                selectedButton,
                movements,
                selectButton,
                facturas,
             };
        }
        
    });
</script>
