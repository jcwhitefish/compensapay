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
                    <td><span>1</span></td>
                    <td><span>2</span></td>
                    <td><span>3</span></td>
                </tr>
                <tr>
                    <td><span>4</span></td>
                    <td><span>5</span></td>
                    <td><span>6</span></td>
                    <td><span>7</span></td>
                    <td><span>8</span></td>
                    <td><span>9</span></td>
                    <td><span>10</span></td>
                </tr>
                <tr>
                    <td><span>11</span></td>
                    <td><span>12</span></td>
                    <td><span>13</span></td>
                    <td><span>14</span></td>
                    <td><span>15</span></td>
                    <td><span>16</span></td>
                    <td><span>17</span></td>
                </tr>
                <tr>
                    <td><span>18</span></td>
                    <td><span>19</span></td>
                    <td><span>20</span></td>
                    <td><span>21</span></td>
                    <td><span>22</span></td>
                    <td><span>23</span></td>
                    <td><span>24</span></td>
                </tr>
                <tr>
                    <td><span>25</span></td>
                    <td><span>26</span></td>
                    <td><span>27</span></td>
                    <td><span>28</span></td>
                    <td><span>29</span></td>
                    <td><span>30</span></td>
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
    .tablas thead{
        background-color: #eeeeee;
    }
    .tablas td{
        border: 1px solid #eeeeee;
        height: 3cm;
        width: 3cm;
    }
    .tablas td span{
        position: relative;
        top: -1cm;
        right: -4cm;
        font-weight: bold;
    }
</style>

<!-- cadena_validar = '{"Usuario":"DemoUser","Llave":"Pasrd"}';
$validar_acceso=$this->Interaccionbd->ValidarAcceso($cadena_validar);
echo $validar_acceso; -->