<?php
session_start();

// Conexión
$conn = new mysqli("localhost", "root", "", "tuoficio");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM trabajos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$trabajo = $result->fetch_assoc();
$stmt->close();

$postulado = false;
$mensaje = "";

// Verificar postulación
if (isset($_SESSION['usuario']) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_SESSION['usuario'];
    
    // Verificar si ya está postulado
    $sql_check = "SELECT * FROM postulaciones WHERE id_trabajo = ? AND correo_usuario = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("is", $id, $correo);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        $mensaje = "Ya has solicitado este trabajo.";
        $postulado = true;
    } else {
        $sql_postular = "INSERT INTO postulaciones (id_trabajo, correo_usuario) VALUES (?, ?)";
        $stmt_postular = $conn->prepare($sql_postular);
        $stmt_postular->bind_param("is", $id, $correo);
        $stmt_postular->execute();
        $mensaje = "¡Has solicitado este trabajo correctamente!";
        $postulado = true;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Trabajo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">TuOficio.com</a>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if ($trabajo): ?>
            <h2><?= htmlspecialchars($trabajo['oficio']) ?> - <?= htmlspecialchars($trabajo['ubicacion']) ?></h2>
            <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($trabajo['descripcion'])) ?></p>
            <p><strong>Precio:</strong> $<?= number_format($trabajo['precio'], 2) ?></p>
            <p><strong>Fecha:</strong> <?= htmlspecialchars($trabajo['fecha']) ?></p>
            <?php if ($trabajo['imagen']): ?>
                <p><strong>Imagen:</strong><br><img src="<?= htmlspecialchars($trabajo['imagen']) ?>" class="img-fluid"></p>
            <?php endif; ?>

            <?php if (isset($_SESSION['usuario'])): ?>
                <?php if ($mensaje): ?>
                    <div class="alert <?= $postulado ? 'alert-success' : 'alert-danger' ?>"><?= $mensaje ?></div>
                <?php endif; ?>
                <?php if (!$postulado): ?>
                    <form method="POST">
                        <button type="submit" class="btn btn-primary">Solicitar trabajo</button>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-warning">Debes <a href="login.php">iniciar sesión</a> para solicitar este trabajo.</div>
            <?php endif; ?>

            <a href="encontrar_trabajo.php" class="btn btn-secondary mt-3">← Volver</a>
        <?php else: ?>
            <p>Trabajo no encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
