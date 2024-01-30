<?php
    session_start();

    include ('../../db/conexion.php');

    if((!isset($_SESSiON["partidas"]) AND !is_array($_SESSION["partidas"])) OR (isset($_POST["nuevafactura"]) AND $_POST["nuevafactura"]==1))
    {
        $_SESSION["partidas"] = array();
    }

    //echo $_POST["partida"];
    
    
    $arrayp = $_SESSION["partidas"];

    //print_r($_SESSION["partidas"]);

    $prt = explode('|', $_POST["partida"]);

    //print_r($prt);

    $J=1; $array=array();

    if($_POST["borrapar"]=='null')
    {
       //agregar partidas existente
        for($a=0;$a<count($arrayp); $a++)
        {
            $arreglo=array($arrayp[$a][0], $arrayp[$a][1], $arrayp[$a][2], $arrayp[$a][3], $arrayp[$a][4], $arrayp[$a][5], $arrayp[$a][6], $arrayp[$a][7], $arrayp[$a][8], $arrayp[$a][9], $arrayp[$a][10], $arrayp[$a][11], $arrayp[$a][12], $arrayp[$a][13], $arrayp[$a][14]);
            array_push($array, $arreglo);
            $J=$arrayp[$a][0];
        }

        //agregar nueva partida
        $ftotal=str_replace(',','',$prt[9]);
        if($prt[0]==1){$ivap=$ftotal*0.16;}else{$ivap=0;}
        if($prt[1]==1){$rivap=$ftotal*($prt[10]/100);}else{$rivap=0;}
        if($prt[2]==1){$risrp=$ftotal*0.10;}else{$risrp=0;}
        $importep=($ftotal+$ivap)-($rivap+$risrp);

        //unidad
        $ResU=mysqli_fetch_array(mysqli_query($conn, "SELECT ClaveUnidad FROM c_claveunidad WHERE Id='".$prt[4]."' LIMIT 1"));

        //claveproductoservicio
        $ResPS=mysqli_fetch_array(mysqli_query($conn, "SELECT ClaveProdServ FROM c_claveprodserv WHERE Id='".$prt[5]."' LIMIT 1"));
    
	    //                 cantidad unidad                clave                    noident                           concept                           preciou  subtota  apiiva   partiva  partisr  iva    retiva  retisr  importe
        //             0   1        2                     3                        4                                 5                                 6        7        8        9        10       11     12      13      14       
        $arreglo=array($J, $prt[3], $ResU["ClaveUnidad"], $ResPS["ClaveProdServ"], str_replace('%20', ' ', $prt[6]), str_replace('%20', ' ', $prt[7]), $prt[8], $ftotal, $prt[0], $prt[1], $prt[2], $ivap, $rivap, $risrp, $importep);
        array_push($array, $arreglo);
    }
    else
    {
        $b=0;
        //agregar partidas existente
        for($a=0;$a<count($arrayp); $a++)
        {
            if($a!=$_POST["borrapar"])
            {
                $arreglo=array($b, $arrayp[$a][1], $arrayp[$a][2], $arrayp[$a][3], $arrayp[$a][4], $arrayp[$a][5], $arrayp[$a][6], $arrayp[$a][7], $arrayp[$a][8], $arrayp[$a][9], $arrayp[$a][10], $arrayp[$a][11], $arrayp[$a][12], $arrayp[$a][13], $arrayp[$a][14]);
                array_push($array, $arreglo);
                $b++;
            }
            $J=$b;
        }
    }
    

    //print_r($array);

    $_SESSION["partidas"] = $array;

