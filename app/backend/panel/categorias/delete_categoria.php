<?php
session_start();
require_once '../../../config/Conecct.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Borrado físico segun tu rúbrica, o soft delete si prefieres (UPDATE set estatus=0)
    $sql = "DELETE FROM categorias_nominaciones WHERE id_categoria_nominacion = $id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../../../views/panel/categorias.php?msg=deleted");
    } else {
        echo "Error: " . $conexion->error;
    }
}
$conexion->close();
?>