<?php
// Mensaje de validación
echo 'Validating...';

// Importar el modelo
require_once '../../../models/Tabla_albumes.php';
require_once '../../../models/Tabla_artista.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia del modelo
    $tabla_album = new Tabla_albumes();
    $tabla_artista = new Tabla_artista();

    // Verificar que los datos requeridos estén presentes
    if (isset($_POST["titulo_album"], $_POST["fecha_lanzamiento_album"], $_POST["id_genero"])) {
        $titulo = trim($_POST["titulo_album"]);
        $fecha_lanzamiento = $_POST["fecha_lanzamiento_album"];
        $descripcion = isset($_POST["descripcion_album"]) ? trim($_POST["descripcion_album"]) : null;
        
        // Obtener ID del Artista desde la sesión
        $artista = $tabla_artista->getArtistaByUsuario($_SESSION['id_usuario']);
        $id_artista = ($artista) ? $artista->id_artista : null;
        
        $id_genero = intval($_POST["id_genero"]);

        if (!$id_artista) {
             $_SESSION['message'] = array(
                "type" => "error",
                "description" => "No se encontró un perfil de artista asociado a tu usuario.",
                "title" => "¡ERROR!"
            );
            header('Location: ../../../views/panel/album_nuevo.php');
            exit();
        }

        // Manejar la imagen del álbum
        $img = $_FILES["imagen_album"];
        $file_name = NULL;

        if (!empty($img["name"])) {
            // Validar la extensión del archivo
            $temp = explode(".", $img["name"]);
            $exten = strtolower(end($temp));

            if (($exten != "jpg") && ($exten != "png") && ($exten != "jpeg")) {
                $_SESSION['message'] = array(
                    "type" => "error",
                    "description" => "La imagen debe tener una extensión válida (jpg, jpeg o png).",
                    "title" => "¡ERROR!"
                );
                header('Location: ../../../views/panel/album_nuevo.php');
                exit();
            }

            // Mover el archivo cargado
            // Asegúrate de que la carpeta exista y tenga permisos
            $target_dir = "../../../../recursos/img/albums/";
            if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }

            if (move_uploaded_file($img['tmp_name'], $target_dir . $img['name'])) {
                $file_name = $img['name'];
            }
        }

        // Preparar los datos para el registro
        $data = array(
            "titulo_album" => $titulo,
            "fecha_lanzamiento_album" => $fecha_lanzamiento,
            "descripcion_album" => $descripcion,
            "imagen_album" => ($file_name == null) ? "default.png" : $file_name, // Imagen por defecto si falla
            "id_artista" => $id_artista,
            "id_genero" => $id_genero
        );

        // Intentar registrar el álbum
        if ($tabla_album->createAlbum($data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El álbum se ha registrado correctamente.",
                "title" => "¡Registro Exitoso!"
            );
            header('Location: ../../../views/panel/albumes.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "error",
                "description" => "Ocurrió un error en la base de datos al registrar el álbum.",
                "title" => "¡ERROR!"
            );
            header('Location: ../../../views/panel/album_nuevo.php');
            exit();
        }

    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Faltan datos requeridos (Título, Fecha o Género).",
            "title" => "¡ERROR!"
        );
        header('Location: ../../../views/panel/album_nuevo.php');
        exit();
    }
} else {
    header('Location: ../../../views/panel/album_nuevo.php');
    exit();
}
?>