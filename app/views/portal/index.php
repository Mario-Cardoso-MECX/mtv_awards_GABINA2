<?php
session_start();
// Importar Modelos y lógica inicial si es necesaria
require_once '../../models/Tabla_usuarios.php';
require_once '../../models/Tabla_artista.php';
require_once '../../models/Tabla_albumes.php';
require_once '../../helpers/funciones_globales.php';

//instanciar modelo artista
$tabla_artista = new Tabla_artista();
$artistas = $tabla_artista->readAllArtists();
// ... resto de tu lógica PHP del index original ...
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MTV Awards | Inicio</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
    <style> .classynav ul li.active a { color: #fbb710 !important; } </style>
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
                                    <li class="active"><a href="./index.php">Inicio</a></li>
                                    <li><a href="./event.php">Eventos</a></li>
                                    <li><a href="./albums-store.php">Géneros</a></li>
                                    <li><a href="./artistas.php">Artistas</a></li>
                                    <li><a href="./nominaciones.php">Nominaciones</a></li>
                                    <li><a href="./votar.php">Votar</a></li>
                                    <li><a href="./resultados.php">Resultados</a></li>
                                </ul>
                                <div class="login-register-cart-button d-flex align-items-center">
                                    <div class="login-register-btn mr-50">
                                        <?php if (isset($_SESSION["nickname"])): ?>
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
                                        <?php else: ?>
                                            <a href="../../../index.php">Iniciar sesión</a>
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

    <section class="hero-area">
        <div class="hero-slides owl-carousel">
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <div class="slide-img bg-img" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/bg-1.jpg);"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h6 data-animation="fadeInUp" data-delay="100ms">MTV Awards</h6>
                                <h2 data-animation="fadeInUp" data-delay="300ms">Música que inspira <span>Música que inspira</span></h2>
                                <a data-animation="fadeInUp" data-delay="500ms" href="./votar.php" class="btn oneMusic-btn mt-50">Votar Ahora <i class="fa fa-angle-double-right"></i></a>
                            </div>
                        </div>
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