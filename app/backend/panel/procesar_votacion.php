<?php
session_start();
require_once '../../config/Conecct.php';

// Validar login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../views/portal/login.php?error=necesitas_login");
    exit();
}

// VALIDACIÓN DE SEGURIDAD: Solo rol 4 (Audiencia) puede votar
$rol_usuario = isset($_SESSION['rol']) ? intval($_SESSION['rol']) : 0;
if ($rol_usuario !== 4) {
    header("Location: ../../views/portal/votar.php?error=permisos");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Conecct();
    $conexion = $db->conecct;

    $id_nominacion = $_POST['id_nominacion'] ?? null;
    $id_usuario = $_SESSION['id_usuario'];

    if(!$id_nominacion) {
        die("Error: Faltan datos.");
    }

    try {
        // [CORREGIDO] 1. Validar si el usuario YA VOTÓ en esta nominación
        $check_sql = "SELECT COUNT(*) as total FROM votaciones WHERE id_nominacion = :nom AND id_usuario = :user";
        $check_stmt = $conexion->prepare($check_sql);
        $check_stmt->bindParam(':nom', $id_nominacion);
        $check_stmt->bindParam(':user', $id_usuario);
        $check_stmt->execute();
        $exists = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($exists['total'] > 0) {
            // Si ya votó, regresarlo con mensaje de error
            header("Location: ../../views/portal/votar.php?msg=ya_votaste");
            exit();
        }

        // 2. Obtener datos de la nominación
        $stmt_info = $conexion->prepare("SELECT id_artista, id_album FROM nominaciones WHERE id_nominacion = :id");
        $stmt_info->bindParam(':id', $id_nominacion);
        $stmt_info->execute();
        $data_nom = $stmt_info->fetch(PDO::FETCH_ASSOC);

        if ($data_nom) {
            $id_art = $data_nom['id_artista'];
            $id_alb = $data_nom['id_album'];

            // 3. Registrar el voto
            // IMPORTANTE: Si la columna 'fecha_votacion' tiene DEFAULT CURRENT_TIMESTAMP en tu BD, no es necesario pasarla.
            // Si no, usa NOW(). Asumiendo que usaste el SQL anterior, aquí lo dejo explícito.
            $sql_voto = "INSERT INTO votaciones (fecha_votacion, id_nominacion, id_usuario, id_artista, id_album) VALUES (NOW(), :nom, :user, :art, :alb)";
            
            $stmt_voto = $conexion->prepare($sql_voto);
            $stmt_voto->bindParam(':nom', $id_nominacion);
            $stmt_voto->bindParam(':user', $id_usuario);
            $stmt_voto->bindParam(':art', $id_art);
            $stmt_voto->bindParam(':alb', $id_alb);

            if ($stmt_voto->execute()) {
                // 4. ACTUALIZAR EL CONTADOR
                $sql_update = "UPDATE nominaciones SET contador_nominacion = contador_nominacion + 1 WHERE id_nominacion = :nom";
                $stmt_upd = $conexion->prepare($sql_update);
                $stmt_upd->bindParam(':nom', $id_nominacion);
                $stmt_upd->execute();

                header("Location: ../../views/portal/votar.php?msg=voto_exitoso");
            } else {
                echo "Error al guardar el voto.";
            }
        } else {
            echo "Nominación no encontrada.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>