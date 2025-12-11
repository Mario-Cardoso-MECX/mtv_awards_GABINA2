<?php 
session_start();
require_once '../../config/Conecct.php';
require_once '../../helpers/menu_lateral.php';
require_once '../../helpers/funciones_globales.php';

if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit;
}

$db = new Conecct();
$conexion = $db->conecct;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTV Awards | Nominaciones</title>
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
                        <input class="form-control form-control-sidebar" type="search" placeholder="Buscar..." aria-label="Search">
                        <div class="input-group-append"><button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button></div>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?= mostrar_menu_lateral("NOMINACIONES") ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Nominaciones Activas</h1></div></div></div>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <a href="nominacion_nueva.php" class="btn btn-success"><i class="fas fa-plus"></i> Nueva Nominación</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Categoría</th>
                                    <th>Nominado</th>
                                    <th>Votos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta limpia usando las nuevas columnas
                                $sql = "SELECT n.*, c.nombre_categoria_nominacion, a.pseudonimo_artista, al.titulo_album 
                                        FROM nominaciones n
                                        LEFT JOIN categorias_nominaciones c ON n.id_categoria_nominacion = c.id_categoria_nominacion
                                        LEFT JOIN artistas a ON n.id_artista = a.id_artista
                                        LEFT JOIN albumes al ON n.id_album = al.id_album";
                                
                                $stmt = $conexion->prepare($sql);
                                $stmt->execute();
                                
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $nominado = !empty($row['pseudonimo_artista']) ? $row['pseudonimo_artista'] : $row['titulo_album'];
                                    
                                    echo "<tr>
                                        <td>{$row['nombre_categoria_nominacion']}</td>
                                        <td>{$nominado}</td>
                                        <td><span class='badge badge-primary' style='font-size:1rem'>{$row['contador_nominacion']}</span></td>
                                        <td>
                                            <a href='nominacion_detalles.php?id={$row['id_nominacion']}' class='btn btn-info btn-sm'><i class='fas fa-edit'></i></a>
                                            <a href='../../backend/panel/nominaciones/delete_nominacion.php?id={$row['id_nominacion']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Borrar?\")'><i class='fas fa-trash'></i></a>
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