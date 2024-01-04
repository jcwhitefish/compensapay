<?php
function operaciones($fechai, $fechaf, $tipo)
{
    include ('../config/conexion.php');
    
    switch ($tipo)
    {
        case 'T': 
            $ResTotOp=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM operations WHERE created_at >= '".strtotime($fechai)."' AND created_at <= '".strtotime($fechaf)."'")); //total de operaciones
            $T = $ResTotOp;
            break;
        case 'P': 
            $ResTotOpPA=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM operations WHERE created_at >= '".strtotime($fechai)."' AND created_at <= '".strtotime($fechaf)."' AND status='0'")); //operaciones por autorizar
            $T = $ResTotOpPA;
            break;
        case 'A':
            $ResTotOpA=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM operations WHERE created_at >='".strtotime($fechai)."' AND created_at <= '".strtotime($fechaf)."' AND status='1'")); //operaciones autorizadas
            $T = $ResTotOpA;
            break;
        case 'R':
            $ResTotOpR=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM operations WHERE created_at >='".strtotime($fechai)."' AND created_at <= '".strtotime($fechaf)."' AND status='2'"));//operaciones rechazadas
            $T = $ResTotOpR;
            break;
        case 'E':
            $ResTotOpRe=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM operations WHERE created_at >='".strtotime($fechai)."' AND created_at <= '".strtotime($fechaf)."' AND status='3'"));//operaciones realizadas
            $T = $ResTotOpRe;
            break;
        case 'V':
            $ResTotOpV=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM operations WHERE created_at >='".strtotime($fechai)."' AND created_at <= '".strtotime($fechaf)."' AND status='4'"));//operaciones vencidas
            $T = $ResTotOpV;
            break;
    }
    
    return $T;
}