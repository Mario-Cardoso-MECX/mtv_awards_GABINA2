<?php
session_start();
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit();
}

require_once '../../config/Conecct.php'; // Para consultas del modal
require_once '../../models/Tabla_artista.php';

$db = new Conecct();
$conn = $db->conecct;

$tabla_artista = new Tabla_artista();
$artistas = $tabla_artista->readAllArtists();
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
                                    <li><a href="./event.php">Eventos</a></li>
                                    <li><a href="./albums-store.php">Albums</a></li>
                                    <li class="active"><a href="./artistas.php">Artistas</a></li> <li><a href="./votar.php">Votar</a></li>
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

    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <h2>Artistas</h2>
            <p>Conoce a los nominados</p>
        </div>
    </section>

    <section class="events-area section-padding-100">
        <div class="container">
            <div class="row">
                <?php foreach ($artistas as $artista): ?>
                    <?php
                        // Consultar foto real de usuario para el modal
                        $stmt_u = $conn->prepare("SELECT imagen_usuario FROM usuarios WHERE id_usuario = :id");
                        $stmt_u->bindParam(':id', $artista->id_usuario);
                        $stmt_u->execute();
                        $user_data = $stmt_u->fetch(PDO::FETCH_ASSOC);
                        $imgUser = !empty($user_data['imagen_usuario']) ? "../../../recursos/img/users/" . $user_data['imagen_usuario'] : "../../../recursos/img/users/user.png";
                    ?>

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="single-event-area mb-30">
                            <div class="event-thumbnail">
                                <img src="../../../recursos/img/bg-img/a8.jpg" alt="">
                            </div>
                            <div class="event-text">
                                <h4><?= htmlspecialchars($artista->pseudonimo_artista) ?></h4>
                                <div class="event-meta-data">
                                    <a href="#" class="event-place"><?= htmlspecialchars($artista->nacionalidad_artista) ?></a>
                                    <a href="#" class="event-date"><?= htmlspecialchars($artista->nombre_genero) ?></a>
                                </div>
                                <button type="button" class="btn oneMusic-btn btn-2 m-2" data-toggle="modal" data-target="#modalArtista<?= $artista->id_artista ?>">
                                    Ver Detalles
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalArtista<?= $artista->id_artista ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?= htmlspecialchars($artista->pseudonimo_artista) ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-3">
                                        <img src="<?= $imgUser ?>" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                    <p><strong>Nacionalidad:</strong> <?= htmlspecialchars($artista->nacionalidad_artista) ?></p>
                                    <p><strong>Género:</strong> <?= htmlspecialchars($artista->nombre_genero) ?></p>
                                    <p class="mt-3"><strong>Biografía:</strong></p>
                                    <p><?= nl2br(htmlspecialchars($artista->biografia_artista)) ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <a href="votar.php" class="btn oneMusic-btn btn-sm">Votar por él</a>
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