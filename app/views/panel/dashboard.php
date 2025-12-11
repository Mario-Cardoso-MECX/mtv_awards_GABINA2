<?php
//Importar librerias
require_once '../../helpers/menu_lateral.php';
require_once '../../helpers/funciones_globales.php';

//Reintancias la variable
session_start();

if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTV | Awards - Dashboard</title>

    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="./dashboard.php" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../backend/panel/liberate_user.php" class="nav-link">Cerrar Sesión</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../views/portal/event.php" class="nav-link">Eventos</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../views/portal/albums-store.php" class="nav-link">Generos</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../views/portal/artistas.php" class="nav-link">Artistas</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../views/portal/votar.php" class="nav-link">Votar</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../backend/panel/liberate_user.php" role="button" data-toggle="tooltip"
                        data-placement="top" title="Cerrar Sesión">
                        <i class="fa fa-window-close"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="./dashboard.php" class="brand-link">
                <img src="../../../recursos/img/system/mtv-logo.jpg" alt="MTV Logo" class="brand-image elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">MTV Awards</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../../recursos/img/users/<?= $_SESSION["img"] ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $_SESSION["nickname"] ?></a>
                    </div>
                </div>

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="¿Qué deseas buscar?" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?= mostrar_menu_lateral("DASHBOARD") ?>
                    </ul>
                </nav>
                </div>
            </aside>

        <div class="content-wrapper">
            <?php
            $breadcrumb = array(
                array(
                    'tarea' => 'Dashboard',
                    'href' => '#'
                )
            );
            echo mostrar_breadcrumb('Dashboard', $breadcrumb);
            ?>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">MTV AWARDS</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        "Celebra el ritmo que hace vibrar al mundo."
                    </div>
                    <div class="card-footer">
                        MTV Awards Panel de Administración.
                    </div>
                    </div>
                </section>
            </div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> Gabriela
            </div>
            <strong>Copyright &copy; 2025.</strong> Todos los derechos reservados.
        </footer>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <?php if (isset($_SESSION['message'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Aseguramos que Toastr esté configurado (opcional)
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right"
            };

            <?=
                mostrar_alerta_mensaje(
                    $_SESSION['message']["type"],
                    $_SESSION['message']["description"],
                    $_SESSION['message']["title"]
                );
            ?>
        });
    </script>
    <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

</body>
</html>