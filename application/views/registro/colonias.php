<select name="colonia" id="colonia" class="browser-default" required>
<?php
    if(is_array($colonias)){
        foreach($colonias AS $value){
            echo '<option value='.$value["zip_id"].'>'.$value["zip_town"].'</option>';
        }
    }
?>
</select>
<label for="colonia">Colonia *</label>