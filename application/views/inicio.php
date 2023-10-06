<div class="container section">
    <div class="row section black" style="border-radius: 15px">
        <div class="col s3 white-text">
            <h5><strong>Oper. Totales</strong></h5>
            <h6>107</h6>
        </div>
        <div class="col s3 white-text">
            <h5><strong>Total por Cobrar</strong></h5>
            <h6>$ 76,452.07</h6>
        </div>
        <div class="col s3 white-text">
            <h5><strong>Total por pagar</strong></h5>
            <h6>$ 451,324.23</h6>
        </div>
        <div class="col s3 white-text">
            <h5><strong>Diferencia Total</strong></h5>
            <h6>$ -169,831.42</h6>
        </div>
    </div>
</div>
<div class="container">    
    <div class="row">
        <div class="col s3">
            <h5><strong>Periodo</strong></h5>
            <input type="date">
            <h6>Inicio</h6>
        </div>
        <div class="col s3">
            <h5>&nbsp;</h5>
            <input type="date">
            <h6>Fin</h6>
        </div>
        <div class="col s6">
            <h5>&nbsp;</h5>
            <select>
                <option value="0">Todos los proveedores</option>
            </select>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Operaciones</strong><i class="material-icons right" style="rotate: 90deg;">import_export</i></span>
                    <p>19</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;">-1.22%</h6>
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Ingresos</strong><i class="material-icons right">arrow_downward</i></span>
                    <p>$ 51,493.10</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;">+2.031</h6>
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Egresos</strong><i class="material-icons right">arrow_upward</i></span>
                    <p>$ 221,324.52</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;">+$2.201</h6>
                </div>
            </div>
        </div>
        <div class="col s3">
            <div class="card grey lighten-3" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Diferencia</strong><i class="material-icons right">attach_money</i></span>
                    <p>$-169,831.42</p>
                    <h6 style="font-size: 12px; color: #bdbdbd;">+3.392</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s8">
            <div class="card" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Ingresos vs. Egresos</strong></span>
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card" style="border-radius: 15px;">
                <div class="card-content">
                    <span class="card-title"><strong>Proveedores Principales</strong></span>
                    <div>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row section">
        <div class="col s12">
         <h5><strong>Operaciones recientes</strong></h5>
            <table class="striped">
            <thead>
      <tr>
        <th>Id Operación</th>
        <th>Proveedor</th>
        <th>Fecha</th>
        <th>Factura</th>
        <th>Nota de Débito</th>
        <th>Estatus</th>
        <th class="currency">Monto Ingreso</th>
        <th class="currency">Monto Egreso</th>
      </tr>
    </thead>
    <tbody>
      <!-- Fila 1 -->
      <tr>
        <td>1</td>
        <td>Proveedor A (Acero)</td>
        <td>2023-09-01</td>
        <td>Factura001</td>
        <td>Debito001</td>
        <td>Aprobado</td>
        <td class="currency"> $1,500.50</td>
        <td class="currency"> $1,200.25</td>
      </tr>
      <!-- Fila 2 -->
      <tr>
        <td>2</td>
        <td>Proveedor B (Otro)</td>
        <td>2023-09-02</td>
        <td>Factura002</td>
        <td>Debito002</td>
        <td>Pendiente</td>
        <td class="currency"> $800.75</td>
        <td class="currency"> $500.25</td>
      </tr>
      <!-- Filas 3 a 10 (datos aleatorios) -->
      <!-- Puedes generar datos aleatorios con un lenguaje de programación como Python o JavaScript -->
      <!-- En este ejemplo, los datos son completamente ficticios -->
      <!-- Puedes copiar y pegar estas filas según sea necesario -->

      <!-- Fila 3 -->
      <tr>
        <td>3</td>
        <td>Proveedor C (Acero)</td>
        <td>2023-09-03</td>
        <td>Factura003</td>
        <td>Debito003</td>
        <td>Aprobado</td>
        <td class="currency"> $2,300.25</td>
        <td class="currency"> $1,800.50</td>
      </tr>

      <!-- Fila 4 -->
      <tr>
        <td>4</td>
        <td>Proveedor D (Otro)</td>
        <td>2023-09-04</td>
        <td>Factura004</td>
        <td>Debito004</td>
        <td>Pendiente</td>
        <td class="currency"> $1,200.50</td>
        <td class="currency"> $900.75</td>
      </tr>

      <!-- Fila 5 -->
      <tr>
        <td>5</td>
        <td>Proveedor E (Acero)</td>
        <td>2023-09-05</td>
        <td>Factura005</td>
        <td>Debito005</td>
        <td>Aprobado</td>
        <td class="currency"> $900.25</td>
        <td class="currency"> $600.50</td>
      </tr>

      <!-- Fila 6 -->
      <tr>
        <td>6</td>
        <td>Proveedor F (Otro)</td>
        <td>2023-09-06</td>
        <td>Factura006</td>
        <td>Debito006</td>
        <td>Pendiente</td>
        <td class="currency"> $1,600.75</td>
        <td class="currency"> $1,200.25</td>
      </tr>

      <!-- Fila 7 -->
      <tr>
        <td>7</td>
        <td>Proveedor G (Acero)</td>
        <td>2023-09-07</td>
        <td>Factura007</td>
        <td>Debito007</td>
        <td>Aprobado</td>
        <td class="currency"> $2,100.50</td>
        <td class="currency"> $1,600.75</td>
      </tr>

      <!-- Fila 8 -->
      <tr>
        <td>8</td>
        <td>Proveedor H (Otro)</td>
        <td>2023-09-08</td>
        <td>Factura008</td>
        <td>Debito008</td>
        <td>Pendiente</td>
        <td class="currency"> $700.25</td>
        <td class="currency"> $400.50</td>
      </tr>

      <!-- Fila 9 -->
      <tr>
        <td>9</td>
        <td>Proveedor I (Acero)</td>
        <td>2023-09-09</td>
        <td>Factura009</td>
        <td>Debito009</td>
        <td>Aprobado</td>
        <td class="currency"> $1,400.50</td>
        <td class="currency"> $1,100.75</td>
      </tr>

      <!-- Fila 10 -->
      <tr>
        <td>10</td>
        <td>Proveedor J (Otro)</td>
        <td>2023-09-10</td>
        <td>Factura010</td>
        <td>Debito010</td>
        <td>Pendiente</td>
        <td class="currency"> $1,900.75</td>
        <td class="currency"> $1,400.25</td>
      </tr>

    </tbody>
  </table>
        </div>
    </div>
</div>

<style>
    
    .container {
  width: 90%;
  max-width:initial;
}


</style>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');
  const ctx2 = document.getElementById('myChart2');

  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul'],
            datasets: [{
            label: 'Ingresos',
            data: [65, 59, 80, 81, 56, 55, 40],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgb(75, 192, 192)',
            tension: 0.1
            }, 
            {
            label: 'Egresos',
            data: [83, 45, 23, 48, 68, 49, 75],
            fill: false,
            borderColor: 'rgb(194, 0, 5)',
            backgroundColor: 'rgb(194, 0, 5)',
            tension: 0.1
            }
        ]}
});

  var myLineChart2 = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Aceros Plus', 'Disilex', 'Acerux'],
            datasets: [{
            label: 'Ingresos',
            data: [65, 59, 80],
            fill: false,
            borderColor: ['rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
            ],
            backgroundColor: ['rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
            }
        ]}
});

</script>