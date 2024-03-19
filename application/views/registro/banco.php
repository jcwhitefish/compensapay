<?php
    if(is_array($banco)){
        foreach($banco AS $value){
            $bn = $value["bnk_nombre"];
        }
    }
    else{
        $bn = '';
    }
?>
<input type="text" name="bank" id="bank" disabled required value="<?php echo $bn;?>">
<label for="bank">Banco emisor *</label>

