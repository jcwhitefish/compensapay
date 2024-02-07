<?php
    if(is_array($noti))
    {
        foreach ($noti as $value)
        {
            $cadena = '<i class="material-icons" style="color:#9118bd;">drafts</i><td>'.$value["title"].'<span style="position:absolute;right:30px;">'.date("d / m / Y", $value["create_at"]).'</span>';
        }
    }

    echo $cadena;
?>