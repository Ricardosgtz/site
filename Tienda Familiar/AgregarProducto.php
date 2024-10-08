<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "family_store";

// Crear la conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener lista de proveedores
$sql_proveedores = "SELECT id_proveedor, nombre_proveedor FROM proveedores";
$result_proveedores = $conn->query($sql_proveedores);

// Manejo del formulario al enviar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_producto = $_POST["nombre_producto"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    $id_proveedor = $_POST["id_proveedor"];

    // Insertar datos en la base de datos
    $sql = "INSERT INTO productos (nombre_producto, precio, cantidad, id_proveedor) 
            VALUES ('$nombre_producto', '$precio', '$cantidad', '$id_proveedor')";

    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página de productos una vez que se agregue el producto
        header("Location: Productos.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #eceff1;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }
        h2 {
            font-size: 24px;
            color: #37474f;
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            font-size: 14px;
            color: #607d8b;
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="number"], select {
            font-family: 'Poppins', sans-serif;
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #cfd8dc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            color: #37474f;
        }
        button {
            font-family: 'Poppins', sans-serif;
            width: 100%;
            padding: 12px;
            background-color: #0288d1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0277bd;
        }
        .back-link {
            margin-top: 20px;
            text-align: center;
        }
        .back-link a {
            color: #0288d1;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Agregar Producto</h2>
        <!-- Formulario para agregar productos -->
        <form method="POST" action="">
            <label for="nombre_producto">Nombre del Producto:</label>
            <input type="text" id="nombre_producto" name="nombre_producto" required>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" id="precio" name="precio" required>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" required>

            <label for="id_proveedor">Proveedor:</label>
            <select id="id_proveedor" name="id_proveedor" required>
                <option value="">Seleccione un proveedor</option>
                <?php
                if ($result_proveedores->num_rows > 0) {
                    while ($proveedor = $result_proveedores->fetch_assoc()) {
                        echo '<option value="' . $proveedor['id_proveedor'] . '">' . $proveedor['nombre_proveedor'] . '</option>';
                    }
                }
                ?>
            </select>

            <button type="submit">Agregar Producto</button>
        </form>

        <div class="back-link">
            <a href="Productos.php">Volver a la Lista de Productos</a>
        </div>
    </div>

</body>
</html>
