<?php
session_start();
if (!isset($_SESSION["is_logged"]) || isset($_SESSION["is_logged"]) == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
}
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
        /* Estilos del Modal */
        .modal-content { background-color: #1a1a1a; color: white; border: 1px solid #333; }
        .modal-header { border-bottom: 1px solid #333; }
        .modal-footer { border-top: 1px solid #333; }
        .close { color: white; text-shadow: none; opacity: 1; }
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
                                    <li class="active"><a href="./event.php">Eventos</a></li>
                                    <li><a href="./albums-store.php">Albums</a></li> <li><a href="./artistas.php">Artistas</a></li>
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

    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <p>Mira las novedades</p>
            <h2>Próximos Eventos</h2>
        </div>
    </section>

    <section class="events-area section-padding-100">
        <div class="container">
            <div class="row">
                <?php 
                $eventos = [
                    ["id" => 1, "titulo" => "Dj en Ibiza", "lugar" => "Space Ibiza", "fecha" => "Dec 4, 2025", "img" => "e1.jpg", "desc" => "La fiesta electrónica más grande del año llega a Ibiza. Prepárate para 12 horas de música ininterrumpida con los mejores DJs del mundo."],
                    ["id" => 2, "titulo" => "Festival de Rock", "lugar" => "Foro Sol", "fecha" => "Jan 15, 2026", "img" => "e2.jpg", "desc" => "Las bandas de rock más legendarias se reúnen en un solo escenario."],
                    ["id" => 3, "titulo" => "Noche de Jazz", "lugar" => "Blue Note", "fecha" => "Feb 10, 2026", "img" => "e3.jpg", "desc" => "Una velada íntima y sofisticada con los exponentes más destacados del Jazz contemporáneo."],
                    ["id" => 4, "titulo" => "Electro Fest", "lugar" => "Miami Beach", "fecha" => "Mar 22, 2026", "img" => "e4.jpg", "desc" => "Sol, playa y beats electrónicos. El festival que da la bienvenida a la primavera."],
                    ["id" => 5, "titulo" => "Pop World Tour", "lugar" => "Wembley", "fecha" => "Apr 05, 2026", "img" => "e5.jpg", "desc" => "El ícono del pop mundial llega a Londres para presentar su nuevo álbum."],
                    ["id" => 6, "titulo" => "Indie Sessions", "lugar" => "The Roxy", "fecha" => "May 12, 2026", "img" => "e6.jpg", "desc" => "Descubre las bandas emergentes que están cambiando la escena musical."],
                ];
                
                foreach ($eventos as $evento): 
                ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-event-area mb-30">
                        <div class="event-thumbnail">
                            <img src="../../../recursos/recursos_portal/img/bg-img/<?= $evento['img'] ?>" alt="">
                        </div>
                        <div class="event-text">
                            <h4><?= $evento['titulo'] ?></h4>
                            <div class="event-meta-data">
                                <a href="#" class="event-place"><?= $evento['lugar'] ?></a>
                                <a href="#" class="event-date"><?= $evento['fecha'] ?></a>
                            </div>
                            <button type="button" class="btn oneMusic-btn btn-2 m-2" data-toggle="modal" data-target="#modalEvento<?= $evento['id'] ?>">
                                Ver Detalles
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalEvento<?= $evento['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tituloEvento<?= $evento['id'] ?>"><?= $evento['titulo'] ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="../../../recursos/recursos_portal/img/bg-img/<?= $evento['img'] ?>" class="img-fluid rounded mb-3" style="max-height: 200px; width: auto; display: block; margin: 0 auto;" alt="">
                                <p><strong>Lugar:</strong> <?= $evento['lugar'] ?></p>
                                <p><strong>Fecha:</strong> <?= $evento['fecha'] ?></p>
                                <p class="mt-3"><?= $evento['desc'] ?></p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn oneMusic-btn btn-sm">Comprar Boletos</button>
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
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-12 col-md-6">
                    <a href="./dashboard.php"><img src="../../../recursos/img/system/mtv-logo-blanco.png" width="15%" alt=""></a>
                </div>
                <div class="col-12 col-md-6">
                    <div class="footer-nav">
                        <ul>
                            <li><a href="./index.php">Inicio</a></li>
                            <li><a href="./event.php">Eventos</a></li>
                            <li><a href="./albums-store.php">Albums</a></li> <li><a href="./artistas.php">Artistas</a></li>
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