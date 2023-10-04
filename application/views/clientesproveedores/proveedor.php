
<div class="p-5" id="app">
    <div class="row">
        <div class="col l12 right-align p-5">
            <a class="modal-trigger button-blue">Invitar Cliente</a>
        </div>
    </div>
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div class="col l3 p-3">
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Facturas' }" @click="selectButton('Facturas')">
                        Clientes
                    </button>
                    &nbsp;
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Operaciones' }" @click="selectButton('Operaciones')">
                        Proveedores
                    </button>
                </div>
                <div class="col 9">
                    <form class="input-border" action="#" method="post" style="display: flex;">
                        <input type="search" placeholder="Buscar" >
                    </form>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table v-if="selectedButton === 'Facturas'" class="visible-table">
                    <thead>
                        <tr>
                            <th class="tabla-celda">RFC</th>
                            <th class="tabla-celda">Alias</th>
                            <th class="tabla-celda">Razón Social</th>
                            <th class="tabla-celda">Dirección</th>
                            <th class="tabla-celda">Contacto</th>
                            <th class="tabla-celda">Teléfono</th>
                            <th class="tabla-celda">Correo electrónico</th>
                            <th class="tabla-celda">Fecha de alta</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="tabla-celda">ABC123456</td>
                            <td class="tabla-celda">Empresa1</td>
                            <td class="tabla-celda">Nombre Empresa 1</td>
                            <td class="tabla-celda">Dirección Empresa 1</td>
                            <td class="tabla-celda">Contacto Empresa 1</td>
                            <td class="tabla-celda">123-456-7890</td>
                            <td class="tabla-celda">correo1@example.com</td>
                            <td class="tabla-celda">2023-01-15</td>
                        </tr>
                        <tr>
                            <td class="tabla-celda">DEF789012</td>
                            <td class="tabla-celda">Empresa2</td>
                            <td class="tabla-celda">Nombre Empresa 2</td>
                            <td class="tabla-celda">Dirección Empresa 2</td>
                            <td class="tabla-celda">Contacto Empresa 2</td>
                            <td class="tabla-celda">987-654-3210</td>
                            <td class="tabla-celda">correo2@example.com</td>
                            <td class="tabla-celda">2022-08-20</td>
                        </tr>
                    </tbody>
                </table>
                <table v-if="selectedButton === 'Operaciones'" class="visible-table">       
                <thead>
                        <tr>
                            <th class="tabla-celda">RFC</th>
                            <th class="tabla-celda">Alias</th>
                            <th class="tabla-celda">Razón Social</th>
                            <th class="tabla-celda">Dirección</th>
                            <th class="tabla-celda">Contacto</th>
                            <th class="tabla-celda">Teléfono</th>
                            <th class="tabla-celda">Correo electrónico</th>
                            <th class="tabla-celda">Fecha de alta</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="tabla-celda">ABC123456</td>
                            <td class="tabla-celda">Empresa1</td>
                            <td class="tabla-celda">Nombre Empresa 1</td>
                            <td class="tabla-celda">Dirección Empresa 1</td>
                            <td class="tabla-celda">Contacto Empresa 1</td>
                            <td class="tabla-celda">123-456-7890</td>
                            <td class="tabla-celda">correo1@example.com</td>
                            <td class="tabla-celda">2023-01-15</td>
                        </tr>
                        <tr>
                            <td class="tabla-celda">DEF789012</td>
                            <td class="tabla-celda">Empresa2</td>
                            <td class="tabla-celda">Nombre Empresa 2</td>
                            <td class="tabla-celda">Dirección Empresa 2</td>
                            <td class="tabla-celda">Contacto Empresa 2</td>
                            <td class="tabla-celda">987-654-3210</td>
                            <td class="tabla-celda">correo2@example.com</td>
                            <td class="tabla-celda">2022-08-20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    .text-modal{
        font-size: 10px;
    }
    .modal {
        max-height: 83% !important;
        width: 80% !important;
    }

    .input-border input[type=search] {
        border: 3px solid #ddd;
        border-radius: 30px !important;
        padding: 0 8px !important;
        margin: 15px 0 10px 0 !important;
        height: 35px !important;
        width: 180px !important;
    }

    .input-border input[type=search]:focus{
        border-color: #444 !important;
        border-bottom: 1px solid #444 !important;
        box-shadow: 0 1px 0 0 #444 !important;
    }

    .input-border label {
        color: black;
        top: -75px;
        position: relative;
        font-weight: bold !important;
    }

    .input-border input[type=search]:focus + label {
        color: #111 !important;
    }
    .tabla-celda {
        min-width: 100px;
        max-width: 150px; 
        padding: 5px; 
        text-align: center; 
        font-size: 13px;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    /* BORRAR */

    .selected {
        background-color: black !important;
        color: white;
        height: 50px;
        border: 2px solid black !important;
        border-radius: 10px;
    }

    .button-table {
        background-color: white;
        border: 2px solid white;
        height: 50px;
        width: 110px
    }

    .button-table:focus {
        background-color: black !important;
        color: white;
        height: 50px;
        border: 2px solid black !important;
        border-radius: 10px;
    }
   
</style>

<script>
    const app = Vue.createApp({
        setup() {
            const invoiceUploadName = Vue.ref('');
            const selectedButton = Vue.ref('Facturas');

            const checkFormatInvoice = (event) => {
                const fileInput = event.target;
                if (fileInput.files.length > 0) {
                    invoiceUploadName.value = fileInput.files[0].name;
                } else {
                    invoiceUploadName.value = '';
                }
            };

            const selectButton = (buttonName) => {
                if (selectedButton.value == buttonName) {
                    selectedButton.value = null;
                } else {
                    selectedButton.value = buttonName;
                }
            };

            return {
                invoiceUploadName,
                selectedButton,
                checkFormatInvoice,
                selectButton,
            };
        }
    });
</script>
