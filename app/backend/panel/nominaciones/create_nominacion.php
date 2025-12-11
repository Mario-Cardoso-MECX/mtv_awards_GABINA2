<?php
session_start();
require_once '../../../config/Conecct.php'; // Ajusta la ruta si es necesario

// Validar sesión y rol si es necesario (opcional, pero recomendado)
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Conecct();
    $conexion = $db->conecct;

    $id_categoria = $_POST['id_categoria'];
    
    // Lógica para asignar NULL real si el campo viene vacío
    $id_artista = !empty($_POST['id_artista']) ? $_POST['id_artista'] : null;
    $id_album = !empty($_POST['id_album']) ? $_POST['id_album'] : null;
    
    // Validar que al menos se elija artista o álbum
    if ($id_artista === null && $id_album === null) {
        echo "<script>alert('Debes seleccionar al menos un Artista o un Álbum'); window.history.back();</script>";
        exit;
    }

    try {
        // Usar Prepared Statements para seguridad y manejo correcto de NULL
        $sql = "INSERT INTO nominaciones (fecha_nominacion, id_categoria_nominacion, id_artista, id_album, contador_nominacion) 
                VALUES (NOW(), :categoria, :artista, :album, 0)";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':categoria', $id_categoria);
        $stmt->bindParam(':artista', $id_artista);
        $stmt->bindParam(':album', $id_album);

        if ($stmt->execute()) {
            // Redireccionar éxito
            header("Location: ../../../views/panel/nominaciones.php?msg=success");
            exit();
        } else {
            echo "Error al crear la nominación.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>