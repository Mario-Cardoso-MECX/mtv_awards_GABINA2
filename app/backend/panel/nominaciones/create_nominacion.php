<?php
session_start();
require_once '../../../config/Conecct.php'; // Ajuste de ruta (3 niveles arriba)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_categoria = $_POST['id_categoria'];
    // Si envían vacío, guardamos NULL en la BD
    $id_artista = !empty($_POST['id_artista']) ? $_POST['id_artista'] : "NULL";
    $id_album = !empty($_POST['id_album']) ? $_POST['id_album'] : "NULL";
    
    // Validar que al menos se elija artista o album
    if($id_artista == "NULL" && $id_album == "NULL"){
        echo "<script>alert('Debes seleccionar al menos un Artista o un Álbum'); window.history.back();</script>";
        exit;
    }

    // Insertar (contador_nominacion inicia en 0 votos)
    $sql = "INSERT INTO nominaciones (fecha_nominacion, id_categoria_nominacion, id_artista, id_album, contador_nominacion) 
            VALUES (NOW(), '$id_categoria', $id_artista, $id_album, 0)";

    if ($conexion->query($sql) === TRUE) {
        // Redireccionar éxito
        header("Location: ../../../views/panel/nominaciones.php?msg=success");
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
$conexion->close();
?>