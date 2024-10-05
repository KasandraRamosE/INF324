<?php
session_start();
include 'db.php';  // Incluir la conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

// Obtener el `id` de la persona desde la URL
$id_persona = $_GET['id'];

// Consultar los datos de la persona
$sql_persona = "SELECT * FROM persona WHERE id='$id_persona'";
$result_persona = $conn->query($sql_persona);
$persona = $result_persona->fetch_assoc();

// Consultar las propiedades asociadas a la persona
$sql_propiedades = "SELECT * FROM propiedad WHERE id_propietario='$id_persona'";
$result_propiedades = $conn->query($sql_propiedades);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detalles de Usuario y Propiedad - HAM-LP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .btn-back {
            background: #a78dff;
            color: white;
            border: none;
            border-radius: 20px;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
        }
        .btn-back:hover {
            background: #8d72ff;
            color: white;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <!-- Título e Información del Usuario -->
    <h2>Detalles del Usuario</h2>
    <table class="table table-bordered">
        <tr><th>CI</th><td><?= $persona['ci'] ?></td></tr>
        <tr><th>Nombre</th><td><?= $persona['nombre'] ?></td></tr>
        <tr><th>Apellido Paterno</th><td><?= $persona['paterno'] ?></td></tr>
        <tr><th>Apellido Materno</th><td><?= $persona['materno'] ?></td></tr>
        <tr><th>Usuario</th><td><?= $persona['usuario'] ?></td></tr>
    </table>

    <!-- Información de Propiedades Asociadas -->
    <h3 class="mt-4">Propiedades Asociadas</h3>
    <table class="table table-hover table-bordered">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Zona</th>
                <th>Superficie</th>
                <th>Distrito</th>
                <th>Coordenadas</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_propiedades->num_rows > 0) { ?>
                <?php while ($propiedad = $result_propiedades->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $propiedad['id'] ?></td>
                        <td><?= $propiedad['zona'] ?></td>
                        <td><?= $propiedad['superficie'] ?> m²</td>
                        <td><?= $propiedad['distrito'] ?></td>
                        <td>(<?= $propiedad['xini'] ?>, <?= $propiedad['yini'] ?>) a (<?= $propiedad['xfin'] ?>, <?= $propiedad['yfin'] ?>)</td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="5" class="text-center">No se encontraron propiedades.</td></tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Botón para Volver al Panel de Administración -->
    <div class="text-center mt-4">
        <a href="admin.php" class="btn-back">Volver al Panel de Administración</a>
    </div>
</div>
</body>
</html>
