<?php
function configuracion_menu($pagina = '')
{
    $menu = array();
    $menu_item = array();
    $sub_menu_item = array();

    // Opcion Dashboard
    $menu_item['is_active'] = (($pagina == 'DASHBOARD') ? true : false);
    $menu_item['href'] = './dashboard.php';
    $menu_item['icon'] = 'fas fa-tachometer-alt'; // Icono corregido para dashboard usual
    $menu_item['text'] = 'Dashboard';
    $menu_item['submenu'] = array();
    $menu['dashboard'] = $menu_item;

    // Opcion Usuarios
    $menu_item['is_active'] = (($pagina == 'USUARIOS') ? true : false);
    $menu_item['href'] = './usuarios.php';
    $menu_item['icon'] = 'fas fa-users';
    $menu_item['text'] = 'Usuarios';
    $menu_item['submenu'] = array();
    $menu['usuarios'] = $menu_item;

    // Opcion Artistas
    $menu_item['is_active'] = (($pagina == 'ARTISTAS') ? true : false);
    $menu_item['href'] = './artistas.php';
    $menu_item['icon'] = 'fas fa-microphone-alt';
    $menu_item['text'] = 'Artistas';
    $menu_item['submenu'] = array();
    $menu['artistas'] = $menu_item;

    // Opcion Albumes (Agregado por si faltaba en la lista visual)
    $menu_item['is_active'] = (($pagina == 'ALBUMES') ? true : false);
    $menu_item['href'] = './albumes.php';
    $menu_item['icon'] = 'fas fa-compact-disc';
    $menu_item['text'] = 'Álbumes';
    $menu_item['submenu'] = array();
    $menu['albumes'] = $menu_item;

    // Opcion Canciones (Agregado por consistencia)
    $menu_item['is_active'] = (($pagina == 'CANCIONES') ? true : false);
    $menu_item['href'] = './canciones.php';
    $menu_item['icon'] = 'fas fa-music';
    $menu_item['text'] = 'Canciones';
    $menu_item['submenu'] = array();
    $menu['canciones'] = $menu_item;

    // Opción Géneros
    $menu_item['is_active'] = (($pagina == 'GENEROS') ? true : false);
    $menu_item['href'] = './generos.php';
    $menu_item['icon'] = 'fas fa-tags'; 
    $menu_item['text'] = 'Géneros';
    $menu_item['submenu'] = array();
    $menu['Generos'] = $menu_item;

    // --- NUEVO: Opción Categorías de Nominación ---
    $menu_item['is_active'] = (($pagina == 'CATEGORIAS') ? true : false);
    $menu_item['href'] = './categorias.php';
    $menu_item['icon'] = 'fas fa-list-ol'; 
    $menu_item['text'] = 'Categorías';
    $menu_item['submenu'] = array();
    $menu['categorias'] = $menu_item;

    // --- NUEVO: Opción Nominaciones ---
    $menu_item['is_active'] = (($pagina == 'NOMINACIONES') ? true : false);
    $menu_item['href'] = './nominaciones.php';
    $menu_item['icon'] = 'fas fa-trophy'; // Icono de trofeo
    $menu_item['text'] = 'Nominaciones';
    $menu_item['submenu'] = array();
    $menu['nominaciones'] = $menu_item;

    return $menu;
}

function mostrar_menu_lateral($pagina = '')
{
    $menu = configuracion_menu($pagina);
    // print("<pre>".print_r($menu, true)."</pre>");
    $html = ' <li class="nav-header text-center">==== ADMINISTRADOR ====</li>';
    foreach ($menu as $item) {
        if ($item['href'] != "#") {
            $html .= '
                        <li class="nav-item">
                            <a href="' . $item["href"] . '" class="nav-link ' . ($item["is_active"] ? "active" : "") . '">
                                <i class="' . $item["icon"] . ' nav-icon"></i>
                                <p>' . $item["text"] . '</p>
                            </a>
                        </li>
                    ';
        }//end if href != #
        else {
            if (sizeof($item['submenu']) > 0) {
                $html .= '
                            <li class="nav-item ' . ($item["is_active"] ? "menu-is-opening menu-open" : "") . ' ">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon ' . $item["icon"] . '"></i>
                                    <p>
                                        ' . $item["text"] . '
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">';
                foreach ($item['submenu'] as $item_submenu) {
                    $html .= '
                                            <li class="nav-item">
                                                <a href="' . $item_submenu["href"] . '" class="nav-link ' . ($item_submenu["is_active"] ? "active" : "") . '">
                                                    <i class="' . $item_submenu["icon"] . ' nav-icon"></i>
                                                    <p>' . $item_submenu["text"] . '</p>
                                                </a>
                                            </li>
                                    ';
                }//end foreach
                $html .= '</ul>
                            </li>
                        ';
            }//end 
        }// end else
    }//end foreach
    return $html;
}//end
?>