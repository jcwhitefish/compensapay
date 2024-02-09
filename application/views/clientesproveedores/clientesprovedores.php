<div class="p-5">
    <h5>Socios de negocio</h5>
    <div class="row card esquinasRedondas">
        <div class="col l12 right-align" style="padding: 20px;">
            <a class="modal-trigger button-gray">Invitar socio</a>
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
</script>