<?php
session_start();
require_once '../../config/Conecct.php';

// Validar Sesión
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=Debes iniciar sesión&type=warning");
    exit();
}

// Validar ID
if (!isset($_GET["id_al"]) || empty($_GET["id_al"])) {
    header("Location: votar.php?error=Álbum no especificado");
    exit();
}

$id_album = $_GET["id_al"];
$db = new Conecct();
$conn = $db->conecct;

// 1. Obtener Detalles del Álbum (JOIN con Artista y Genero)
// Nota: Ajusta 'nombre_usuario' o 'pseudonimo_artista' según tu preferencia visual
$sql_album = "SELECT a.*, ar.pseudonimo_artista, g.nombre_genero 
              FROM albumes a 
              LEFT JOIN artistas ar ON a.id_artista = ar.id_artista 
              LEFT JOIN generos g ON a.id_genero = g.id_genero 
              WHERE a.id_album = :id";
$stmt = $conn->prepare($sql_album);
$stmt->bindParam(':id', $id_album);
$stmt->execute();
$album = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$album) {
    echo "El álbum no existe.";
    exit();
}

// 2. Obtener Canciones del Álbum (PUNTO CLAVE RÚBRICA)
$sql_canciones = "SELECT * FROM canciones WHERE id_album = :id AND estatus_cancion = 1";
$stmt_c = $conn->prepare($sql_canciones);
$stmt_c->bindParam(':id', $id_album);
$stmt_c->execute();
$canciones = $stmt_c->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($album['titulo_album']) ?> | Detalles</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
</head>

<body>
    <header class="header-area">
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">
                        <a href="./index.php" class="nav-brand"><img src="../../../recursos/img/system/mtv-logo-blanco.png" width="50%" alt=""></a>
                        <div class="classy-menu">
                            <div class="classynav">
                                <ul>
                                    <li><a href="./index.php">Inicio</a></li>
                                    <li><a href="./votar.php">Votar</a></li>
                                    <li><a href="../../backend/panel/liberate_user.php">Salir</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <h2><?= htmlspecialchars($album['titulo_album']) ?></h2>
            <p>De: <?= htmlspecialchars($album['pseudonimo_artista']) ?></p>
        </div>
    </section>

    <section class="about-us-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="about-thumbnail mb-100">
                        <img src="../../../recursos/img/albums/<?= !empty($album['imagen_album']) ? $album['imagen_album'] : 'default.png' ?>" alt="">
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="about-content mb-100">
                        <h4>Información del Álbum</h4>
                        <p><strong>Género:</strong> <?= htmlspecialchars($album['nombre_genero'] ?? 'General') ?></p>
                        <p><strong>Lanzamiento:</strong> <?= htmlspecialchars($album['fecha_lanzamiento_album']) ?></p>
                        <p><?= nl2br(htmlspecialchars($album['descripcion_album'] ?? 'Sin descripción.')) ?></p>
                        
                        <div class="song-play-area mt-5">
                            <h4>Lista de Canciones</h4>
                            <?php if (count($canciones) > 0): ?>
                                <div class="list-group">
                                    <?php foreach ($canciones as $cancion): ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center" style="border:none; border-bottom:1px solid #eee; padding: 15px 0;">
                                            <div>
                                                <h6 class="mb-1"><?= htmlspecialchars($cancion['nombre_cancion']) ?></h6>
                                                <small>Duración: <?= htmlspecialchars($cancion['duracion_cancion']) ?></small>
                                            </div>
                                            <?php if (!empty($cancion['mp3_cancion'])): ?>
                                                <audio controls style="height: 30px;">
                                                    <source src="../../../recursos/audio/<?= $cancion['mp3_cancion'] ?>" type="audio/mpeg">
                                                </audio>
                                            <?php elseif (!empty($cancion['url_cancion'])): ?>
                                                <a href="<?= $cancion['url_cancion'] ?>" target="_blank" class="btn oneMusic-btn btn-sm">Escuchar <i class="fa fa-external-link"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Este álbum aún no tiene canciones registradas.</p>
                            <?php endif; ?>
                        </div>

                        <div class="mt-5">
                            <a href="votar.php" class="btn oneMusic-btn">Volver a Votar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-area">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-12 col-md-6">
                    <a href="#"><img src="../../../recursos/img/system/mtv-logo-blanco.png" width="100" alt=""></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="../../../recursos/recursos_portal/js/jquery/jquery-2.2.4.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/bootstrap/bootstrap.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/plugins/plugins.js"></script>
    <script src="../../../recursos/recursos_portal/js/active.js"></script>
</body>
</html>