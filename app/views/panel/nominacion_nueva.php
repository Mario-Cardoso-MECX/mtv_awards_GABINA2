<?php
session_start();
require_once '../../config/Conecct.php'; // Apuntando al archivo correcto

// Obtener Categorías
$categorias = $conexion->query("SELECT * FROM categorias_nominaciones WHERE estatus_categoria_nominacion = 1");
// Obtener Artistas
$artistas = $conexion->query("SELECT * FROM artistas WHERE estatus_artista = 1");
// Obtener Albumes
$albumes = $conexion->query("SELECT * FROM albumes WHERE estatus_album = 1");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Nominación</title>
    </head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php require_once('../../helpers/menu_lateral.php'); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Registrar Nominación</h1>
        </section>

        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Datos de la Nominación</h3>
                </div>
                <form action="../../backend/panel/nominaciones/create_nominacion.php" method="POST">
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label>Categoría</label>
                            <select name="id_categoria" class="form-control" required>
                                <option value="">Seleccione una categoría...</option>
                                <?php while($cat = $categorias->fetch_assoc()): ?>
                                    <option value="<?php echo $cat['id_categoria_nominacion']; ?>">
                                        <?php echo $cat['nombre_categoria_nominacion']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Artista (Opcional si es por Álbum)</label>
                            <select name="id_artista" class="form-control">
                                <option value="">Seleccione un artista...</option>
                                <?php while($art = $artistas->fetch_assoc()): ?>
                                    <option value="<?php echo $art['id_artista']; ?>">
                                        <?php echo $art['pseudonimo_artista']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Álbum (Opcional si es solo al Artista)</label>
                            <select name="id_album" class="form-control">
                                <option value="">Seleccione un álbum...</option>
                                <?php while($alb = $albumes->fetch_assoc()): ?>
                                    <option value="<?php echo $alb['id_album']; ?>">
                                        <?php echo $alb['titulo_album']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Nominación</button>
                        <a href="nominaciones.php" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
</body>
</html>