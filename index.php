<?php
session_start();

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "tuoficio";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$nombre_usuario = null;
if (isset($_SESSION['usuario'])) {
    $correo = $_SESSION['usuario'];
    $sql = "SELECT nombre FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->bind_result($nombre_usuario);
    $stmt->fetch();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a TuOficio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f7f9fc, #e3eaf0);
        }
        .card-main {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">
        <a class="navbar-brand fs-3" href="index.php">TuOficio.com</a>

        <div class="ms-auto d-flex align-items-center text-white">
            <?php if ($nombre_usuario): ?>
                <span class="me-3 d-none d-md-inline">👤 <?php echo htmlspecialchars($nombre_usuario); ?></span>
                <button class="btn btn-outline-light btn-sm me-2" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                    ☰
                </button>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
            <?php else: ?>
                <a href="loging.php" class="btn btn-outline-light btn-sm">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Offcanvas sidebar -->
<?php if ($nombre_usuario): ?>
<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menú</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-group">
            <li class="list-group-item"><a href="perfil.php">👤 Perfil</a></li>
            <li class="list-group-item"><a href="postulaciones.php">📄 Mis postulaciones</a></li>
            <li class="list-group-item"><a href="mis_trabajos.php">🛠️ Mis trabajos</a></li>
        </ul>
    </div>
</div>
<?php endif; ?>

<!-- Main content -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 card-main">
            <h2 class="mb-4 text-center">Bienvenido a TuOficio</h2>
            <p class="text-center mb-4">Encuentra o publica trabajos para los oficios que necesites.</p>

            <div class="row justify-content-center mb-4">
                <div class="col-md-5 d-grid mb-3">
                    <a href="contratar.php" class="btn btn-success btn-lg shadow">🔍 Contratar</a>
                </div>
                <div class="col-md-5 d-grid mb-3">
                    <a href="encontrar_trabajo.php" class="btn btn-warning btn-lg shadow">🛠️ Encontrar trabajo</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
