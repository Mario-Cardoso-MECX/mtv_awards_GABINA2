<?php 
// 1. Importaciones
session_start();
require_once '../../config/Conecct.php';
require_once '../../helpers/menu_lateral.php';
require_once '../../helpers/funciones_globales.php';

// 2. Validar Sesión
if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit;
}

// 3. Instanciar Conexión
$db = new Conecct();
$conexion = $db->conecct;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTV Awards | Categorías</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
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
                        <?= mostrar_menu_lateral("CATEGORIAS") ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2"><div class="col-sm-6"><h1>Gestión de Categorías</h1></div></div>
                </div>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <a href="categoria_nueva.php" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Nueva Categoría</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM categorias_nominaciones";
                                $stmt = $conexion->prepare($sql);
                                $stmt->execute();
                                
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    // Lógica para mostrar el texto del tipo
                                    $tipoTexto = 'Desconocido';
                                    switch($row['tipo_categoria_nominacion']) {
                                        case 1: $tipoTexto = '<span class="badge badge-info">Artista</span>'; break;
                                        case 2: $tipoTexto = '<span class="badge badge-warning">Álbum</span>'; break;
                                        case 3: $tipoTexto = '<span class="badge badge-success">Canción</span>'; break;
                                    }

                                    echo "<tr>
                                        <td>{$row['id_categoria_nominacion']}</td>
                                        <td>{$row['nombre_categoria_nominacion']}</td>
                                        <td>{$tipoTexto}</td>
                                        <td>
                                            <a href='categoria_detalles.php?id={$row['id_categoria_nominacion']}' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></a>
                                            <a href='../../backend/panel/categorias/delete_categoria.php?id={$row['id_categoria_nominacion']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Eliminar?\")'><i class='fas fa-trash'></i></a>
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <footer class="main-footer"><div class="float-right d-none d-sm-block"><b>Version</b> 3.2.0</div><strong>Copyright &copy; 2025.</strong></footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>