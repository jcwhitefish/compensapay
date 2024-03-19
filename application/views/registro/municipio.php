<?php
    if(is_array($municipio)){
        foreach($municipio AS $value){
            $mun = $value["municipio"];
        }
    }
    else{
        $mun = '';
    }
?>

<input type="text" name="municipio" id="municipio" value="<?php echo $mun;?>" disabled required>
<label for="estado">Municipio *</label>