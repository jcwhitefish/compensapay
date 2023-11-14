<div class="p-5" id="app">
    <!-- Filtros de vista -->
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
                    <input @change="crearCalendario" class="fechas datepicker no-autoinit" type="text" id="date" value="<?= date('m/d/Y'); ?>">
                    <i class="material-icons prefix">arrow_drop_down</i>
                </div>

            </div>
        </div>
        <div class="col l2 center-align">
            <div class="row">
                <div class="col s12"><a @click="cambiarSatusBoton('p')" :class="`btnLeyenda btn-small  ${vProgramed == false ? 'transparent black-text' : 'programed'}`">Programadas</a></div>
            </div>
            <div class="row">
                <div class="col s12"><a @click="cambiarSatusBoton('v')" :class="`btnLeyenda btn-small  ${vOverdue == false ? 'transparent black-text' : 'overdue'}`">Vencidas</a></div>
            </div>
        </div>
    </div>

    <!-- Calendario -->
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
                                <p v-if="typeof semana[indiceCelda] == 'object'" :id="semana[indiceCelda]['numero']">
                                    <div v-for="op in opeToView">
                                        <a v-if="op.dia === semana[indiceCelda]?.numero" class="modal-trigger no-link" href="#modal-vista-operacion" @click="viewOperation(op.indexOp)">
                                            <p class="opeCalendar" :class="op.estado">{{op.numberOp}}</p>
                                        </a>
                                    </div>
                                </p>
                            </td>
                        </template>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Visualizar información de operación -->
    <div id="modal-vista-operacion" class="modal">
        <div class="modal-content" v-for="ope in operationsView">
            <h5>ID Operacion: {{ope.operation_number}}</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <div class="row">
                        <div class="row">
                            <div class="col l4">
                                <p class="font_head_op_info" for="invoiceDisabled">Estatus Factura: </p>
                                <h6 v-if="ope.status == '0' " >Por autorizar</h6>
                                <h6 v-if="ope.status == '1' " >Autorizada</h6>
                                <h6 v-if="ope.status == '2' " >Rechazada</h6>
                                <h6 v-if="ope.status == '3' " >Realizada</h6>
                                <h6 v-if="ope.status == '4' " >Vencida</h6>
                            </div>
                            <div class="col l4">
                                <p class="font_head_op_info" for="invoiceDisabled">Proveedor: </p>
                                <h6 v-if="ope.short_name != null && ope.short_name != ''">{{ope.short_name}}</h6>
                                <h6 v-if="ope.short_name == null || ope.short_name == ''">{{ope.legal_name}}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Fecha factura: </p>
                                <h6>{{ope.payment_date}}</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Fecha Alta: </p>
                                <h6>{{ope.created_at}}</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Fecha Transacción: </p>
                                <h6>{{ope.transaction_date}}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">UUID Factura Proveedor: </p>
                                <h6>{{ope.uuid}}</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">UUID Mi Factura: </p>
                                <h6 v-if="ope.uuid_relation != null">{{ope.uuid_relation}}</h6>
                                <h6 v-if="ope.uuid_relation == null">N.A.</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">UUID Nota: </p>
                                <h6 v-if="ope.uuid_nota != null">{{ope.uuid_nota}}</h6>
                                <h6 v-if="ope.uuid_nota == null">N.A.</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Monto Factura Proveedor: </p>
                                <h6>${{ope.money_prov}}</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Monto Mi Factura: </p>
                                <h6 v-if="ope.money_clie != null">${{ope.money_clie}}</h6>
                                <h6 v-if="ope.money_clie == null">N.A.</h6>
                            </div>
                            <div class="col l4 h6-border">
                                <p class="font_head_op_info" for="invoiceDisabled">Monto Nota: </p>
                                <h6 v-if="ope.money_nota != null">${{ope.money_nota}}</h6>
                                <h6 v-if="ope.money_nota == null">N.A.</h6>
                            </div>
                        </div>
                        <!--div class="col l12">
                            <div class="col l8">
                                <a class="button-gray modal-close">Cerrar</a>
                            </div>
                        </div-->
                    </div>
                </div>
            </div>
        </div>
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
            const operationsView = Vue.ref([]);
            const opeToView = Vue.ref([]);
            const cambiaModelo = (modelo) => {
                modeloTabla.value = modelo;
            }
            const datosDia = ref([]);
            const calendario = ref([]);
            const operaciones = Vue.ref([]);
            const daysString = ref(['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']);
            const vProgramed = ref(true);
            const vOverdue = ref(true);
            const formatearDate = () => {
                let options = {
                    format: 'dd/mm/yyyy', // Formato de fecha
                    setDefaultDate: true, // Inicializar con la fecha actual
                    autoClose: true, // Cerrar automáticamente después de seleccionar la fecha
                };

                let datepicker = document.getElementById('date');

                let instance = M.Datepicker.init(datepicker, options);


            }

            //tabla de get operaciones
            const getOperations = () => {
                    const formData = new FormData();
                    formData.append('mesSelected',fecha.value.slice(3, -5));
                var requestOptions = {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow'
                };

                fetch("<?= base_url("facturas/operacionesCalendario") ?>", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        operaciones.value = result.operaciones;
                        operaciones.value.reverse();

                        colocarOperaciones();
                    })
                    .catch(error => console.log('error', error));
            };

            const cambiarSatusBoton = (boton) => {
                if(boton == 'p'){
                    vProgramed.value = !vProgramed.value;
                }else{
                    vOverdue.value = !vOverdue.value;
                }
                colocarOperaciones();
            }

            const colocarOperaciones = () => {
                const op = operaciones.value;
                if (op.length > 0) {
                    opeToView.value = [];
                    for (let i = 0; i < op.length; i++) {
                        const dia = op[i]['transaction_date'].slice(8);
                        const estado = op[i]['status'] == '0' ? 'programed' : 'overdue';
                        const dt = {
                            'dia': parseInt(dia),
                            'estado': estado,
                            'indexOp': i,
                            'numberOp': op[i]['operation_number']
                        };
                        if(vProgramed.value && !vOverdue.value && estado == 'programed'){
                            opeToView.value.push(dt);
                        }else if(!vProgramed.value && vOverdue.value && estado == 'overdue'){
                            opeToView.value.push(dt);
                        }else if(vProgramed.value && vOverdue.value){
                            opeToView.value.push(dt);
                        }else if(!vProgramed.value && !vOverdue.value){
                            opeToView.value.push(dt);
                        }
                    }
                    console.log(opeToView.value);
                }
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
                getOperations();
            }

            //Llenar vista de operación seleccionada
            const viewOperation = (operacion) => {
                console.log(operacion);
                operationsView.value[0] = operaciones.value[operacion];
                console.log(operationsView.value);
            }

            onMounted(
                () => {
                    formatearDate();
                    crearCalendario();
                    getOperations();
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
                viewOperation,
                datosDia,
                operaciones,
                operationsView,
                colocarOperaciones,
                opeToView,
                vProgramed,
                vOverdue,
                cambiarSatusBoton
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

    .programed {
        background-color: #4FDBBF;
    }

    .overdue {
        background-color: #DB544F;
    }

    .opeCalendar {
        text-align: center;
        color: white;
        border-radius: 5px !important;
        box-shadow: -3px 1px 6px 1px rgb(94 92 92 / 50%);
    }

    .opeCalendar:hover {
        transform: scale(1.3);
        box-shadow: -3px 1px 6px 1px rgb(94 92 92 / 50%);
    }
    .no-link{
        color: white !important;
        text-decoration: none !important;
    }
</style>