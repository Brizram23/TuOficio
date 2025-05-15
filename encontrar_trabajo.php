<?php
// encontrar_trabajo.php

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "tuoficio";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener oficios únicos
$oficios_result = $conn->query("SELECT DISTINCT oficio FROM trabajos ORDER BY oficio ASC");

// Filtrar por oficio si se envió por GET
$oficioSeleccionado = isset($_GET['oficio']) ? $conn->real_escape_string($_GET['oficio']) : "";

// Consulta SQL
$sql = "SELECT * FROM trabajos";
if (!empty($oficioSeleccionado)) {
    $sql .= " WHERE oficio = '$oficioSeleccionado'";
}
$sql .= " ORDER BY fecha DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encontrar Trabajo - TuOficio</title>
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
        .card-header {
            background-color: #0d6efd;
            color: white;
        }
        a.card-link {
            text-decoration: none;
            color: inherit;
        }
        a.card-link:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">
        <a class="navbar-brand fs-3" href="index.php">TuOficio.com</a>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 card-main">
            <h2 class="mb-4 text-center">🛠️ Trabajos Disponibles</h2>

            <!-- Filtro por oficio -->
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-9">
                        <select name="oficio" class="form-select">
                            <option value="">-- Todos los oficios --</option>
                            <?php
                            while ($of = $oficios_result->fetch_assoc()) {
                                $selected = ($oficioSeleccionado == $of['oficio']) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($of['oficio']) . "' $selected>" . htmlspecialchars($of['oficio']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </div>
            </form>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<a href="detalle_trabajo.php?id=' . $row['id'] . '" class="card-link">';
                    echo '<div class="card mb-3">';
                    echo '<div class="card-header"><h5>' . htmlspecialchars($row['oficio']) . ' - ' . htmlspecialchars($row['ubicacion']) . '</h5></div>';
                    echo '<div class="card-body">';
                    echo '<p><strong>Descripción:</strong> ' . htmlspecialchars($row['descripcion']) . '</p>';
                    echo '<p><strong>Precio:</strong> $' . number_format($row['precio'], 2) . '</p>';
                    echo '<p><strong>Fecha:</strong> ' . $row['fecha'] . '</p>';
                    if ($row['imagen']) {
                        echo '<p><strong>Imagen:</strong><br><img src="' . htmlspecialchars($row['imagen']) . '" alt="Imagen del trabajo" class="img-fluid"></p>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            } else {
                echo "<p>No hay trabajos disponibles en este momento.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</div>

</body>
</html>
