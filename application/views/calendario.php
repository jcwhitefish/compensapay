<div class="p-5" id="app">
    <div class="row valign-wrapper">
        <div class="col l6">
            <div class="row valign-wrapper">

                <div class="col l2">
                    <a @click="cambiaModelo(0)" :class="`btn btnMDA ${modeloTabla != 0 ? 'transparent black-text' : 'black'}  waves-effect waves-light`">Dia</a>
                    <!-- <a class="btn btnMDA black waves-effect waves-light">Dia</a> -->
                </div>
                <div class="col l2">
                    <a @click="cambiaModelo(1)" :class="`btn btnMDA ${modeloTabla !=  1 ? 'transparent black-text' : 'black'}  waves-effect waves-light`">Semana</a>
                </div>
                <div class="col l2">
                    <a @click="cambiaModelo(2)" :class="`btn btnMDA ${modeloTabla != 2 ? 'transparent black-text' : 'black'}  waves-effect waves-light`">Mes</a>
                </div>
                <div class="input-field col l6">
                    <input v-model="fecha" class="fechas datepicker" type="text" id="date">
                    <i class="material-icons prefix">arrow_drop_down</i>
                </div>

            </div>
        </div>
        <div class="col l4">{{fecha}}</div>
        <div class="col l2 center-align">
            <div class="row">
                <div class="col s12"><a class="btnLeyenda btn-small cyan accent-3">Programadas</a></div>
            </div>
            <div class="row">
                <div class="col s12"><a class="btnLeyenda btn-small green  accent-3">Realizadas</a></div>
            </div>
            <div class="row">
                <div class="col s12"><a class="btnLeyenda btn-small red accent-3">Vencidas</a></div>
            </div>


        </div>
    </div>
    <!-- Aqui va lo de mes -->
    <div class="row tablas" v-if="modeloTabla == 2">
        <table>
            <thead>
                <tr>
                    <th>Domingo</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miercoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sabado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><span>
                            <p>1</p>
                            
                            <a class="btnLeyenda btn-small red accent-3" style="font-size:11px;">Frontier - A404 - $120,0</a>
                        </span></td>
                    <td><span>
                            <p>2</p>
                        </span></td>
                    <td><span>
                            <p>3</p>
                        </span></td>
                </tr>
                <tr>
                    <td><span>
                            <p>4</p>
                        </span></td>
                    <td><span>
                            <p>5</p>
                        </span></td>
                    <td><span>
                            <p>6</p>
                            <a class="btnLeyenda btn-small green accent-3" style="font-size:11px;">Frontier - A404 - $120,0</a>
                        </span></td>
                    <td><span>
                            <p>7</p>
                        </span></td>
                    <td><span>
                            <p>8</p>
                        </span></td>
                    <td><span>
                            <p>9</p>
                        </span></td>
                    <td><span>
                            <p>10</p>
                        </span></td>
                </tr>
                <tr>
                    <td><span>
                            <p>11</p>
                        </span></td>
                    <td><span>
                            <p>12</p>
                            
                            <a class="btnLeyenda btn-small cyan accent-3" style="font-size:11px;">Frontier - A404 - $120,0</a>
                        </span></td>
                    <td><span>
                            <p>13</p>
                        </span></td>
                    <td><span>
                            <p>14</p>

                            <a class="btnLeyenda btn-small cyan accent-3" style="font-size:11px;">Frontier - A404 - $120,0</a>
                        </span></td>
                    <td><span>
                            <p>15</p>
                        </span></td>
                    <td><span>
                            <p>16</p>
                        </span></td>
                    <td>
                        <span>
                            <p>17</p>
                            <a class="btnLeyenda btn-small red accent-3" style="font-size:11px;">Frontier - A404 - $120,0</a>
                        </span>

                    </td>
                </tr>
                <tr>
                    <td><span>
                            <p>18</p>
                            <a class="btnLeyenda btn-small cyan accent-3" style="font-size:11px;">Frontier - A404 - $120,0</a>
                        </span></td>
                    <td><span>
                            <p>19</p>

                        </span></td>
                    <td><span>
                            <p>20</p>
                        </span></td>
                    <td><span>
                            <p>21</p>
                        </span></td>
                    <td><span>
                            <p>22</p>
                            
                            <a class="btnLeyenda btn-small green accent-3" style="font-size:11px;">Frontier - A404 - $120,0</a>
                        </span></td>
                    <td><span>
                            <p>23</p>
                        </span></td>
                    <td><span>
                            <p>24</p>
                        </span></td>
                </tr>
                <tr>
                    <td><span>
                            <a class="btnLeyenda btn-small green accent-3" style="font-size:11px;">Frontier - A404 - $120,0</a>
                            <p>25</p>
                        </span></td>
                    <td><span>
                            <p>26</p>
                        </span></td>
                    <td><span>
                            <p>27</p>
                        </span></td>
                    <td><span>
                            <p>28</p>
                        </span></td>
                    <td><span>
                            <p>29</p>
                        </span></td>
                    <td><span>
                            <p>30</p>
                            
                            <a class="btnLeyenda btn-small cyan accent-3" style="font-size:11px;">Frontier - A404 - $120,0</a>
                            
                            <a class="btnLeyenda btn-small green accent-3" style="font-size:11px;">Frontier - A404 - $120,0</a>
                        </span></td>
                    <!-- Puedes añadir más días si es necesario -->
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    const {

        createApp,
        ref,
        onMounted,
        nextTick
    } = Vue;

    const app = createApp({
        setup() {
            const modeloTabla = ref(2);
            const fecha = ref(null);
            const cambiaModelo = (modelo) => {
                modeloTabla.value = modelo;
            }
            const formatearDate = () => {
                var options = {
                    format: 'dd/mm/yyyy', // Formato de fecha
                    autoClose: true, // Cerrar automáticamente después de seleccionar la fecha
                    // Puedes agregar más opciones según tus necesidades
                };
                nextTick(() => {
                    // M.Datepicker.init(document.getElementById('date'),options);
                    M.AutoInit();
                });

            }
            onMounted(
                () => {
                    formatearDate();
                }
            )
            // Retornar el estado y métodos
            return {
                modeloTabla,
                cambiaModelo,
                fecha
            };
        },
    });
