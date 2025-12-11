<?php 
session_start();
require_once '../../config/Conecct.php';
require_once '../../helpers/menu_lateral.php';
// ... includes ...
echo mostrar_menu_lateral('Nominaciones');
?>
<div class="content-wrapper">
    <section class="content-header"><h1>Nominaciones Activas</h1></section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <a href="nominacion_nueva.php" class="btn btn-success">Nueva Nominación</a>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Nominado (Artista/Album)</th>
                            <th>Votos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // JOIN para traer los nombres reales
                        $sql = "SELECT n.*, c.nombre_categoria_nominacion, a.pseudonimo_artista, al.titulo_album 
                                FROM nominaciones n
                                LEFT JOIN categorias_nominaciones c ON n.id_categoria_nominacion = c.id_categoria_nominacion
                                LEFT JOIN artistas a ON n.id_artista = a.id_artista
                                LEFT JOIN albumes al ON n.id_album = al.id_album";
                        
                        $result = $conexion->query($sql);
                        
                        while($row = $result->fetch_assoc()) {
                            // Determinar quién es el nominado
                            $nominado = $row['pseudonimo_artista'] ? $row['pseudonimo_artista'] : $row['titulo_album'];
                            
                            echo "<tr>
                                <td>{$row['nombre_categoria_nominacion']}</td>
                                <td>{$nominado}</td>
                                <td>{$row['contador_nominacion']}</td>
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