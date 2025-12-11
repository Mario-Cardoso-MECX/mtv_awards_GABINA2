<?php
session_start();
require_once '../../config/Conecct.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos
    $nombre = $_POST['nombre'] ?? '';
    $ap_paterno = $_POST['ap_paterno'] ?? '';
    $ap_materno = $_POST['ap_materno'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $sexo = $_POST['sexo'] ?? 1;

    // Validar vacíos
    if (empty($nombre) || empty($ap_paterno) || empty($email) || empty($password)) {
        header("Location: ../../../register.php?error=Llena todos los campos obligatorios");
        exit();
    }

    $db = new Conecct();
    $conn = $db->conecct;

    try {
        // 1. Verificar si el correo existe
        $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE correo_usuario = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: ../../../register.php?error=Este correo ya está registrado");
            exit();
        }

        // 2. Insertar Usuario (Rol 4 = Audiencia)
        // Usamos SHA256 para la contraseña ya que tu BD usa varchar(64)
        $pass_hash = hash('sha256', $password); 
        $rol = 4; // Audiencia
        $estatus = 1; // Activo
        $imagen = ($sexo == 1) ? 'man.png' : 'woman.png'; // Imagen por defecto

        $sql = "INSERT INTO usuarios (nombre_usuario, ap_usuario, am_usuario, sexo_usuario, correo_usuario, password_usuario, imagen_usuario, id_rol, estatus_usuario) 
                VALUES (:nom, :ap, :am, :sex, :email, :pass, :img, :rol, :est, 1)"; 
                // Nota: Asegúrate de que tu tabla tenga la columna 'estatus_usuario'. Si no, quítala del query.
                // Según tu SQL anterior, parece que 'estatus_usuario' no estaba en el CREATE TABLE del PDF, 
                // pero si 'validate_user.php' lo usa ($data->estatus_usuario), debe existir.
                // Si te da error, borra ", estatus_usuario" y ":est".
        
        // CORRECCIÓN QUERY SIMPLE (Basado en tu PDF):
        $sql = "INSERT INTO usuarios (nombre_usuario, ap_usuario, am_usuario, sexo_usuario, correo_usuario, password_usuario, imagen_usuario, id_rol) 
                VALUES (:nom, :ap, :am, :sex, :email, :pass, :img, :rol)";

        $stmt_ins = $conn->prepare($sql);
        $stmt_ins->bindParam(':nom', $nombre);
        $stmt_ins->bindParam(':ap', $ap_paterno);
        $stmt_ins->bindParam(':am', $ap_materno);
        $stmt_ins->bindParam(':sex', $sexo);
        $stmt_ins->bindParam(':email', $email);
        $stmt_ins->bindParam(':pass', $pass_hash);
        $stmt_ins->bindParam(':img', $imagen);
        $stmt_ins->bindParam(':rol', $rol);

        if ($stmt_ins->execute()) {
            header("Location: ../../../index.php?error=Registro exitoso. Inicia sesión.&type=success");
        } else {
            header("Location: ../../../register.php?error=Error al registrar en BD");
        }

    } catch (PDOException $e) {
        header("Location: ../../../register.php?error=Error: " . $e->getMessage());
    }
}
?>