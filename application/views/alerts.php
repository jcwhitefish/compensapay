<style>
	a:hover {
		cursor: pointer;
	}
	.ui-dialog-titlebar{
		background: -moz-linear-gradient(#c613db,#76248a) !important;
		color: white !important;
	}
</style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<div class="p-5">
	<div class="row center-align">
		<div class="col l2">
			<a class="button-gray modal-close" id="toast">Toast</a>
		</div>
		<div class="col l3">
			<div class="row">
				<a class="button-blue modal-close" id="toast2">Toast Automatico</a>
			</div>
			<div class="row">
				<label class="col l6"><span>displayLength</span>
					<input
						id="disLength" name="disLength" maxlength="2" class="validate" type="text"
						placeholder="En segundos" data-openpay-card="expiration_month" required
						oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
				</label>
				<label class="col l6"><span>Duración</span>
					<input
						id="duration" name="duration" maxlength="2" class="validate" type="text"
						placeholder="En segundos" data-openpay-card="expiration_month" required
						oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
				</label>
			</div>
		</div>
		<div class="col l2">
			<a class="button-orange modal-close" id="alertS">Alert</a>
		</div>
		<div class="col l2">
			<a class="button-white darken-2 modal-close" id="modalR">Modal</a>
		</div>
		<div class="col l2">
			<a class="button-gray darken-2 modal-close" id="dialogS">Dialog</a>
		</div>
	</div>
</div>
<div id="alertModal" class="modal modal-fixed-footer">
	<div class="modal-content">
		<p>Alerta con un modal</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
	</div>
</div>
<div id="dialog" title="Alerta con dialogo">
	<p>Asi se ve una alerta en un UI Dialog</p>
</div>
<script>
	$(document).ready(function () {
		$("#dialog").dialog({
			autoOpen: false,
			modal: true
		});
		$("#toast").on("click", function () {
			const toastHTML =
				"<span>Esto es un toast que se puede cerrar</span>" +
				"<button onclick=\"M.Toast.dismissAll()\" class=\"btn-flat toast-action\"><strong> X </strong></button>";
			M.toast({html: toastHTML, displayLength: 8000, duration: 8000, edge: "rigth"});
		});
		$("#toast2").on("click", function () {
			let dl = $("#disLength").val();
			dl = dl * 1000;
			let d = $("#duration").val();
			d = d * 1000;
			const toastHTML =
				"<span>Esto es un toast con temporizador</span>";
			M.toast({html: toastHTML, displayLength: dl, duration: d, edge: "rigth"});
		});
		$("#alertS").on("click", function () {
			alert("Esto es una alerta por defecto");
		});
		$("#modalR").on("click", function () {
			$("#alertModal").modal("open");
		});
		$("#dialogS").on("click", function () {
			$("#dialog").dialog("open");
		});
	});
</script>
