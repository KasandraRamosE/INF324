<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trámites y Servicios - HAM-LP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        .btn-category {
            width: 200px;
            height: 120px;
            border-radius: 20px;
            font-size: 18px;
            font-weight: 500;
            color: white;
        }
        .btn-category i {
            display: block;
            font-size: 35px;
            margin-bottom: 5px;
        }
        .btn-naranja { background-color: #ffbb84; }
        .btn-rosado { background-color: #ff8f91; }
        .btn-morado { background-color: #a78dff; }
        .btn-celeste { background-color: #00e1ea; }
        .navbar-custom {
            background: linear-gradient(90deg, #ff8f91 0%, #a78dff 100%);
        }
        .footer-custom {
            background: #292b2c;
            color: #ffffff;
        }
        .footer-custom a {
            color: #ffffff;
            text-decoration: none;
        }
        .footer-custom a:hover {
            text-decoration: underline;
        }
        .carousel-item img {
            height: 500px; /* Altura de las imágenes en el carrusel */
            object-fit: cover; /* Ajuste para cubrir todo el contenedor */
        }
    </style>
</head>
<body>
    <!-- Navbar con Logo y Colores Personalizados -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./imagenes/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
                HAM-LP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Trámites</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Información</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carrusel de Imágenes -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./imagenes/imagen1.png" class="d-block w-100" alt="Imagen 1">
            </div>
            <div class="carousel-item">
                <img src="./imagenes/imagen2.jpg" class="d-block w-100" alt="Imagen 2">
            </div>
            <div class="carousel-item">
                <img src="./imagenes/imagen3.jpg" class="d-block w-100" alt="Imagen 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Información de la Alcaldía -->
    <div class="container text-center my-5">
        <h1 class="mb-4">Tu <strong>Alcaldía</strong></h1>
        <div class="row">
            <!-- Misión -->
            <div class="col-md-6 mb-4">
                <h2>Misión Institucional</h2>
                <p>Somos una institución pública municipal renovada, dinámica, transparente e incluyente, que brinda servicios públicos modernos, eficientes, ágiles y planificados, con concertación y participación ciudadana, impulsando una convivencia pacífica en búsqueda de una mejor calidad de vida de la población paceña por el Bien Común.</p>
            </div>
            <!-- Visión -->
            <div class="col-md-6 mb-4">
                <h2>Visión Institucional</h2>
                <p>Ser una institución pública modelo de gestión municipal democrática, participativa, transparente, eficiente, innovadora y tecnológica, que dinamiza la economía, el desarrollo social y territorial; consolidando una La Paz saludable, productiva, competitiva, biodiversa y resiliente, cultural, ordenada e interconectada, con diálogo y reconciliación por el Bien Común.</p>
            </div>
        </div>
    </div>

    <!-- Tipos de Trámites -->
    <div class="container text-center my-5">
        <h2 class="mb-4">Trámites y Servicios</h2>
        <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
            <!-- Botón 1: Impuestos Municipales (Naranja) -->
            <button type="button" class="btn btn-naranja btn-category">
                <i class="bi bi-receipt"></i>
                Impuestos Municipales
            </button>

            <!-- Botón 2: Negocios y comercio (Rosado) -->
            <button type="button" class="btn btn-rosado btn-category">
                <i class="bi bi-shop-window"></i>
                Negocios y comercio
            </button>

            <!-- Botón 3: Catastro y territorio (Morado) -->
            <button type="button" class="btn btn-morado btn-category">
                <i class="bi bi-house-door"></i>
                <a href="catastro.php" >Catastro y Territorio</a>
            </button>

            <!-- Botón 4: Servicios sociales (Celeste) -->
            <button type="button" class="btn btn-celeste btn-category">
                <i class="bi bi-people"></i>
                Servicios sociales
            </button>
        </div>

        <!-- Botón para más trámites -->
        <button type="button" class="btn btn-outline-primary btn-lg">
            Más trámites y servicios
        </button>
    </div>

    <!-- Pie de Página en 3 Columnas con Redes Sociales Separadas -->
    <footer class="footer-custom text-white text-center py-5">
        <div class="container">
            <div class="row">
                <!-- Columna 1: Números de Emergencia Izquierda -->
                <div class="col-md-4">
                    <h4>Números de Emergencia</h4>
                    <p>Información general: <strong>155</strong></p>
                    <p>Seguimiento de trámites: <strong>155</strong> opción 1</p>
                    <p>Registro IGOB ciudadano: <strong>155</strong> opción 1</p>
                    <p>Administración tributaria: <strong>155</strong> opción 2</p>
                    <p>Actividades económicas: <strong>155</strong> opción 3</p>
                </div>

                <!-- Columna 2: Números de Emergencia Derecha -->
                <div class="col-md-4">
                    <h4>Contactos Directos</h4>
                    <p>Red de Ambulancias: <strong>167</strong></p>
                    <p>Defensoría de la Niñez: <strong>156</strong></p>
                    <p>Guarda de transporte: <strong>165</strong></p>
                    <p>Intendencia Municipal: <strong>165</strong></p>
                    <p>Retén de Emergencia: <strong>114</strong></p>
                </div>

                <!-- Columna 3: Contactos Adicionales -->
                <div class="col-md-4">
                    <h4>Contactos Adicionales</h4>
                    <p>SAC La Paz Bus: <strong>155</strong> opción 4</p>
                    <p>Alumbrado y semaforización: <strong>155</strong> opción 5</p>
                    <p>Guardia municipal: <strong>155</strong> opción 6</p>
                    <p>Servicio de Catastro Masivo: <strong>800 103037</strong></p>
                    <p>Línea Arco Iris: <strong>2650915</strong></p>
                    <p>Quejas de recojo de basura: <strong>800 101777</strong></p>
                </div>
            </div>

            <!-- Sección de Redes Sociales Separada -->
            <div class="mt-4">
                <h4>Síguenos en</h4>
                <a href="#" class="mx-2"><i class="bi bi-facebook"></i> Facebook</a>
                <a href="#" class="mx-2"><i class="bi bi-twitter"></i> Twitter</a>
                <a href="#" class="mx-2"><i class="bi bi-instagram"></i> Instagram</a>
                <a href="#" class="mx-2"><i class="bi bi-youtube"></i> YouTube</a>
            </div>

            <div class="mt-3">
                <p>&copy; 2024 GOBIERNO AUTÓNOMO MUNICIPAL DE LA PAZ. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
