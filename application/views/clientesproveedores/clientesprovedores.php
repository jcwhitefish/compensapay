<div class="p-5">
    <h5>Socios de negocio</h5>
    <div class="row card esquinasRedondas">
        <div class="col l12 right-align" style="padding: 20px;">
            <a class="modal-trigger button-gray" href="#modalcf">Invitar socio comercial</a>
        </div>
    </div>
    <div class="card esquinasRedondas">
        <div class="card-content">
            <table id="tabla_socios" class="stripe row-border order-column nowrap">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Alias</th>
                        <th>RFC</th>
                        <th>Dirección</th>
                        <th>Código postal</th>
                        <th>Teléfono</th>
                        <th>Fecha de alta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($clipro["clientes"]))
                    {
                        foreach ($clipro["clientes"] as $value)
                        {
                            echo '<tr>
                                    <td>'.$value["legal_name"].'</td>
                                    <td>'.$value["short_name"].'</td>
                                    <td>'.$value['rfc'].'</td>
                                    <td>'.$value["address"].'</td>
                                    <td>'.$value["zip_code"].'</td>
                                    <td>'.$value["telephone"].'</td>
                                    <td>'.date('d-m-Y', $value["created_at"]).'</td>
                                </tr>';
                        }
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalcf" class="modal" style="width: 80% !important; height: 90% !important;">
    <div id="modalinvite" class="modal-content" styke="background: #f6f2f7 !important;">
        <h5>Invitar Socio de negocio</h5>
        <form name="finvitepartner" id="finvitepartner">
        <div class="row card esquinasRedondas">
            <div class="col s12">
                <p>Por favor ingresa el nombre de tu socio y el nombre de su empresa y le haremos llegar una invitación para que se una a la plataforma Solve y puedas conciliar operaciones entre ambos.</p>
            </div>    
            <div class="col s3 input-field">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo de tu socio" required>
                <label for="nombre">Nombre completo de tu socio</label>
            </div>
            <div class="col s3 input-field">
                <input type="text" name="empresa" id="empresa" placeholder="Nombre de la empresa" required>
                <label for="empresa">Nombre de la empresa</label>
            </div>
            <div class="col s3 input-field">
                <input type="text" name="correoe" id="correoe" placeholder="Correo Electrónico" required>
                <label for="correoe">Correo Electrónico</label>
            </div>
            <div class="col s3 input-field">
                <input type="submit" name="botinvsocio" id="botinvsocio" value="Invitar Socio" class="button-gray">
            </div>
        </div>
        </form>
    </div>
</div>

<style>

    /* Fix button selected but all class selected afect */

    .selected {
        background-color: black !important;
        color: white;
        height: 50px;
        border: 2px solid black !important;
        border-radius: 10px;
    }

</style>
<script>
var tabla_51 = $('#tabla_socios').DataTable({
	deferRender:    true,
	language: {
		decimal: '.',
		thousands: ',',
		url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
	},
	paging: false,
	info: false,
	searching: false,
	sort: true
});


$("#finvitepartner").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("finvitepartner"));

	$.ajax({
		url: "<?= base_url('ClientesProveedores/invitasocio'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#modalinvite").html(echo);
	});
});
</script>