<?php
session_start();
require_once '../../config/Conecct.php';

if (!isset($_GET["id_al"])) { header("Location: albums-store.php"); exit(); }

$id_album = $_GET["id_al"];
$db = new Conecct();
$conn = $db->conecct;

$stmt = $conn->prepare("SELECT a.*, ar.pseudonimo_artista, g.nombre_genero FROM albumes a LEFT JOIN artistas ar ON a.id_artista = ar.id_artista LEFT JOIN generos g ON a.id_genero = g.id_genero WHERE a.id_album = :id");
$stmt->bindParam(':id', $id_album);
$stmt->execute();
$album = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt_c = $conn->prepare("SELECT * FROM canciones WHERE id_album = :id AND estatus_cancion = 1");
$stmt_c->bindParam(':id', $id_album);
$stmt_c->execute();
$canciones = $stmt_c->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
    <style> .classynav ul li.active a { color: #fbb710 !important; } audio { width: 100%; height: 30px; } </style>
</head>
<body>
    <header class="header-area">
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">
                        <a href="index.php" class="nav-brand"><img src="../../../recursos/img/system/mtv-logo-blanco.png" width="50%" alt=""></a>
                        <div class="classy-navbar-toggler"><span class="navbarToggler"><span></span><span></span><span></span></span></div>
                        <div class="classy-menu">
                            <div class="classycloseIcon"><div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div></div>
                            <div class="classynav">
                                <ul>
                                    <li><a href="./index.php">Inicio</a></li>
                                    <li><a href="./event.php">Eventos</a></li>
                                    <li class="active"><a href="./albums-store.php">Géneros</a></li>
                                    <li><a href="./artistas.php">Artistas</a></li>
                                    <li><a href="./nominaciones.php">Nominaciones</a></li>
                                    <li><a href="./votar.php">Votar</a></li>
                                    <li><a href="./resultados.php">Resultados</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section class="about-us-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <img src="../../../recursos/img/albums/<?= !empty($album['imagen_album']) ? $album['imagen_album'] : 'default.png' ?>" alt="">
                </div>
                <div class="col-12 col-lg-8">
                    <h2><?= htmlspecialchars($album['titulo_album']) ?></h2>
                    <p>Artista: <?= htmlspecialchars($album['pseudonimo_artista']) ?></p>
                    <div class="mt-4">
                        <h4>Canciones</h4>
                        <ul class="list-group">
                            <?php foreach ($canciones as $track): ?>
                                <li class="list-group-item bg-dark text-white">
                                    <?= htmlspecialchars($track['nombre_cancion']) ?>
                                    <?php if (!empty($track['mp3_cancion'])): ?>
                                        <audio controls>
                                            <source src="../../../recursos/audio/<?= $track['mp3_cancion'] ?>" type="audio/mpeg">
                                        </audio>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="../../../recursos/recursos_portal/js/jquery/jquery-2.2.4.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/bootstrap/bootstrap.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/plugins/plugins.js"></script>
    <script src="../../../recursos/recursos_portal/js/active.js"></script>
</body>
</html>