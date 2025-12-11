<?php 
session_start();
require_once '../../config/Conecct.php';
require_once '../../helpers/menu_lateral.php';
// ... includes ...
echo mostrar_menu_lateral('Categorias');
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Gestión de Categorías</h1>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <a href="categoria_nueva.php" class="btn btn-primary">Nueva Categoría</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
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
                        $result = $conexion->query($sql);
                        while($row = $result->fetch_assoc()) {
                            $tipo = ($row['tipo_categoria_nominacion'] == 1) ? 'Artista' : (($row['tipo_categoria_nominacion'] == 2) ? 'Álbum' : 'Canción');
                            echo "<tr>
                                <td>{$row['id_categoria_nominacion']}</td>
                                <td>{$row['nombre_categoria_nominacion']}</td>
                                <td>{$tipo}</td>
                                <td>
                                    <a href='categoria_detalles.php?id={$row['id_categoria_nominacion']}' class='btn btn-warning btn-sm'>Editar</a>
                                    <a href='../../backend/panel/categorias/delete_categoria.php?id={$row['id_categoria_nominacion']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Seguro?\")'>Eliminar</a>
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