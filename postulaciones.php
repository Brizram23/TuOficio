<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$correo = $_SESSION['usuario'];

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "tuoficio");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener las postulaciones del usuario
$sql = "
    SELECT t.oficio, t.descripcion, t.ubicacion, t.precio, t.fecha, t.imagen, p.fecha_postulacion
    FROM postulaciones p
    INNER JOIN trabajos t ON p.id_trabajo = t.id
    WHERE p.correo_usuario = ?
    ORDER BY p.fecha_postulacion DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Postulaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">TuOficio.com</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">📝 Mis Postulaciones</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['oficio']) ?> - <?= htmlspecialchars($row['ubicacion']) ?></h5>
                        <p class="card-text"><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($row['descripcion'])) ?></p>
                        <p class="card-text"><strong>Precio:</strong> $<?= number_format($row['precio'], 2) ?></p>
                        <p class="card-text"><strong>Fecha del trabajo:</strong> <?= htmlspecialchars($row['fecha']) ?></p>
                        <p class="card-text text-muted"><small>Postulado el <?= htmlspecialchars($row['fecha_postulacion']) ?></small></p>
                        <?php if ($row['imagen']): ?>
                            <img src="<?= htmlspecialchars($row['imagen']) ?>" class="img-fluid rounded" style="max-width: 300px;">
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">No has solicitado ningún trabajo aún.</div>
        <?php endif; ?>
    </div>
</body>
</html>
