<?php
session_start();
require_once '../../../config/Conecct.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre_categoria'];
    $tipo = $_POST['tipo']; // 1: Album, 2: Cancion, 3: Artista (segun tu logica)
    
    $sql = "INSERT INTO categorias_nominaciones (nombre_categoria_nominacion, tipo_categoria_nominacion, fecha_categoria_nominacion, estatus_categoria_nominacion) 
            VALUES ('$nombre', '$tipo', NOW(), 1)";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../../../views/panel/categorias.php?msg=success");
    } else {
        echo "Error: " . $conexion->error;
    }
}
$conexion->close();
?>