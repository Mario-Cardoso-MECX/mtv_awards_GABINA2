<?php
require_once '../../../models/Tabla_canciones.php';
require_once '../../../models/Tabla_artista.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabla_cancion = new Tabla_canciones();
    $tabla_artista = new Tabla_artista();

    // 1. Validar Usuario
    if (!isset($_SESSION['id_usuario'])) {
         header('Location: ../../../index.php');
         exit();
    }

    // 2. Obtener Artista
    $id_artista = null;
    if (isset($_POST['id_artista']) && !empty($_POST['id_artista'])) {
        $id_artista = intval($_POST['id_artista']);
    } else {
        $artista = $tabla_artista->getArtistaByUsuario($_SESSION['id_usuario']);
        if ($artista) {
            $id_artista = $artista->id_artista;
        }
    }

    if (!$id_artista) {
        $_SESSION['message'] = array("type" => "error", "description" => "Error: No se pudo identificar al artista.", "title" => "Error");
        header('Location: ../../../views/panel/cancion_nueva.php');
        exit();
    }

    // 3. Procesar Datos
    if (isset($_POST["nombre_cancion"], $_POST["duracion_cancion"], $_POST["id_genero"], $_POST["id_album"])) {
        
        $nombre_cancion = trim($_POST["nombre_cancion"]);
        $fecha = !empty($_POST["fecha_lanzamiento_cancion"]) ? $_POST["fecha_lanzamiento_cancion"] : date('Y-m-d');
        $duracion = $_POST["duracion_cancion"];
        $id_genero = intval($_POST["id_genero"]);
        $id_album = intval($_POST["id_album"]);
        $url_cancion = !empty($_POST["url_cancion"]) ? $_POST["url_cancion"] : null;
        $url_video = !empty($_POST["url_video_cancion"]) ? $_POST["url_video_cancion"] : null;

        // 4. SUBIDA DE ARCHIVO MP3 (CORREGIDO)
        $file_name = null;
        
        if (isset($_FILES["mp3_cancion"]) && !empty($_FILES["mp3_cancion"]["name"])) {
            $mp3 = $_FILES["mp3_cancion"];
            $temp = explode(".", $mp3["name"]);
            $exten = strtolower(end($temp));

            if ($exten !== "mp3") {
                $_SESSION['message'] = array("type" => "error", "description" => "Solo se permiten archivos MP3.", "title" => "Formato Incorrecto");
                header('Location: ../../../views/panel/cancion_nueva.php');
                exit();
            }

            // Ruta: Subir 4 niveles para llegar a la raíz (app/backend/panel/canciones/ -> raíz)
            $target_dir = "../../../../recursos/audio/";
            
            // Crear carpeta si no existe
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Limpiar nombre (reemplaza espacios por guiones bajos)
            $clean_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $mp3['name']);
            // Agregar timestamp para evitar duplicados
            $final_name = time() . "_" . $clean_name;
            $target_file = $target_dir . $final_name;

            if (move_uploaded_file($mp3['tmp_name'], $target_file)) {
                $file_name = $final_name; // Guardamos este nombre en la BD
            } else {
                $_SESSION['message'] = array("type" => "error", "description" => "No se pudo mover el archivo al servidor.", "title" => "Error de Permisos");
                header('Location: ../../../views/panel/cancion_nueva.php');
                exit();
            }
        }

        // 5. Insertar en BD
        $data = array(
            "nombre_cancion" => $nombre_cancion,
            "fecha_lanzamiento_cancion" => $fecha,
            "duracion_cancion" => $duracion,
            "mp3_cancion" => $file_name, // Aquí se guarda el nombre del archivo
            "url_cancion" => $url_cancion,
            "url_video_cancion" => $url_video,
            "id_artista" => $id_artista,
            "id_genero" => $id_genero,
            "id_album" => $id_album,
            "estatus_cancion" => 1
        );

        if ($tabla_cancion->createCancion($data)) {
            $_SESSION['message'] = array("type" => "success", "description" => "Canción y MP3 guardados correctamente.", "title" => "Éxito");
            header('Location: ../../../views/panel/canciones.php');
            exit();
        } else {
            $_SESSION['message'] = array("type" => "error", "description" => "Error al guardar en base de datos.", "title" => "Error SQL");
            header('Location: ../../../views/panel/cancion_nueva.php');
            exit();
        }

    } else {
        $_SESSION['message'] = array("type" => "error", "description" => "Faltan datos obligatorios.", "title" => "Error");
        header('Location: ../../../views/panel/cancion_nueva.php');
        exit();
    }
}
?>