<?php
session_start();
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=Debes iniciar sesión&type=warning");
    exit();
}

$rol_usuario = isset($_SESSION['rol']) ? intval($_SESSION['rol']) : 0;
$puede_votar = ($rol_usuario === 4); 

require_once '../../config/Conecct.php';
$db = new Conecct();
$conn = $db->conecct;

$stmt_cat = $conn->prepare("SELECT * FROM categorias_nominaciones WHERE estatus_categoria_nominacion = 1");
$stmt_cat->execute();
$categorias = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MTV Awards | Votar</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style-votar.css">
    <style>
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
                                <li><a href="./nominaciones.php">Nominaciones</a></li>
                                <li class="active"><a href="./votar.php">Votar</a></li>
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

    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb.jpg);">
        <div class="bradcumbContent">
            <h2>Zona de Votación</h2>
            <p>Tu voto decide al ganador</p>
        </div>
    </section>

    <section class="oneMusic-buy-now-area mb-100 section-padding-100">
        <div class="container">
            <?php if (!$puede_votar): ?>
                <div class="alert alert-warning text-center mb-5">
                    <strong>Modo Visualización:</strong> Estás conectado como Administrador o Artista. No tienes permisos para votar.
                </div>
            <?php endif; ?>

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
                        $sql_nom = "SELECT n.id_nominacion, n.contador_nominacion, 
                                           a.pseudonimo_artista, a.biografia_artista, a.nacionalidad_artista,
                                           u.imagen_usuario as imagen_artista,
                                           al.titulo_album, al.imagen_album, al.descripcion_album, al.fecha_lanzamiento_album,
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
                                    $esAlbum = !empty($nom['titulo_album']);
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
                                            <p class="text-muted">Votos: <strong><?= $nom['contador_nominacion'] ?></strong></p>
                                            
                                            <div class="d-flex justify-content-center">
                                                <?php if ($puede_votar): ?>
                                                    <form action="../../backend/panel/procesar_votacion.php" method="POST" class="mr-2">
                                                        <input type="hidden" name="id_nominacion" value="<?= $nom['id_nominacion'] ?>">
                                                        <button type="submit" class="btn oneMusic-btn btn-sm">Votar</button>
                                                    </form>
                                                <?php else: ?>
                                                    <button type="button" class="btn oneMusic-btn btn-sm btn-disabled mr-2" disabled>Votar</button>
                                                <?php endif; ?>
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
    
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'voto_exitoso'): ?>
        <script>alert("¡Voto registrado!");</script>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'ya_votaste'): ?>
        <script>alert("¡Ya has votado en esta categoría!");</script>
    <?php endif; ?>
</body>
</html>