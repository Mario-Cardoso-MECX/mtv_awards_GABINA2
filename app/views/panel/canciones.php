<?php
session_start();

// Validar Sesión
if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit;
}

// 1. IMPORTAR MODELOS
require_once '../../models/Tabla_canciones.php';
require_once '../../models/Tabla_artista.php';

// 2. LÓGICA DE MENÚ INTELIGENTE
// Usamos 'rol' igual que en el login
if (isset($_SESSION['rol']) && $_SESSION['rol'] == 85) { 
    require_once '../../helpers/menu_lateral_artista.php';
} else {
    require_once '../../helpers/menu_lateral.php';
}

require_once '../../helpers/funciones_globales.php';

// Instancias
$tabla_canciones = new Tabla_canciones();
$tabla_artista = new Tabla_artista();

// Obtener artista del usuario logueado
$id_usuario = $_SESSION['id_usuario'];
$artista = $tabla_artista->getArtistaByUsuario($id_usuario);

// Evita errores si no existe relación (por ejemplo si es Admin)
$id_artista = ($artista) ? $artista->id_artista : 0;

// Obtener canciones: Si es artista (id > 0), muestra las suyas. Si es Admin (0), muestra vacio o todas.
if ($id_artista > 0) {
    $canciones = $tabla_canciones->readAllByArtista($id_artista);
} else {
    $canciones = []; // O todas las canciones si tienes un método para admin
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTV | awards</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
                <li class="nav-item d-none d-sm-inline-block"><a href="./dashboard.php" class="nav-link">Inicio</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="../../backend/panel/liberate_user.php"><i class="fa fa-window-close"></i></a></li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="../../index3.html" class="brand-link">
                <img src="../../../recursos/img/system/mtv-logo.jpg" alt="Logo" class="brand-image elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">MTV Awards</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image"><img src="../../../recursos/img/users/<?= $_SESSION["img"] ?>" class="img-circle elevation-2"></div>
                    <div class="info"><a href="#" class="d-block"><?= $_SESSION["nickname"] ?></a></div>
                </div>
                
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="¿Qué deseas buscar?" aria-label="Search">
                        <div class="input-group-append"><button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button></div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?= isset($_SESSION['rol']) && $_SESSION['rol'] == 85 ? mostrar_menu_lateral("CANCIONES") : mostrar_menu_lateral("CANCIONES") ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <?php
            $breadcrumb = array(array('tarea' => 'Canciones', 'href' => '#'));
            echo mostrar_breadcrumb_art('Canciones', $breadcrumb);
            ?>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <a href="./cancion_nueva.php" class="btn btn-block btn-dark"><i class="fa fa-plus-circle"></i> Agregar</a>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header text-center"><h3 class="card-title">Lista de Canciones</h3></div>
                            <div class="card-body">
                                <table id="table-canciones" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>URL</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (empty($canciones)) {
                                            echo '<tr><td colspan="5" class="text-center">No hay canciones disponibles.</td></tr>';
                                        } else {
                                            $count = 0;
                                            foreach ($canciones as $cancion) {
                                                echo '<tr>
                                                    <td>' . ++$count . '</td>
                                                    <td>' . $cancion->nombre_cancion . '</td>
                                                    <td><a href="' . $cancion->url_cancion . '" target="_blank" class="btn btn-sm btn-primary">Enlace</a></td>';
                                                
                                                echo ($cancion->estatus_cancion == 0)
                                                    ? '<td><a href="../../backend/panel/canciones/estatus_cancion.php?id=' . $cancion->id_acancion . '&estatus=1" class="btn btn-block btn-info">Habilitar</a></td>'
                                                    : '<td><a href="../../backend/panel/canciones/estatus_cancion.php?id=' . $cancion->id_acancion . '&estatus=0" class="btn btn-block btn-outline-success">Deshabilitar</a></td>';
                                                
                                                echo '<td>
                                                        <a href="../../backend/panel/canciones/delete_cancion.php?id=' . $cancion->id_acancion . '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                                        <a href="./cancion_detalles.php?id=' . $cancion->id_acancion . '" class="btn btn-warning btn-xs text-white"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer class="main-footer"><div class="float-right d-none d-sm-block"><b>Version</b> 3.2.0</div><strong>Copyright &copy;</strong></footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <?php if (isset($_SESSION['message'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                <?= mostrar_alerta_mensaje($_SESSION['message']["type"], $_SESSION['message']["description"], $_SESSION['message']["title"]); ?>
            });
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</body>
</html>