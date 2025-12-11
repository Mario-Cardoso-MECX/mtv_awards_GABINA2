<?php
session_start();
require_once '../../config/Conecct.php';

// Validar Sesión (Opcional, si quieres que sea público quita esto)
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=Debes iniciar sesión&type=warning");
    exit();
}

$db = new Conecct();
$conn = $db->conecct;

// 1. Obtener EL ARTISTA más votado
$sql_top_artista = "SELECT a.pseudonimo_artista, u.imagen_usuario, n.contador_nominacion, c.nombre_categoria_nominacion
                    FROM nominaciones n
                    INNER JOIN artistas a ON n.id_artista = a.id_artista
                    INNER JOIN usuarios u ON a.id_usuario = u.id_usuario
                    INNER JOIN categorias_nominaciones c ON n.id_categoria_nominacion = c.id_categoria_nominacion
                    ORDER BY n.contador_nominacion DESC LIMIT 1";
$stmt_art = $conn->prepare($sql_top_artista);
$stmt_art->execute();
$topArtista = $stmt_art->fetch(PDO::FETCH_ASSOC);

// 2. Obtener EL ÁLBUM más votado
$sql_top_album = "SELECT al.titulo_album, al.imagen_album, n.contador_nominacion, c.nombre_categoria_nominacion, a.pseudonimo_artista
                  FROM nominaciones n
                  INNER JOIN albumes al ON n.id_album = al.id_album
                  INNER JOIN artistas a ON n.id_artista = a.id_artista
                  INNER JOIN categorias_nominaciones c ON n.id_categoria_nominacion = c.id_categoria_nominacion
                  ORDER BY n.contador_nominacion DESC LIMIT 1";
$stmt_alb = $conn->prepare($sql_top_album);
$stmt_alb->execute();
$topAlbum = $stmt_alb->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados | Lo Más Top</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
    <style>
        /* Estilo para la línea naranjita (menú activo) */
        .classynav ul li.active a { color: #fbb710 !important; }

        .winner-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .winner-card:hover { transform: translateY(-10px); }
        .winner-img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            border: 5px solid #fbb710;
        }
        .album-img { border-radius: 10px; }
        .vote-badge {
            background-color: #fbb710;
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }
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
                                <li><a href="./votar.php">Votar</a></li>
                                <li class="active"><a href="./resultados.php">Resultados</a></li>
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
            <h2>Ganadores del Momento</h2>
            <p>Los favoritos de la audiencia en tiempo real</p>
        </div>
    </section>

    <section class="section-padding-100">
        <div class="container">
            <div class="row">
                
                <div class="col-12 col-md-6">
                    <div class="winner-card mb-5">
                        <h3 class="text-uppercase mb-4">👑 Artista Más Votado</h3>
                        <?php if ($topArtista): ?>
                            <img src="../../../recursos/img/users/<?= !empty($topArtista['imagen_usuario']) ? $topArtista['imagen_usuario'] : 'user.png' ?>" class="winner-img" alt="">
                            <h2><?= htmlspecialchars($topArtista['pseudonimo_artista']) ?></h2>
                            <p class="text-muted">Nominado en: <?= htmlspecialchars($topArtista['nombre_categoria_nominacion']) ?></p>
                            <div class="vote-badge"><?= $topArtista['contador_nominacion'] ?> Votos</div>
                        <?php else: ?>
                            <p>Aún no hay votos registrados.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="winner-card mb-5">
                        <h3 class="text-uppercase mb-4">💿 Álbum Más Votado</h3>
                        <?php if ($topAlbum): ?>
                            <img src="../../../recursos/img/albums/<?= !empty($topAlbum['imagen_album']) ? $topAlbum['imagen_album'] : 'casete.png' ?>" class="winner-img album-img" alt="">
                            <h2><?= htmlspecialchars($topAlbum['titulo_album']) ?></h2>
                            <p>De: <strong><?= htmlspecialchars($topAlbum['pseudonimo_artista']) ?></strong></p>
                            <p class="text-muted">Nominado en: <?= htmlspecialchars($topAlbum['nombre_categoria_nominacion']) ?></p>
                            <div class="vote-badge"><?= $topAlbum['contador_nominacion'] ?> Votos</div>
                        <?php else: ?>
                            <p>Aún no hay votos registrados.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            
            <div class="row mt-5 text-center">
                <div class="col-12">
                    <h3>¿No estás de acuerdo?</h3>
                    <a href="votar.php" class="btn oneMusic-btn mt-3">Ir a Votar y Cambiar la Historia</a>
                </div>
            </div>

        </div>
    </section>

    <footer class="footer-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <img src="../../../recursos/img/system/mtv-logo-blanco.png" width="100" alt="">
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