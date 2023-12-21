<?php
function empresas($fechai, $fechaf, $tipo)
{
    include ('../config/conexion.php');
    
    switch ($tipo)
    {
        case 'T': 
            $ResTotEmp=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM companies WHERE created_at <= '".strtotime($fechaf)."'")); //total de empresas
            $T = $ResTotEmp;
            break;
        case 'A': 
            $ResTotEmpA=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM companies WHERE cancel_at IS NULL or cancel_at >'".strtotime($fechaf)."'")); //empresas activas
            $T = $ResTotEmpA;
            break;
        case 'N':
            $ResTotEmpN=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM companies WHERE created_at >='".strtotime($fechai)."' AND created_at <= '".strtotime($fechaf)."'")); //empresas nuevas
            $T = $ResTotEmpN;
            break;
        case 'C':
            $ResTotEmpC=mysqli_num_rows(mysqli_query($conn, "SELECT id FROM companies WHERE cancel_at >='".strtotime($fechai)."' AND created_at <='".strtotime($fechaf)."'"));//empresas canceladas
            $T = $ResTotEmpC;
            break;
    }
    
    return $T;
}