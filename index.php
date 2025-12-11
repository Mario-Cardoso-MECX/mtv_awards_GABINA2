<?php
require_once('./app/config/Conecct.php');
$connect = new Conecct();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>MTV awards</title>

  <link rel="icon" href="./recursos/img/system/mtv-logo.jpg">

  <link rel="stylesheet" href="./recursos/recursos_portal/style.css">

  </head>

<body>
  <div class="preloader d-flex align-items-center justify-content-center">
    <div class="lds-ellipsis">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>

  <header class="header-area">
    <div class="oneMusic-main-menu">
      <div class="classy-nav-container breakpoint-off">
        <div class="container">
          <nav class="classy-navbar justify-content-between" id="oneMusicNav">

            <a href="./app/views/portal/index.php" class="nav-brand"><img
                src="./recursos/img/system/mtv-logo-blanco.png" width="50%" alt=""></a>

            <div class="classy-menu">

              <div class="classynav">
                <ul>
                  <li><a href="./app/views/portal/index.php">Inicio</a></li>
                  <li><a href="./app/views/portal/event.php">Eventos</a></li>
                  <li><a href="./app/views/portal/albums-store.php">Generos</a></li>
                  <li><a href="./app/views/portal/artistas.php">Artistas</a></li>
                  <li><a href="./app/views/portal/votar.php">Votar</a></li>
                  <li><a href="./app/views/portal/resultados.php">Resultados</a></li>
                </ul>

                <div class="login-register-cart-button d-flex align-items-center">
                  <div class="login-register-btn mr-50">
                    <?php if (isset($_SESSION["nickname"])): ?>
                      <div class="dropdown">
                        <a href="#" class="dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true"
                          aria-expanded="false">
                          <?= htmlspecialchars($_SESSION["nickname"]) ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                          <a class="dropdown-item text-dark" href="./app/views/portal/miPerfil.php">Mi perfil</a>
                          <a class="dropdown-item text-dark" href="./backend/panel/liberate_user.php">Cerrar
                            sesión</a>
                        </div>
                      </div>
                    <?php else: ?>
                      <a href="./index.php">Iniciar sesión</a>
                    <?php endif; ?>
                  </div>
                </div>

              </div>
              </div>
          </nav>
        </div>
      </div>
    </div>
  </header>
  <section class="breadcumb-area bg-img bg-overlay"
    style="background-image: url(./recursos/recursos_portal/img/bg-img/breadcumb3.jpg);">
    <div class="bradcumbContent">
      <h2>Iniciar Sesión</h2>
    </div>
  </section>
  <section class="login-area section-padding-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
          <div class="login-content">
            <?php
            if (isset($_GET['error']) && isset($_GET['type'])) {
              echo '<div class="alert alert-' . $_GET['type'] . '" role="alert">
                            ' . $_GET['error'] . '
                            </div>';
            }
            ?>

            <h3>bienvenido de nuevo</h3>
            <div class="login-form">
              <form action="./app/backend/panel/validate_user.php" method="post">
                <div class="form-group">
                  <label for="exampleInputEmail1">Correo Electrónico</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Ingresa tu correo electrónico">
                  <small id="emailHelp" class="form-text text-muted"><i class="fa fa-lock mr-2"></i>
                    Nunca compartiremos su correo electrónico con nadie más.</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Contraseña</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                    placeholder="Ingresa tu contraseña">
                </div>
                <button type="submit" class="btn oneMusic-btn mt-30">Login</button>
                <div class="text-center mt-3">
    <a href="register.php" style="color: #000;">¿No tienes cuenta? Regístrate aquí</a>
</div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer class="footer-area">
    <div class="container">
      <div class="row d-flex flex-wrap align-items-center">
        <div class="col-12 col-md-6">
          <a href="./index.php"><img src="./recursos/img/system/mtv-logo-blanco.png" width="20%" alt=""></a>
        </div>

        <div class="col-12 col-md-6">
          <div class="footer-nav">
            <ul>
              <li><a href="./app/views/portal/index.php">Inicio</a></li>
              <li><a href="./app/views/portal/event.php">Eventos</a></li>
              <li><a href="./app/views/portal/albums-store.php">Generos</a></li>
              <li><a href="./app/views/portal/artistas.php">Artistas</a></li>
              <li><a href="./app/views/portal/votar.php">Votar</a></li>
              <li><a href="./app/views/portal/resultados.php">Resultados</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
  
  <script src="./recursos/recursos_portal/js/plugins/plugins.js"></script>
  
  <script src="./recursos/recursos_portal/js/active.js"></script>
</body>

</html>