<?php 
session_start();
require_once '../../config/Conecct.php';
require_once '../../helpers/menu_lateral.php';

// Obtener listas
$artistas = $conexion->query("SELECT id_artista, pseudonimo_artista FROM artistas");
$albumes = $conexion->query("SELECT id_album, titulo_album FROM albumes");
$categorias = $conexion->query("SELECT * FROM categorias_nominaciones WHERE estatus_categoria_nominacion = 1");
?>

<div class="content-wrapper">
    <section class="content">
        <div class="card card-success">
            <div class="card-header"><h3 class="card-title">Registrar Nominación</h3></div>
            <form action="../../backend/panel/nominaciones/create_nominacion.php" method="POST">
                <div class="card-body">
                    
                    <div class="form-group">
                        <label>Categoría</label>
                        <select name="id_categoria" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <?php while($c = $categorias->fetch_assoc()): ?>
                                <option value="<?= $c['id_categoria_nominacion'] ?>">
                                    <?= $c['nombre_categoria_nominacion'] ?> (<?= ($c['tipo_categoria_nominacion'] == 1)?'Artista':'Álbum' ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Artista (Opcional si es categoría de álbum)</label>
                                <select name="id_artista" class="form-control">
                                    <option value="">-- Ninguno --</option>
                                    <?php while($a = $artistas->fetch_assoc()): ?>
                                        <option value="<?= $a['id_artista'] ?>"><?= $a['pseudonimo_artista'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Álbum (Opcional si es categoría de artista)</label>
                                <select name="id_album" class="form-control">
                                    <option value="">-- Ninguno --</option>
                                    <?php while($al = $albumes->fetch_assoc()): ?>
                                        <option value="<?= $al['id_album'] ?>"><?= $al['titulo_album'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <small class="text-danger">* Selecciona solo Artista O Álbum dependiendo de la categoría.</small>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Crear Nominación</button>
                </div>
            </form>
        </div>
    </section>
</div>