<?php
session_start();
require_once '../../config/Conecct.php';
$db = new Conecct();
$conn = $db->conecct;

// Obtener Álbumes Activos
$sql = "SELECT a.*, ar.pseudonimo_artista, g.nombre_genero 
        FROM albumes a 
        LEFT JOIN artistas ar ON a.id_artista = ar.id_artista 
        LEFT JOIN generos g ON a.id_genero = g.id_genero 
        WHERE a.estatus_album = 1 ORDER BY a.fecha_lanzamiento_album DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$albumes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MTV Awards | Géneros</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
    <style>
        .modal-content { background-color: #1a1a1a; color: white; border: 1px solid #333; }
        .modal-header { border-bottom: 1px solid #333; }
        .close { color: white; opacity: 1; }
        .list-group-item { background-color: #222; border-color: #333; color: #ddd; }
        .classynav ul li.active a { color: #fbb710 !important; }
        /* Estilo del reproductor */
        audio { width: 100%; height: 32px; margin-top: 5px; outline: none; }
    </style>
</head>

<body>
    <header class="header-area">
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">
                        <a href="./index.php" class="nav-brand"><img src="../../../recursos/img/system/mtv-logo-blanco.png" width="50%" alt=""></a>
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
                                <div class="login-register-cart-button d-flex align-items-center">
                                    <div class="login-register-btn mr-50">
                                        <?php if (isset($_SESSION["nickname"])): ?>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" id="userDropdown" data-toggle="dropdown" style="color: white;"><?= htmlspecialchars($_SESSION["nickname"]) ?></a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item text-dark" href="../../backend/panel/liberate_user.php">Cerrar sesión</a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <a href="../../../index.php" style="color: white;">Iniciar sesión</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb2.jpg);">
        <div class="bradcumbContent">
            <h2>Explora Géneros</h2>
        </div>
    </section>

    <section class="album-catagory section-padding-100-0">
        <div class="container">
            <div class="row">
                <?php foreach ($albumes as $alb): ?>
                    <?php 
                        $stmt_c = $conn->prepare("SELECT * FROM canciones WHERE id_album = :id AND estatus_cancion = 1");
                        $stmt_c->bindParam(':id', $alb['id_album']);
                        $stmt_c->execute();
                        $canciones = $stmt_c->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="single-album-area wow fadeInUp" data-wow-delay="100ms">
                            <div class="album-thumb">
                                <img src="../../../recursos/img/albums/<?= !empty($alb['imagen_album']) ? $alb['imagen_album'] : 'default.png' ?>" style="height: 250px; object-fit: cover;" alt="">
                            </div>
                            <div class="album-info">
                                <a href="#"><h5><?= htmlspecialchars($alb['titulo_album']) ?></h5></a>
                                <p><?= htmlspecialchars($alb['pseudonimo_artista']) ?></p>
                                <p class="text-muted small"><?= htmlspecialchars($alb['nombre_genero']) ?></p>
                                <button class="btn oneMusic-btn btn-sm mt-2" data-toggle="modal" data-target="#modalAlbum<?= $alb['id_album'] ?>">Ver Detalles</button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalAlbum<?= $alb['id_album'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?= htmlspecialchars($alb['titulo_album']) ?></h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <img src="../../../recursos/img/albums/<?= !empty($alb['imagen_album']) ? $alb['imagen_album'] : 'default.png' ?>" class="img-fluid rounded" alt="">
                                        </div>
                                        <div class="col-md-7">
                                            <p><strong>Artista:</strong> <?= htmlspecialchars($alb['pseudonimo_artista']) ?></p>
                                            <p><strong>Género:</strong> <?= htmlspecialchars($alb['nombre_genero']) ?></p>
                                            <hr style="background-color: #444;">
                                            <h6>Canciones:</h6>
                                            <?php if (count($canciones) > 0): ?>
                                                <ul class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                                                    <?php foreach ($canciones as $track): ?>
                                                        <li class="list-group-item bg-dark border-secondary">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <span><i class="fa fa-music"></i> <?= htmlspecialchars($track['nombre_cancion']) ?></span>
                                                                <span class="badge badge-warning"><?= htmlspecialchars($track['duracion_cancion']) ?></span>
                                                            </div>
                                                            
                                                            <?php if (!empty($track['mp3_cancion'])): ?>
                                                                <audio controls>
                                                                    <source src="../../../recursos/audio/<?= $track['mp3_cancion'] ?>" type="audio/mpeg">
                                                                    Tu navegador no soporta el audio.
                                                                </audio>
                                                            <?php else: ?>
                                                                <small class="text-muted">Sin archivo MP3.</small>
                                                            <?php endif; ?>

                                                            <?php if (!empty($track['url_cancion'])): ?>
                                                                <a href="<?= $track['url_cancion'] ?>" target="_blank" class="btn btn-sm btn-outline-light mt-1 btn-block">Enlace Externo</a>
                                                            <?php endif; ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p class="text-muted">No hay canciones.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer class="footer-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6"><img src="../../../recursos/img/system/mtv-logo-blanco.png" width="100" alt=""></div>
                <div class="col-12 col-md-6">
                    <div class="footer-nav">
                        <ul>
                            <li><a href="./index.php">Inicio</a></li>
                            <li><a href="./albums-store.php">Géneros</a></li>
                            <li><a href="./nominaciones.php">Nominaciones</a></li>
                            <li><a href="./votar.php">Votar</a></li>
                        </ul>
                    </div>
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