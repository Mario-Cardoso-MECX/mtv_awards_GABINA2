<?php 
session_start();
// Importar configuraciones y helpers
require_once '../../config/Conecct.php';
require_once '../../helpers/menu_lateral.php';
require_once '../../helpers/funciones_globales.php';

// Validar sesión
if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit;
}

// 1. Crear la instancia de la conexión (ESTO FALTABA)
$db = new Conecct();
$conexion = $db->conecct;

// 2. Obtener listas usando PDO
$artistas = $conexion->query("SELECT id_artista, pseudonimo_artista FROM artistas WHERE estatus_artista = 1");
$albumes = $conexion->query("SELECT id_album, titulo_album FROM albumes WHERE estatus_album = 1");
$categorias = $conexion->query("SELECT * FROM categorias_nominaciones WHERE estatus_categoria_nominacion = 1");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTV | Nueva Nominación</title>
    
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
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="./dashboard.php" class="brand-link">
                <img src="../../../recursos/img/system/mtv-logo.jpg" alt="Logo" class="brand-image elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">MTV Awards</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image"><img src="../../../recursos/img/users/<?= $_SESSION["img"] ?>" class="img-circle elevation-2" alt="User"></div>
                    <div class="info"><a href="#" class="d-block"><?= $_SESSION["nickname"] ?></a></div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <?= mostrar_menu_lateral("NOMINACIONES") ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6"><h1>Nominaciones</h1></div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Registrar Nueva Nominación</h3>
                        </div>
                        
                        <form action="../../backend/panel/nominaciones/create_nominacion.php" method="POST">
                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label>Categoría</label>
                                    <select name="id_categoria" class="form-control" required>
                                        <option value="">Seleccione una categoría...</option>
                                        <?php while($c = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                                            <option value="<?= $c['id_categoria_nominacion'] ?>">
                                                <?= $c['nombre_categoria_nominacion'] ?> 
                                                (Tipo: <?= ($c['tipo_categoria_nominacion'] == 1)?'Artista':'Álbum' ?>)
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="alert alert-info">
                                    <i class="icon fas fa-info"></i> Nota: Seleccione <b>solo una opción</b> abajo (Artista O Álbum) dependiendo del tipo de categoría.
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Artista (Para categorías de Artista)</label>
                                            <select name="id_artista" class="form-control">
                                                <option value="">-- Ninguno --</option>
                                                <?php while($a = $artistas->fetch(PDO::FETCH_ASSOC)): ?>
                                                    <option value="<?= $a['id_artista'] ?>"><?= $a['pseudonimo_artista'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Álbum (Para categorías de Álbum)</label>
                                            <select name="id_album" class="form-control">
                                                <option value="">-- Ninguno --</option>
                                                <?php while($al = $albumes->fetch(PDO::FETCH_ASSOC)): ?>
                                                    <option value="<?= $al['id_album'] ?>"><?= $al['titulo_album'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Crear Nominación</button>
                                <a href="nominaciones.php" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block"><b>Version</b> 3.2.0</div>
            <strong>Copyright &copy; 2025.</strong>
        </footer>
    </div>

    <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../recursos/recursos_panel/js/adminlte.min.js"></script>
</body>
</html>