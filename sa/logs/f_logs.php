<?php
function logs($fechai, $fechaf)
{
    include ('../config/conexion.php');
    
    switch ($tipo)
    {
        case 'T': 
            $ResLogs=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM logs WHERE created_at >= '".strtotime($fechai)."' AND created_at <= '".strtotime($fechaf)."'")); //total de logs
            $T = $ResTotOp;
            break;
        
    }
    
    return $T;
}