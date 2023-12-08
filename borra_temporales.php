<?php
$directorio = 'temporales';

function borrarCarpetasDirectorio($directorio) {
    if (!file_exists($directorio)) {
        echo "El directorio no existe.";
        return;
    }

    $carpetas = glob($directorio . '/*', GLOB_ONLYDIR);
    
    foreach ($carpetas as $carpeta) {
        borrarContenidoDirectorio($carpeta);
        //echo 'se borro carpeta '.$carpeta.'<br />';
        rmdir($carpeta);
    }
}

function borrarContenidoDirectorio($directorio) {
    $archivos = glob($directorio . '/*');
    
    foreach ($archivos as $archivo) {
        if (is_file($archivo)) {
            //echo 'se borro archivo '.$archivo.'<br />';
            unlink($archivo);
        } elseif (is_dir($archivo)) {
            borrarContenidoDirectorio($archivo);
        }
    }
}

borrarCarpetasDirectorio($directorio);

?>