<?php
// contratar.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Trabajo - TuOficio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f7f9fc, #e3eaf0);
        }
        .form-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-top: 50px;
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
            <div class="col-lg-8 form-card">
                <h2 class="mb-4 text-center">📝 Publicar Solicitud de Trabajo</h2>
                <form action="guardar_solicitud.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción del trabajo</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="4" placeholder="Ej. Necesito reparar una instalación eléctrica en mi cocina..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="oficio" class="form-label">Tipo de oficio requerido</label>
                        <select name="oficio" id="oficio" class="form-select" required>
                            <option value="">Seleccione un oficio</option>
                            <option>Electricista</option>
                            <option>Albañil</option>
                            <option>Plomero</option>
                            <option>Pintor</option>
                            <option>Jardinero</option>
                            <option>Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio que estás dispuesto a pagar</label>
                        <input type="number" name="precio" id="precio" class="form-control" placeholder="Ej. 800" required>
                    </div>

                    <div class="mb-3">
                        <label for="ubicacion" class="form-label">Ubicación (Estado)</label>
                        <select name="ubicacion" id="ubicacion" class="form-select" required>
                            <option value="">Seleccione su estado</option>
                            <option>Aguascalientes</option>
                            <option>Baja California</option>
                            <option>Baja California Sur</option>
                            <option>Campeche</option>
                            <option>Chiapas</option>
                            <option>Chihuahua</option>
                            <option>Ciudad de México</option>
                            <option>Coahuila</option>
                            <option>Colima</option>
                            <option>Durango</option>
                            <option>Estado de México</option>
                            <option>Guanajuato</option>
                            <option>Guerrero</option>
                            <option>Hidalgo</option>
                            <option>Jalisco</option>
                            <option>Michoacán</option>
                            <option>Morelos</option>
                            <option>Nayarit</option>
                            <option>Nuevo León</option>
                            <option>Oaxaca</option>
                            <option>Puebla</option>
                            <option>Querétaro</option>
                            <option>Quintana Roo</option>
                            <option>San Luis Potosí</option>
                            <option>Sinaloa</option>
                            <option>Sonora</option>
                            <option>Tabasco</option>
                            <option>Tamaulipas</option>
                            <option>Tlaxcala</option>
                            <option>Veracruz</option>
                            <option>Yucatán</option>
                            <option>Zacatecas</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen opcional (del lugar o del problema)</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">Publicar Trabajo</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>
</html>
