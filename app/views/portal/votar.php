<?php
session_start();
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=Debes iniciar sesión&type=warning");
    exit();
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <header class="header-area">
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">
                        <a href="./index.php" class="nav-brand"><img src="../../../recursos/img/system/mtv-logo-blanco.png" width="50%" alt=""></a>
                        <div class="classy-menu">
                            <div class="classynav">
                                <ul>
                                    <li><a href="./index.php">Inicio</a></li>
                                    <li><a href="./votar.php">Votar</a></li>
                                    <li><a href="../../backend/panel/liberate_user.php">Salir</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb.jpg);">
        <div class="bradcumbContent">
            <h2>Votaciones Abiertas</h2>
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
                                <p><?= htmlspecialchars($cat['descripcion_categoria_nominacion'] ?? '') ?></p>
                            </div>
                        </div>

                        <?php 
                        $id_cat = $cat['id_categoria_nominacion'];
                        // CORRECCIÓN SQL: JOIN con usuarios para sacar imagen de artista
                        $sql_nom = "SELECT n.id_nominacion, n.contador_nominacion, 
                                           a.pseudonimo_artista, 
                                           u.imagen_usuario as imagen_artista,
                                           al.titulo_album, al.imagen_album
                                    FROM nominaciones n
                                    LEFT JOIN artistas a ON n.id_artista = a.id_artista
                                    LEFT JOIN usuarios u ON a.id_usuario = u.id_usuario
                                    LEFT JOIN albumes al ON n.id_album = al.id_album
                                    WHERE n.id_categoria_nominacion = :id_cat";
                        $stmt_nom = $conn->prepare($sql_nom);
                        $stmt_nom->bindParam(':id_cat', $id_cat);
                        $stmt_nom->execute();
                        $nominados = $stmt_nom->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <?php if (count($nominados) > 0): ?>
                            <?php foreach ($nominados as $nom): ?>
                                <?php 
                                    $nombre = !empty($nom['pseudonimo_artista']) ? $nom['pseudonimo_artista'] : $nom['titulo_album'];
                                    
                                    $imgRaw = "";
                                    if (!empty($nom['imagen_artista'])) {
                                        $imgRaw = "../../../recursos/img/users/" . $nom['imagen_artista'];
                                    } elseif (!empty($nom['imagen_album'])) {
                                        $imgRaw = "../../../recursos/img/albums/" . $nom['imagen_album'];
                                    } else {
                                        $imgRaw = "../../../recursos/img/casete.png";
                                    }
                                ?>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="single-album-area">
                                        <div class="album-thumb">
                                            <img src="<?= $imgRaw ?>" alt="<?= htmlspecialchars($nombre) ?>" style="height: 250px; object-fit: cover; width: 100%;">
                                        </div>
                                        <div class="album-info text-center mt-3">
                                            <h5><?= htmlspecialchars($nombre) ?></h5>
                                            <p>Votos: <strong><?= $nom['contador_nominacion'] ?></strong></p>
                                            <form action="../../backend/panel/procesar_votacion.php" method="POST">
                                                <input type="hidden" name="id_nominacion" value="<?= $nom['id_nominacion'] ?>">
                                                <button type="submit" class="btn oneMusic-btn mt-2">Votar</button>
                                            </form>
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
                <div class="alert alert-info text-center">No hay votaciones activas.</div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <img src="../../../recursos/img/system/mtv-logo-blanco.png" width="100" alt="">
                </div>
            </div>
        </div>
    </footer>

    <script src="../../../recursos/recursos_portal/js/jquery/jquery-2.2.4.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/bootstrap/bootstrap.min.js"></script>
    <script src="../../../recursos/recursos_portal/js/plugins/plugins.js"></script>
    <script src="../../../recursos/recursos_portal/js/active.js"></script>
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'voto_exitoso'): ?>
        <script>alert("¡Voto registrado!");</script>
    <?php endif; ?>
</body>
</html>