?>
<table class="visible-table">
                    <thead>
                        <tr>
                            <th align="center" class="texto3">IVA</th>
                            <th align="center" class="texto3">R. IVA</th>
                            <th align="center" class="texto3">R. ISR</th>
                            <th align="center" class="texto3">Cantidad</th>
                            <th align="center" class="texto3">Unidad</th>
                            <th align="center" class="texto3">Clave</th>
                            <th align="center" class="texto3">No. Identificación</th>
                            <th align="center" class="texto3">Concepto</th>
                            <th align="center" class="texto3">Precio</th>
                            <th align="center" class="texto3">Importe</th>
                            <th align="center" class="texto3">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td bgcolor="#dfe1e7" align="center" class="texto">
                                <div class="switch">
                                    <label>
                                        <input name="aplicaiva" id="aplicaiva" type="checkbox" value="1" checked>
                                        <span class="lever"></span>
                                    </label>
                                </div>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto">
                                <div class="switch">
                                    <label>
                                        <input name="aplicariva" id="aplicariva" type="checkbox" value="1" <?php if($prt[1]==1){echo ' checked';}?> >
                                        <span class="lever"></span>
                                    </label>
                                </div>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto">
                                <div class="switch">
                                    <label>
                                        <input name="aplicarisr" id="aplicarisr" type="checkbox" value="1" <?php if($prt[2]==1){echo ' checked';}?>>
                                        <span class="lever"></span>
                                    </label>
                                </div>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <input type="text" name="cantidad" id="cantidad" size="5"  value="1" onKeyUp="calculo(this.value,precio.value,total);">
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <select name="unidad" id="unidad"  class="browser-default">
                                    <option value="0">Seleccione</option>
                                    <?php
                                        $ResUnidad = mysqli_query($conn, "SELECT cu.Id, cu.ClaveUnidad, cu.Descripcion FROM c_claveunidad AS cu 
                                                                            INNER JOIN c_claveunidad_emp AS cue ON cu.Id=cue.IdClaveUnidad
                                                                            WHERE cue.Empresa = '".$_POST["empresa"]."' ORDER BY cu.ClaveUnidad ASC");
                                        while($RResU=mysqli_fetch_array($ResUnidad))
                                        {
                                            echo '<option value="'.$RResU["Id"].'">'.$RResU["ClaveUnidad"].' - '.$RResU["Descripcion"].'</option>';
                                        }
                                    ?>
                                </select>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <select name="claveprodserv" id="claveprodserv"  class="browser-default">
                                    <option value="0">Seleccione</option>
                                    <?php
                                        $ResProdServ = mysqli_query($conn, "SELECT cp.Id, cp.ClaveProdServ, cp.Descripcion FROM c_claveprodserv AS cp 
                                                                            INNER JOIN c_claveprodserv_emp AS cpe ON cp.Id=cpe.IdClaveProdServ
                                                                            WHERE cpe.Empresa = '".$_POST["empresa"]."' ORDER BY cp.ClaveProdServ ASC");
                                        while($RResPS=mysqli_fetch_Array($ResProdServ))
                                        {
                                            echo '<option value="'.$RResPS["Id"].'">'.$RResPS["ClaveProdServ"].' - '.$RResPS["Descripcion"].'</option>';
                                        }
                                    ?>
                                </select>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <input type="text" name="numidentificacion" id="numidentificacion" size="10"  value="NO APLICA">
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <textarea name="producto" id="producto" style="height: 70px"></textarea>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <input type="text" name="precio" id="precio" size="10"  onKeyUp="calculo(cantidad.value,this.value,total)">
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <input type="text" name="total" id="total" size="10" >
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <input type="hidden" name="nuevafactura" id="nuevafactura" value="0">
                                <a class="modal-trigger button-blue" onclick="partidas()">+</a>
                            </td>
                        </tr>
                        <?php
                            $subtotal=0;
                            $subtotalaplicariva=0;
                            $subtotalaplicarisr=0;
                            for($i=0; $i<count($array); $i++)
                            {
                                echo '<tr>
                                        <td align="center" class="texto" valign="top">
                                            ';if($array[$i][8]==1){echo ' <i class="fa fa-check" aria-hidden="true"></i>';}
                                echo '      <input type="hidden" name="ivap_'.$i.'" id="ivap_'.$i.'" value="'.$array[$i][8].'">
                                        </td>
                                        <td align="center" class="texto">
                                        ';if($array[$i][9]==1){echo ' <i class="fa fa-check" aria-hidden="true"></i>';}
                                echo '      <input type="hidden" name="rivap_'.$i.'" id="rivap_'.$i.'" value="'.$array[$i][9].'">
                                        </td>
                                        <td align="center" class="texto">
                                        ';if($array[$i][10]==1){echo ' <i class="fa fa-check" aria-hidden="true"></i>';}
                                echo '      <input type="hidden" name="risrp_'.$i.'" id="risrp_'.$i.'" value="'.$array[$i][10].'">
                                        </td>
                                        <td align="center" class="texto" valign="top">
                                            <input type="hidden" name="cantidad_'.$i.'" id="cantidad_'.$i.'" value="'.$array[$i][1].'">'.$array[$i][1].'
                                        </td>
                                        <td align="center" class="texto" valign="top">
                                            <input type="hidden" name="unidad_'.$i.'" id="unidad_'.$i.'" value="'.$array[$i][2].'">'.$array[$i][2].'
                                        </td>
                                        <td align="center" class="texto" valign="top">
                                            <input type="hidden" name="claveprodserv_'.$i.'" id="claveprodserv_'.$i.'" value="'.$array[$i][3].'">'.$array[$i][3].'
                                        </td>
                                        <td align="center" class="texto" valign="top">
                                            <input type="hidden" name="numidentificacion_'.$i.'" id="numidentificacion_'.$i.'" value="'.$array[$i][4].'">'.$array[$i][4].'
                                        </td>
                                        <td align="left" class="texto" valign="top">
                                            <input type="hidden" name="producto_'.$i.'" id="producto_'.$i.'" value="'.$array[$i][5].'">'.$array[$i][5].'
                                        </td>
                                        <td bgcolor="" align="right" class="texto" valign="top">
                                            <input type="hidden" name="precio_'.$i.'" id="precio_'.$i.'" value="'.$array[$i][6].'">$ '.number_format($array[$i][6], 2).'
                                        </td>
                                        <td align="right" class="texto" valign="top">
                                            <input type="hidden" name="total_'.$i.'" id="total_'.$i.'" value="'.$array[$i][7].'">$ '.number_format($array[$i][7], 2).'
                                            <input type="hidden" name="importep_'.$i.'" id="importep_'.$i.'" value="'.$array[$i][14].'">
                                        </td>
                                        <td bgcolor="" align="center" class="texto" valign="top">
                                            <input type="hidden" name="aplicaiva_'.$i.'" id="aplicaiva_'.$i.'" value="'.$array[$i][11].'">
                                            <input type="hidden" name="aplicariva_'.$i.'" id="aplicariva_'.$i.'" value="'.$array[$i][12].'">
                                            <input type="hidden" name="aplicarisr_'.$i.'" id="aplicarisr_'.$i.'" value="'.$array[$i][13].'">
                                            <a onclick="partidas(\''.$i.'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>';

                                    $subtotal = $subtotal + $array[$i][7];
                                    $subtotalaplicariva=$subtotalaplicariva+$array[$i][12];
                                    $subtotalaplicarisr=$subtotalaplicarisr+$array[$i][13];
                            }

                            $descuento='0.'.$_POST["descuento"];
                        
                            if($descuento>0.00)
                            {
                                //aplica descuento
                                $sdescuento=$subtotal*$descuento;

                                echo '<tr>
                                        <td colspan="9" bgcolor="" style="text-align: right">Descuento: </td>
                                        <td align="right" bgcolor="">
                                            <input type="hidden" name="descuentof" id="descuentof" value="'.$sdescuento.'">$ '.number_format($sdescuento,2).'
                                        </td>
                                        <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                                    </tr>';
                            }

                            echo '<tr>
                                    <td colspan="9" bgcolor="" style="text-align: right">Subtotal: </td>
                                    <td align="right" bgcolor="">
                                        <input type="hidden" name="subtotalf" id="subtotalf" value="'.$subtotal.'">$ '.number_format($subtotal,2).'
                                    </td>
                                    <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                                </tr>';

                            if($descuento>0.00)
                            {
                                $subtotal=$subtotal-$sdescuento;
                            }
                            
                            $iva=$subtotal*0.16;

                            //cacula el totol

                            $total= $subtotal - ($subtotalaplicariva + $subtotalaplicarisr) + $iva;
                        ?>
                        <tr>
                            <td colspan="9" bgcolor="" style="text-align: right">Iva 16 %: </td>
                            <td align="right" class="texto" bgcolor="">
                                <input type="hidden" name="ivaf" id="ivaf" value="<?php echo $iva;?>">$ <?php echo number_format($iva, 2);?> 
                            </td>
                            <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                        </tr>
                        <?php 
                            if($subtotalaplicarisr>0)
                            {
                                echo '<tr>
                                    <td colspan="9" bgcolor="" style="text-align: right">RET. I.S.R.: </td>
                                    <td align="right" class="texto" bgcolor="">
                                        <input type="hidden" name="risr" id="risr" value="'.$subtotalaplicarisr.'"  size="3">$ '.number_format($subtotalaplicarisr, 2).'
                                    </td>
                                    <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                                </tr>';
                            }

                            if($subtotalaplicariva>0)
                            {
                                echo '<tr>
                                    <td colspan="9" bgcolor="" style="text-align: right">RET. I.V.A.: </td>
                                    <td align="right" class="texto" bgcolor="">
                                        <input type="hidden" name="riva" id="riva" value="'.$subtotalaplicariva.'"  size="3">$ '.number_format($subtotalaplicariva, 2).'
                                    </td>
                                    <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                                </tr>';
                            }
                        ?>
                        
                        <tr>
                            <td colspan="9" bgcolor="" style="text-align: right">Total: </td>
                            <td align="right" class="texto" bgcolor="">
                                <input type="hidden" name="totalf" id="totalf" value="<?php echo $total;?>">$ <?php echo number_format($total, 2);?></td>
                            <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="15" align="center" bgcolor="" style="text-align: right">
                                <input type="hidden" name="partidas" id="partidas" value="<?php echo count($array);?>">
                                <input type="submit" name="botfinfact" id="botfinfact" value="Guardar Factura>>" class="btn waves-effect waves-light" onclick="">
                            </td>
                        </tr>
                    </tbody>
                </table>