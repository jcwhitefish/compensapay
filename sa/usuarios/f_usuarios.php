<?php
function usuarios($fechai, $fechaf, $tipo)
{
    include ('../config/conexion.php');
    
    switch ($tipo)
    {
        case 'T': 
            $ResTotUser=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE created_at <= '".strtotime($fechaf)."'")); //total de usuarios
            $T = $ResTotUser;
            break;
        case 'A': 
            $ResTotUserA=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE cancel_at IS NULL or cancel_at >'".strtotime($fechaf)."'")); //usuarios activos
            $T = $ResTotUserA;
            break;
        case 'N':
            $ResTotUserN=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE created_at >='".strtotime($fechai)."' AND created_at <= '".strtotime($fechaf)."'")); //usuarios nuevos
            $T = $ResTotUserN;
            break;
        case 'C':
            $ResTotUserC=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE cancel_at >='".strtotime($fechai)."' AND created_at <='".strtotime($fechaf)."'"));//usuarios cancelados
            $T = $ResTotUserC;
            break;
    }
    
    return $T;
}