</script>


<style>
    .btnLeyenda {
        border-radius: 25px !important;
        width: 130px;
    }

    .btnMDA {
        width: 90px;
        text-align: center;
    }

    .fechas {
        position: relative;
        text-align: center;
        border-radius: 10px 0 0 10px !important;
        max-height: 35px;
        z-index: 10 !important;
        margin: 0 !important;
        background: linear-gradient(to right, #eeeeee 90%, transparent 10%);

    }

    /* label underline focus color */
    .input-field input[type=text]:focus {
        border-bottom: 1px solid rgba(255, 0, 0, 0.0) !important;
        box-shadow: 0 1px 0 0 rgba(255, 0, 0, 0.0) !important;

    }

    .input-field .prefix {
        color: white;
        width: 30px;
        height: 36px;
        right: 12px;
        background-color: black;
        top: 0;
        z-index: 5 !important;
    }

    /* Estos estilos son del datapicker */
    .datepicker-date-display {
        background-color: #e0e51d !important;

    }

    .datepicker-cancel,
    .datepicker-clear,
    .datepicker-today,
    .datepicker-done {
        color: #e0e51d;
    }

    .datepicker-table td.is-today {
        color: #e0e51d;
    }

    .datepicker-table td.is-selected {
        background-color: #e0e51d;
        color: #fff;
    }

    .dropdown-content li>a,
    .dropdown-content li>span {
        color: #e0e51d;
    }

    button:focus {
        outline: none;
        background-color: #e0e51d;
    }

    .tablas thead {
        background-color: #eeeeee;
    }

    .tablas td {
        border: 1px solid #eeeeee;
        height: 3cm;
        width: 3cm;
    }

    .tablas td span {

        flex-direction: column;
        font-weight: bold;
        display: flex;
        align-items: center
    }

    .tablas td span p {
        position: relative;
        width: 100%;
        text-align: right;
    }

    /* quitar el hover */
    tbody tr:hover{
        background-color: white !important;
    }
</style>

<!-- cadena_validar = '{"Usuario":"DemoUser","Llave":"Pasrd"}';
$validar_acceso=$this->Interaccionbd->ValidarAcceso($cadena_validar);
echo $validar_acceso; -->