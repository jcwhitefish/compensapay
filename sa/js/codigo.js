//definimos el modal
var modal = document.getElementById('myModal');

function limpiar(){
    document.getElementById("modal-body").innerHTML="";
}

function abrirmodal(){
	modal.style.display = "flex";
}
function cerrarmodal(){
	modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}

//funciones ajax
function dashboard(fechai, fechaf){
	$.ajax({
				type: 'POST',
				url : 'dashboard/dashboard.php',
                data: 'fechai=' + fechai + '&fechaf=' + fechaf
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

function empresas(fechai, fechaf){
	$.ajax({
				type: 'POST',
				url : 'empresas/empresas.php',
                data: 'fechai=' + fechai + '&fechaf=' + fechaf
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}