<?php
// app/backend/panel/albumes/create_album.php

require_once '../../../models/Tabla_albumes.php';
require_once '../../../models/Tabla_artista.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabla_album = new Tabla_albumes();
    $tabla_artista = new Tabla_artista();

    if (isset($_POST["titulo_album"], $_POST["fecha_lanzamiento_album"], $_POST["id_genero"])) {
        $titulo = trim($_POST["titulo_album"]);
        $fecha_lanzamiento = $_POST["fecha_lanzamiento_album"];
        $descripcion = isset($_POST["descripcion_album"]) ? trim($_POST["descripcion_album"]) : null;
        $id_genero = intval($_POST["id_genero"]);

        // LÓGICA PARA ASIGNAR ARTISTA
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
             $_SESSION['message'] = array("type" => "error", "description" => "No se pudo identificar al artista.", "title" => "Error");
            header('Location: ../../../views/panel/album_nuevo.php');
            exit();
        }

        // Imagen
        $img = $_FILES["imagen_album"];
        $file_name = NULL;

        if (!empty($img["name"])) {
            $temp = explode(".", $img["name"]);
            $exten = strtolower(end($temp));

            if (!in_array($exten, ["jpg", "png", "jpeg"])) {
                $_SESSION['message'] = array("type" => "error", "description" => "Formato de imagen inválido.", "title" => "Error");
                header('Location: ../../../views/panel/album_nuevo.php');
                exit();
            }

            $target_dir = "../../../../recursos/img/albums/";
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

            if (move_uploaded_file($img['tmp_name'], $target_dir . $img['name'])) {
                $file_name = $img['name'];
            }
        }

        $data = array(
            "titulo_album" => $titulo,
            "fecha_lanzamiento_album" => $fecha_lanzamiento,
            "descripcion_album" => $descripcion,
            "imagen_album" => ($file_name == null) ? "default.png" : $file_name,
            "id_artista" => $id_artista,
            "id_genero" => $id_genero,
            "estatus_album" => 1 // [CORREGIDO] Importante para que sea visible
        );

        if ($tabla_album->createAlbum($data)) {
            $_SESSION['message'] = array("type" => "success", "description" => "Álbum registrado correctamente.", "title" => "Éxito");
            header('Location: ../../../views/panel/albumes.php');
            exit();
        } else {
            $_SESSION['message'] = array("type" => "error", "description" => "Error al guardar.", "title" => "Error");
            header('Location: ../../../views/panel/album_nuevo.php');
            exit();
        }
    } else {
        $_SESSION['message'] = array("type" => "error", "description" => "Faltan datos.", "title" => "Error");
        header('Location: ../../../views/panel/album_nuevo.php');
        exit();
    }
}
?>