<?php
session_start();
include 'db.php';  // Incluir la conexión a la base de datos

// Verificar si el usuario está autenticado y es un administrador
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

// Variables para mensajes
$success_message = '';
$error_message = '';

// CRUD para la tabla `persona`
if (isset($_GET['delete_persona'])) {
    $id = $_GET['delete_persona'];
    $sql = "DELETE FROM persona WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Persona eliminada correctamente.";
    } else {
        $_SESSION['error_message'] = "Error al eliminar la persona: " . $conn->error;
    }
    header("Location: admin.php");
    exit();
}

// Filtro de búsqueda por CI en la tabla de personas
$filter_ci = '';
if (isset($_POST['filter'])) {
    $filter_ci = $_POST['filter_ci'];
    $sql = "SELECT * FROM persona WHERE ci LIKE '%$filter_ci%'";  // Mostrar a todas las personas filtrando solo por CI
} else {
    $sql = "SELECT * FROM persona";  // Mostrar a todas las personas
}

$result = $conn->query($sql);

// Manejar mensajes de sesión
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de Administración - HAM-LP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f7f6;
        }
        .container {
            margin-top: 30px;
        }
        .btn-custom {
            background: linear-gradient(90deg, #ff8f91 0%, #a78dff 100%);
            color: white;
            border: none;
            border-radius: 20px;
        }
        .btn-custom:hover {
            background: linear-gradient(90deg, #a78dff 0%, #ff8f91 100%);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">Panel de Administración</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Botón para CRUD de Personas -->
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">CRUD de Personas</a>
                    </li>
                    <!-- Nuevo Botón para CRUD de Propiedades -->
                    <li class="nav-item">
                        <a class="nav-link" href="crud_propiedades.php">CRUD de Propiedades</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="logout.php" class="btn btn-outline-light">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Mensajes de Éxito/Error -->
        <?php if ($success_message) { ?>
            <div class="alert alert-success mt-3"><?= $success_message; ?></div>
        <?php } ?>
        <?php if ($error_message) { ?>
            <div class="alert alert-danger mt-3"><?= $error_message; ?></div>
        <?php } ?>

        <!-- Sección de Administración de Personas -->
        <div class="d-flex justify-content-between mb-3 mt-4">
            <h2>Administración de Personas</h2>
            <a href="agregar.php" class="btn btn-custom">Agregar Nuevo Usuario</a>
        </div>

        <!-- Filtro por CI -->
        <form method="POST" action="">
            <div class="input-group mb-4">
                <input type="text" name="filter_ci" class="form-control" placeholder="Buscar por CI" value="<?= htmlspecialchars($filter_ci) ?>">
                <button type="submit" name="filter" class="btn btn-secondary">Filtrar</button>
            </div>
        </form>

        <!-- Tabla de Resultados de Personas -->
        <h3 class="mt-3">Lista de Personas</h3>
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>CI</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['ci']) ?></td>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td><?= htmlspecialchars($row['paterno']) ?></td>
                            <td><?= htmlspecialchars($row['materno']) ?></td>
                            <td><?= htmlspecialchars($row['usuario']) ?></td>
                            <td>
                                <!-- Botón de Ver Detalles -->
                                <a href="ver_detalle.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-info btn-sm">Ver Detalles</a>
                                
                                <!-- Botón de Actualizar -->
                                <a href="actualizar.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-warning btn-sm">Actualizar</a>
                                
                                <!-- Botón de Añadir Propiedad -->
                                <a href="anadir_propiedad.php?id_propietario=<?= htmlspecialchars($row['id']) ?>" class="btn btn-success btn-sm">Añadir Propiedad</a>
                                
                                <!-- Botón de Eliminar -->
                                <a href="admin.php?delete_persona=<?= htmlspecialchars($row['id']) ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Está seguro de que desea eliminar a esta persona?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="7" class="text-center">No se encontraron registros.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
