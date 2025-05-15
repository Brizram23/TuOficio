<?php
// guardar_solicitud.php

// Conexión a la base de datos
$host = "localhost";
$user = "root";      // Cambia si usas otro usuario
$pass = "";          // Cambia si tienes contraseña
$dbname = "tuoficio";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Capturar datos del formulario
$descripcion = $_POST['descripcion'];
$oficio = $_POST['oficio'];
$precio = $_POST['precio'];
$ubicacion = $_POST['ubicacion'];

// Manejar imagen si se sube
$nombreImagen = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $directorio = "imagenes/";
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }
    $nombreImagen = $directorio . basename($_FILES["imagen"]["name"]);
    move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreImagen);
}

// Insertar en base de datos
$sql = "INSERT INTO trabajos (descripcion, oficio, precio, ubicacion, imagen)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdss", $descripcion, $oficio, $precio, $ubicacion, $nombreImagen);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<div style='padding:20px; font-family:sans-serif;'>
            <h2>✅ Trabajo publicado con éxito</h2>
            <a href='index.php'>Volver al inicio</a>
          </div>";
} else {
    echo "❌ Error al guardar el trabajo.";
}

$stmt->close();
$conn->close();
?>
