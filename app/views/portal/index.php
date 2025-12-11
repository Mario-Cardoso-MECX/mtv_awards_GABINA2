<?php
//Importar Modelo
require_once '../../models/Tabla_usuarios.php';
require_once '../../models/Tabla_artista.php';
require_once '../../models/Tabla_albumes.php';
require_once '../../helpers/funciones_globales.php';

//instanciar modelo artista
$tabla_artista = new Tabla_artista();
$artistas = $tabla_artista->readAllArtists();
$interpretes = $tabla_artista->getAllAlbumDetails();

//instanciar modelo albumes
$tabla_album = new Tabla_albumes();
$albums = $tabla_album->readAllAlbumsG();

//Reintancias la variable
session_start();

//Instancia del Objeto
$tabla_usuarios = new Tabla_usuarios();
$usuarios = $tabla_usuarios->readAllUsers();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MTV | awards</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">
    <style>
        .classynav ul li.active a { color: #fbb710 !important; }
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
                                    <li class="active"><a href="./index.php">Inicio</a></li>
                                    <li><a href="./event.php">Eventos</a></li>
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
                                                    <a class="dropdown-item text-dark" href="./miPerfil.php?id=<?php echo $_SESSION['id_usuario']; ?>">Mi perfil</a>
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

    <section class="hero-area">
        <div class="hero-slides owl-carousel">
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <div class="slide-img bg-img" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/bg-1.jpg);"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h6 data-animation="fadeInUp" data-delay="100ms">Participa ahora</h6>
                                <h2 data-animation="fadeInUp" data-delay="300ms">Vota por tu álbum favorito <span>¡Haz tu elección!</span></h2>
                                <a data-animation="fadeInUp" data-delay="500ms" href="./votar.php" class="btn oneMusic-btn mt-50">Vota por tu artista <i class="fa fa-angle-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <div class="slide-img bg-img" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/bg-2.jpg);"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h6 data-animation="fadeInUp" data-delay="100ms">Descubre al mejor</h6>
                                <h2 data-animation="fadeInUp" data-delay="300ms">El artista más escuchado<span>¡No te lo pierdas!</span></h2>
                                <a data-animation="fadeInUp" data-delay="500ms" href="./artistas.php" class="btn oneMusic-btn mt-50">Ver artistas <i class="fa fa-angle-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="latest-albums-area section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading style-2">
                        <p>Descubre la música</p>
                        <h2>Artistas y sus géneros</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">
                    <div class="ablums-text text-center mb-70">
                        <p>Explora nuestra amplia colección de artistas, desde las icónicas leyendas del rock hasta las voces emergentes del pop y el indie. Cada género tiene una historia única que contar.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="albums-slideshow owl-carousel">
                        <?php foreach ($artistas as $artista): ?>
                            <div class="single-album">
                                <img src="../../img/bg-img/a7.jpg" alt="">
                                <div class="album-info">
                                    <a href="#"><h5><?= $artista->pseudonimo_artista ?></h5></a>
                                    <p><?= $artista->nombre_genero ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="oneMusic-buy-now-area has-fluid bg-gray section-padding-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading style-2">
                        <p>Explora lo mejor</p>
                        <h2>Álbumes destacados</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($albums as $album): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="single-album-area wow fadeInUp" data-wow-delay="300ms">
                            <div class="album-thumb"><img src="../../img/bg-img/b3.jpg" alt=""></div>
                            <div class="album-info"><a href="#"><h5><?= $album->titulo_album ?></h5></a></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="load-more-btn text-center wow fadeInUp" data-wow-delay="300ms">
                        <a href="./albums-store.php" class="btn oneMusic-btn">Ver Albums <i class="fa fa-angle-double-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="miscellaneous-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <?php
                $contador = 0;
                foreach ($interpretes as $interprete):
                    if ($contador >= 4) break;
                    $contador++;
                    ?>
                    <div class="col-12 col-lg-4">
                        <div class="new-hits-area mb-100">
                            <div class="section-heading text-left mb-50 wow fadeInUp" data-wow-delay="50ms">
                                <p><?= htmlspecialchars($interprete['Artista']) ?></p>
                                <h2><?= htmlspecialchars($interprete['Album']) ?></h2>
                            </div>
                            <?php foreach ($interprete['Canciones'] as $cancion): ?>
                                <div class="single-new-item d-flex align-items-center justify-content-between wow fadeInUp" data-wow-delay="250ms">
                                    <div class="first-part d-flex align-items-center">
                                        <div class="thumbnail"><img src="../../../recursos/img/musica.png" alt="img"></div>
                                        <div class="content-">
                                            <h6><?= htmlspecialchars($cancion['nombre_cancion']) ?></h6>
                                            <p><?= htmlspecialchars($interprete['Album']) ?></p>
                                        </div>
                                    </div>
                                    <audio preload="auto" controls>
                                        <source src="<?= '../../../recursos/audio/' . $cancion['mp3_cancion'] ?>">
                                    </audio>
                                </div>
                            <?php endforeach; ?>
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