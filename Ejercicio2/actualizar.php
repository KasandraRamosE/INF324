<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';  // Incluir la conexión a la base de datos

// Verificar si se ha recibido el `id` del usuario a actualizar
if (isset($_GET['id'])) {
    $id_persona = $_GET['id'];

    // Consultar los datos de la persona sin filtrar por `id_admi`
    $sql_persona = "SELECT * FROM persona WHERE id='$id_persona'";
    $result_persona = $conn->query($sql_persona);

    if ($result_persona->num_rows > 0) {
        $user = $result_persona->fetch_assoc();  // Obtener los datos de la persona en un array asociativo
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
}

// Procesar el formulario de actualización
if (isset($_POST['update_persona'])) {
    $ci = $_POST['ci'];
    $nombre = $_POST['nombre'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $usuario = $_POST['usuario'];

    // Si la contraseña no está vacía, se actualiza con la nueva contraseña
    if (!empty($_POST['contraseña'])) {
        $contraseña = $_POST['contraseña'];  // La contraseña se maneja en texto plano según tu especificación
        $sql_persona_update = "UPDATE persona SET ci='$ci', nombre='$nombre', paterno='$paterno', materno='$materno', usuario='$usuario', contraseña='$contraseña' WHERE id='$id_persona'";
    } else {
        // Si no se actualiza la contraseña, no se incluye en la consulta
        $sql_persona_update = "UPDATE persona SET ci='$ci', nombre='$nombre', paterno='$paterno', materno='$materno', usuario='$usuario' WHERE id='$id_persona'";
    }

    // Ejecutar la consulta de actualización de persona
    if ($conn->query($sql_persona_update) === TRUE) {
        $success = "Datos del usuario actualizados exitosamente.";
    } else {
        $error = "Error al actualizar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Usuario - HAM-LP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-back {
            background: #a78dff;
            color: white;
            border: none;
            border-radius: 20px;
        }
        .btn-update {
            background: #00e1ea;
            color: white;
            border: none;
            border-radius: 20px;
        }
        .section-title {
            background: #f2f2f2;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Actualizar Información del Usuario</h2>
            
            <!-- Mensaje de Éxito/Error -->
            <?php if (isset($success)) { ?>
                <div class="alert alert-success text-center">
                    <?= $success; ?>
                </div>
            <?php } ?>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger text-center">
                    <?= $error; ?>
                </div>
            <?php } ?>

            <!-- Formulario de Actualización -->
            <form method="POST" action="">
                <h4 class="section-title">Información del Usuario</h4>
                <div class="mb-3">
                    <label for="ci" class="form-label">CI</label>
                    <input type="text" class="form-control" name="ci" id="ci" value="<?= $user['ci'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?= $user['nombre'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="paterno" class="form-label">Apellido Paterno</label>
                    <input type="text" class="form-control" name="paterno" id="paterno" value="<?= $user['paterno'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="materno" class="form-label">Apellido Materno</label>
                    <input type="text" class="form-control" name="materno" id="materno" value="<?= $user['materno'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="usuario" id="usuario" value="<?= $user['usuario'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña (Dejar en blanco para no cambiar)</label>
                    <input type="password" class="form-control" name="contraseña" id="contraseña">
                </div>

                <!-- Botón de Actualizar Usuario -->
                <div class="d-grid mt-4">
                    <button type="submit" name="update_persona" class="btn btn-update">Actualizar Usuario</button>
                </div>
            </form>

            <!-- Botón de Regreso al Panel de Administración -->
            <div class="text-center mt-3">
                <a href="admin.php" class="btn btn-back">Volver al Panel de Administración</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
