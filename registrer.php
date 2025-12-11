<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MTV Awards | Registro</title>
  <link rel="icon" href="./recursos/img/system/mtv-logo.jpg">
  <link rel="stylesheet" href="./recursos/recursos_portal/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
      body { background-image: url(./recursos/recursos_portal/img/bg-img/breadcumb3.jpg); background-size: cover; background-position: center; height: 100vh; display: flex; align-items: center; justify-content: center; }
      .login-content { background-color: rgba(255, 255, 255, 0.9); padding: 40px; border-radius: 10px; width: 100%; max-width: 500px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
      .login-form .form-control { background-color: #f2f4f8; border: none; height: 50px; }
  </style>
</head>

<body>
  <div class="login-content">
    <div class="text-center mb-4">
        <a href="index.php"><img src="./recursos/img/system/mtv-logo.jpg" width="80" alt="Logo"></a>
        <h3 class="mt-3">Crear Cuenta</h3>
        <p>Únete a la comunidad y vota por tus favoritos</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <div class="login-form">
      <form action="./app/backend/panel/register_user.php" method="post">
        
        <div class="form-group">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre(s)" required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="text" name="ap_paterno" class="form-control" placeholder="Apellido Paterno" required>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="ap_materno" class="form-control" placeholder="Apellido Materno" required>
            </div>
        </div>

        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
        </div>
        
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
        </div>

        <div class="form-group">
            <select name="sexo" class="form-control">
                <option value="1">Hombre</option>
                <option value="0">Mujer</option>
            </select>
        </div>

        <button type="submit" class="btn btn-dark btn-block mt-30" style="background-color: #000; color: #fff;">Registrarse</button>
        
        <div class="text-center mt-3">
            <a href="index.php">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>