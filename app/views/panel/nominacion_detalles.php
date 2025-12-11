<?php
session_start();
require_once '../../config/Conecct.php';

if (!isset($_GET['id'])) {
    header("Location: nominaciones.php");
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM nominaciones WHERE id_nominacion = $id";
$resultado = $conexion->query($query);
$nominacion = $resultado->fetch_assoc();

// Consultas para los select
$categorias = $conexion->query("SELECT * FROM categorias_nominaciones WHERE estatus_categoria_nominacion = 1");
$artistas = $conexion->query("SELECT * FROM artistas WHERE estatus_artista = 1");
$albumes = $conexion->query("SELECT * FROM albumes WHERE estatus_album = 1");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Nominación</title>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php require_once('../../helpers/menu_lateral.php'); ?>
    
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Editar Nominación #<?php echo $id; ?></h1>
        </section>
        <section class="content">
            <div class="card card-warning">
                <form action="../../backend/panel/nominaciones/update_nominacion.php" method="POST">
                    <input type="hidden" name="id_nominacion" value="<?php echo $id; ?>">
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label>Categoría</label>
                            <select name="id_categoria" class="form-control" required>
                                <?php while($cat = $categorias->fetch_assoc()): ?>
                                    <option value="<?php echo $cat['id_categoria_nominacion']; ?>" 
                                        <?php if($cat['id_categoria_nominacion'] == $nominacion['id_categoria_nominacion']) echo 'selected'; ?>>
                                        <?php echo $cat['nombre_categoria_nominacion']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Artista</label>
                            <select name="id_artista" class="form-control">
                                <option value="">Ninguno</option>
                                <?php while($art = $artistas->fetch_assoc()): ?>
                                    <option value="<?php echo $art['id_artista']; ?>"
                                        <?php if($art['id_artista'] == $nominacion['id_artista']) echo 'selected'; ?>>
                                        <?php echo $art['pseudonimo_artista']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Álbum</label>
                            <select name="id_album" class="form-control">
                                <option value="">Ninguno</option>
                                <?php while($alb = $albumes->fetch_assoc()): ?>
                                    <option value="<?php echo $alb['id_album']; ?>"
                                        <?php if($alb['id_album'] == $nominacion['id_album']) echo 'selected'; ?>>
                                        <?php echo $alb['titulo_album']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                        <a href="nominaciones.php" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
</body>
</html>