<?php
session_start();
include 'db.php';  // Incluir la conexión a la base de datos

// Verificar si el usuario está autenticado y es un administrador
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

// Variables para mensajes de éxito o error
$success_message = '';
$error_message = '';

// Eliminar propiedad
if (isset($_GET['delete_propiedad'])) {
    $id_propiedad = $_GET['delete_propiedad'];
    $sql = "DELETE FROM propiedad WHERE id='$id_propiedad'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Propiedad eliminada correctamente.";
    } else {
        $_SESSION['error_message'] = "Error al eliminar la propiedad: " . $conn->error;
    }
    header("Location: crud_propiedades.php");
    exit();
}

// Filtro de búsqueda por ID de Catastro
$filter_id = '';
if (isset($_POST['filter'])) {
    $filter_id = $_POST['filter_id'];
    $sql = "SELECT * FROM propiedad WHERE id LIKE '%$filter_id%'";  // Mostrar propiedades filtradas por ID
} else {
    $sql = "SELECT * FROM propiedad";  // Mostrar todas las propiedades
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
    <title>CRUD de Propiedades - HAM-LP</title>
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
        .btn-danger {
            border-radius: 20px;
        }
        .btn-warning {
            border-radius: 20px;
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
                    <!-- Botón para CRUD de Propiedades -->
                    <li class="nav-item">
                        <a class="nav-link active" href="crud_propiedades.php">CRUD de Propiedades</a>
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
        <?php if (!empty($success_message)) { ?>
            <div class="alert alert-success">
                <?= $success_message; ?>
            </div>
        <?php } ?>
        <?php if (!empty($error_message)) { ?>
            <div class="alert alert-danger">
                <?= $error_message; ?>
            </div>
        <?php } ?>

        <h2 class="text-center mb-4">Lista de Propiedades</h2>

        <!-- Formulario de Filtro -->
        <form method="POST" action="">
            <div class="input-group mb-3">
                <input type="text" name="filter_id" class="form-control" placeholder="Buscar por ID de Catastro" value="<?= htmlspecialchars($filter_id); ?>">
                <button type="submit" name="filter" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <!-- Tabla de Propiedades -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Zona</th>
                    <th>X Inicial</th>
                    <th>Y Inicial</th>
                    <th>X Final</th>
                    <th>Y Final</th>
                    <th>Superficie</th>
                    <th>Distrito</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['zona']; ?></td>
                        <td><?= $row['xini']; ?></td>
                        <td><?= $row['yini']; ?></td>
                        <td><?= $row['xfin']; ?></td>
                        <td><?= $row['yfin']; ?></td>
                        <td><?= $row['superficie']; ?></td>
                        <td><?= $row['distrito']; ?></td>
                        <td>
                            <a href="editar_propiedad.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="crud_propiedades.php?delete_propiedad=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta propiedad?')">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
