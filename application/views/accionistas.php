<div class="col s2"></div>
<div class="col s8">
	<table>
		<thead>
            <tr>
                <th>Accionistas</th>
                <th>Capital Social</th>
                <th></th>
            </tr>
		</thead>
		<tbody>
            <tr>
                <td><input type="text" name="nombreacc<?php echo $tipo;?>" id="nombreacc<?php echo $tipo;?>"></td>
                <td><input type="number" name="capitalsocial<?php echo $tipo;?>" id="capitalsocial<?php echo $tipo;?>"></td>
                <td align="center">
                    <input type="hidden" name="tipoa<?php echo $tipo;?>" id="tipoa<?php echo $tipo;?>" value="<?php echo $tipo;?>">
                    <input type="button" name="botadacc" id="botadacc" class="button-gray" value="Agregar" onClick="ad_acc(document.getElementById('nombreacc<?php echo $tipo;?>').value, document.getElementById('capitalsocial<?php echo $tipo;?>').value, document.getElementById('tipoa<?php echo $tipo;?>').value)">
                </td>
            </tr>
            <?php
                if(is_array($accionistas))
                {
                    foreach($accionistas as $value)
                    {
                        echo '<tr>
                                <td>'.$value["Accionista"].'</td>
                                <td>'.number_format($value["CapitalSocial"], 2).' %</td>
                                <td></td>
                            </tr>';
                    }
                }
            ?>
		</tbody>
	</table>
</div>
<div class="col s2"></div>