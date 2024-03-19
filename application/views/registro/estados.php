<?php
    if(is_array($estado)){
        foreach($estado AS $value){
            $es = $value["estado"];
        }
    }
    else{
        $es = '';
    }
?>

<input type="text" name="estado" id="estado" value="<?php echo $es;?>" disabled required>
<label for="estado">Estado</label>