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
<div class="p-5" style="margin: 0;padding: 0 !important;">
    <!-- head con el calendario -->
	<div class="card esquinasRedondas" style="margin-right: 15px; margin-bottom: 5px">
		<div class="row" style="margin-left: 30px; margin-bottom: 1px">
			<h6>Periodo:</h6>
		</div>
		<div class="row" style="margin-bottom: 10px">
			<div class="col l3">
				<div class="row" style="margin-bottom: 0px;">
					<div class="col valign-wrapper"><p>Desde:</p></div>
					<div class="col">
						<label for="start">
							<input type="date" id="start" name="trip-start" value="2023-10-01" min="2023-10-01" max="<?=date('Y-m-d', strtotime('now'))?>" />
						</label>
					</div>
				</div>
			</div>
			<div class="col l3">
				<div class="row" style="margin-bottom: 0px;">
					<div class="col valign-wrapper"><p>Hasta:</p></div>
					<div class="col">
						<label for="fin">
							<input type="date" id="fin" name="trip-start" value="<?=date('Y-m-d', strtotime('now'))?>" min="2023-10-01" max="<?=date('Y-m-d', strtotime('now'))?>" />
						</label>
					</div>
				</div>
			</div>
			<div class="col l3"></div>
			<div class="col l3 valign-wrapper">
				<a id="download" class="waves-effect btn " download
				   style="background-color:#1565c0 !important; border: 2px solid #0d47a1 !important;
				   border-radius:10px !important">Exportar</a>
			</div>
		</div>

	</div>
    <!-- Las tablas principales que se muestran -->
    <div class="card esquinasRedondas" id="tblsViewer" style="margin-right: 15px">
        <div class="card-content" style="padding: 10px; margin-right: ">
            <div class="row" style="margin-bottom: 1px">
                <div id="Menus" class="row l12 p-3" style="margin-bottom: 5px">
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
                <table id="activeTbl" class="visible-table striped responsive-table" style="display: block; max-height: 400px">
					<tbody>
						<tr><td class="center-align">No hay datos</td></tr>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
	let btnActive = 0;
	$(document).ready(function() {
		cfdi();
		$('#start').on('change', function (){
			switch(btnActive) {
				case 0:
					cfdi();
					break;
				case 1:
					comprobantesP()
					break;
				case 2:
					movimientos()
					break;
				case 3:
					estados()
					break;
				default:
				// code block
			}

		});
		$('#fin').on('change', function (){
			switch(btnActive) {
				case 0:
					cfdi();
					break;
				case 1:
					comprobantesP()
					break;
				case 2:
					movimientos()
					break;
				case 3:
					estados()
					break;
				default:
				// code block
			}

		});
	});
	function noSelect(){
		$('#cfdi').removeClass("selected");
		$('#comprobantes').removeClass("selected");
		$('#movimientos').removeClass("selected");
		$('#estados').removeClass("selected");
		$('#activeTbl').empty();
	}
	function cfdi(){
		btnActive = 0;
		noSelect();
		$('#cfdi').addClass("selected");
		const tableBase = '<thead style="position:sticky; top: 0;"><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Emisor</th>' +
			'<th>Receptor</th>' +
			'<th class="center-align">CFDI</th>' +
			'<th>Fecha CFDI</th>' +
			'<th>Fecha Alta</th>' +
			'<th style="min-width: 135px">Fecha limite de pago</th>' +
			'<th style="min-width: 110px">Total</th>' +
			'<th>tipo</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan=11" class="center-align">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
		$.ajax({
			url: '/Documentos/DocsCFDI',
			data: {
				from: $('#start').val(),
				to: $('#fin').val(),
			},
			dataType: 'json',
			method: 'post',
			beforeSend: function () {
				const obj = $('#tblsViewer');
				const left = obj.offset().left;
				const top = obj.offset().top;
				const width = obj.width();
				const height = obj.height();
				$('#solveLoader').css({
					display: 'block',
					left: left,
					top: top,
					width: width,
					height: height,
					zIndex: 999999
				}).focus();
			},
			success: function (data) {
				if (data.code === 500){
					let toastHTML = '<span><strong>'+data.message+'</strong></span>';
					M.toast({html: toastHTML});
					toastHTML = '<span><strong>'+data.reason+'</strong></span>';
					M.toast({html: toastHTML});
				}else if (data.code === 404){
				}else{
					$('#tblBody').empty();
					$.each(data, function(index, value){
						let uuid = '<a href="' + value.idurl + '" target="_blank">' + value.uuid + '</a>';
						let subtotal;
						let iva;
						const tr = $('<tr>' +
							'<td><input id="checkTbl" type="checkbox" style="position:static"></td>' +
							'<td>' + value.emisor + '</td>' +
							'<td>' + value.receptor + '</td>' +
							'<td>' + uuid + '</td>' +
							'<td>' + value.dateCFDI + '</td>' +
							'<td>' + value.dateCreate + '</td>' +
							'<td>' + value.dateToPay + '</td>' +
							'<td>$ ' + value.total + '</td>' +
							'<td>' + value.tipo + '</td>' +
							'</tr>');
						$('#tblBody').append(tr);
					});
				}
			},
			complete: function () {
				$('#solveLoader').css({
					display: 'none'
				});
			},
			error: function (data){
				$('#solveLoader').css({
					display: 'none'
				});
				let toastHTML = '<span><strong>Ha ocurrido un problema</strong></span>';
				M.toast({html: toastHTML});
				toastHTML = '<span>Por favor intente mas tarde</span>';
				M.toast({html: toastHTML});
				toastHTML = '<span>Si el problema persiste levante ticket en el apartado de soporte</span>';
				M.toast({html: toastHTML});
			}
		});
	}
	function comprobantesP(){
		btnActive = 1;
		noSelect();
		$('#comprobantes').addClass("selected");
		const tableBase = '<thead style="position:sticky; top: 0;"><tr>' +
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
			'<tbody id="tblBody"><tr><td colspan="9" class="center-align">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
		$.ajax({
			url: '/Documentos/DocsCEP',
			data: {
				from: $('#start').val(),
				to: $('#fin').val(),
			},
			dataType: 'json',
			method: 'post',
			beforeSend: function () {
				const obj = $('#tblsViewer');
				const left = obj.offset().left;
				const top = obj.offset().top;
				const width = obj.width();
				const height = obj.height();
				$('#solveLoader').css({
					display: 'block',
					left: left,
					top: top,
					width: width,
					height: height,
					zIndex: 999999
				}).focus();
			},
			success: function (data) {
				if (data.code === 500 || data.code === 404){
					let toastHTML = '<span><strong>'+data.message+'</strong></span>';
					M.toast({html: toastHTML});
					toastHTML = '<span><strong>'+data.reason+'</strong></span>';
					M.toast({html: toastHTML});
				}else{
					$('#tblBody').empty();
					$.each(data, function(index, value){
						let cepUrl;
						if (value.cepUrl !== null || value.cepUrl !== ''){
							cepUrl = '<a href="' + value.cepUrl + '" target="_blank">Descargar CEP</a>';
						}else{
							cepUrl = 'No disponible';
						}
						const tr = $('<tr>' +
							'<td><input id="checkTbl" type="checkbox" style="position:static"></td>' +
							'<td>' + cepUrl + '</td>' +
							'<td>' + value.source_bank + '</td>' +
							'<td>' + value.receiver_bank + '</td>' +
							'<td>' + value.receiver_clabe + '</td>' +
							'<td>' + value.traking_key + '</td>' +
							'<td>' + value.operationNumber + '</td>' +
							'<td>' + value.transaction_date + '</td>' +
							'<td>' + value.amount + '</td>' +
							'</tr>');
						$('#tblBody').append(tr);
					});
				}
			},
			complete: function () {
				$('#solveLoader').css({
					display: 'none'
				});
			},
			error: function (data){
				$('#solveLoader').css({
					display: 'none'
				});
				let toastHTML = '<span><strong>Ha ocurrido un problema</strong></span>';
				M.toast({html: toastHTML});
				toastHTML = '<span>Por favor intente mas tarde</span>';
				M.toast({html: toastHTML});
				toastHTML = '<span>Si el problema persiste levante ticket en el apartado de soporte</span>';
				M.toast({html: toastHTML});
			}
		});
	}
	function movimientos(){
		btnActive = 2;
		noSelect();
		$('#movimientos').addClass("selected");
		const tableBase = '<thead style="position:sticky; top: 0;"><tr>' +
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
			'<th>CFDI correspondiente</th>' +
			'<th>Fecha de Transacción</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan="16" class="center-align">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
		$.ajax({
			url: '/Documentos/DocsMovimientos',
			data: {
				from: $('#start').val(),
				to: $('#fin').val(),
			},
			dataType: 'json',
			method: 'post',
			beforeSend: function () {
				const obj = $('#tblsViewer');
				const left = obj.offset().left;
				const top = obj.offset().top;
				const width = obj.width();
				const height = obj.height();
				$('#solveLoader').css({
					display: 'block',
					left: left,
					top: top,
					width: width,
					height: height,
					zIndex: 999999
				}).focus();
			},
			success: function (data) {
				if (data.code === 500 || data.code === 404){
					let toastHTML = '<span><strong>'+data.message+'</strong></span>';
					M.toast({html: toastHTML});
					toastHTML = '<span><strong>'+data.reason+'</strong></span>';
					M.toast({html: toastHTML});
				}else{
					$('#tblBody').empty();
					$.each(data, function(index, value){
						let uuid;
						let urlCep;
						if (value.cepUrl !== null || value.cepUrl !== ''){
							urlCep = '<a href="' + value.cepUrl + '" target="_blank">Descargar CEP</a>';
						}else{
							urlCep = 'No disponible';
						}
						uuid = '<a href="' + value.idurl + '" target="_blank">' + value.uuid + '</a>';
						const tr = $('<tr>' +
							'<td><input id="checkTbl" type="checkbox" style="position:static"></td>' +
							'<td>' + value.amount + '</td>' +
							'<td>' + value.traking_key + '</td>' +
							'<td>' + urlCep + '</td>' +
							'<td>' + value.descriptor + '</td>' +
							'<td>' + value.source_bank + '</td>' +
							'<td>' + value.destination_bank + '</td>' +
							'<td>' + ((value.source_name === null || value.source_name === ''  || value.source_name === 'null') ? '---': value.source_name) + '</td>' +
							'<td>' + ((value.source_rfc === null || value.source_rfc === ''  || value.source_rfc === 'null') ? '---': value.source_rfc) + '</td>' +
							'<td>' + ((value.destiantion_name === null || value.destiantion_name === ''  || value.destiantion_name === 'null') ? '---' : value.destiantion_name) + '</td>' +
							'<td>' + ((value.destination_rfc === null || value.destination_rfc === ''  || value.destination_rfc === 'null') ? '---' : value.destination_rfc) + '</td>' +
							'<td>' + value.source_clabe + '</td>' +
							'<td>' + value.receiver_clabe + '</td>' +
							'<td>' + uuid + '</td>' +
							'<td>' + value.transaction_date + '</td>' +
							'</tr>');
						$('#tblBody').append(tr);
					});
				}
			},
			complete: function () {
				$('#solveLoader').css({
					display: 'none'
				});
			},
			error: function (data){
				$('#solveLoader').css({
					display: 'none'
				});
				let toastHTML = '<span><strong>Ha ocurrido un problema</strong></span>';
				M.toast({html: toastHTML});
				toastHTML = '<span>Por favor intente mas tarde</span>';
				M.toast({html: toastHTML});
				toastHTML = '<span>Si el problema persiste levante ticket en el apartado de soporte</span>';
				M.toast({html: toastHTML});
			}
		});
	}
	function estados(){
		noSelect();
		$('#estados').addClass("selected");
		const tableBase = '<thead style="position:sticky; top: 0;"><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Mes</th>' +
			'<th>Días del periodo</th>' +
			'<th>Depósitos</th>' +
			'<th>Retiros</th>' +
			'<th>Saldo inicial</th>' +
			'<th>Saldo Final</th>' +
			'<th>Movimientos</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan="8" class="center-align">No hay datos</td></tr></tbody>';
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
