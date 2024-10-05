<?php
session_start();
include 'db.php';  // Incluir la conexión a la base de datos

// Verificar si el usuario está autenticado y es un administrador
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha recibido el ID del propietario
$id_propietario = isset($_GET['id_propietario']) ? $_GET['id_propietario'] : '';

if (empty($id_propietario)) {
    header("Location: admin.php");
    exit();
}

// Procesar el formulario al enviar
if (isset($_POST['add_propiedad'])) {
    $id = $_POST['id'];
    $zona = $_POST['zona'];
    $xini = $_POST['xini'];
    $yini = $_POST['yini'];
    $xfin = $_POST['xfin'];
    $yfin = $_POST['yfin'];
    $superficie = $_POST['superficie'];
    $distrito = $_POST['distrito'];

    // Insertar propiedad en la tabla `propiedad`
    $sql = "INSERT INTO propiedad (id, zona, xini, yini, xfin, yfin, superficie, distrito, id_propietario) 
            VALUES ('$id', '$zona', '$xini', '$yini', '$xfin', '$yfin', '$superficie', '$distrito', '$id_propietario')";
    if ($conn->query($sql) === TRUE) {
        $success = "Nueva propiedad registrada exitosamente.";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Añadir Propiedad - HAM-LP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
        }
        .form-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-primary, .btn-secondary {
            border-radius: 20px;
        }
        .section-title {
            background: #e9ecef;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .form-control {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container shadow-lg">
            <h2 class="text-center mb-4">Añadir Nueva Propiedad</h2>

            <!-- Mensaje de Éxito/Error -->
            <?php if (isset($success)) { ?>
                <div class="alert alert-success text-center"><?= $success; ?></div>
            <?php } ?>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger text-center"><?= $error; ?></div>
            <?php } ?>

            <!-- Formulario de Añadir Propiedad -->
            <form method="POST" action="">
                <h4 class="section-title">Datos de la Propiedad</h4>
                <div class="mb-3">
                    <label for="id" class="form-label">ID de Propiedad</label>
                    <input type="text" class="form-control" name="id" id="id" required>
                </div>
                
                <div class="mb-3">
                    <label for="distrito" class="form-label">Distrito</label>
                    <select class="form-control" name="distrito" id="distrito">
                        <option value="">Seleccione un distrito</option>
                        <?php
                        // Obtener todos los distritos de la base de datos
                        $sql = "SELECT id, nombre FROM distrito";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
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
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="xini" class="form-label">X Inicial</label>
                        <input type="text" class="form-control" name="xini" id="xini" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="yini" class="form-label">Y Inicial</label>
                        <input type="text" class="form-control" name="yini" id="yini" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="xfin" class="form-label">X Final</label>
                        <input type="text" class="form-control" name="xfin" id="xfin" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="yfin" class="form-label">Y Final</label>
                        <input type="text" class="form-control" name="yfin" id="yfin" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="superficie" class="form-label">Superficie</label>
                    <input type="text" class="form-control" name="superficie" id="superficie" required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="add_propiedad" class="btn btn-primary mb-3">Añadir Propiedad</button>
                    <!-- Botón de Volver -->
                    <a href="admin.php" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
document.getElementById('distrito').addEventListener('change', function() {
    var distrito_id = this.value;

    // Limpiar el campo de zona antes de hacer la solicitud AJAX
    var zonaSelect = document.getElementById('zona');
    zonaSelect.innerHTML = '<option value="">Seleccione una zona</option>';

    if (distrito_id) {
        // Realizar la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'zonas.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Definir lo que sucederá cuando la solicitud tenga éxito
        xhr.onload = function() {
            if (this.status === 200) {
                var zonas = JSON.parse(this.responseText);
                zonas.forEach(function(zona) {
                    var option = document.createElement('option');
                    option.value = zona.id;
                    option.textContent = zona.nombre;
                    zonaSelect.appendChild(option);
                });
            }
        };

        // Enviar la solicitud con el id del distrito
        xhr.send('distrito_id=' + distrito_id);
    }
});
</script>

</html>
