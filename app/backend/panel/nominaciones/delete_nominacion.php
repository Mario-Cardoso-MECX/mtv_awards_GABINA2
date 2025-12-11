<?php
session_start();
require_once '../../../config/Conecct.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // DELETE FÍSICO (Borrar de la base de datos)
    $sql = "DELETE FROM nominaciones WHERE id_nominacion = $id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../../../views/panel/nominaciones.php?msg=deleted");
    } else {
        echo "Error borrando: " . $conexion->error;
    }
}
$conexion->close();
?>