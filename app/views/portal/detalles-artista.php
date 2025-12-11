<?php
session_start();
require_once '../../config/Conecct.php';

if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=Debes iniciar sesión&type=warning");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=Artista no especificado");
    exit();
}

$id_artista = $_GET['id'];
$db = new Conecct();
$conn = $db->conecct;

// 1. Obtener Info del Artista (JOIN con Usuarios para la foto)
$sql_art = "SELECT a.*, u.imagen_usuario, u.nombre_usuario 
            FROM artistas a 
            INNER JOIN usuarios u ON a.id_usuario = u.id_usuario 
            WHERE a.id_artista = :id";
$stmt = $conn->prepare($sql_art);
$stmt->bindParam(':id', $id_artista);
$stmt->execute();
$artista = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$artista) {
    echo "Artista no encontrado.";
    exit();
}

// 2. Obtener Álbumes del Artista
$sql_albums = "SELECT * FROM albumes WHERE id_artista = :id AND estatus_album = 1";
$stmt_a = $conn->prepare($sql_albums);
$stmt_a->bindParam(':id', $id_artista);
$stmt_a->execute();
$albums = $stmt_a->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($artista['pseudonimo_artista']) ?> | MTV Awards</title>
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
                                    <li><a href="./artistas.php">Artistas</a></li>
                                    <li><a href="../../backend/panel/liberate_user.php">Salir</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb.jpg);">
        <div class="bradcumbContent">
            <h2><?= htmlspecialchars($artista['pseudonimo_artista']) ?></h2>
            <p><?= htmlspecialchars($artista['nacionalidad_artista']) ?></p>
        </div>
    </section>

    <section class="about-us-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="about-thumbnail mb-100">
                        <img src="../../../recursos/img/users/<?= !empty($artista['imagen_usuario']) ? $artista['imagen_usuario'] : 'user.png' ?>" alt="">
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="about-content mb-100">
                        <h4>Biografía</h4>
                        <p><?= nl2br(htmlspecialchars($artista['biografia_artista'] ?? 'Sin biografía disponible.')) ?></p>
                        
                        <h4 class="mt-5">Discografía</h4>
                        <div class="row">
                            <?php if (count($albums) > 0): ?>
                                <?php foreach ($albums as $alb): ?>
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <div class="single-album-area">
                                            <div class="album-thumb">
                                                <img src="../../../recursos/img/albums/<?= $alb['imagen_album'] ?>" alt="" style="height:200px; object-fit:cover;">
                                            </div>
                                            <div class="album-info text-center">
                                                <h5><?= htmlspecialchars($alb['titulo_album']) ?></h5>
                                                <a href="detalles_album.php?id_al=<?= $alb['id_album'] ?>" class="btn oneMusic-btn btn-sm mt-2">Ver Álbum</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12"><p>Este artista aún no tiene álbumes publicados.</p></div>
                            <?php endif; ?>
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