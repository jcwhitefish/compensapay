<div class="p-5" id="app">
    <div class="row">
        <p class="px-3">Periodo:</p>
        <div class="col l3">
            <input type="date" id="start" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
            <label for="start">Desde:</label>
        </div>
        <div class="col l3">
            <input type="date" id="fin" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
            <label for="fin">Hasta:</label>
        </div>
        <div class="col l3">
        </div>
    </div>

    <div class="card esquinasRedondas">
        <div class="card-content">
            <div style="overflow-x: auto;">
                <table class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Empresa</th>
                            <th style="text-align: right;">Total<br />operaciones</th>
                            <th style="text-align: right;">Operaciones<br />realizadas</th>
                            <th style="text-align: right;">Operaciones<br />canceladas</th>
                            <th style="text-align: right;">Operaciones<br />pendientes</th>
                            <th style="text-align: right;">Operaciones<br />autorizadas</th>
                            <th>Fecha última operación</th>
                            <th style="text-align: right;">Monto<br />ingreso</th>
                            <th style="text-align: right;">Monto<br />egreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(is_array($repor["reporte"]))
                        {
                            foreach ($repor["reporte"] as $value)
                            {
                                $tipo = $value["provider_id"] == $this->session->userdata('datosEmpresa')['id'] ? 'Clente' : 'Proveedor';
                                $empresa = $value["short_name"] != NULL ? $value["short_name"] : $value["long_name"];

                                echo '<tr>
                                        <td>'.$tipo.'</td>
                                        <td style="white-space: nowrap;">'.$empresa.'</td>
                                        <td style="text-align: right;">'.$value["operaciones"].'</td>
                                        <td style="text-align: right;">'.$value["realizadas"].'</td>
                                        <td style="text-align: right;">'.$value["canceladas"].'</td>
                                        <td style="text-align: right;">'.$value["pendientes"].'</td>
                                        <td style="text-align: right;">'.$value["autorizadas"].'</td>
                                        <td style="white-space: nowrap;">'.date('d-m-Y',$value["ultimaoperacion"]).'</td>
                                        <td style="text-align: right; white-space: nowrap;">$ '.number_format($value["ingresos"],2).'</td>
                                        <td style="text-align: right; white-space: nowrap;">$ '.number_format($value["egresos"], 2).'</td>
                                    </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>