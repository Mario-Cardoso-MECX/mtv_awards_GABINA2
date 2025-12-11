<?php
session_start();
require_once '../../config/Conecct.php';

// Validar que el usuario esté logueado (punto de rúbrica)
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../views/portal/login.php?error=necesitas_login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_nominacion = $_POST['id_nominacion'];
    $id_usuario = $_SESSION['id_usuario'];
    
    // 1. Verificar si el usuario ya votó en esta categoría (opcional, buena práctica)
    // Para simplificar, asumiremos que pueden votar varias veces o lo controlas en frontend.
    
    // 2. Insertar el voto en la tabla historial 'votaciones'
    // Primero obtenemos datos de la nominación para llenar la tabla votaciones correctamente
    $query_info = "SELECT id_artista, id_album FROM nominaciones WHERE id_nominacion = '$id_nominacion'";
    $res_info = $conexion->query($query_info);
    $data_nom = $res_info->fetch_assoc();
    
    $id_art = $data_nom['id_artista'] ? $data_nom['id_artista'] : "NULL";
    $id_alb = $data_nom['id_album'] ? $data_nom['id_album'] : "NULL";

    $sql_voto = "INSERT INTO votaciones (fecha_votacion, id_nominacion, id_usuario, id_artista, id_album) 
                 VALUES (NOW(), '$id_nominacion', '$id_usuario', $id_art, $id_alb)";

    if ($conexion->query($sql_voto) === TRUE) {
        // 3. Incrementar el contador en la tabla 'nominaciones' (TRIGGER MANUAL)
        $sql_update = "UPDATE nominaciones SET contador_nominacion = contador_nominacion + 1 WHERE id_nominacion = '$id_nominacion'";
        $conexion->query($sql_update);
        
        header("Location: ../../views/portal/votar.php?msg=voto_exitoso");
    } else {
        echo "Error al votar: " . $conexion->error;
    }
}
$conexion->close();
?>