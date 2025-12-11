<?php require_once '../../helpers/menu_lateral.php'; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Crear Categoría</h3></div>
            <form action="../../backend/panel/categorias/create_categoria.php" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nombre de la Categoría (Ej: Video del Año)</label>
                        <input type="text" name="nombre_categoria" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Aplica para:</label>
                        <select name="tipo" class="form-control">
                            <option value="1">Artista</option>
                            <option value="2">Álbum</option>
                            <option value="3">Canción</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </section>
</div>