<?php
session_start();
require_once '../../../config/Conecct.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_categoria'];
    $nombre = $_POST['nombre_categoria'];
    $tipo = $_POST['tipo'];

    $sql = "UPDATE categorias_nominaciones SET 
            nombre_categoria_nominacion = '$nombre',
            tipo_categoria_nominacion = '$tipo'
            WHERE id_categoria_nominacion = $id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../../../views/panel/categorias.php?msg=updated");
    } else {
        echo "Error: " . $conexion->error;
    }
}
$conexion->close();
?>