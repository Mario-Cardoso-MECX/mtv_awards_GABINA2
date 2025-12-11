<?php
session_start();
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit();
}

require_once '../../config/Conecct.php';
require_once '../../models/Tabla_albumes.php';
require_once '../../models/Tabla_votaciones.php';

$db = new Conecct();
$conn = $db->conecct;

$tabla_album = new Tabla_albumes();
$albums = $tabla_album->readAllAlbumsG(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MTV | awards</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
    <style>
        .classynav ul li.active a { color: #fbb710 !important; }
        
        /* ESTILOS MODAL COMPACTO */
        .modal-content { background-color: #1a1a1a; color: white; border: 1px solid #333; }
        .modal-header { border-bottom: 1px solid #333; padding: 1rem; }
        .modal-footer { border-top: 1px solid #333; padding: 0.75rem; }
        .close { color: white; text-shadow: none; opacity: 1; }
        .list-group-item { background-color: #222; border-color: #333; color: #ddd; padding: 0.5rem 1rem; }
        
        /* Ajuste de tamaño de ventana */
        .modal-dialog-compact { max-width: 400px; margin: 1.75rem auto; }
        
        /* Botón ancho completo en tarjeta */
        .btn-full-width { width: 100%; display: block; margin-top: 10px; }
    </style>
</head>

<body>
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
    </div>

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
                                    <li class="active"><a href="./albums-store.php">Albums</a></li> <li><a href="./artistas.php">Artistas</a></li>
                                    <li><a href="./votar.php">Votar</a></li>
                                    <li><a href="./resultados.php">Resultados</a></li>
                                </ul>
                                <div class="login-register-cart-button d-flex align-items-center">
                                    <div class="login-register-btn mr-50">
                                        <?php if (isset($_SESSION["nickname"])): ?>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?= htmlspecialchars($_SESSION["nickname"]) ?>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="userDropdown">
                                                    <?php 
                                                    $rol = isset($_SESSION['rol']) ? intval($_SESSION['rol']) : 0;
                                                    if ($rol == 128) { echo '<a class="dropdown-item text-dark" href="../panel/dashboard.php">Ir al Panel</a>'; } 
                                                    elseif ($rol == 85) { echo '<a class="dropdown-item text-dark" href="../panel/dashboard_artista.php">Ir al Panel</a>'; }
                                                    ?>
                                                    <a class="dropdown-item text-dark" href="./miPerfil.php?id=<?= $_SESSION['id_usuario']; ?>">Mi perfil</a>
                                                    <a class="dropdown-item text-dark" href="../../backend/panel/liberate_user.php">Cerrar sesión</a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <a href="../../../index.php">Iniciar sesión / Registrarse</a>
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

    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb.jpg);">
        <div class="bradcumbContent">
            <h2>Colección de Álbumes</h2>
            <p>Explora todos los géneros</p>
        </div>
    </section>

    <section class="album-catagory section-padding-100-0">
        <div class="container">
            <div class="row">
                <?php if (!empty($albums)): ?>
                    <?php foreach ($albums as $album): ?>
                        
                        <?php 
                            $id_alb = $album->id_album;
                            $sql_s = "SELECT * FROM canciones WHERE id_album = :id AND estatus_cancion = 1";
                            $stmt_s = $conn->prepare($sql_s);
                            $stmt_s->bindParam(':id', $id_alb);
                            $stmt_s->execute();
                            $canciones = $stmt_s->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="single-album-area wow fadeInUp" data-wow-delay="100ms">
                                <div class="album-thumb">
                                    <img src="../../../recursos/img/albums/<?= htmlspecialchars($album->imagen_album) ?>" alt="" style="height: 250px; object-fit: cover; width: 100%;">
                                    <button type="button" class="btn oneMusic-btn btn-sm btn-full-width" data-toggle="modal" data-target="#modalAlbum<?= $album->id_album ?>">
                                        Ver Detalles
                                    </button>
                                </div>
                                <div class="album-info mt-2">
                                    <a href="#"><h5><?= htmlspecialchars($album->titulo_album) ?></h5></a>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalAlbum<?= $album->id_album ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-compact" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="font-size: 1rem;"><?= htmlspecialchars($album->titulo_album) ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-3">
                                        <div class="text-center mb-3">
                                            <img src="../../../recursos/img/albums/<?= htmlspecialchars($album->imagen_album) ?>" class="img-fluid rounded shadow" style="max-height: 150px;">
                                        </div>
                                        <div class="text-center mb-3">
                                            <p class="mb-0"><strong>Artista:</strong> <?= htmlspecialchars($album->nombre_usuario) ?></p>
                                            <p class="mb-0 text-muted"><small><?= htmlspecialchars($album->nombre_genero) ?></small></p>
                                        </div>
                                        
                                        <p class="small text-justify bg-dark p-2 rounded"><?= nl2br(htmlspecialchars($album->descripcion_album)) ?></p>
                                        
                                        <h6 class="text-warning mt-3 small text-uppercase">Canciones:</h6>
                                        <?php if (count($canciones) > 0): ?>
                                            <ul class="list-group list-group-flush small">
                                                <?php foreach ($canciones as $cancion): ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span class="text-truncate" style="max-width: 200px;"><i class="fa fa-music mr-1"></i> <?= htmlspecialchars($cancion['nombre_cancion']) ?></span>
                                                        <span class="badge badge-dark"><?= htmlspecialchars($cancion['duracion_cancion']) ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p class="small text-muted text-center">Sin canciones.</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                        <a href="votar.php" class="btn oneMusic-btn btn-sm">Votar</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center w-100">No hay álbumes disponibles.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <footer class="footer-area">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-12 col-md-6">
                    <a href="./dashboard.php"><img src="../../../recursos/img/system/mtv-logo-blanco.png" width="15%" alt=""></a>
                </div>
                <div class="col-12 col-md-6">
                    <div class="footer-nav">
                        <ul>
                            <li><a href="./index.php">Inicio</a></li>
                            <li><a href="./event.php">Eventos</a></li>
                            <li><a href="./albums-store.php">Albums</a></li>
                            <li><a href="./artistas.php">Artistas</a></li>
                            <li><a href="./votar.php">Votar</a></li>
                            <li><a href="./resultados.php">Resultados</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/plugins/plugins.js"></script>
    <script src="../../../recursos/recursos_portal/js/active.js"></script>
</body>
</html>