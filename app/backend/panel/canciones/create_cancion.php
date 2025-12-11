<?php
// app/backend/panel/canciones/create_cancion.php

require_once '../../../models/Tabla_canciones.php';
require_once '../../../models/Tabla_artista.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabla_cancion = new Tabla_canciones();
    $tabla_artista = new Tabla_artista();

    if (!isset($_SESSION['id_usuario'])) {
         header('Location: ../../../index.php');
         exit();
    }

    $id_artista = null;
    if (isset($_POST['id_artista']) && !empty($_POST['id_artista'])) {
        $id_artista = intval($_POST['id_artista']);
    } else {
        $artista = $tabla_artista->getArtistaByUsuario($_SESSION['id_usuario']);
        if ($artista) $id_artista = $artista->id_artista;
    }

    if (!$id_artista) {
        $_SESSION['message'] = array("type" => "error", "description" => "Error: Artista no identificado.", "title" => "Error");
        header('Location: ../../../views/panel/cancion_nueva.php');
        exit();
    }

    if (isset($_POST["nombre_cancion"], $_POST["duracion_cancion"], $_POST["id_genero"], $_POST["id_album"])) {
        
        if (!empty($_FILES["mp3_cancion"]["name"]) || !empty($_POST["url_cancion"])) {
            $nombre_cancion = trim($_POST["nombre_cancion"]);
            $fecha = !empty($_POST["fecha_lanzamiento_cancion"]) ? $_POST["fecha_lanzamiento_cancion"] : date('Y-m-d');
            $duracion = $_POST["duracion_cancion"];
            $id_genero = intval($_POST["id_genero"]);
            $id_album = intval($_POST["id_album"]);

            $mp3 = $_FILES["mp3_cancion"];
            $file_name = null;

            if (!empty($mp3["name"])) {
                $temp = explode(".", $mp3["name"]);
                $exten = strtolower(end($temp));

                if ($exten !== "mp3") {
                    $_SESSION['message'] = array("type" => "error", "description" => "Solo archivos MP3.", "title" => "Error");
                    header('Location: ../../../views/panel/cancion_nueva.php');
                    exit();
                }

                $target_dir = "../../../../recursos/audio/";
                if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

                if (move_uploaded_file($mp3['tmp_name'], $target_dir . $mp3['name'])) {
                    $file_name = $mp3['name'];
                }
            }

            $data = array(
                "nombre_cancion" => $nombre_cancion,
                "fecha_lanzamiento_cancion" => $fecha,
                "duracion_cancion" => $duracion,
                "mp3_cancion" => $file_name,
                "url_cancion" => !empty($_POST["url_cancion"]) ? $_POST["url_cancion"] : null,
                "url_video_cancion" => !empty($_POST["url_video_cancion"]) ? $_POST["url_video_cancion"] : null,
                "id_artista" => $id_artista,
                "id_genero" => $id_genero,
                "id_album" => $id_album,
                "estatus_cancion" => 1 // [CORREGIDO] Habilita la canción automáticamente
            );

            if ($tabla_cancion->createCancion($data)) {
                $_SESSION['message'] = array("type" => "success", "description" => "Canción registrada.", "title" => "Éxito");
                header('Location: ../../../views/panel/canciones.php');
                exit();
            } else {
                $_SESSION['message'] = array("type" => "error", "description" => "Error SQL.", "title" => "Error");
                header('Location: ../../../views/panel/cancion_nueva.php');
                exit();
            }
        } else {
            $_SESSION['message'] = array("type" => "error", "description" => "Sube un archivo o pon URL.", "title" => "Error");
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