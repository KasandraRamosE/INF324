<?php
session_start();
include 'db.php';  // Incluir la conexión a la base de datos

// Verificar si el usuario está autenticado y es un administrador
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha recibido el `id` de la propiedad a editar
if (isset($_GET['id'])) {
    $id_propiedad = $_GET['id'];

    // Obtener los datos de la propiedad
    $sql = "SELECT * FROM propiedad WHERE id='$id_propiedad'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $property = $result->fetch_assoc();  // Obtener los datos de la propiedad
    } else {
        echo "Propiedad no encontrada.";
        exit();
    }
}

// Procesar el formulario de actualización
if (isset($_POST['update_propiedad'])) {
    $zona = $_POST['zona'];
    $xini = $_POST['xini'];
    $yini = $_POST['yini'];
    $xfin = $_POST['xfin'];
    $yfin = $_POST['yfin'];
    $superficie = $_POST['superficie'];
    $distrito_id = $_POST['distrito'];  // Almacenar el ID del Distrito seleccionado

    // Obtener el nombre del distrito para guardar en la tabla propiedad
    $sql_distrito = "SELECT nombre FROM distrito WHERE id='$distrito_id'";
    $result_distrito = $conn->query($sql_distrito);
    $distrito_nombre = $result_distrito->fetch_assoc()['nombre'];

    // Actualizar la propiedad en la base de datos
    $sql_update = "UPDATE propiedad SET zona='$zona', xini='$xini', yini='$yini', xfin='$xfin', yfin='$yfin', superficie='$superficie', distrito='$distrito_nombre' WHERE id='$id_propiedad'";
    
    if ($conn->query($sql_update) === TRUE) {
        $_SESSION['success_message'] = "Propiedad actualizada correctamente.";
        header("Location: crud_propiedades.php");
        exit();
    } else {
        $error_message = "Error al actualizar la propiedad: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Propiedad - HAM-LP</title>
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
        .form-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Editar Propiedad</h2>

        <!-- Mensaje de Error -->
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger text-center">
                <?= $error_message; ?>
            </div>
        <?php } ?>

        <!-- Formulario de Edición -->
        <div class="form-container">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="distrito" class="form-label">Distrito</label>
                    <select class="form-control" name="distrito" id="distrito">
                        <option value="">Seleccione un distrito</option>
                        <?php
                        // Obtener todos los distritos de la base de datos
                        $sql_distritos = "SELECT id, nombre FROM distrito";
                        $result_distritos = $conn->query($sql_distritos);
                        while ($row = $result_distritos->fetch_assoc()) {
                            $selected = ($row['nombre'] == $property['distrito']) ? 'selected' : '';
                            echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="zona" class="form-label">Zona</label>
                    <select class="form-control" name="zona" id="zona">
                        <option value="">Seleccione una zona</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="xini" class="form-label">X Inicial</label>
                    <input type="text" class="form-control" name="xini" id="xini" value="<?= $property['xini'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="yini" class="form-label">Y Inicial</label>
                    <input type="text" class="form-control" name="yini" id="yini" value="<?= $property['yini'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="xfin" class="form-label">X Final</label>
                    <input type="text" class="form-control" name="xfin" id="xfin" value="<?= $property['xfin'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="yfin" class="form-label">Y Final</label>
                    <input type="text" class="form-control" name="yfin" id="yfin" value="<?= $property['yfin'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="superficie" class="form-label">Superficie</label>
                    <input type="text" class="form-control" name="superficie" id="superficie" value="<?= $property['superficie'] ?>" required>
                </div>

                <div class="d-grid">
                    <button type="submit" name="update_propiedad" class="btn btn-custom">Actualizar Propiedad</button>
                    <a href="crud_propiedades.php" class="btn btn-secondary mt-3">Volver</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Script AJAX para Distrito y Zona -->
    <script>
    document.getElementById('distrito').addEventListener('change', function() {
        var distrito_id = this.value;
        var zonaSelect = document.getElementById('zona');
        zonaSelect.innerHTML = '<option value="">Seleccione una zona</option>';

        if (distrito_id) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'zonas.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    var zonas = JSON.parse(this.responseText);
                    zonas.forEach(function(zona) {
                        var option = document.createElement('option');
                        option.value = zona.nombre;
                        option.textContent = zona.nombre;
                        zonaSelect.appendChild(option);
                    });
                }
            };
            xhr.send('distrito_id=' + distrito_id);
        }
    });

    // Pre-seleccionar zona
    window.onload = function() {
        document.getElementById('distrito').dispatchEvent(new Event('change'));
    };
    </script>
</body>
</html>
