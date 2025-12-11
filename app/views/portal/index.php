<?php
session_start();
// (Mantén tus requires iniciales si los tienes, aquí pongo lo esencial del header)
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

    <section class="hero-area">
        <div class="hero-slides owl-carousel">
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <div class="slide-img bg-img" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/bg-1.jpg);"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h6>MTV Awards</h6>
                                <h2>Música que inspira</h2>
                                <a href="./votar.php" class="btn oneMusic-btn mt-50">Votar Ahora <i class="fa fa-angle-double-right"></i></a>
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