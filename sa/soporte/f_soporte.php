<?php
function tickets($fechai, $fechaf, $tipo)
{
    include ('../config/conexion.php');

    switch ($tipo)
    {
        case 'T': 
            $ResTotTck=mysqli_num_rows(mysqli_query($conn, "SELECT tck_id FROM tck_ticket WHERE tck_created_at <= '".strtotime($fechaf)."' AND tck_created_at >= '".strtotime($fechai)."'")); //total de tickets
            $T = $ResTotTck;
            break;
        case 'A': 
            $ResTotTckA=mysqli_num_rows(mysqli_query($conn, "SELECT tck_id FROM tck_ticket WHERE tck_status='1' AND tck_created_at >= '".strtotime($fechai)."' AND tck_created_at <= '".strtotime($fechaf)."'")); //tickets abiertos
            $T = $ResTotTckA;
            break;
        case 'P':
            $ResTotTckP=mysqli_num_rows(mysqli_query($conn, "SELECT tck_id FROM tck_ticket WHERE tck_status='2' AND tck_created_at >= '".strtotime($fechai)."' AND tck_created_at <= '".strtotime($fechaf)."'")); //tickets en proceso
            $T = $ResTotTckP;
            break;
        case 'C':
            $ResTotTckC=mysqli_num_rows(mysqli_query($conn, "SELECT tck_id FROM tck_ticket WHERE tck_status='3' AND tck_created_at >= '".strtotime($fechai)."' AND tck_created_at <= '".strtotime($fechaf)."'"));//tickets cerrados
            $T = $ResTotTckC;
            break;
    }
    
    return $T;
}