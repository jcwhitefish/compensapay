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
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Clientes' }" @click="selectButton('Clientes')">
                        Clientes
                    </button>
                    &nbsp;
                    <button class="button-table" :class="{ 'selected': selectedButton == 'Proveedores' }" @click="selectButton('Proveedores')">
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
                <table v-if="selectedButton === 'Clientes'" class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Cliente</th>
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
                <div style="overflow-x: auto;">
                <table v-if="selectedButton === 'Proveedores'" class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Proveedor</th>
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
                        if(is_array($clipro["proveedores"]))
                        {
                            foreach ($clipro["proveedores"] as $value)
                            {
                                //print_r($value);
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
    const app = Vue.createApp({
        setup() {
            
            const selectedButton = Vue.ref('Clientes');

            const selectButton = (buttonName) => {
                if (selectedButton.value != buttonName) {
                    selectedButton.value = buttonName;
                } 
            };

            return {
                
                selectedButton,
                selectButton
            };
        }
    });
</script>