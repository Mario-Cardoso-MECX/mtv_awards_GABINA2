<?php
session_start();
// Ajusta la ruta según tu estructura de carpetas real si es necesario
require_once '../../config/Constants.php';
require_once '../../config/Conecct.php'; 

// Verificar sesión
if (!isset($_SESSION['is_logged']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../../index.php");
    exit;
}

// Consulta con JOINS para traer los nombres en lugar de solo IDs
$sql = "SELECT 
            n.id_nominacion, 
            n.fecha_nominacion,
            c.nombre_categoria_nominacion,
            a.pseudonimo_artista,
            al.titulo_album
        FROM nominaciones n
        LEFT JOIN categorias_nominaciones c ON n.id_categoria_nominacion = c.id_categoria_nominacion
        LEFT JOIN artistas a ON n.id_artista = a.id_artista
        LEFT JOIN albumes al ON n.id_album = al.id_album
        ORDER BY n.id_nominacion DESC";

$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo - Nominaciones</title>
    <?php require_once('../../helpers/header_panel.php'); // Asumo que tienes un header o incluye los css manuales ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    
    <?php require_once('../../helpers/menu_lateral.php'); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión de Nominaciones</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="nominacion_nueva.php" class="btn btn-primary float-sm-right">
                            <i class="fas fa-plus"></i> Nueva Nominación
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Listado de Nominados</h3>
                            </div>
                            <div class="card-body">
                                <table id="tabla_nominaciones" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Categoría</th>
                                            <th>Artista</th>
                                            <th>Álbum (Opcional)</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id_nominacion']; ?></td>
                                            <td><?php echo $row['nombre_categoria_nominacion']; ?></td>
                                            <td><?php echo $row['pseudonimo_artista'] ? $row['pseudonimo_artista'] : 'N/A'; ?></td>
                                            <td><?php echo $row['titulo_album'] ? $row['titulo_album'] : 'N/A'; ?></td>
                                            <td><?php echo $row['fecha_nominacion']; ?></td>
                                            <td>
                                                <a href="nominacion_detalles.php?id=<?php echo $row['id_nominacion']; ?>" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                <a href="../../backend/panel/nominaciones/delete_nominacion.php?id=<?php echo $row['id_nominacion']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta nominación?');"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php require_once('../../helpers/footer_panel.php'); // O los scripts de cierre ?>
</div>
</body>
</html>