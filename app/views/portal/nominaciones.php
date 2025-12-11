<?php
session_start();
// Validación de sesión
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=Debes iniciar sesión&type=warning");
    exit();
}

require_once '../../config/Conecct.php';
$db = new Conecct();
$conn = $db->conecct;

// Obtener Categorías Activas
$stmt_cat = $conn->prepare("SELECT * FROM categorias_nominaciones WHERE estatus_categoria_nominacion = 1");
$stmt_cat->execute();
$categorias = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MTV Awards | Nominaciones</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style-votar.css">
    <style>
        /* Estilos del modal y menú */
        .modal-content { background-color: #1a1a1a; color: white; border: 1px solid #333; }
        .modal-header { border-bottom: 1px solid #333; }
        .close { color: white; opacity: 1; }
        .classynav ul li.active a { color: #fbb710 !important; }
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
                                    <li><a href="./albums-store.php">Géneros</a></li>
                                    <li><a href="./artistas.php">Artistas</a></li>
                                    <li class="active"><a href="./nominaciones.php">Nominaciones</a></li> <li><a href="./votar.php">Votar</a></li>
                                    <li><a href="./resultados.php">Resultados</a></li>
                                </ul>
                                <div class="login-register-cart-button d-flex align-items-center">
                                    <div class="login-register-btn mr-50">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" id="userDropdown" data-toggle="dropdown"><?= htmlspecialchars($_SESSION["nickname"]) ?></a>
                                            <div class="dropdown-menu">
                                                <?php 
                                                $rol = isset($_SESSION['rol']) ? intval($_SESSION['rol']) : 0;
                                                if ($rol == 128) { echo '<a class="dropdown-item text-dark" href="../panel/dashboard.php">Ir al Panel</a>'; } 
                                                elseif ($rol == 85) { echo '<a class="dropdown-item text-dark" href="../panel/dashboard_artista.php">Ir al Panel</a>'; }
                                                ?>
                                                <a class="dropdown-item text-dark" href="./miPerfil.php?id=<?= $_SESSION['id_usuario']; ?>">Mi perfil</a>
                                                <a class="dropdown-item text-dark" href="../../backend/panel/liberate_user.php">Cerrar sesión</a>
                                            </div>
                                        </div>
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
            <h2>Nominados Oficiales</h2>
            <p>Conoce a los candidatos de este año</p>
        </div>
    </section>

    <section class="oneMusic-buy-now-area mb-100 section-padding-100">
        <div class="container">
            <?php if (count($categorias) > 0): ?>
                <?php foreach ($categorias as $cat): ?>
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="section-heading style-2">
                                <h2><?= htmlspecialchars($cat['nombre_categoria_nominacion']) ?></h2>
                                <p><?= htmlspecialchars($cat['descripcion_categoria_nominacion']) ?></p>
                            </div>
                        </div>

                        <?php 
                        $id_cat = $cat['id_categoria_nominacion'];
                        $sql_nom = "SELECT n.id_nominacion, 
                                           a.pseudonimo_artista, a.biografia_artista, a.nacionalidad_artista,
                                           u.imagen_usuario as imagen_artista,
                                           al.id_album, al.titulo_album, al.imagen_album, al.descripcion_album, al.fecha_lanzamiento_album,
                                           g.nombre_genero
                                    FROM nominaciones n
                                    LEFT JOIN artistas a ON n.id_artista = a.id_artista
                                    LEFT JOIN usuarios u ON a.id_usuario = u.id_usuario
                                    LEFT JOIN albumes al ON n.id_album = al.id_album
                                    LEFT JOIN generos g ON al.id_genero = g.id_genero
                                    WHERE n.id_categoria_nominacion = :id_cat";
                        $stmt_nom = $conn->prepare($sql_nom);
                        $stmt_nom->bindParam(':id_cat', $id_cat);
                        $stmt_nom->execute();
                        $nominados = $stmt_nom->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <?php if (count($nominados) > 0): ?>
                            <?php foreach ($nominados as $nom): ?>
                                <?php 
                                    $esAlbum = !empty($nom['id_album']);
                                    $nombre = $esAlbum ? $nom['titulo_album'] : $nom['pseudonimo_artista'];
                                    $imgRaw = "";
                                    if (!empty($nom['imagen_artista'])) { $imgRaw = "../../../recursos/img/users/" . $nom['imagen_artista']; } 
                                    elseif (!empty($nom['imagen_album'])) { $imgRaw = "../../../recursos/img/albums/" . $nom['imagen_album']; } 
                                    else { $imgRaw = "../../../recursos/img/casete.png"; }
                                ?>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="single-album-area wow fadeInUp" data-wow-delay="100ms">
                                        <div class="album-thumb">
                                            <img src="<?= $imgRaw ?>" alt="<?= htmlspecialchars($nombre) ?>" style="height: 250px; object-fit: cover; width: 100%;">
                                        </div>
                                        <div class="album-info text-center mt-3">
                                            <h5><?= htmlspecialchars($nombre) ?></h5>
                                            <button type="button" class="btn oneMusic-btn btn-sm btn-dark mt-2" data-toggle="modal" data-target="#modalDetalle<?= $nom['id_nominacion'] ?>">Ver Detalles</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalDetalle<?= $nom['id_nominacion'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= htmlspecialchars($nombre) ?></h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-5"><img src="<?= $imgRaw ?>" class="img-fluid rounded mb-3" alt="Portada"></div>
                                                    <div class="col-md-7">
                                                        <?php if ($esAlbum): ?>
                                                            <p><strong>Género:</strong> <?= htmlspecialchars($nom['nombre_genero'] ?? 'N/A') ?></p>
                                                            <p><strong>Lanzamiento:</strong> <?= htmlspecialchars($nom['fecha_lanzamiento_album']) ?></p>
                                                            <p><strong>Descripción:</strong><br> <?= nl2br(htmlspecialchars($nom['descripcion_album'] ?? '')) ?></p>
                                                        <?php else: ?>
                                                            <p><strong>Nacionalidad:</strong> <?= htmlspecialchars($nom['nacionalidad_artista']) ?></p>
                                                            <p><strong>Biografía:</strong><br> <?= nl2br(htmlspecialchars($nom['biografia_artista'] ?? '')) ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12"><p class="text-center">Aún no hay nominados.</p></div>
                        <?php endif; ?>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info text-center">No hay categorías activas.</div>
            <?php endif; ?>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/plugins/plugins.js"></script>
    <script src="../../../recursos/recursos_portal/js/active.js"></script>
</body>
</html>