<?php
session_start();
require_once '../../../config/Conecct.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_nominacion'];
    $id_categoria = $_POST['id_categoria'];
    $id_artista = !empty($_POST['id_artista']) ? $_POST['id_artista'] : "NULL";
    $id_album = !empty($_POST['id_album']) ? $_POST['id_album'] : "NULL";

    $sql = "UPDATE nominaciones SET 
            id_categoria_nominacion = '$id_categoria',
            id_artista = $id_artista,
            id_album = $id_album
            WHERE id_nominacion = $id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../../../views/panel/nominaciones.php?msg=updated");
    } else {
        echo "Error actualizando: " . $conexion->error;
    }
}
$conexion->close();
?>