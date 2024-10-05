<?php
session_start();
include 'db.php';  // Incluir la conexión a la base de datos

if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];  // La contraseña se tratará como texto plano según el ejemplo proporcionado

    // Primero, se verifica en la tabla `persona`
    $sql_persona = "SELECT * FROM persona WHERE usuario='$usuario' AND contraseña='$contraseña'";
    $result_persona = $conn->query($sql_persona);

    if ($result_persona && $result_persona->num_rows > 0) {
        // Usuario encontrado en `persona`
        $user = $result_persona->fetch_assoc();
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['id_persona'] = $user['id'];  // Almacenar el ID de la persona
        $_SESSION['ci'] = $user['ci'];  // Almacenar el CI en la sesión

        // Mostrar mensaje de depuración
        echo "<pre>Redirigiendo como usuario: {$_SESSION['usuario']}, ID: {$_SESSION['id_persona']}</pre>";
        
        // Redirigir a la página de catastro para usuarios
        header("Location: catastro.php");
        exit();
    } else {
        // Si no se encuentra en `persona`, se busca en la tabla `administrador`
        $sql_admin = "SELECT * FROM administrador WHERE usuario='$usuario' AND contraseña='$contraseña'";
        $result_admin = $conn->query($sql_admin);

        if ($result_admin && $result_admin->num_rows > 0) {
            // Usuario encontrado en `administrador`
            $admin = $result_admin->fetch_assoc();
            $_SESSION['usuario'] = $admin['usuario'];
            $_SESSION['id_admin'] = $admin['id'];  // Almacenar el ID del administrador
            $_SESSION['ci'] = $admin['ci'];  // Almacenar el CI en la sesión

            // Mostrar mensaje de depuración
            echo "<pre>Redirigiendo como administrador: {$_SESSION['usuario']}, ID: {$_SESSION['id_admin']}</pre>";

            // Redirigir al panel de administración para administradores
            header("Location: admin.php");
            exit();
        } else {
            // Usuario no encontrado en `persona` ni en `administrador`
            $error = "Usuario o contraseña incorrectos. Inténtelo nuevamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión - HAM-LP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-card {
            width: 400px;
            border: none;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-login {
            background: linear-gradient(90deg, #ff8f91 0%, #a78dff 100%);
            color: white;
            border-radius: 20px;
        }
        .btn-login:hover {
            background: linear-gradient(90deg, #a78dff 0%, #ff8f91 100%);
        }
    </style>
</head>
<body>
    <div class="login-card shadow-lg bg-white">
        <h3 class="text-center mb-4">Iniciar Sesión</h3>
        <form method="POST" action="">
            <!-- Campo de Usuario -->
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control" id="usuario" required>
            </div>

            <!-- Campo de Contraseña -->
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input type="password" name="contraseña" class="form-control" id="contraseña" required>
            </div>

            <!-- Botón de Iniciar Sesión -->
            <div class="d-grid">
                <button type="submit" name="login" class="btn btn-login">Ingresar</button>
            </div>
        </form>

        <!-- Mensaje de Error -->
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger text-center mt-3">
                <?= $error; ?>
            </div>
        <?php } ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
