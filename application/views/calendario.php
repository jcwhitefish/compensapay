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
                    <!-- TODO:La etiqueta no-autoinit te ayuda a avitar que el autoinit lo haga en automatico -->
                    <input @change="crearCalendario" class="fechas datepicker no-autoinit" type="text" id="date" value="<?= date('d/m/Y'); ?>">
                    <i class="material-icons prefix">arrow_drop_down</i>
                </div>

            </div>
        </div>
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
    <div class="row tablas">
        <table>
            <thead>
                <tr>
                    <template v-for="(day,index) in daysString" :key="index">
                        <th if="(modeloTabla == 2)||(modeloTabla == 1)||(modeloTabla == 0 && datosDia['diaSemana'] == index)"> {{daysString[index]}}</th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <template v-for="(semana,indiceSemana) in calendario" :key="indiceSemana">
                    <tr v-if="(modeloTabla == 2)||(modeloTabla == 1 && datosDia['semana'] == indiceSemana)|| (modeloTabla == 0)">
                        <template v-for="(celda,indiceCelda) in 7" :key="indiceCelda">
                            <td v-if="(modeloTabla == 2)||(modeloTabla == 1)||(modeloTabla == 0 && datosDia['semana'] == indiceSemana && datosDia['diaSemana'] == indiceCelda)">
                                <p class="numeroDia">{{`${typeof semana[indiceCelda] == 'object' ? semana[indiceCelda]['numero'] : ''}`}}</p>
                            </td>
                        </template>
                    </tr>
                </template>
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
            const fecha = ref('');
            const cambiaModelo = (modelo) => {
                modeloTabla.value = modelo;
            }
            const datosDia = ref([]);
            const calendario = ref([]);
            const daysString = ref(['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']);
            const formatearDate = () => {
                let options = {
                    format: 'dd/mm/yyyy', // Formato de fecha
                    setDefaultDate: true, // Inicializar con la fecha actual
                    autoClose: true, // Cerrar automáticamente después de seleccionar la fecha

                };

                let datepicker = document.getElementById('date');

                let instance = M.Datepicker.init(datepicker, options);


            }


            const crearCalendario = () => {
                let datepicker = document.getElementById('date');
                fecha.value = datepicker.value;
                //obtenermos el dia mes y año de la variable fecha y los metemos en distintas variables separando el string por /
                let [day, month, year] = fecha.value.split('/');
                //obtenemos en que dia de la semana cae el primer dia del mes
                let firstDay = new Date(year, month - 1, 1).getDay();

                //console.log(firstDay);
                //lo convertimos a letras

                let firstDayString = daysString.value[firstDay];
                //console.log(firstDayString);

                //obtenemos el ultimo dia del mes
                let lastDay = new Date(year, month, 0).getDate();
                //console.log(lastDay);
                //obtenemso las variables x y y
                let x = firstDay; //x inicia en el dia de la semana que cae el primer dia del mes
                let y = 0;
                //creamos z que es el dia que se va a imprimir en el calendario
                let z = 1;
                //creamos el calendario
                calendario.value[y] = [];
                while (lastDay >= z) {
                    calendario.value[y][x] = {
                        'numero': z
                    };
                    if (z == day) {
                        datosDia.value['diaSemana'] = x;
                        datosDia.value['semana'] = y;
                        datosDia.value['diaNumero'] = z;
                    }
                    if (x == 6) {
                        x = 0;
                        y++;
                        calendario.value[y] = [];
                    } else {
                        x++;
                    }
                    z++;
                }

            }
            onMounted(
                () => {
                    formatearDate();
                    crearCalendario();
                }
            )
            // Retornar el estado y métodos
            return {
                modeloTabla,
                cambiaModelo,
                fecha,
                daysString,
                calendario,
                crearCalendario,
                datosDia
            };
        },
    });
</script>


<style>
    th {
        background-color: #fafafa !important;
    }

    /* Seleccionamos a los elementos th que estan dentro de tables y les ponemos color red */
    .tablas th {
        background-color: #17a2b8 !important;
    }

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
        background-color: #17a2b8 !important;

    }

    .datepicker-cancel,
    .datepicker-clear,
    .datepicker-today,
    .datepicker-done {
        color: #17a2b8;
    }

    .datepicker-table td.is-today {
        color: #17a2b8;
    }

    .datepicker-table td.is-selected {
        background-color: #17a2b8;
        color: #fff;
    }

    .dropdown-content li>a,
    .dropdown-content li>span {
        color: #17a2b8;
    }

    button:focus {
        outline: none;
        background-color: #17a2b8;
    }

    .tablas thead {
        background-color: #eeeeee;
    }

    .tablas td {
        border: 1px solid #eeeeee;
        min-height: 3cm;
    }

    /* quitar el hover */
    tbody tr:hover {
        background-color: white !important;
    }

    .numeroDia {
        text-align: end;
        font-weight: bold;
    }
</style>